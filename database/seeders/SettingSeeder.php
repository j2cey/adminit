<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Enums\Settings;
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
        /*
        // groupe app_name
        Setting::createNew("app_name", null, "Gestion-Cheques", "string", ",", "Application Name.");
        // groupe roles
        $group = Setting::createNew("roles", null, null, "string", ",", "settings Roles.");
        Setting::createNew("default", $group, "1", "integer", ",", "Role par défaut à la création d un utilisateur dont le role n est pas explicitement déterminé.");
        // groupe files
        $group = Setting::createNew("files", null, null, null, ",", "settings Files.");
        // sub groupe files.uploads
        $group = Setting::createNew("uploads", $group, null, null, ",", "Uploads.");
        // sub groupe files.uploads.max_size
        $group = Setting::createNew("max_size", $group, null, null, ",", "Max Size.");
        Setting::createNew("any", $group, "10", "integer", ",", "Any file Max size.");
        Setting::createNew("image", $group, "5", "integer", ",", "Image file Max size.");
        Setting::createNew("video", $group, "10", "integer", ",", "Video file Max size.");

        // groupe ldap
        $group = Setting::createNew("ldap", null, null, "string", ",", "settings LDAP.");
        // value ldap.liste_sigles
        Setting::createNew("liste_sigles", $group, "gt,rh,si,it,sav,in,bss,msan,rva,erp,dr", "array", ",", "liste des sigles (à prendre en compte dans l importation LDAP).");

        // groupe ReportFileType
        $group = Setting::createNew("reportfiletype", null, null, "string", ",", "settings ReportFileType.");
        // value reportfiletype.extension_is_unique
        Setting::createNew("extension_is_unique", $group, "0", "bool", ",", "Détermine si l'extension d'un ReportFileType doit être UNIQUE.");

        // groupe ReportFile
        $group = Setting::createNew("reportfile", null, null, "string", ",", "settings ReportFile.");
        // value reportfile.retrieve_by_wildcard_label
        Setting::createNew("retrieve_by_wildcard_label", $group, "Par Wildcard", "string", ",", "Libellé pour le champs 'retrieve_by_wildcard'.");
        // value reportfile.retrieve_by_name_label
        Setting::createNew("retrieve_by_name_label", $group, "Par Nom", "string", ",", "Libellé pour le champs 'retrieve_by_name_label'.");

        // groupe SelectedRetrieveAction
        $group = Setting::createNew("selretrieveaction", null, null, "string", ",", "settings SelectedRetrieveAction.");
        // value selretrieveaction.default_actions_scopes
        Setting::createNew("default_actions_scopes", $group, "retrieveByName,renameFile", "array", ",", "liste des actions par défaut.");

        // groupe ReportTreatment
        $group = Setting::createNew("reporttreatment", null, null, "string", ",", "settings ReportTreatments.");
        // value reporttreatment.activate
        Setting::createNew("activate", $group, "0", "bool", ",", "active ou desactive les traitements de Rapports.");
        // value reporttreatment.max_retries
        Setting::createNew("max_retries", $group, "5", "integer", ",", "nombre max de tentatives de retraitement.");
        // sub group reporttreatment.formatcolumns
        $group = Setting::createNew("formatcolumns", $group, null, null, ",", "Formattage des colonnes.");
        // value reporttreatment.formatcolumns.append_batch_max
        Setting::createNew("append_batch_max", $group, "5", "integer", ",", "nombre max de colonnes a ajouter au batch de traitement de la ligne.");

        // groupe queues
        $group = Setting::createNew("queues", null, null, "string", ",", "settings for Queues.");
        // sub group queues.workerbounds
        $group = Setting::createNew("workerbounds", $group, null, null, ",", "Min et Max du nombre de workers par type de traitement.");
        // value queues.workerbounds.listeners
        Setting::createNew("listeners", $group, "1,5", "array", ",", "workers bounds pour listeners.");
        // value queues.workerbounds.downloadfiles
        Setting::createNew("downloadfiles", $group, "1,5", "array", ",", "workers bounds pour downloadfiles.");
        // value queues.workerbounds.importlines
        Setting::createNew("importlines", $group, "1,5", "array", ",", "workers bounds pour importlines.");
        // value queues.workerbounds.importvalues
        Setting::createNew("importvalues", $group, "1,5", "array", ",", "workers bounds pour importvalues.");
        // value queues.workerbounds.formatvalues
        Setting::createNew("formatvalues", $group, "1,5", "array", ",", "workers bounds pour formatvalues.");
        */
        $class_methods = get_class_methods(Settings::class);

        foreach ($class_methods as $class_method) {
            $branch = Settings::$class_method();
            $branch->save();
            foreach ($branch->getChildren() as $child) {
                $child->save();
                $child->saveChildren();
            }
        }
    }

}
