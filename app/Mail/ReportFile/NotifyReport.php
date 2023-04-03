<?php

namespace App\Mail\ReportFile;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyReport extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->subject = "Alert Rapport";
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //return $this->view('view.name');
        return $this->subject($this->subject)->view('reports.emailnotify');
    }
}
