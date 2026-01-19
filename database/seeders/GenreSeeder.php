<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Genre;

class GenreSeeder extends Seeder
{
    public function run()
    {
        $genres = [
            ['name'=>'Action','description'=>'Action-packed films'],
            ['name'=>'Drama','description'=>'Drama films'],
            ['name'=>'Comedy','description'=>'Comedy films'],
            ['name'=>'Sci-Fi','description'=>'Science fiction'],
            ['name'=>'Horror','description'=>'Horror films'],
            ['name'=>'Fantasy','description'=>'Fantasy and magical worlds'],
            ['name'=>'Romance','description'=>'Romantic stories'],
            ['name'=>'Thriller','description'=>'Suspense and thriller'],
            ['name'=>'Mystery','description'=>'Mystery and detective stories'],
            ['name'=>'Biography','description'=>'Biographical works'],
            ['name'=>'Historical Fiction','description'=>'Historical novels'],
            ['name'=>'Adventure','description'=>'Adventure stories'],
        ];
        foreach($genres as $g) {
            Genre::firstOrCreate(['name' => $g['name']], $g);
        }
    }
}
