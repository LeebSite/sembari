<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Daerah extends Model
{
    protected $table = 'daerah';

    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * Buku-buku dari daerah ini (one-to-many).
     * Satu daerah bisa memiliki banyak buku.
     */
    public function books(): HasMany
    {
        return $this->hasMany(Book::class, 'daerah_id');
    }
}
