<?php

namespace App\Mail;

use App\Models\Medication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MedicationNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Medication $medication
    ) {}

    public function envelope(): Envelope
    {
        $medicationName = $this->medication->drug?->name ?? $this->medication->name;
        $residentName = trim(($this->medication->resident->first_name ?? '') . ' ' . ($this->medication->resident->last_name ?? ''));
        
        return new Envelope(
            subject: "New Medication Added: {$medicationName} - {$residentName}",
        );
    }

    public function content(): Content
    {
        $medicationName = $this->medication->drug?->name ?? $this->medication->name;
        $residentName = trim(($this->medication->resident->first_name ?? '') . ' ' . ($this->medication->resident->last_name ?? ''));
        $dosage = $this->medication->dosage ?? 'Not specified';
        $frequency = $this->medication->frequency ?? 'Not specified';
        $route = $this->medication->route ?? 'Not specified';
        
        return new Content(
            text: 'mail.medication',
            with: [
                'medicationName' => $medicationName,
                'residentName' => $residentName,
                'dosage' => $dosage,
                'frequency' => $frequency,
                'route' => $route,
                'startDate' => $this->medication->start_date?->format('M d, Y'),
                'endDate' => $this->medication->end_date?->format('M d, Y'),
                'instructions' => $this->medication->instructions,
                'notes' => $this->medication->notes,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

