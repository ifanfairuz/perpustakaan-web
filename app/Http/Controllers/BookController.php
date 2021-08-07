<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\MyResponse;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use Yajra\Datatables\Datatables;

class BookController extends Controller
{
    use MyResponse;

    protected $books_path = 'public/books/';
    protected $books_uri = '/storage/books/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->datatable();
        }
        return view('book.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('book.create');
    }

    /**
     * Delete thumbnail
     * 
     * @param string $name
     * @return bool
     * @protected
     */
    protected function delete_thumnail(string $name)
    {
        if (Storage::exists($this->books_path.$name)) {
            return Storage::delete($this->books_path.$name);
        }
        return false;
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
            'code' => 'string|max:15|unique:books|nullable',
            'name' => 'required|string|max:255|unique:books',
            'writer' => 'required|string|max:255',
            'year' => 'required|integer|min:1800|max:'.(date('Y')+1),
            'description' => 'nullable|string',
            'cover' => 'nullable|image',
            'category_id' => 'required|exists:categories,id'
        ]);

        if (!$request->code) {
            $code = Str::upper(Str::random(6));

            $request->merge([
                'code' => $code
            ]);
        }

        $cover = $request->cover;
        $coverName = $request->code;
        $coverName = $coverName.'_'.time().'.'.$cover->getClientOriginalExtension();
        $path = $this->books_uri.$coverName;
        
        $request->cover->storeAs($this->books_path, $coverName);
        
        $request->merge([
            'thumbnail' => asset($path)
        ]);

        Book::create($request->all());

        return redirect('book')->with('success', 'Success Create Book');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $request->validate([
            'code' => 'string|max:15|nullable|unique:books,code,'.$book->id,
            'name' => 'required|string|max:255|unique:books,name,'.$book->id,
            'writer' => 'required|string|max:255',
            'year' => 'required|integer|min:1800|max:'.(date('Y')+1),
            'description' => 'nullable|string',
            'cover' => 'nullable|image',
            'category_id' => 'required|exists:categories,id'
        ]);

        if (!$request->code) {
            $code = Str::upper(Str::random(6));

            $request->merge([
                'code' => $code
            ]);
        }

        $delete_old = false;
        if ($request->hasFile('cover')) {
            $old_cover = parse_url($book->thumbnail, PHP_URL_PATH);
            $cover = $request->cover;
            $coverName = $request->code;
            $coverName = $coverName.'_'.time().'.'.$cover->getClientOriginalExtension();
            $path = $this->books_uri.$coverName;
            $delete_old = $old_cover != $path;

            $request->cover->storeAs($this->books_path, $coverName);

            $request->merge([
                'thumbnail' => asset($path)
            ]);
        }

        $book->update($request->all());
        
        if ($delete_old) $this->delete_thumnail(pathinfo(@$old_cover, PATHINFO_BASENAME));

        return response()->json(['msg' => 'Success Update Book']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return response()->json(['msg' => 'Success Delete Book']);
    }

    // Get Book
    public function get(Request $request)
    {
        $code = $request->code ?? $request->name;
        $books = Book::select('id', 'name', 'stock')
            ->selectRaw("CONCAT('(', code, ') ', name) as text")
            ->where('code', 'like', '%'.$code.'%')
            ->orWhere('name', 'like', '%'.$code.'%')
            ->latest()->get();
        return $books;
    }

    public function getSingle(Request $request, $id)
    {
        $query = Book::with('category');

        return $this->api_response($query->find($id));
    }

    // all
    public function all(Request $request, int $limit = 20)
    {
        $request->validate([
            'category' => 'string|nullable',
            'keyword' => 'string|nullable'
        ]);

        $query = Book::with('category');
        if ($category = $request->category) {
            $query = $query->whereHas('category', function ($q) use ($category) {
                $q->where('id', $category);
            });
        }
        if ($keyword = $request->keyword) {
            $query = $query->where('name', 'like', "%$keyword%");
        }
        
        return $this->pagination_response($request, $query->simplePaginate($limit));
    }

    // Get Datatable
    public function datatable()
    {
        $books = Book::with('category')->get();

        return Datatables::of($books)
                    ->addIndexColumn()
                    ->addColumn('action', function ()
                    {
                        $btn = '
                            <button class="btn btn-success btn-sm edit">Edit</button>
                            <button class="btn btn-danger btn-sm delete">Delete</button>
                        ';
                        return $btn;
                    })
                    ->make(true);
    }
}
