<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            [
                'group' => "ldap",
                'name' => "liste_sigles",
                'value' => "gt,rh,si,it,sav,in,bss,msan,rva,erp,dr",
                'type' => "array",
                'description' => "liste des sigles (à prendre en compte dans l importation LDAP)."
            ]
        ];
        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}
