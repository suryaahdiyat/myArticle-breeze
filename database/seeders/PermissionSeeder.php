<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(["name"=> "crud post"]);
        Permission::create(["name"=> "crud like"]);
        Permission::create(["name"=> "crud comment"]);
        Permission::create(["name"=> "crud user"]);
        Permission::create(["name"=> "see all"]);

        $user = Role::create(["name"=> "user"]);
        $admin = Role::create(["name"=> "admin"]);

        $user->givePermissionTo('see all');
        $admin->givePermissionTo('see all');
        $admin->givePermissionTo('crud post');
        $admin->givePermissionTo('crud like');
        $admin->givePermissionTo('crud comment');
        $admin->givePermissionTo('crud user');
    }
}
