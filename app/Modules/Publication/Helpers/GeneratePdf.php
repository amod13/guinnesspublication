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
        // Light gray overlay
        $pdf->SetFillColor(240, 240, 240);
        $pdf->Rect(0, 0, 210, 297, 'F');

        // Add image (example: lock icon)
        // Path must be absolute
        $imagePath = public_path('admin/assets/img/loginpart.png');
        $pdf->Image($imagePath, 80, 70, 50); // (x, y, width)

        // Title
        $pdf->SetFont('Arial', 'B', 24);
        $pdf->SetTextColor(100, 100, 100);
        $pdf->SetXY(50, 140);
        $pdf->Cell(110, 20, 'Premium Content (You are not logged in)', 0, 0, 'C');

        // Subtitle
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetXY(50, 160);
        $pdf->Cell(110, 10, 'Login First', 0, 0, 'C');
    }
}
