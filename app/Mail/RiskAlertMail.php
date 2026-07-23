<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RiskAlertMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $alertSubject;
    public $alertMessage;
    public $actionUrl;

    public function __construct($alertSubject, $alertMessage, $actionUrl)
    {
        $this->alertSubject = $alertSubject;
        $this->alertMessage = $alertMessage;
        $this->actionUrl = $actionUrl;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Alerta do Sistema de Gestão de Riscos: ' . $this->alertSubject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.risk-alert',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
