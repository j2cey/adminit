<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Status;
use App\Models\Setting;
use App\Models\OsAndServer\OsServer;
use Illuminate\Testing\TestResponse;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Config;
use App\Models\OsAndServer\ReportServer;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReportServerTest extends TestCase
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

        // on tronque la table du modèle ReportServer dans la base de données
        Schema::disableForeignKeyConstraints();
        ReportServer::truncate();
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Test la création d'un nouveau ReportServer
     *
     * @return void
     */
    public function test_aReportServer_can_be_stored_to_the_database()
    {
        //$this->withoutExceptionHandling();

        //$reportserver_count_before_test = ReportServer::all()->count();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_reportserver("dest","156.25.4.2","dvhhej_hcedj", OsServer::first(), Status::default()->first(),"duf");

        // on test si l'assertion s'est bien passée
        $response->assertStatus(201);

        // on test qu'il y a bien 1 objet dans la base de données
        $this->assertCount(1, ReportServer::all());
    }

    /**
     * Test la validation d'un nouveau ReportServer avant création
     *
     * @return void
     */
    public function test_aReportServer_required_fields_must_be_validated_before_creation()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_reportserver("","","", null, Status::default()->first(),"dgh");

        // on doit avoir une erreur de validation des champs ci-dessous
        $response->assertSessionHasErrors(['name','ip_address','domain_name','osserver']);
    }

    /**
     * Test la modification d'un ReportServer
     *
     * @return void
     */
    public function test_aReportServer_can_be_updated_from_the_database()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_reportserver("bonjour","153.2.5.45","sfedsg", OsServer::first(), Status::default()->first(),"gf");

        $newreportserver = ReportServer::first();

        $last_osserver = OsServer::orderBy('id', 'DESC')->first();
        $status = Status::inactive()->first();
        $this->update_existing_reportserver($newreportserver, "new-name-edited", "153.2.5.44","new-domain_name", $last_osserver,$status ,"new desc upd");

        $newreportserver->refresh();

        $this->assertEquals('new-name-edited',$newreportserver->name);
        $this->assertEquals('153.2.5.44',$newreportserver->ip_address);
        $this->assertEquals('new-domain_name',$newreportserver->domain_name);
        $this->assertEquals($last_osserver->id,$newreportserver->osserver->id);
        $this->assertEquals($status->id, $newreportserver->status->id);
        $this->assertEquals('new desc upd', $newreportserver->description);
    }

    /**
     * Test la suppression d'un ReportServer
     *
     * @return void
     */
    public function test_aReportServer_can_be_deleted()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_reportserver("dest","156.25.4.2","dvhhej_hcedj", OsServer::first(), Status::default()->first(),"duf");

        $newreportserver = ReportServer::first();

        $this->delete('reportservers/' . $newreportserver->uuid);

        $this->assertCount(0, ReportServer::all());
    }


    #region Private Functions

    private function add_new_reportserver($name, $ip_address, $domain_name, $osserver, $status = null, $description = ""): TestResponse
    {
        return $this->post('reportservers', $this->new_data($name, $ip_address, $domain_name, $osserver, $status, $description));
    }

    private function update_existing_reportserver($existing_reportserver, $name, $ip_address, $domain_name, $osserver, $status = null, $description = ""): TestResponse
    {
        return $this->put('reportservers/' . $existing_reportserver->uuid, $this->new_data($name, $ip_address, $domain_name, $osserver, $status, $description));
    }

    private function new_data($name, $ip_address, $domain_name, $osserver, $status = null, $description = "") {
        return [
            'name' => $name,
            'ip_address' => $ip_address,
            'domain_name' => $domain_name,
            'description' => $description,
            'status' => $status,

            //si osserver null je récupère le premier reportserver à partir de la base de données.
            'osserver' => $osserver,
        ];
    }
    #endregion
}
