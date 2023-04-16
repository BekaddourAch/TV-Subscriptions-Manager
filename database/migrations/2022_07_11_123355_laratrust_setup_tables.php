<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LaratrustSetupTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        // Create table for storing roles
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Create table for storing permissions
        Schema::create('permissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->string('groupe')->nullable();
            $table->timestamps();
        });
         // Insert some stuff
         DB::table('permissions')->insert(
            [
                // ------------------------------------------------- USRES
                [
                'name' => 'users-create',
                'display_name' => 'Créer',
                'description' => '',
                'groupe' => 'Utilisateurs',
                ],
                [
                'name' => 'users-display',
                'display_name' => 'Afficher',
                'description' => '',
                'groupe' => 'Utilisateurs',
                ],
                [
                'name' => 'users-update',
                'display_name' => 'Modifier',
                'description' => '',
                'groupe' => 'Utilisateurs',
                ],
                [
                'name' => 'users-delete',
                'display_name' => 'Supprimer',
                'description' => '',
                'groupe' => 'Utilisateurs',
                ],
                // ------------------------------------------------- CLIENTS
                [
                'name' => 'customers-create',
                'display_name' => 'Créer',
                'description' => '',
                'groupe' => 'Clients',
                ],
                [
                'name' => 'customers-display',
                'display_name' => 'Afficher',
                'description' => '',
                'groupe' => 'Clients',
                ],
                [
                'name' => 'customers-update',
                'display_name' => 'Modifier',
                'description' => '',
                'groupe' => 'Clients',
                ],
                [
                'name' => 'customers-delete',
                'display_name' => 'Supprimer',
                'description' => '',
                'groupe' => 'Clients',
                ],
                // ------------------------------------------------- SERVICES
                [
                'name' => 'services-create',
                'display_name' => 'Créer',
                'description' => '',
                'groupe' => 'Services',
                ],
                [
                'name' => 'services-display',
                'display_name' => 'Afficher',
                'description' => '',
                'groupe' => 'Services',
                ],
                [
                'name' => 'services-update',
                'display_name' => 'Modifier',
                'description' => '',
                'groupe' => 'Services',
                ],
                [
                'name' => 'services-delete',
                'display_name' => 'Supprimer',
                'description' => '',
                'groupe' => 'Services',
                ],
                // ------------------------------------------------- SUBSCRIPTION
                [
                'name' => 'subscription-create',
                'display_name' => 'Créer',
                'description' => '',
                'groupe' => 'Abonnements',
                ],
                [
                'name' => 'subscription-display',
                'display_name' => 'Afficher',
                'description' => '',
                'groupe' => 'Abonnements',
                ],
                [
                'name' => 'subscription-update',
                'display_name' => 'Modifier',
                'description' => '',
                'groupe' => 'Abonnements',
                ],
                [
                'name' => 'subscription-delete',
                'display_name' => 'Supprimer',
                'description' => '',
                'groupe' => 'Abonnements',
                ],
                // ------------------------------------------------- Statistiques
                [
                'name' => 'statistics-display',
                'display_name' => 'Afficher les Statistiques',
                'description' => '',
                'groupe' => 'Statistiques',
                ],
            ]

        );

        // Create table for associating roles to users and teams (Many To Many Polymorphic)
        Schema::create('role_user', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('user_id');
            $table->string('user_type');

            $table->foreign('role_id')->references('id')->on('roles')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['user_id', 'role_id', 'user_type']);
        });

        // Create table for associating permissions to users (Many To Many Polymorphic)
        Schema::create('permission_user', function (Blueprint $table) {
            $table->unsignedBigInteger('permission_id');
            $table->unsignedBigInteger('user_id');
            $table->string('user_type');

            $table->foreign('permission_id')->references('id')->on('permissions')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['user_id', 'permission_id', 'user_type']);
        });

        // Create table for associating permissions to roles (Many-to-Many)
        Schema::create('permission_role', function (Blueprint $table) {
            $table->unsignedBigInteger('permission_id');
            $table->unsignedBigInteger('role_id');

            $table->foreign('permission_id')->references('id')->on('permissions')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['permission_id', 'role_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::dropIfExists('permission_user');
        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('roles');
    }
}
