<?php

namespace App\Services\PDF;

use Dompdf\Dompdf;
use Illuminate\Http\UploadedFile;

class FlightReportPdfService
{
    /**
     * Generate PDF file from txt file.
     */
    public function generateFromFile(UploadedFile $file): string
    {
        $rawContent = file_get_contents($file->getRealPath());

        $utf8 = iconv('CP852', 'UTF-8', $rawContent);

        $htmlReady = $this->transformControlCodes($utf8);
        $htmlReady = $this->centerOnlyFirstPage($htmlReady);

        // Debug html file
        // file_put_contents(storage_path('app/debug.html'), $htmlReady);

        $html = view('pdf.branch', ['content' => $htmlReady])->render();

        $dompdf = new Dompdf();
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->loadHtml($html);
        $dompdf->render();

        return $dompdf->output();
    }

    private function transformControlCodes(string $text): string
    {
        $text = str_replace("\e", '[ESC]', $text);
        $text = str_replace('[ESC]2', '', $text);

        $text = preg_replace_callback(
            '/\[ESC\]G\[ESC\]W1(.*?)(\[ESC\]H)?\[ESC\]W0/s',
            fn($m) => '<h1>' . e(trim($m[1])) . '</h1>',
            $text
        );

        $text = preg_replace_callback(
            '/\[ESC\]G\[ESC\]W1(.*?)\[ESC\]W0/s',
            fn($m) => '<h2>' . e(trim($m[1])) . '</h2>',
            $text
        );

        $text = preg_replace_callback(
            '/\[ESC\]36(.*?)\[ESC\]H/s',
            fn($m) => '<h3>' . e(trim($m[1])) . '</h3>',
            $text
        );

        $text = str_replace("\f", '<div class="page-break"></div>', $text);
        $text = str_replace('[ESC]', '', $text);
        $text = str_replace(["\r\n", "\n", "\r"], "<br />", $text);

        return $text;
    }

    private function centerOnlyFirstPage(string $html): string
    {
        $parts = explode('<div class="page-break"></div>', $html, 2);

        if (count($parts) < 2) {
            return $html;
        }

        $centered = <<<HTML
            <div class="first-page-center">
                <div class="first-page-inner">
                    {$parts[0]}
                </div>
            </div>
        HTML;

        return $centered . '<div class="page-break"></div>' . $parts[1];
    }
}
