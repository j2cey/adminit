<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Status;
use App\Models\AccessAccount;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\WithFaker;
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
    public function test_an_accessaccount_can_be_stored_to_the_database()
    {
        //$this->withoutExceptionHandling();

        //$accessaccount_count_before_test = AccessAccount::all()->count();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_accessaccount("ftpadmin","ftpadmin","ftpadmin@adminit.com","ftpadmin");

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
    public function test_an_accessaccount_required_fields_must_be_validated_before_creation()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_accessaccount("","","","");

        // on doit avoir une erreur de validation des champs ci-dessous
        $response->assertSessionHasErrors(['login','email','username']);
    }

    /**
     * Test la validation d'un nouveau AccessAccount avant création
     *
     * @return void
     */
    public function test_an_accessaccount_email_fields_must_be_validated_before_creation()
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
    public function test_an_accessaccount_unique_fields_must_be_validated_before_creation()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_accessaccount("ftpadmin","ftpadmin","ftpadmin@adminit.com","ftpadmin");
        $response = $this->add_new_accessaccount("ftpadmin","ftpadmin","ftpadmin@adminit.com","ftpadmin");

        // on doit avoir une erreur de validation des champs ci-dessous
        $response->assertSessionHasErrors(['username']);
    }

    /**
     * Test la validation d'un nouveau AccessAccount avant création
     *
     * @return void
     */
    public function test_an_accessaccount_unique_fields_can_updated_with_same_values()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_accessaccount("ftpadmin","ftpadmin","ftpadmin@adminit.com","ftpadmin");
        $newaccessaccount = AccessAccount::first();
        $response = $this->update_existing_accessaccount($newaccessaccount, "new login edited", "new-pwd","newemail@adminit.com","ftpadmin","new-description");

        // on test si l'assertion s'est bien passée
        $response->assertStatus(200);
    }


    /**
     * Test la modification d'un AccessAccount
     *
     * @return void
     */
    public function test_an_accessaccount_can_be_updated_from_the_database()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_accessaccount("ftpadmin","ftpadmin","ftpadmin@adminit.com","ftpadmin");

        $newaccessaccount = AccessAccount::first();

        $this->update_existing_accessaccount($newaccessaccount, "new login edited", "new-pwd","newemail@adminit.com","new-username","new-description");

        $newaccessaccount->refresh();

        $this->assertEquals('new login edited',$newaccessaccount->login);
        $this->assertEquals('new-pwd', $newaccessaccount->pwd);
        $this->assertEquals('newemail@adminit.com', $newaccessaccount->email);
        $this->assertEquals('new-username', $newaccessaccount->username);
        $this->assertEquals('new-description', $newaccessaccount->description);
    }

    /**
     * Test la suppression d'un AccessAccount
     *
     * @return void
     */
    public function test_a_accessaccount_can_be_deleted()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_accessaccount("new access account","new-pwd","newemail@adminit.com",",new-username","new-description");

        $newaccessaccount = AccessAccount::first();

        $this->delete('accessaccounts/' . $newaccessaccount->uuid);

        $this->assertCount(0, AccessAccount::all());
    }




    #region Private Functions

    private function add_new_accessaccount($login, $pwd, $email, $username, $description = "")
    {
        // on essaie d'insérer un nouvel objet AccessAccount dans la base de données
        // et on récupère le résultat dans une variable $response

        return $this->post('accessaccounts', [
                'login' => $login,
                'pwd' => $pwd,
                'email' => $email,
                'username' => $username,
                'description' => $description,
            ]
        );
    }

    private function update_existing_accessaccount($existingaccessaccount, $login, $pwd, $email, $username, $description = "")
    {
        return $this->put('accessaccounts/' . $existingaccessaccount->uuid, [
            'login' => $login,
            'pwd' => $pwd,
            'email' => $email,
            'username' => $username,
            'description' => $description,
        ]);
    }

    #endregion
}
