<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Book extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'detail',
        'license',
        'reading_level_id',
        'daerah_id',
        'cover_image',
        'pdf_file',
    ];

    /**
     * Tingkat baca buku ini.
     */
    public function readingLevel(): BelongsTo
    {
        return $this->belongsTo(ReadingLevel::class);
    }

    /**
     * Daerah asal buku (one-to-many: 1 buku punya 1 daerah).
     */
    public function daerah(): BelongsTo
    {
        return $this->belongsTo(Daerah::class, 'daerah_id');
    }

    /**
     * Statistik buku (views, likes, reads).
     */
    public function stat(): HasOne
    {
        return $this->hasOne(BookStat::class);
    }

    /**
     * Kategori-kategori buku ini (many-to-many).
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'book_categories');
    }

    /**
     * Jenis-jenis buku ini (many-to-many) — legacy.
     */
    public function bookTypes(): BelongsToMany
    {
        return $this->belongsToMany(BookType::class, 'book_book_type');
    }

    /**
     * URL cover image.
     */
    public function getCoverUrlAttribute(): ?string
    {
        return $this->cover_image ? asset('storage/' . $this->cover_image) : null;
    }

    /**
     * URL file PDF.
     */
    public function getPdfUrlAttribute(): ?string
    {
        return $this->pdf_file ? asset('storage/' . $this->pdf_file) : null;
    }
}
