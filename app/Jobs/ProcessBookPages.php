<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessBookPages implements ShouldQueue
{
    use Queueable;

    protected $book;

    /**
     * Create a new job instance.
     */
    public function __construct(\App\Models\Book $book)
    {
        $this->book = $book;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (!$this->book->pdf_file) {
            return;
        }

        $pdfPath = storage_path('app/public/' . $this->book->pdf_file);
        
        if (!file_exists($pdfPath)) {
            \Log::error("PDF file not found: " . $pdfPath);
            return;
        }

        $outputDir = storage_path('app/public/books/' . $this->book->id . '/pages');

        if (!file_exists($outputDir)) {
            mkdir($outputDir, 0755, true);
        }

        if (!extension_loaded('imagick')) {
            \Log::error("Imagick extension is not loaded. PDF conversion requires Imagick and Ghostscript.");
            return;
        }

        try {
            $pdf = new \Spatie\PdfToImage\Pdf($pdfPath);
            $numberOfPages = $pdf->getNumberOfPages();

            for ($i = 1; $i <= $numberOfPages; $i++) {
                $imagePath = $outputDir . '/page-' . $i . '.jpg';
                if (!file_exists($imagePath)) {
                    $pdf->setPage($i)
                        ->saveImage($imagePath);
                }
            }
        } catch (\Exception $e) {
            \Log::error("Failed to process PDF for book {$this->book->id}: " . $e->getMessage());
        }
    }
}
