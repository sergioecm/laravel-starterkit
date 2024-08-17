<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        //php artisan db:seed --class=AdminUserSeeder
        $roles=[
            'super-admin'=>['admin@admin.com','Qwerty123'],
            'Administrator'=>['admin2@admin.com','Qwerty123'],
            'Editor'=>["Editor@admin.com","Qwerty123"],
            'User-Basic'=>["UsuarioBasico@admin.com","Qwerty123"],
            'User-Pro'=>["UsuarioPro@admin.com","Qwerty123"],
        ];

        foreach ($roles as $rol => $data) {
            $user = User::factory()->withPersonalTeam()->create([
                'name' => "Test {$rol}",
                'email' => $data[0],
                'password' => bcrypt($data[1])
            ]);
            echo "\t se creo usuario:".$data[0]." con rol ". strtolower(trim($rol)) ."\n ";
            $user->assignRole(strtolower(trim($rol)));

            unset($rol);
            unset($user);
        }
    }
}
