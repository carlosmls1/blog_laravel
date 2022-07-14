<?php

use Illuminate\Database\Seeder;
use HttpOz\Roles\Models\Role;
use App\User;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'description' => 'User administrator',
            'group' => 'admin'
        ]);

        $supervisorRole = Role::create([
            'name' => 'Supervisor',
            'slug' => 'supervisor',
            'description' => 'Blogger Supervisor',
            'group' => 'supervisor'
        ]);

        $bloggerRole = Role::create([
            'name' => 'Blogger',
            'slug' => 'blogger',
            'description' => 'Blog creator',
            'group' => 'default'
        ]);

        $user = User::get()->first();
        $user->attachRole($adminRole);

    }
}
