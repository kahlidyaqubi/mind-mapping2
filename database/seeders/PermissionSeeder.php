<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('model_has_permissions')->truncate();
        DB::statement("SET foreign_key_checks=0");
        \Spatie\Permission\Models\Permission::truncate();
        DB::statement("SET foreign_key_checks=1");
        \Spatie\Permission\Models\Permission::insert(
            [
                //admins
                /*1*/
                ['name' => 'admins', 'guard_name' => 'admin', 'link' => '#', 'title' => 'المدراء', 'parent_id' => '0', 'in_menu' => '1', 'in_constant' => '0', 'icon' => 'fas fa-users'],
                /*2*/
                ['name' => 'admins list', 'guard_name' => 'admin', 'link' => '/admin/admins', 'title' => 'إدارة المدراء', 'parent_id' => '1', 'in_menu' => '1', 'in_constant' => '0', 'icon' => 'fas fa-users'],
                /*3*/
                ['name' => 'create admin', 'guard_name' => 'admin', 'link' => '/admin/admins/create', 'title' => 'إنشاء مدير', 'parent_id' => '1', 'in_menu' => '0', 'in_constant' => '0', 'icon' => 'fas fa-users'],
                /*4*/
                ['name' => 'edit admin', 'guard_name' => 'admin', 'link' => '/admin/admins/edit', 'title' => 'تعديل مدير', 'parent_id' => '1', 'in_menu' => '0', 'in_constant' => '0', 'icon' => 'fas fa-users'],
                /*5*/
                ['name' => 'delete admin', 'guard_name' => 'admin', 'link' => '/admin/admins/delete', 'title' => 'حذف مدير', 'parent_id' => '1', 'in_menu' => '0', 'in_constant' => '0', 'icon' => 'fas fa-users'],
                /*6*/
                ['name' => 'permission admin', 'guard_name' => 'admin', 'link' => '/admin/admins/permissions', 'title' => 'تعديل صلاحية', 'parent_id' => '1', 'in_menu' => '0', 'in_constant' => '0', 'icon' => 'fas fa-users'],
                /*7*/
                ['name' => 'logs admin', 'guard_name' => 'admin', 'link' => '/admin/admins/logs', 'title' => 'سجلات المدير', 'parent_id' => '1', 'in_menu' => '0', 'in_constant' => '0', 'icon' => 'fas fa-users'],
                /*8*/
                ['name' => 'status admin', 'guard_name' => 'admin', 'link' => '/admin/admins/active', 'title' => 'حالة المدير', 'parent_id' => '1', 'in_menu' => '0', 'in_constant' => '0', 'icon' => 'fas fa-users'],
                /**/
                //logs
                /*9*/
                ['name' => 'logs', 'guard_name' => 'admin', 'link' => '#', 'title' => 'السجلات', 'parent_id' => '0', 'in_menu' => '1', 'in_constant' => '0', 'icon' => 'fas fa-clipboard-list'],
                /*10*/
                ['name' => 'logs list', 'guard_name' => 'admin', 'link' => '/admin/logs', 'title' => 'إدارة السجلات', 'parent_id' => '9', 'in_menu' => '1', 'in_constant' => '0', 'icon' => 'fas fa-clipboard-list'],
                /**/
                /*11*/
                ['name' => 'users', 'guard_name' => 'admin', 'link' => '#', 'title' => 'المستخدمون', 'parent_id' => '0', 'in_menu' => '1', 'in_constant' => '0', 'icon' => 'fas fa-users'],
                /*12*/
                ['name' => 'users list', 'guard_name' => 'admin', 'link' => '/admin/users', 'title' => 'إدارة المستخدمون', 'parent_id' => '11', 'in_menu' => '1', 'in_constant' => '0', 'icon' => 'fas fa-users'],
                /*13*/
                ['name' => 'create user', 'guard_name' => 'admin', 'link' => '/admin/users/create', 'title' => 'إضافة مستخدم', 'parent_id' => '11', 'in_menu' => '0', 'in_constant' => '0', 'icon' => 'fas fa-users'],
                /*14*/
                ['name' => 'edit user', 'guard_name' => 'admin', 'link' => '/admin/users/edit', 'title' => 'تعديل مستخدم', 'parent_id' => '11', 'in_menu' => '0', 'in_constant' => '0', 'icon' => 'fas fa-users'],
                /*15*/
                ['name' => 'delete user', 'guard_name' => 'admin', 'link' => '/admin/users/delete', 'title' => 'حذف مستخدم', 'parent_id' => '11', 'in_menu' => '0', 'in_constant' => '0', 'icon' => 'fas fa-users'],
                /*16*/
                ['name' => 'status user', 'guard_name' => 'admin', 'link' => '/admin/users/active', 'title' => 'حالةالمستخدم', 'parent_id' => '11', 'in_menu' => '0', 'in_constant' => '0', 'icon' => 'fas fa-users'],
                /**//*surahs*/
                /*17*/
                ['name' => 'surahs', 'guard_name' => 'admin', 'link' => '#', 'title' => 'السور', 'parent_id' => '0', 'in_menu' => '1', 'in_constant' => '0', 'icon' => 'fas fa-quran'],
                /*18*/
                ['name' => 'surahs list', 'guard_name' => 'admin', 'link' => '/admin/surahs', 'title' => 'إدارة السور', 'parent_id' => '17', 'in_menu' => '1', 'in_constant' => '0', 'icon' => 'fas fa-quran'],
                /*19*/
                ['name' => 'status surah', 'guard_name' => 'admin', 'link' => '/admin/surahs/active', 'title' => 'حالة السورة', 'parent_id' => '17', 'in_menu' => '0', 'in_constant' => '0', 'icon' => 'fas fa-quran'],
                /**/
                /*reciters*/
                /*20*/
                ['name' => 'reciters', 'guard_name' => 'admin', 'link' => '#', 'title' => 'القراء', 'parent_id' => '0', 'in_menu' => '1', 'in_constant' => '0', 'icon' => 'fas fa-microphone-alt'],
                /*21*/
                ['name' => 'reciters list', 'guard_name' => 'admin', 'link' => '/admin/reciters', 'title' => 'إدارة القراء', 'parent_id' => '20', 'in_menu' => '1', 'in_constant' => '0', 'icon' => 'fas fa-microphone-alt'],
                /*22*/
                ['name' => 'create reciter', 'guard_name' => 'admin', 'link' => '/admin/reciters/create', 'title' => 'إضافة قارئ', 'parent_id' => '20', 'in_menu' => '0', 'in_constant' => '0', 'icon' => 'fas fa-microphone-alt'],
                /*23*/
                ['name' => 'edit reciter', 'guard_name' => 'admin', 'link' => '/admin/reciters/edit', 'title' => 'تعديل قارئ', 'parent_id' => '20', 'in_menu' => '0', 'in_constant' => '0', 'icon' => 'fas fa-microphone-alt'],
                /*24*/
                ['name' => 'delete reciter', 'guard_name' => 'admin', 'link' => '/admin/reciters/delete', 'title' => 'حذف قارئ', 'parent_id' => '20', 'in_menu' => '0', 'in_constant' => '0', 'icon' => 'fas fa-microphone-alt'],
                /*25*/
                ['name' => 'status reciter', 'guard_name' => 'admin', 'link' => '/admin/reciters/active', 'title' => 'حالة القارئ', 'parent_id' => '20', 'in_menu' => '0', 'in_constant' => '0', 'icon' => 'fas fa-microphone-alt'],
                /**/
                //settings
                /*26*/
                ['name' => 'settings', 'guard_name' => 'admin', 'link' => '#', 'title' => 'الإعدادات', 'parent_id' => '0', 'in_menu' => '1', 'in_constant' => '1', 'icon' => 'fas fa-cogs'],
                /*27*/
                ['name' => 'settings list', 'guard_name' => 'admin', 'link' => '/admin/settings/settings', 'title' => 'إدارة الإعدادات', 'parent_id' => '26', 'in_menu' => '1', 'in_constant' => '1', 'icon' => 'fas fa-cogs'],
                /*28*/
                ['name' => 'create setting', 'guard_name' => 'admin', 'link' => '/admin/settings/settings/create', 'title' => 'إنشاء إعداد', 'parent_id' => '26', 'in_menu' => '1', 'in_constant' => '0', 'icon' => 'fas fa-cogs'],
                /*29*/
                ['name' => 'edit setting', 'guard_name' => 'admin', 'link' => '/admin/settings/settings/edit', 'title' => 'تعديل إعداد', 'parent_id' => '26', 'in_menu' => '0', 'in_constant' => '0', 'icon' => 'fas fa-cogs'],
                /*30*/
                ['name' => 'delete setting', 'guard_name' => 'admin', 'link' => '/admin/settings/settings/delete', 'title' => 'حذف إعداد', 'parent_id' => '26', 'in_menu' => '0', 'in_constant' => '0', 'icon' => 'fas fa-cogs'],
                /*31*/
                ['name' => 'status setting', 'guard_name' => 'admin', 'link' => '/admin/settings/settings/active', 'title' => 'حالة الإعداد', 'parent_id' => '26', 'in_menu' => '0', 'in_constant' => '0', 'icon' => 'fas fa-cogs'],
                /**/
                //maps
                /*32*/
                ['name' => 'parts', 'guard_name' => 'admin', 'link' => '#', 'title' => 'الخرائط', 'parent_id' => '0', 'in_menu' => '0', 'in_constant' => '0', 'icon' => 'fas fa-book-open'],
                /*33*/
                ['name' => 'parts list', 'guard_name' => 'admin', 'link' => '/admin/maps', 'title' => 'إدارة الخرائط', 'parent_id' => '32', 'in_menu' => '0', 'in_constant' => '0', 'icon' => 'fas fa-book-open'],
                /*34*/
                ['name' => 'create part', 'guard_name' => 'admin', 'link' => '/admin/maps/create', 'title' => 'إضافة خارطة', 'parent_id' => '32', 'in_menu' => '0', 'in_constant' => '0', 'icon' => 'fas fa-book-open'],
                /*35*/
                ['name' => 'edit part', 'guard_name' => 'admin', 'link' => '/admin/maps/edit', 'title' => 'تعديل خارطة', 'parent_id' => '32', 'in_menu' => '0', 'in_constant' => '0', 'icon' => 'fas fa-book-open'],
                /*36*/
                ['name' => 'delete part', 'guard_name' => 'admin', 'link' => '/admin/maps/delete', 'title' => 'حذف الخارطة', 'parent_id' => '32', 'in_menu' => '0', 'in_constant' => '0', 'icon' => 'fas fa-book-open'],
                /*37*/
                ['name' => 'status part', 'guard_name' => 'admin', 'link' => '/admin/maps/active', 'title' => 'حالة الخارطة', 'parent_id' => '32', 'in_menu' => '0', 'in_constant' => '0', 'icon' => 'fas fa-book-open'],
                /**/ //verses
                /*38*/
                ['name' => 'verses', 'guard_name' => 'admin', 'link' => '#', 'title' => 'الآيات', 'parent_id' => '0', 'in_menu' => '0', 'in_constant' => '0', 'icon' => 'fas fa-book-open'],
                /*39*/
                ['name' => 'verses list', 'guard_name' => 'admin', 'link' => '/admin/verses', 'title' => 'إدارة الآيات', 'parent_id' => '38', 'in_menu' => '0', 'in_constant' => '0', 'icon' => 'fas fa-book-open'],
               /*40*/
                ['name' => 'edit verse', 'guard_name' => 'admin', 'link' => '/admin/verses/edit', 'title' => 'تعديل محتوى تفسير الآية', 'parent_id' => '38', 'in_menu' => '0', 'in_constant' => '0', 'icon' => 'fas fa-book-open'],
                /*41*/
                ['name' => 'status verse', 'guard_name' => 'admin', 'link' => '/admin/verses/active', 'title' => 'حالة الآية', 'parent_id' => '38', 'in_menu' => '0', 'in_constant' => '0', 'icon' => 'fas fa-book-open'],
                /**/

            ]
        );
        $admin = \App\Models\Admin::get()->first();
        $admin->syncPermissions(\Spatie\Permission\Models\Permission::pluck('id')->toArray());
    }
}