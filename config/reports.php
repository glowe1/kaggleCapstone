<?php

return [

    /*
    |--------------------------------------------------------------------------
    | PDF rendering driver
    |--------------------------------------------------------------------------
    |
    | auto       — Use Chromium via Browsershot when a binary is found; otherwise DomPDF.
    | dompdf     — Always DomPDF (recommended on hosts without Chrome/Node).
    | browsershot — Always Browsershot (falls back to DomPDF on failure).
    |
    */
    'pdf_driver' => env('REPORTS_PDF_DRIVER', 'auto'),

];
