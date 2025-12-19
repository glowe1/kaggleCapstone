<?php

namespace App\Mail;

use App\Models\ResidentSignOut;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class ResidentSignOutNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public ResidentSignOut $signOut,
        public string $eventType // 'signed_out', 'returned'
    ) {}

    public function envelope(): Envelope
    {
        $residentName = trim(($this->signOut->resident->first_name ?? '') . ' ' . ($this->signOut->resident->last_name ?? ''));
        
        $subject = match($this->eventType) {
            'signed_out' => "Resident Signed Out: {$residentName}",
            'returned' => "Resident Returned: {$residentName}",
            default => "Resident Sign-Out Update: {$residentName}",
        };
        
        return new Envelope(
            subject: $subject,
        );
    }

    public function content(): Content
    {
        $residentName = trim(($this->signOut->resident->first_name ?? '') . ' ' . ($this->signOut->resident->last_name ?? ''));
        $signedOutByName = $this->signOut->signedOutBy 
            ? trim(($this->signOut->signedOutBy->first_name ?? '') . ' ' . ($this->signOut->signedOutBy->last_name ?? ''))
            : 'Staff';
        $signOutDate = $this->signOut->sign_out_time ? Carbon::parse($this->signOut->sign_out_time)->format('M d, Y g:i A') : 'TBD';
        $returnDate = $this->signOut->return_time ? Carbon::parse($this->signOut->return_time)->format('M d, Y g:i A') : null;
        $destination = $this->signOut->destination ?? 'Not specified';
        $accompaniedBy = $this->signOut->accompanied_by ?? 'Not specified';
        
        return new Content(
            text: 'mail.resident-sign-out',
            with: [
                'residentName' => $residentName,
                'signedOutByName' => $signedOutByName,
                'signOutDate' => $signOutDate,
                'returnDate' => $returnDate,
                'destination' => $destination,
                'accompaniedBy' => $accompaniedBy,
                'eventType' => $this->eventType,
                'expectedReturnTime' => $this->signOut->expected_return_time?->format('M d, Y g:i A'),
                'notes' => $this->signOut->notes,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

