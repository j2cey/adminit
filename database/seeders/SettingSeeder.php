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
            [ 'name' => "ldap", 'description' => "settings LDAP." ], // 1
            [
                'group_id' => 1, 'name' => "liste_sigles", 'value' => "gt,rh,si,it,sav,in,bss,msan,rva,erp,dr", 'type' => "array", 'description' => "liste des sigles (à prendre en compte dans l importation LDAP)."
            ],
            [ 'name' => "roles", 'description' => "settings Roles." ], // 3
            [
                'group_id' => 3, 'name' => "default", 'value' => "1", 'type' => "integer", 'description' => "Role par défaut à la creéation d un utilisateur dont le role n est pas explicitement déterminé."
            ],
            [ 'name' => "bordereaux_remise", 'description' => "settings bordereaux de remise" ], // 5
            [ 'group_id' => 5, 'name' => "fichier", 'description' => "settings fichiers de bordereaux de remise" ], // 6
            [
                'group_id' => 6, 'name' => "separateur_colonnes", 'value' => "|", 'type' => "string", 'description' => "Caractère séparateur de colonnes du fichier de Bordereaux de Remise"
            ],
            [ 'group_id' => 5, 'name' => "importation", 'description' => "settings importation de bordereaux de remise" ], // 8
            [
                'group_id' => 8, 'name' => "nb_max_lines", 'value' => "100", 'type' => "integer", 'description' => "Nombre Max de Ligne pouvant être importées par exécution du script dédié."
            ],
            [ 'name' => "app_name", 'value' => "Gest-Bordereaux-Remise", 'description' => "settings LDAP." ], // 1
        ];
        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}
