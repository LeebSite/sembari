<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookStat extends Model
{
    protected $table = 'book_stats';

    protected $fillable = [
        'book_id',
        'views_count',
        'likes_count',
        'reads_count',
    ];

    protected $casts = [
        'views_count' => 'integer',
        'likes_count' => 'integer',
        'reads_count' => 'integer',
    ];

    /**
     * Buku yang dimiliki statistik ini.
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
