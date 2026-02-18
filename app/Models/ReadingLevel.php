<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReadingLevel extends Model
{
    protected $fillable = [
        'name',
        'order',
        'description',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    /**
     * Buku-buku dengan tingkat baca ini.
     */
    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}
