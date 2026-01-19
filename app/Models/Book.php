<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['title','author','published_year','genre_id','rating','description','photo'];
    
    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }
}
