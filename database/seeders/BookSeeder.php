<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use App\Models\Stock;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    /**
     * store category
     */
    protected function store_cover($url, $code)
    {
        $filename = $code.'_'.time().'.'.pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION);
        copy($url, storage_path("app/public/books/$filename"));
        return "/storage/books/$filename";
    }

    /**
     * store category
     */
    protected function store_category($name)
    {
        if ($category = Category::where('name', $name)->first()) return $category;

        return Category::create([
            'name' => $name
        ]);
    }

    /**
     * store category
     */
    protected function store_stock($bookid)
    {
        return Stock::create([
            'total' => rand(10, 100),
            'type' => 'in',
            'book_id' => $bookid
        ]);
    }

    /**
     * store
     */
    protected function store($data)
    {
        try {
            DB::beginTransaction();
            $category_name = sizeof($data['categories']) > 0 ? $data['categories'][0] : 'Tidak Berkategori';
            $category = $this->store_category($category_name);
            $description = @$data['shortDescription'] ?? (@$data['longDescription'] ?? '');
            $book = Book::create([
                'code' => $data['isbn'],
                'name' => $data['title'],
                'writer' => join(', ', $data['authors']),
                'year' => date_create_from_format('Y-m-d\TH:i:s.vO', $data['publishedDate']['$date'])->format('Y'),
                'description' => $description,
                'thumbnail' => '',
                'category_id' => $category->id,
            ]);
            if ($book) {
                $cover = $this->store_cover($data['thumbnailUrl'], $book->code);
                $stock = $this->store_stock($book->id);
                $book->increment('stock', $stock->total);
                $book->thumbnail = $cover;
                $book->save();
                DB::commit();
            }
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = json_decode(file_get_contents(__DIR__. '/books.json'), true);
        foreach ($datas as $key => $data) {
            $this->store($data);
        }
    }
}
