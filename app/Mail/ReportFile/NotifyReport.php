<?php

namespace App\Mail\ReportFile;

use Nette\Utils\Html;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\ReportFile\CollectedReportFile;

class NotifyReport extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public CollectedReportFile $collectedreportfile;
    public ?string $htmlvalue;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(CollectedReportFile $collectedreportfile)
    {
        $this->subject = $collectedreportfile->reportfile->report->title . " (" . $collectedreportfile->reportfile->name . ")";
        $this->collectedreportfile = $collectedreportfile;

        $this->htmlvalue = $collectedreportfile->htmlformattedvalue->getFormattedValue();
        //$this->htmlvalue = str_replace(['&quot;'], [''], $collectedreportfile->htmlformattedvalue->getFormattedValue());
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //return $this->view('view.name');
        return $this->subject($this->subject)
            ->view('reports.emailnotify');
            //->with('value', $this->collectedreportfile->formattedvalue->value );
    }
}
