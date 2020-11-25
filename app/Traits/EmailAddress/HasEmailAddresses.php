<?php

namespace App\Traits\EmailAddress;

use App\Models\Status;
use App\Models\EmailAddress;

trait HasEmailAddresses
{
    /**
     * Renvoie les e-mails (Adresseemail) de ce model.
     */
    public function emailaddresses() {
        $elem_type = get_called_class();
        return $this->belongsToMany('App\EmailAddress', 'model_has_email_addresses', 'email_address_id', 'model_id')
            ->wherePivot('model_type', $elem_type)
            ->withPivot('posi')
            ->withTimestamps()
            ->orderBy('posi','asc');
    }

    public function addNewEmailAddress($email)
    {
        // TODO: Valider l'adresse mail
        if (empty($email)) {
            return false;
        }

        $elem_type = get_called_class();

        $adresseemail = EmailAddress::create([
            'email' => $email,
            'status_id' => Status::active()->first()->id,
        ]);

        $adresseemail_count = $this->emailaddresses()->count();

        $this->emailaddresses()->attach($adresseemail->id, [
            'model_type' => $elem_type,
            'model_id' => $this->id,
            'posi' => $adresseemail_count,
        ]);
        return true;
    }
}
