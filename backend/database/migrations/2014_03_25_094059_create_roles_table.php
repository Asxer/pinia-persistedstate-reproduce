<?php

use App\Models\Role;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Artel\Support\Traits\MigrationTrait;

class CreateRolesTable extends Migration
{
    use MigrationTrait;

    public function up()
    {
        DB::beginTransaction();

        $this->createTable();
        $this->addRoles();

        DB::commit();
    }

    public function down()
    {
        DB::beginTransaction();

        Schema::drop('roles');

        DB::commit();
    }

    public function createTable()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
    }

    public function addRoles()
    {
        $roles = [
            [
                'id' => Role::ADMIN,
                'name' => 'administrator'
            ],
            [
                'id' => Role::USER,
                'name' => 'user'
            ]
        ];

        DB::table('roles')->insert($roles);
    }
}