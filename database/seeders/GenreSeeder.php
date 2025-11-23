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
            ['name'=>'Horror','description'=>'Horror films']
        ];
        foreach($genres as $g) Genre::create($g);
    }
}
