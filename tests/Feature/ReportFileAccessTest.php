<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Status;
use App\Models\Setting;
use App\Models\Reports\Report;
use App\Models\Reports\ReportType;
use App\Models\Access\AccessAccount;
use App\Models\OsAndServer\OsServer;
use Illuminate\Testing\TestResponse;
use App\Models\ReportFile\ReportFile;
use App\Models\Access\AccessProtocole;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Config;
use App\Models\OsAndServer\ReportServer;
use App\Models\ReportFile\ReportFileType;
use App\Models\ReportFile\ReportFileAccess;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReportFileAccessTest extends TestCase
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

        // Custom Configs
        Config::set('Settings', Setting::getAllGrouped());

        // on tronque la table du modèle AccessAccount dans la base de données
        Schema::disableForeignKeyConstraints();
        ReportFileAccess::truncate();
        Schema::enableForeignKeyConstraints();
    }


    /**
     * Test la création d'un nouveau reportfileaccess
     *
     * @return void
     */
    public function test_aReportFileAccess_can_be_stored_to_the_database()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $reportfile = $this->get_new_reportfile("new report", "new file");
        $reportserver = $this->get_new_reportserver("new serveur","10.10.10.10","new_serveur_dns");
        $protocole_ftp = AccessProtocole::ftp()->first();
        $accessaccount = AccessAccount::createNew("new_accout","new_account_pwd","new_account@email.com","new account");

        $response = $this->add_new_reportfileaccess(
            $reportfile,
            $accessaccount,
            $reportserver,
            $protocole_ftp,
            "new_reportfileaccess"
        );

        // on test si l'assertion s'est bien passée
        $response->assertStatus(201);

        // on test qu'il y a bien 1 objet dans la base de données
        $this->assertCount(1, ReportFileAccess::all());
    }

    /**
     * Test la validation d'un nouveau ReportFile avant création
     *
     * @return void
     */
    public function test_aReportFileAccess_required_fields_must_be_validated_before_creation()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_reportfileaccess(
            null,
            null,
            null,
            null
        );

        // on doit avoir une erreur de validation des champs ci-dessous
        $response->assertSessionHasErrors(['reportfile','accessaccount','reportserver','accessprotocole']);
    }

    /**
     * Test la modification d'un ReportFile
     *
     * @return void
     */
    public function test_aReportFileAccess_can_be_updated_from_the_database()
    {
        $this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $reportfile = $this->get_new_reportfile("new report", "new file");
        $reportserver = $this->get_new_reportserver("new serveur","10.10.10.10","new_serveur_dns");
        $protocole_ftp = AccessProtocole::ftp()->first();
        $accessaccount = AccessAccount::createNew("new_accout","new_account_pwd","new_account@email.com","new account");

        $response = $this->add_new_reportfileaccess(
            $reportfile,
            $accessaccount,
            $reportserver,
            $protocole_ftp,
            "new_reportfileaccess",
            "new_code",
            Status::active()->first(),
            true,
            false,
            "new reportfile access desc"
        );

        $reportfileaccess = ReportFileAccess::first();
        dd($reportfileaccess->executeTreatment());

        $another_reportfile = $this->get_new_reportfile("another report", "another file");
        $another_reportserver = $this->get_new_reportserver("another serveur","10.10.10.11","another_serveur_dns");
        $protocole_sftp = AccessProtocole::sftp()->first();
        $another_accessaccount = AccessAccount::createNew("another_accout","another_account_pwd","another_account@email.com","another account");
        $status_inactive = Status::inactive()->first();

        $this->update_existing_reportfileaccess(
            $reportfileaccess,
            $another_reportfile,
            $another_accessaccount,
            $another_reportserver,
            $protocole_sftp,
            "new reportfileaccess",
            "upd_code",
            $status_inactive,
            false,
            true,
            "new reportfile access desc"
        );

        $reportfileaccess->refresh();

        $this->assertEquals($another_reportfile->id, $reportfileaccess->reportfile->id);
        $this->assertEquals($another_accessaccount->id, $reportfileaccess->accessaccount->id);
        $this->assertEquals($another_reportserver->id, $reportfileaccess->reportserver->id);
        $this->assertEquals($protocole_sftp->id, $reportfileaccess->accessprotocole->id);
        $this->assertEquals("new reportfileaccess", $reportfileaccess->name);
        $this->assertEquals("upd_code", $reportfileaccess->code);
        $this->assertEquals($status_inactive->id, $reportfileaccess->status->id);
        $this->assertEquals(false, $reportfileaccess->retrieve_by_name);
        $this->assertEquals(true, $reportfileaccess->retrieve_by_wildcard);
    }

    /**
     * Test la suppression d'un ReportFile
     *
     * @return void
     */
    public function test_aReportFileAccess_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $reportfile = $this->get_new_reportfile("new report", "new file");
        $reportserver = $this->get_new_reportserver("new serveur","10.10.10.10","new_serveur_dns");
        $protocole_ftp = AccessProtocole::ftp()->first();
        $accessaccount = AccessAccount::createNew("new_accout","new_account_pwd","new_account@email.com","new account");

        $response = $this->add_new_reportfileaccess(
            $reportfile,
            $accessaccount,
            $reportserver,
            $protocole_ftp,
            "new_reportfileaccess"
        );

        $reportfileaccess = ReportFileAccess::first();

        $this->delete('reportfileaccesses/' . $reportfileaccess->uuid);

        $this->assertCount(0, ReportFileAccess::all());
    }



    #region Private Functions

    private function get_new_reportserver($serveur_name, $ip_address, $domain_name): ReportServer {
        $osserver = OsServer::first();
        return ReportServer::createNew($osserver, $serveur_name, $ip_address, $domain_name);
    }

    private function get_new_reportfile($report_title, $file_name): ReportFile {
        $reporttype = ReportType::defaultReport()->first();
        $report = Report::createNew($report_title,$reporttype,"new report file");
        return ReportFile::createNew($report, ReportFileType::txt()->first(), Status::default()->first(), $file_name);
    }

    private function add_new_reportfileaccess($reportfile, $accessaccount, $reportserver, $accessprotocole, $name = null, $code = null, $status = null, $retrieve_by_name = null, $retrieve_by_wildcard = null, $description = ""): TestResponse
    {
        return $this->post('reportfileaccesses', $this->new_data($reportfile, $accessaccount, $reportserver, $accessprotocole, $name, $code, $status, $retrieve_by_name, $retrieve_by_wildcard, $description));
    }

    private function update_existing_reportfileaccess($existing_reportfileaccess, $reportfile, $accessaccount, $reportserver, $accessprotocole, $name = null, $code = null, $status = null, $retrieve_by_name = null, $retrieve_by_wildcard = null, $description = ""): TestResponse
    {
        return $this->put('reportfileaccesses/' . $existing_reportfileaccess->uuid, $this->new_data($reportfile, $accessaccount, $reportserver, $accessprotocole, $name, $code, $status, $retrieve_by_name, $retrieve_by_wildcard, $description));
    }

    private function new_data($reportfile, $accessaccount, $reportserver, $accessprotocole, $name = null, $code = null, $status = null, $retrieve_by_name = null, $retrieve_by_wildcard = null, $description = ""): array
    {
        return [
            'name' => $name,
            'code' => $code,
            'retrieve_by_name' => $retrieve_by_name,
            'retrieve_by_wildcard' => $retrieve_by_wildcard,
            'description' => $description,

            'status' => $status,
            'reportfile' => $reportfile,
            'accessaccount' => $accessaccount,
            'reportserver' => $reportserver,
            'accessprotocole' => $accessprotocole,
        ];
    }

    #endregion
}
