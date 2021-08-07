<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\ApiGuard;
use App\Http\Controllers\Traits\MyResponse;
use App\Models\Loan;
use App\Models\Book;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{
    use MyResponse, ApiGuard;

    private $error_msg = '';

    public function all(Request $request)
    {
        $query = Loan::with(['books', 'member', 'books.category']);

        return $this->api_response($query->get());
    }

    public function get(Request $request, $id)
    {
        $query = Loan::with(['books', 'member', 'books.category']);

        return $this->api_response($query->find($id));
    }

    private function validate_store(Member $user, $book_id)
    {
        $count = Loan::where('member_id', $user->id)->whereNotIn('status', [-1, 0])->count();
        if ($count >= 3) {
            $this->error_msg = 'Maks pinjam 3 buku sekaligus.';
            return false;
        }
        $count = Loan::where('member_id', $user->id)
            ->whereNotIn('status', [-1, 0])
            ->whereHas('books', function ($q) use ($book_id) {
                return $q->where('books.id', $book_id);
            })
            ->count();
        if ($count > 0) {
            $this->error_msg = 'Tidak bisa pinjam buku yang sama sekaligus.';
            return false;
        }
        
        return true;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|integer|exists:books,id',
        ]);

        $book = Book::findOrFail($request->book_id);
        if ($book->stock > 0 && $user = $this->user()) {
            if (!$this->validate_store($user, $book->id)) return $this->api_response(null, false, $this->error_msg);
            try {
                DB::beginTransaction();
                $return = Carbon::now()->addDays(3);
                $book->decrement('stock', 1);
                $loan = Loan::create([
                    'member_id' => $user->id,
                    'status' => 2,
                    'return' => $return->format('Y-m-d')
                ]);
                $loan->books()->attach([$book->id => ['qty' => 1]]);
                $loan->load(['books', 'member', 'books.category']);
                DB::commit();
                return $this->api_response($loan);
            } catch (\Exception $e) {
                DB::rollBack();
                return $this->api_response($e, false, 'Error.');
            }
        } elseif ($book->stock > 0) {
            return $this->api_response(null, false, 'Stok Habis.');
        }

        return $this->api_response(null, false, 'Tidak bisa melakukan Pinjaman');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Loan $loan)
    {
        $loan->delete();

        return $this->api_response(null, true, 'Berhasil hapus Pinjaman.');
    }

    // Abort Loan
    public function abort(Request $request, $id)
    {
        $loan = Loan::find($id);
        if (!$loan) return $this->api_response(null, false, 'Data tidak ditemukan.');
        if ($loan->status != 2) return $this->api_response(null, false, 'Status pinjaman invalid.');

        $books = $loan->books;

        $books->each(function ($book)
        {
            $book->increment('stock', $book->pivot->qty);
        });

        $loan->update([
            'status' => -1
        ]);

        $loan->load(['books', 'member', 'books.category']);
        return $this->api_response($loan);
    }

    // Extend Loan
    public function extend_request(Request $request, Loan $loan)
    {
        // $request->validate([
        //     'date' => 'required|date|after:today'
        // ]);

        // $loan->update([
        //     'return' => $request->date
        // ]);

        // return response()->json(['msg' => 'Success Extend Loan']);
    }
}
