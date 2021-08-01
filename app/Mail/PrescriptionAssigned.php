<?php

namespace App\Mail;

use App\Models\Prescription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PrescriptionAssigned extends Mailable
{
    use Queueable, SerializesModels;

    public $prescription;

    /**
     * Create a new message instance.
     *
     * @param Prescription $prescription
     */
    public function __construct(Prescription $prescription)
    {
        $this->prescription = $prescription;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.prescriptionAssigned');
    }
}
