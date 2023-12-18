<?php

namespace App\Traits\Person;

use App\Models\Status;
use App\Models\Person\PhoneNumber;

/**
 * @property PhoneNumber[] $phonenumbers
 */
trait HasPhoneNumbers
{
    public function phonenumbers()
    {
        return $this->morphMany(PhoneNumber::class, 'hasphonenumber');
    }

    public function latestPhonenumber()
    {
        return $this->morphOne(PhoneNumber::class, 'hasphonenumber')->latest('id');
    }

    public function oldestPhonenumber()
    {
        return $this->morphOne(Phonenumber::class, 'hasphonenumber')->oldest('id');
    }

    public function addNewPhoneNumber($number) : ?PhoneNumber
    {
        // TODO: Valider le numéro de Phone
        if (empty($number)) {
            return null;
        }

        $phonenumber = $this->phonenumbers()->where('number', $number)->first();
        if ($phonenumber) {
            return $phonenumber;
        }

        $phonenumber_count = $this->phonenumbers()->count();

        $phonenumber = $this->phonenumbers()->create([
            'number' => $number,
            'posi' => $phonenumber_count,
            'status_id' => Status::active()->first()->id,
        ]);

        return $phonenumber;
    }

    public function hasThisPhone($num) {
        if ( $this->phonenumbers()->where('number', $num)->count() > 0 ) {
            return true;
        } else {
            return false;
        }
    }

    public function removePhonenumber($num) {
        $rresult = null;

        $phonenumber = $this->phonenumbers()->where('number', $num)->first();
        if ($phonenumber) {
            $rresult = $phonenumber->delete();
        }
        return $rresult;
    }
    public function removePhonenumbersAll() {
        $this->phonenumbers()->each( function($phonenumber) {
            $phonenumber->delete();
        });
    }

    /**
     * Add, dynamically, Eloquent relation (eager loading) to this model
     */
    protected function initializeHasPhoneNumbers()
    {
        $this->with = array_unique(array_merge($this->with, ['phonenumbers','latestPhonenumber','oldestPhonenumber']));
    }

    public static function bootHasPhoneNumbers()
    {
        static::deleting(function ($model) {
            $model->removePhonenumbersAll();
        });
    }
}
