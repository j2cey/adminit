<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('username')->unique()->comment('login du compte ou première partie de l adresse e-mail');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->string('image')->nullable()->comment('Avatar de l utilisateur');
            $table->boolean('is_local')->default(false)->comment('indique si le compte est locale');
            $table->boolean('is_ldap')->default(false)->comment('indique si le compte est LDAP');
            $table->string('objectguid')->nullable()->comment('GUID du compte');

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
