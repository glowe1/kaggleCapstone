<?php

namespace App\Mail;

use App\Models\StaffClockIn;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class StaffClockInNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public StaffClockIn $clockIn,
        public string $eventType // 'clocked_in', 'clocked_out'
    ) {}

    public function envelope(): Envelope
    {
        $staffName = trim(($this->clockIn->staff->first_name ?? '') . ' ' . ($this->clockIn->staff->last_name ?? ''));
        
        $subject = match($this->eventType) {
            'clocked_in' => "Staff Clocked In: {$staffName}",
            'clocked_out' => "Staff Clocked Out: {$staffName}",
            default => "Staff Clock Update: {$staffName}",
        };
        
        return new Envelope(
            subject: $subject,
        );
    }

    public function content(): Content
    {
        $staffName = trim(($this->clockIn->staff->first_name ?? '') . ' ' . ($this->clockIn->staff->last_name ?? ''));
        $clockInTime = $this->clockIn->clock_in_time ? Carbon::parse($this->clockIn->clock_in_time)->format('M d, Y g:i A') : 'TBD';
        $clockOutTime = $this->clockIn->clock_out_time ? Carbon::parse($this->clockIn->clock_out_time)->format('M d, Y g:i A') : null;
        $branchName = $this->clockIn->branch?->name ?? 'Branch';
        
        return new Content(
            text: 'mail.staff-clock-in',
            with: [
                'staffName' => $staffName,
                'clockInTime' => $clockInTime,
                'clockOutTime' => $clockOutTime,
                'branchName' => $branchName,
                'eventType' => $this->eventType,
                'notes' => $this->clockIn->notes,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

