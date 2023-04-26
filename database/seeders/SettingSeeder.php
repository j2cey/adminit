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

        // groupe ReportFileType
        $group = $this->createNew("reportfiletype", null, null, "string", ",", "settings ReportFileType.");
        // value ldap.reportfiletype_extension_is_unique
        $this->createNew("reportfiletype_extension_is_unique", $group->id, "false", "bool", ",", "Détermine si l'extension d'un ReportFileType doit être UNIQUE.");

        // groupe ReportFile
        $group = $this->createNew("reportfile", null, null, "string", ",", "settings ReportFile.");
        // value reportfile.retrieve_by_wildcard_label
        $this->createNew("retrieve_by_wildcard_label", $group->id, "Par Wildcard", "string", ",", "Libellé pour le champs 'retrieve_by_wildcard'.");
        // value reportfile.retrieve_by_name_label
        $this->createNew("retrieve_by_name_label", $group->id, "Par Nom", "string", ",", "Libellé pour le champs 'retrieve_by_name_label'.");

        // groupe SelectedRetrieveAction
        $group = $this->createNew("selretrieveaction", null, null, "string", ",", "settings SelectedRetrieveAction.");
        // value selretrieveaction.default_actions_scopes
        $this->createNew("default_actions_scopes", $group->id, "retrieveByName,renameFile", "array", ",", "liste des actions par défaut.");

        // groupe ReportTreatment
        $group = $this->createNew("reporttreatment", null, null, "string", ",", "settings ReportTreatments.");
        // value reporttreatment.max_retries
        $this->createNew("max_retries", $group->id, "5", "integer", ",", "nombre max de tentatives de retraitement.");
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
