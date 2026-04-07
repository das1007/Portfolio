<?php
namespace App\Mail;
use Illuminate\Bus\Queueable; use Illuminate\Mail\Mailable; use Illuminate\Queue\SerializesModels; use App\Models\Contact;
class ContactNotification extends Mailable {
    use Queueable, SerializesModels;
    public Contact $contact;
    public function __construct(Contact $contact) { $this->contact = $contact; }
    public function build(): self { return $this->subject('🔔 New Contact: '.$this->contact->subject)->view('emails.contact'); }
}
