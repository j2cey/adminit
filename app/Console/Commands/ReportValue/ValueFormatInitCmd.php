<?php

namespace App\Console\Commands\ReportValue;

use App\Enums\HtmlTagKey;
use Illuminate\Console\Command;
use App\Models\DynamicValue\DynamicValue;
use App\Models\ReportTreatments\Treatment;

class ValueFormatInitCmd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'valueformat:init {dynamicvalueId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $dynamicvalueId = (int) $this->argument('dynamicvalueId');

        if ( empty($dynamicvalueId) ) {
            $this->error("No Treatment ID provided !");
        } else {
            $dynamicvalue = DynamicValue::getById($dynamicvalueId);

            $dynamicvalue->setFormattedValue(HtmlTagKey::TABLE_COL);//, $thevalue);
            $dynamicvalue->setDefaultFormatSize();


            $max_tries = 10;
            do {
                $format_value_set = $this->initFormat($dynamicvalue);
                $max_tries--;
            } while ( ! $format_value_set && ( $max_tries > 0 ) );

            if ( $format_value_set ) {
                $new_row_imported = $dynamicvalue->dynamicrow->setValuesImported();
                $dynamicvalue->dynamicrow->hasdynamicrow->setRowsImported($new_row_imported);
            }
        }
        return 0;
    }

    private function initFormat(DynamicValue $dynamicvalue): bool {
        $dynamicvalue->refresh();
        if ( $dynamicvalue->htmlformattedvalue && $dynamicvalue->smsformattedvalue ) {
            $dynamicvalue->initFormattedValue();
            return true;
        }
        return false;
    }
}
