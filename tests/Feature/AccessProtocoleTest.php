<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Status;
use App\Models\Setting;
use App\Models\Access\AccessProtocole;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Config;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AccessProtocoleTest extends TestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        // seed the database
        $this->artisan('db:seed');
        // alternatively you can call
        // $this->seed();

        Config::set('Settings', Setting::getAllGrouped());

        // on tronque la table du modèle AccessProtocole dans la base de données
        Schema::disableForeignKeyConstraints();
        AccessProtocole::truncate();
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Test la création d'un nouveau AccessProtocole
     *
     * @return void
     */
    public function test_anAccessProtocole_can_be_stored_to_the_database()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_accessprotocole("Anri", "anri","new protocole_class");

        // on test si l'assertion s'est bien passée
        $response->assertStatus(201);

        // on test qu'il y a bien 1 objet dans la base de données
        $this->assertCount(1, AccessProtocole::all());
    }

    /**
     * Test la validation d'un nouveau AccessProtocole avant création
     *
     * @return void
     */
    public function test_anAccessProtocole_required_fields_must_be_validated_before_creation()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_accessprotocole("","", "");

        // on doit avoir une erreur de validation des champs ci-dessous
        $response->assertSessionHasErrors(['name','code','protocole_class']);
    }

    /**
     * Test la modification d'un AccessProtocole
     *
     * @return void
     */
    public function test_anAccessProtocole_can_be_updated_from_the_database()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_accessprotocole(
            "vcibvfuezb",
            "new_code",
            "new protocole_class",
            Status::active()->first(),
            "first desc"
        );

        $newaccessprotocole = AccessProtocole::first();

        $status_another = Status::inactive()->first();
        $this->update_existing_accessprotocole(
            $newaccessprotocole,
            "upd name edited",
            "upd code edited",
            "upd protocole_class",
            $status_another,
            "upd-description"
        );

        $newaccessprotocole->refresh();

        $this->assertEquals('upd name edited',$newaccessprotocole->name);
        $this->assertEquals('upd code edited',$newaccessprotocole->code);
        $this->assertEquals('upd protocole_class',$newaccessprotocole->protocole_class);
        $this->assertEquals($status_another->id,$newaccessprotocole->status->id);
        $this->assertEquals('upd-description', $newaccessprotocole->description);
    }

    /**
     * Test la suppression d'un AccessProtocole
     *
     * @return void
     */
    public function test_anAccessProtocole_can_be_deleted()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_accessprotocole("new access protocole", "new_access_protocole", "new protocole_class");

        $newaccessprotocole = AccessProtocole::first();

        $this->delete('accessprotocoles/' . $newaccessprotocole->uuid);

        $this->assertCount(0, AccessProtocole::all());
    }

    #region Private Functions

    private function add_new_accessprotocole($name, $code, $protocole_class,$status = null, $description = null)
    {
        return $this->post('accessprotocoles', $this->new_data($name,$code,$protocole_class,$status,$description));
    }

    private function update_existing_accessprotocole($existingaccessprotocole, $name, $code, $protocole_class,$status = null,$description = null)
    {
        return $this->put('accessprotocoles/' . $existingaccessprotocole->uuid, $this->new_data($name,$code,$protocole_class,$status,$description));
    }

    private function new_data($name,$code,$protocole_class,$status = null,$description = null) {
        return [
            'name' => $name,
            'code' => $code,
            'protocole_class' => $protocole_class,
            'status' => $status,
            'description' => $description,
        ];
    }

    #endregion
}
