<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    protected $fillable = ['title','author','published_year','genre_id','rating','description'];
    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }
}
