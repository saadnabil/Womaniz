<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class CreatePermissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissiongroups = [
            'admins' => [
                'admin-list',
                'admin-create',
                'admin-edit',
                'admin-show',
                'admin-delete',
                'admin-change-status',
                'admin-export',
            ],
            'users' => [
                'user-list',
                'user-create',
                'user-edit',
                'user-show',
                'user-delete',
                'user-change-status',
                'user-export',
            ],
            'vendors' => [
                'vendor-list',
                'vendor-create',
                'vendor-edit',
                'vendor-show',
                'vendor-delete',
                'vendor-change-status',
                'vendor-export',
            ],
            'scratch-game' => [
                'scratch-game-information',
                'scratch-game-information-update'
            ],
            'spin-game' => [
                'spin-game-information',
                'spin-game-information-update'
            ],
            'roles' => [
                'role-list',
                'role-create',
                'role-edit',
                'role-show',
                'role-delete',
            ],
        ];
        foreach ($permissiongroups as $groupname => $permissiongroup) {
            foreach($permissiongroup as $permission){
                Permission::firstOrCreate(
                    [
                        'name' => $permission,
                        'guard_name' => 'admin',
                        'grouping' => $groupname
                    ],
                );
            }
        }
    }
}
