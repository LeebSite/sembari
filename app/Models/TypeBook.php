<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TypeBook extends Model
{
    protected $table = 'book_types'; 
    protected $fillable = ['name', 'slug'];

    public function books(): BelongsToMany
    {
        // Karena nama tabel pivot kamu adalah book_book_type
        return $this->belongsToMany(Book::class, 'book_book_type', 'book_type_id', 'book_id');
    }
}