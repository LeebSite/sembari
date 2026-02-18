<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BookType extends Model
{
    protected $table = 'book_types';

    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * Buku-buku dengan jenis ini (many-to-many).
     */
    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'book_book_type');
    }
}
