<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	\App\Models\Site::create([
    		'name' => 'Perpustakaan - PRIVOS',
    		'address' => 'JL. Pecalukan, 67157, Ledug, Ledug, Prigen, Pasuruan, Pasuruan, Jawa Timur 67157'
    	]);
    }
}
