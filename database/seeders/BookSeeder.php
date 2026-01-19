<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Genre;

class BookSeeder extends Seeder
{
    public function run()
    {
        $books = [
            ['title'=>'The Great Gatsby','author'=>'F. Scott Fitzgerald','published_year'=>2020,'genre'=>'Drama','rating'=>'9.2','description'=>'A classic American novel about the Jazz Age.'],
            ['title'=>'1984','author'=>'George Orwell','published_year'=>2019,'genre'=>'Sci-Fi','rating'=>'9.0','description'=>'A dystopian social science fiction novel.'],
            ['title'=>'To Kill a Mockingbird','author'=>'Harper Lee','published_year'=>2018,'genre'=>'Drama','rating'=>'8.8','description'=>'A novel about racial injustice in the Deep South.'],
            ['title'=>'The Hitchhiker\'s Guide to the Galaxy','author'=>'Douglas Adams','published_year'=>2021,'genre'=>'Comedy','rating'=>'8.5','description'=>'A comedic science fiction series.'],
            ['title'=>'Dune','author'=>'Frank Herbert','published_year'=>2022,'genre'=>'Sci-Fi','rating'=>'9.1','description'=>'A science fiction novel set in a distant future.'],
            ['title'=>'The Shining','author'=>'Stephen King','published_year'=>2017,'genre'=>'Horror','rating'=>'8.3','description'=>'A horror novel about a family isolated in a hotel.'],
            ['title'=>'Pride and Prejudice','author'=>'Jane Austen','published_year'=>2023,'genre'=>'Romance','rating'=>'8.9','description'=>'A romantic novel of manners.'],
            ['title'=>'The Hobbit','author'=>'J.R.R. Tolkien','published_year'=>2024,'genre'=>'Fantasy','rating'=>'8.7','description'=>'A fantasy adventure novel.'],
            ['title'=>'Good Omens','author'=>'Neil Gaiman & Terry Pratchett','published_year'=>2025,'genre'=>'Comedy','rating'=>'8.6','description'=>'A comedic fantasy novel about the apocalypse.'],
            ['title'=>'Dracula','author'=>'Bram Stoker','published_year'=>2016,'genre'=>'Horror','rating'=>'8.4','description'=>'A Gothic horror novel about Count Dracula.'],
            ['title'=>'Harry Potter and the Philosopher\'s Stone','author'=>'J.K. Rowling','published_year'=>2020,'genre'=>'Fantasy','rating'=>'9.3','description'=>'A young wizard discovers his magical heritage.'],
            ['title'=>'The Da Vinci Code','author'=>'Dan Brown','published_year'=>2021,'genre'=>'Mystery','rating'=>'8.2','description'=>'A symbologist uncovers a religious mystery.'],
            ['title'=>'Gone Girl','author'=>'Gillian Flynn','published_year'=>2019,'genre'=>'Thriller','rating'=>'8.5','description'=>'A wife disappears on her anniversary.'],
            ['title'=>'The Lord of the Rings','author'=>'J.R.R. Tolkien','published_year'=>2022,'genre'=>'Fantasy','rating'=>'9.5','description'=>'An epic fantasy trilogy about Middle-earth.'],
            ['title'=>'Steve Jobs','author'=>'Walter Isaacson','published_year'=>2018,'genre'=>'Biography','rating'=>'8.7','description'=>'The biography of Apple co-founder Steve Jobs.'],
            ['title'=>'The Notebook','author'=>'Nicholas Sparks','published_year'=>2017,'genre'=>'Romance','rating'=>'8.1','description'=>'A timeless love story.'],
            ['title'=>'Sherlock Holmes: The Complete Collection','author'=>'Arthur Conan Doyle','published_year'=>2023,'genre'=>'Mystery','rating'=>'9.0','description'=>'Classic detective mysteries.'],
            ['title'=>'The Martian','author'=>'Andy Weir','published_year'=>2024,'genre'=>'Sci-Fi','rating'=>'8.8','description'=>'An astronaut is stranded on Mars.'],
            ['title'=>'Becoming','author'=>'Michelle Obama','published_year'=>2025,'genre'=>'Biography','rating'=>'8.9','description'=>'Memoir of former First Lady Michelle Obama.'],
            ['title'=>'The Count of Monte Cristo','author'=>'Alexandre Dumas','published_year'=>2016,'genre'=>'Adventure','rating'=>'9.1','description'=>'A tale of wrongful imprisonment and revenge.'],
        ];

        foreach($books as $b){
            $genre = Genre::where('name',$b['genre'])->first();
            Book::firstOrCreate(
                ['title' => $b['title']],
                [
                    'author'=>$b['author'],
                    'published_year'=>$b['published_year'],
                    'genre_id'=>$genre ? $genre->id : null,
                    'rating'=>$b['rating'],
                    'description'=>$b['description']
                ]
            );
        }
    }
}
