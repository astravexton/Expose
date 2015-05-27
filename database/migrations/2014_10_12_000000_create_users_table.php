<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

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
            $table->increments('id');
            $table->string('name');
            $table->string('username')->unique();
            $table->string('password');

            $table->boolean('admin')->default(false);

            $table->rememberToken();
            $table->timestamps();
        });

        \Expose\User::create([
            'name'     => 'Admin User',
            'username' => 'admin',
            'password' => Hash::make('admin'),
            'admin'    => true
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }

}
