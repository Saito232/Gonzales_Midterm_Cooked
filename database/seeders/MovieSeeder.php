<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Movie;
use App\Models\Genre;

class MovieSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['title'=>'Skyfall','director'=>'Sam Mendes','release_year'=>2012,'genre'=>'Action','rating'=>7.8],
            ['title'=>'Inception','director'=>'Christopher Nolan','release_year'=>2010,'genre'=>'Sci-Fi','rating'=>8.8],
            ['title'=>'The Godfather','director'=>'Francis Ford Coppola','release_year'=>1972,'genre'=>'Drama','rating'=>9.2],
            ['title'=>'The Hangover','director'=>'Todd Phillips','release_year'=>2009,'genre'=>'Comedy','rating'=>7.7],
            ['title'=>'Get Out','director'=>'Jordan Peele','release_year'=>2017,'genre'=>'Horror','rating'=>7.7],
        ];
        foreach($data as $d){
            $genre = Genre::where('name',$d['genre'])->first();
            Movie::create([
                'title'=>$d['title'],
                'director'=>$d['director'],
                'release_year'=>$d['release_year'],
                'genre_id'=>$genre? $genre->id : null,
                'rating'=>$d['rating'],
                'description'=>'' 
            ]);
        }
    }
}
