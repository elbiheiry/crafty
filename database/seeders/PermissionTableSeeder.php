<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'admin-list',
            'admin-create',
            'admin-edit',
            'admin-delete',
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'article-list',
            'article-create',
            'article-edit',
            'article-delete',
            'social-list',
            'social-create',
            'social-edit',
            'social-delete',
            'settings-edit',
            'faqs-list',
            'faqs-create',
            'faqs-edit',
            'faqs-delete',
            'faqs-edit',
            'about-edit',
            'features-list',
            'features-create',
            'features-edit',
            'features-delete',
        ];
        
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
