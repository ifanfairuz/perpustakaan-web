<?php

namespace App\Console\Commands;

use App\Models\Book;
use Illuminate\Console\Command;

class FillBookRak extends Command
{
    protected $rak = [];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'book:generate_rak';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Book Rak';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function get_rak()
    {
        $raks = Book::selectRaw('`rak`')
                ->selectRaw('count(`id`) as `count`')
                ->groupBy('rak');
        foreach ($raks as $key => $rak) {
            if (strlen($rak->rak) >= 2) {
                $char = $rak->rak[0];
                $number = $rak->rak[1];
                if (!in_array($char, $this->rak)) $this->rak[$char] = [];
                $this->rak[$char][$number-1] = $rak->count;
            }
        }
    }

    public function get_books()
    {
        return Book::where('rak', '')->get();
    }

    public function get_rak_name(string $char)
    {
        $count = 1;
        $number = 0;
        if (in_array($char, $this->rak)) {
            $raks = $this->rak[$char];
            if (sizeof($raks) > 0) {
                foreach ($raks as $key => $count) {
                    if ($count < 20) {
                        $number = $key+1;
                        $count = $count+1;
                        break;
                    }
                }
                if ($number == 0) {
                    $number = sizeof($raks)+1;
                }
            } else {
                $number = 1;
            }
        } else {
            $number = 1;
            $this->rak[$char] = [];
        }
        $this->rak[$char][$number-1] = $count;
        return $char . $number;
    }

    public function get_char(string $name)
    {
        $char_at = 0;
        while (!ctype_alpha($name[$char_at])) {
            $char_at++;
        }
        return strtoupper($name[$char_at]);
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->get_rak();
        $books = $this->get_books();
        foreach ($books as $key => $book) {
            $char = $this->get_char($book->name);
            $rak = $this->get_rak_name($char);
            $book->rak = $rak;
            $book->save();
        }
        return 0;
    }
}
