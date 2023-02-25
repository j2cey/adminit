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
        // groupe app_name
        $this->createNew("app_name", null, "Gestion-Cheques", "string", ",", "Application Name.");
        // groupe roles
        $group = $this->createNew("roles", null, null, "string", ",", "settings Roles.");
        $this->createNew("default", $group->id, "1", "integer", ",", "Role par défaut à la création d un utilisateur dont le role n est pas explicitement déterminé.");
        // groupe files
        $group = $this->createNew("files", null, null, null, ",", "settings Files.");
        // sub groupe files.uploads
        $group = $this->createNew("uploads", $group->id, null, null, ",", "Uploads.");
        // sub groupe files.uploads.max_size
        $group = $this->createNew("max_size", $group->id, null, null, ",", "Max Size.");
        $this->createNew("any", $group->id, "10", "integer", ",", "Any file Max size.");
        $this->createNew("image", $group->id, "5", "integer", ",", "Image file Max size.");
        $this->createNew("video", $group->id, "10", "integer", ",", "Video file Max size.");

        // groupe ldap
        $group = $this->createNew("ldap", null, null, "string", ",", "settings LDAP.");
        // value ldap.liste_sigles
        $this->createNew("liste_sigles", $group->id, "gt,rh,si,it,sav,in,bss,msan,rva,erp,dr", "array", ",", "liste des sigles (à prendre en compte dans l importation LDAP).");
    }

    private function createNew($name, $group_id = null, $value = null, $type = null, $array_sep = ",", $description = null)
    {
        $data = ['name' => $name, 'array_sep' => $array_sep];
        if (!is_null($group_id)) {
            $data['group_id'] = $group_id;
        }
        if (!is_null($value)) {
            $data['value'] = $value;
        }
        if (!is_null($type)) {
            $data['type'] = $type;
        }
        if (!is_null($description)) {
            $data['description'] = $description;
        }
        return Setting::create($data);
    }
}
