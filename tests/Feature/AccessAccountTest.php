<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Status;
use App\Models\Access\AccessAccount;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AccessAccountTest extends TestCase
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

        // on tronque la table du modèle AccessAccount dans la base de données
        Schema::disableForeignKeyConstraints();
        AccessAccount::truncate();
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Test la création d'un nouveau AccessAccount
     *
     * @return void
     */
    public function test_anAccessAccount_can_be_stored_to_the_database()
    {
        //$this->withoutExceptionHandling();

        //$accessaccount_count_before_test = AccessAccount::all()->count();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_accessaccount(
            "ftpadmin",
            "ftpadmin",
            "ftpadmin@adminit.com",
            "ftpadmin"
        );

        // on test si l'assertion s'est bien passée
        $response->assertStatus(201);

        // on test qu'il y a bien 1 objet dans la base de données
        $this->assertCount(1, AccessAccount::all());
    }

    /**
     * Test la validation d'un nouveau AccessAccount avant création
     *
     * @return void
     */
    public function test_anAccessAccount_required_fields_must_be_validated_before_creation()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_accessaccount(null,null,null,null);

        // on doit avoir une erreur de validation des champs ci-dessous
        $response->assertSessionHasErrors(['login', 'pwd','email','username']);
    }

    /**
     * Test la validation d'un nouveau AccessAccount avant création
     *
     * @return void
     */
    public function test_anAccessAccount_email_fields_must_be_validated_before_creation()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_accessaccount("ddffdf","ddddff","dfdfdd","dfdfd");

        // on doit avoir une erreur de validation des champs ci-dessous
        $response->assertSessionHasErrors(['email']);
    }

    /**
     * Test la validation d'un nouveau AccessAccount avant création
     *
     * @return void
     */
    public function test_anAccessAccount_unique_fields_must_be_validated_before_creation()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_accessaccount(
            "ftpadmin",
            "ftpadmin",
            "ftpadmin@adminit.com",
            "ftpadmin"
        );
        $response = $this->add_new_accessaccount(
            "ftpadmin",
            "ftpadmin",
            "ftpadmin@adminit.com",
            "ftpadmin"
        );

        // on doit avoir une erreur de validation des champs ci-dessous
        $response->assertSessionHasErrors(['username']);
    }

    /**
     * Test la validation d'un nouveau AccessAccount avant création
     *
     * @return void
     */
    public function test_anAccessAccount_unique_fields_can_updated_with_same_values()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_accessaccount(
            "ftpadmin",
            "ftpadmin",
            "ftpadmin@adminit.com",
            "ftpadmin",
            Status::active()->first(),
            "access account desc"
        );

        $newaccessaccount = AccessAccount::first();

        $status_another = Status::inactive()->first();
        $response = $this->update_existing_accessaccount(
            $newaccessaccount,
            "new login edited",
            "new-pwd",
            "newemail@adminit.com",
            "ftpadmin",
            $status_another,
            "new-description"
        );

        // on test si l'assertion s'est bien passée
        $response->assertStatus(200);
    }


    /**
     * Test la modification d'un AccessAccount
     *
     * @return void
     */
    public function test_anAccessAccount_can_be_updated_from_the_database()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_accessaccount(
            "new_login",
            "new_pwd",
            "newemail@adminit.com",
            "new username",
            Status::active()->first(),
            "access account desc"
        );

        $newaccessaccount = AccessAccount::first();

        $status_another = Status::inactive()->first();
        $response = $this->update_existing_accessaccount(
            $newaccessaccount,
            "new_login_upd",
            "new_pwd_upd",
            "newemail_upd@adminit.com",
            "new username upd",
            $status_another,
            "access account desc upd"
        );

        $newaccessaccount->refresh();

        $this->assertEquals('new_login_upd',$newaccessaccount->login);
        $this->assertEquals('new_pwd_upd', $newaccessaccount->pwd);
        $this->assertEquals('newemail_upd@adminit.com', $newaccessaccount->email);
        $this->assertEquals('new username upd', $newaccessaccount->username);
        $this->assertEquals($status_another->id, $newaccessaccount->status->id);
        $this->assertEquals('access account desc upd', $newaccessaccount->description);
    }

    /**
     * Test la suppression d'un AccessAccount
     *
     * @return void
     */
    public function test_anAccessAccount_can_be_deleted()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_accessaccount(
            "new access account",
            "new-pwd",
            "newemail@adminit.com",
            ",new-username",
            "new-description"
        );

        $newaccessaccount = AccessAccount::first();

        $this->delete('accessaccounts/' . $newaccessaccount->uuid);

        $this->assertCount(0, AccessAccount::all());
    }




    #region Private Functions

    private function add_new_accessaccount($login, $pwd, $email, $username, $status = null, $description = null)
    {
        return $this->post('accessaccounts', $this->new_data($login,$pwd,$email,$username,$status,$description));
    }

    private function update_existing_accessaccount($existingaccessaccount, $login, $pwd, $email, $username, $status = null, $description = null)
    {
        return $this->put('accessaccounts/' . $existingaccessaccount->uuid, $this->new_data($login,$pwd,$email,$username,$status,$description));
    }

    private function new_data($login,$pwd,$email,$username,$status = null,$description = null) {
        return [
            'login' => $login,
            'pwd' => $pwd,
            'email' => $email,
            'username' => $username,
            'status' => $status,
            'description' => $description,
        ];
    }

    #endregion
}
