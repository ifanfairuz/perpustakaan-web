<?php

namespace App\Console\Commands;

use App\Models\Loan;
use Illuminate\Console\Command;

class CekEpiriedLoan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'loan:abort_expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Abort Expired';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function getLoans()
    {
        return Loan::query()->where('status', 2)->where('created_at', '<', date('Y-m-d'));
    }

    public function abort(Loan $loan)
    {
        $books = $loan->books;

        $books->each(function ($book)
        {
            $book->increment('stock', $book->pivot->qty);
        });

        $loan->update([
            'status' => -1
        ]);
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $loans = $this->getLoans();
        foreach ($loans as $key => $loan) {
            $this->abort($loan);
        }
        return 0;
    }
}
