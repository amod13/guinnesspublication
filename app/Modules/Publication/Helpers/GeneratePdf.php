<?php

namespace App\Modules\Publication\Helpers;

use setasign\Fpdi\Fpdi;
use App\Modules\Publication\Models\Book;

class GeneratePdf
{
    public static function generateAllowedPagesPdf($bookId, $allowedPageNumbers)
    {
        return self::extractPdfPages($bookId, $allowedPageNumbers);
    }

    private static function extractPdfPages($bookId, $allowedPageNumbers)
    {
        // Get book record to find PDF path
        $book = Book::find($bookId);
        if (!$book || !$book->pdf_file) {
            throw new \Exception('Book or PDF file not found');
        }

        // Get original PDF path from storage
        $mediaUrl = $book->getMediaUrl('pdf_file');
        // Convert URL to local file path
        $originalPdfPath = public_path(str_replace(url('/'), '', $mediaUrl));

        if (!file_exists($originalPdfPath)) {
            throw new \Exception('Original PDF file not found at: ' . $originalPdfPath);
        }

        $pdf = new Fpdi();
        $pageCount = $pdf->setSourceFile($originalPdfPath);

        // Show all pages but blur non-allowed ones
        for ($i = 1; $i <= $pageCount; $i++) {
            $template = $pdf->importPage($i);
            $pdf->AddPage();
            $pdf->useTemplate($template);

            // If page is not allowed, add blur overlay
            if (!in_array($i, $allowedPageNumbers)) {
                self::addBlurOverlay($pdf);
            }
        }

        return $pdf->Output('S');
    }

  private static function addBlurOverlay($pdf)
    {
        // Add white overlay to hide content
        $pdf->SetFillColor(240, 240, 240); // Light gray overlay
        $pdf->Rect(0, 0, 210, 297, 'F'); // A4 size overlay

        // Add "Premium Content" text
        $pdf->SetFont('Arial', 'B', 24);
        $pdf->SetTextColor(100, 100, 100); // Dark gray text
        $pdf->SetXY(50, 140);
        $pdf->Cell(110, 20, 'Premium Content', 0, 0, 'C');
        $pdf->SetXY(50, 160);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(110, 10, 'Login First', 0, 0, 'C');
    }
}
