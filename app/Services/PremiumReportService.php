<?php

namespace App\Services;

use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class PremiumReportService
{
    /**
     * Generate a professional PDF from a Blade view using Browsershot.
     * 
     * @param string $view The blade view name
     * @param array $data Data to pass to the view
     * @param string|null $filename Optional filename for the download or storage
     * @param array $options Additional Browsershot options
     * @return string The binary PDF content
     */
    public function generate(string $view, array $data = [], ?string $filename = null, array $options = []): string
    {
        Log::debug('Starting professional PDF generation', ['view' => $view, 'filename' => $filename]);

        // Render the HTML view
        $html = View::make($view, $data)->render();

        // Initialize Browsershot
        $browsershot = Browsershot::html($html)
            ->format($options['format'] ?? 'A4')
            ->margins(
                $options['margin_top'] ?? 10,
                $options['margin_right'] ?? 10,
                $options['margin_bottom'] ?? 10,
                $options['margin_left'] ?? 10
            )
            ->showBackground();

        // Handle orientation
        if (($options['orientation'] ?? 'portrait') === 'landscape') {
            $browsershot->landscape();
        }

        // Environment-aware binary paths
        $chromePath = env('CHROME_PATH', '/usr/bin/google-chrome');
        if (!file_exists($chromePath)) {
            $chromePath = '/usr/bin/google-chrome-stable';
            if (!file_exists($chromePath)) {
                $chromePath = '/usr/bin/chromium-browser';
                if (!file_exists($chromePath)) {
                    $chromePath = '/usr/bin/chromium';
                }
            }
        }

        if (file_exists($chromePath)) {
            Log::debug('Using Chrome binary at: ' . $chromePath);
            $browsershot->setChromePath($chromePath);
        } else {
            Log::warning('Chrome binary not found at standard paths. Browsershot will attempt auto-discovery.');
        }

        if (file_exists('/usr/bin/node')) {
            $browsershot->setNodeBinary('/usr/bin/node');
        }

        if (file_exists('/usr/bin/npm')) {
            $browsershot->setNpmBinary('/usr/bin/npm');
        }

        // Optimized settings for production stability
        $browsershot->timeout(120) // Even higher timeout for heavy reports
            ->addChromiumArguments([
                'no-sandbox',
                'disable-setuid-sandbox',
                'disable-dev-shm-usage',
                'disable-gpu',
                'disable-extensions',
                'font-render-hinting=none',
                'disable-web-security'
            ]);

        return $browsershot->pdf();
    }
}
