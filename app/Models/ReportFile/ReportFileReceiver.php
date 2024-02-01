<?php

namespace App\Models\ReportFile;

use App\Models\Status;
use App\Models\BaseModel;
use App\Models\Person\Person;
use App\Models\Person\PhoneNumber;
use App\Models\Person\EmailAddress;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @method static ReportFileReceiver create(array $array)
 * @property Person $person
 * @property EmailAddress $emailaddress
 * @property PhoneNumber $phonenumber
 */
class ReportFileReceiver extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    #region Validation Rules

    public static function defaultRules()
    {
        return [
        ];
    }

    public static function createRules()
    {
        return array_merge(self::defaultRules(), [

        ]);
    }

    public static function updateRules($model)
    {
        return array_merge(self::defaultRules($model), [
        ]);
    }

    public static function messagesRules()
    {
        return [
        ];
    }

    #region Scopes

    #endregion

    #region Eloquent Relationships

    public function reportfile() {
        return $this->belongsTo(ReportFile::class, 'report_file_id');
    }

    public function person() {
        return $this->belongsTo(Person::class, 'person_id');
    }

    public function emailaddress() {
        return $this->belongsTo(EmailAddress::class, 'email_address_id');
    }

    public function phonenumber() {
        return $this->belongsTo(PhoneNumber::class, 'phone_number_id');
    }

    #endregion

    /**
     * Create a New Person
     * @param ReportFile $reportfile First Name
     * @param Person $person
     * @param EmailAddress $emailaddress
     * @param PhoneNumber $phonenumber
     * @param Status|null $status Statut
     * @return ReportFileReceiver
     */
    public static function createNew(ReportFile $reportfile, Person $person, EmailAddress $emailaddress, PhoneNumber $phonenumber, Status $status = null): ReportFileReceiver
    {
        $status = is_null($status) ? Status::default()->first() : $status;

        $reportfilereceiver = ReportFileReceiver::create([]);

        $reportfilereceiver->status()->associate($status)->save();
        $reportfilereceiver->reportfile()->associate($reportfile)->save();

        $reportfilereceiver->person()->associate($person)->save();
        $reportfilereceiver->emailaddress()->associate($emailaddress)->save();
        $reportfilereceiver->phonenumber()->associate($phonenumber)->save();

        return $reportfilereceiver;
    }

    /**
     * @param int $id
     * @return ReportFileReceiver|null
     */
    public static function getById(int $id) {
        return ReportFileReceiver::find($id);
    }
}
