<?php

namespace App\Traits\Person;

use App\Models\Status;
use App\Models\Person\EmailAddress;

/**
 * @property EmailAddress[] $emailaddresses
 */
trait HasEmailAddresses
{
    /**
     * Renvoie les e-mails (Adresseemail) de ce model.
     */
    public function emailaddresses()
    {
        return $this->morphMany(EmailAddress::class, 'hasemailaddress');
    }

    public function latestEmailAddress()
    {
        return $this->morphOne(EmailAddress::class, 'hasemailaddress')->latest('id');
    }

    public function oldestEmailAddress()
    {
        return $this->morphOne(EmailAddress::class, 'hasemailaddress')->oldest('id');
    }

    public function addNewEmailAddress($email) : ?EmailAddress
    {
        // TODO: Valider l'adresse mail
        if (empty($email)) {
            return null;
        }

        $adresseemail = $this->emailaddresses()->where('email', $email)->where('hasemailaddress_type', get_class($this))->first();
        if ($adresseemail) {
            return $adresseemail;
        }

        $adresseemail_count = $this->emailaddresses()->count();

        $adresseemail = $this->emailaddresses()->create([
            'email' => $email,
            'posi' => $adresseemail_count,
            'status_id' => Status::active()->first()->id,
        ]);

        return $adresseemail;
    }

    public function hasThisEmail($email) {
        if ( $this->emailaddresses()->where('email', $email)->count() > 0 ) {
            return true;
        } else {
            return false;
        }
    }

    public function removeEmailAddress($email) {
        $email = $this->emailaddresses()->where('email', $email)->first();
        if ($email) {
            $email->delete();
        }
    }
    public function removeEmailAddressesAll() {
        $this->emailaddresses()->each( function($email) {
            $email->delete();
        });
    }

    /**
     * Add, dynamically, Eloquent relation (eager loading) to this model
     */
    protected function initializeHasEmailAddresses()
    {
        $this->with = array_unique(array_merge($this->with, ['emailaddresses','latestEmailAddress','oldestEmailAddress']));
    }

    public static function bootHasEmailAddresses()
    {
        static::deleting(function ($model) {
            $model->removeEmailAddressesAll();
        });
    }
}
