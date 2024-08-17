<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesyPermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        //php artisan db:seed --class=RolesyPermisosSeeder

        $rolePermisos = [
            'Administrator' => [
                ['roles-view' => 'Ver Roles'],
                ['roles-edit' => 'Editar Roles'],
                ['roles-create' => 'Crear Roles'],
                ['roles-delete' => 'Borrar Roles'],
                ['permissions-view' => 'Ver Permisos'],
                ['permissions-edit' => 'Editar Permisos'],
                ['permissions-create' => 'Crear Permisos'],
                ['permissions-delete' => 'Borrar Permisos'],
                ['users-view' => 'Ver usuarios'],
                ['users-edit' => 'Editar usuarios'],
                ['users-create' => 'Crear usuarios'],
                ['users-delete' => 'Borrar usuarios'],
                ['teams-view' => 'Ver Teams'],
                ['teams-edit' => 'Editar Teams'],
                ['teams-create' => 'Crear Teams'],
                ['teams-delete' => 'Borrar Teams'],
                ['ingredients-view' => 'Ver Ingredientes'],
                ['ingredients-edit' => 'Editar Ingredientes'],
                ['ingredients-create' => 'Crear Ingredientes'],
                ['ingredients-delete' => 'Borrar Ingredientes'],
                ['measures-view' => 'Ver Medidas'],
                ['measures-edit' => 'Editar Medidas'],
                ['measures-create' => 'Crear Medidas'],
                ['measures-delete' => 'Borrar Medidas'],
                ['recipes-view' => 'Ver Recetas'],
                ['recipes-edit' => 'Editar Recetas'],
                ['recipes-create' => 'Crear Recetas'],
                ['recipes-delete' => 'Borrar Recetas'],
                ['pdf-view' => 'ver Pdf'],
                ['pdf-download' => 'descargar pdf'],
                ['schedule-programing' => 'Programar calendario'],
                ['schedule-view' => 'ver calendarios']
            ],
            'Editor' => [
                ['ingredients-view' => 'Ver Ingredientes'],
                ['ingredients-edit' => 'Editar Ingredientes'],
                ['ingredients-create' => 'Crear Ingredientes'],
                ['measures-view' => 'Ver Medidas'],
                ['measures-edit' => 'Editar Medidas'],
                ['measures-create' => 'Crear Medidas'],
                ['recipes-view' => 'Ver Recetas'],
                ['recipes-edit' => 'Editar Recetas'],
                ['recipes-create' => 'Crear Recetas'],
                ['recipes-delete' => 'Borrar Recetas'],
                ['pdf-view' => 'ver Pdf'],
                ['pdf-download' => 'descargar pdf'],
                ['schedule-programing' => 'Programar calendario'],
                ['schedule-view' => 'ver calendarios']
            ],
            'User-Basic' => [
                ['recipes-view' => 'Ver Recetas'],
            ],
            'User-Pro' => [
                ['recipes-view' => 'Ver Recetas'],
                ['pdf-view' => 'ver Pdf'],
                ['pdf-download' => 'descargar pdf'],
                ['schedule-programing' => 'Programar calendario'],
                ['schedule-view' => 'ver calendarios']
            ],
        ];

        Role::create(['name' => strtolower(trim('super-admin'))]);

        foreach ($rolePermisos as $rol => $permisos) {
            //echo __LINE__." ".var_dump($rol) ."<br> ";
            $role = Role::create(['name' => strtolower(trim($rol))]);
            foreach ($permisos as $permiso) {
                foreach ($permiso as $k => $v) {
                    if ($rol == 'Administrator') {
                        //echo __LINE__." ".var_dump($permiso) ."\n ";
                        echo __LINE__ . " rol $rol Permiso name: ".strtolower(trim($k))." -> description:".trim($v)." \n ";
                        // echo __LINE__ . " rol $rol  ['".strtolower(trim($k))." => '".trim($v)."'], \n ";

                        $permission = Permission::create(['name' => strtolower(trim($k)), 'description' => trim($v)]);
                        $permission->assignRole($role);
                        unset($permission);
                    }
                    else {
                        echo __LINE__ . " rol $rol Permiso name: ".strtolower(trim($k))." -> description:".trim($v)." \n ";
                        $role->givePermissionTo(strtolower(trim($k)));
                    }
                }
            }
            unset($role);
        }

    }
}
