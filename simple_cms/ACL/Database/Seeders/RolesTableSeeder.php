<?php

namespace SimpleCMS\ACL\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use SimpleCMS\ACL\Models\RoleModel;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'id'    => 1,
                'slug'  => 'super-admin-roles',
                'name'  => 'Super Admin Roles',
                'permissions' => 'simple_cms.acl.backend.user.index,simple_cms.acl.backend.user.add,simple_cms.acl.backend.user.edit,simple_cms.acl.backend.user.save_update,simple_cms.acl.backend.user.soft_delete,simple_cms.acl.backend.user.force_delete,simple_cms.acl.backend.user.restore,simple_cms.acl.backend.user.activity_log,simple_cms.acl.backend.user.profile,simple_cms.acl.backend.user.update_profile,simple_cms.acl.backend.user.password,simple_cms.acl.backend.user.update_password,simple_cms.acl.backend.user.activity,simple_cms.acl.backend.user.setting,simple_cms.acl.backend.role.index,simple_cms.acl.backend.role.add,simple_cms.acl.backend.role.edit,simple_cms.acl.backend.role.save_update,simple_cms.acl.backend.role.soft_delete,simple_cms.acl.backend.role.restore,simple_cms.acl.backend.role.activity_log,simple_cms.acl.backend.group.index,simple_cms.acl.backend.group.add,simple_cms.acl.backend.group.edit,simple_cms.acl.backend.group.save_update,simple_cms.acl.backend.group.soft_delete,simple_cms.acl.backend.group.restore,simple_cms.acl.backend.group.activity_log,simple_cms.activitylog.backend.index,simple_cms.activitylog.backend.modal,simple_cms.blog.backend.category.index,simple_cms.blog.backend.category.modal_add,simple_cms.blog.backend.category.modal_edit,simple_cms.blog.backend.category.save_update,simple_cms.blog.backend.category.soft_delete,simple_cms.blog.backend.category.force_delete,simple_cms.blog.backend.category.restore,simple_cms.blog.backend.category.activity_log,simple_cms.blog.backend.tag.index,simple_cms.blog.backend.tag.modal_add,simple_cms.blog.backend.tag.modal_edit,simple_cms.blog.backend.tag.save_update,simple_cms.blog.backend.tag.soft_delete,simple_cms.blog.backend.tag.force_delete,simple_cms.blog.backend.tag.restore,simple_cms.blog.backend.tag.select2,simple_cms.blog.backend.tag.activity_log,simple_cms.blog.backend.post.index,simple_cms.blog.backend.post.add,simple_cms.blog.backend.post.edit,simple_cms.blog.backend.post.preview,simple_cms.blog.backend.post.save_update,simple_cms.blog.backend.post.restore_delete,simple_cms.blog.backend.post.soft_delete,simple_cms.blog.backend.post.force_delete,simple_cms.blog.backend.post.active_inactive_comment,simple_cms.blog.backend.post.active_inactive_featured,simple_cms.blog.backend.page.index,simple_cms.blog.backend.page.add,simple_cms.blog.backend.page.edit,simple_cms.blog.backend.page.save_update,simple_cms.blog.backend.page.restore_delete,simple_cms.blog.backend.page.soft_delete,simple_cms.blog.backend.page.force_delete,simple_cms.dashboard.backend.index,simple_cms.filemanager.index,simple_cms.filemanager.connector,simple_cms.filemanager.popup,simple_cms.filemanager.filepicker,simple_cms.filemanager.tinymce',
                'description' => 'Super Admin Roles',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s')
            ],
            [
                'id'    => 2,
                'slug'  => 'admin-roles',
                'name'  => 'Admin Roles',
                'permissions' => 'simple_cms.acl.backend.user.index,simple_cms.acl.backend.user.add,simple_cms.acl.backend.user.edit,simple_cms.acl.backend.user.save_update,simple_cms.acl.backend.user.soft_delete,simple_cms.acl.backend.user.force_delete,simple_cms.acl.backend.user.restore,simple_cms.acl.backend.user.activity_log,simple_cms.acl.backend.user.profile,simple_cms.acl.backend.user.update_profile,simple_cms.acl.backend.user.password,simple_cms.acl.backend.user.update_password,simple_cms.acl.backend.user.activity,simple_cms.acl.backend.user.setting,simple_cms.acl.backend.role.index,simple_cms.acl.backend.role.add,simple_cms.acl.backend.role.edit,simple_cms.acl.backend.role.save_update,simple_cms.acl.backend.role.soft_delete,simple_cms.acl.backend.role.restore,simple_cms.acl.backend.role.activity_log,simple_cms.acl.backend.group.index,simple_cms.acl.backend.group.add,simple_cms.acl.backend.group.edit,simple_cms.acl.backend.group.save_update,simple_cms.acl.backend.group.soft_delete,simple_cms.acl.backend.group.restore,simple_cms.acl.backend.group.activity_log,simple_cms.activitylog.backend.index,simple_cms.activitylog.backend.modal,simple_cms.blog.backend.category.index,simple_cms.blog.backend.category.modal_add,simple_cms.blog.backend.category.modal_edit,simple_cms.blog.backend.category.save_update,simple_cms.blog.backend.category.soft_delete,simple_cms.blog.backend.category.force_delete,simple_cms.blog.backend.category.restore,simple_cms.blog.backend.category.activity_log,simple_cms.blog.backend.tag.index,simple_cms.blog.backend.tag.modal_add,simple_cms.blog.backend.tag.modal_edit,simple_cms.blog.backend.tag.save_update,simple_cms.blog.backend.tag.soft_delete,simple_cms.blog.backend.tag.force_delete,simple_cms.blog.backend.tag.restore,simple_cms.blog.backend.tag.select2,simple_cms.blog.backend.tag.activity_log,simple_cms.blog.backend.post.index,simple_cms.blog.backend.post.add,simple_cms.blog.backend.post.edit,simple_cms.blog.backend.post.preview,simple_cms.blog.backend.post.save_update,simple_cms.blog.backend.post.restore_delete,simple_cms.blog.backend.post.soft_delete,simple_cms.blog.backend.post.force_delete,simple_cms.blog.backend.post.active_inactive_comment,simple_cms.blog.backend.post.active_inactive_featured,simple_cms.blog.backend.page.index,simple_cms.blog.backend.page.add,simple_cms.blog.backend.page.edit,simple_cms.blog.backend.page.save_update,simple_cms.blog.backend.page.restore_delete,simple_cms.blog.backend.page.soft_delete,simple_cms.blog.backend.page.force_delete,simple_cms.dashboard.backend.index,simple_cms.filemanager.index,simple_cms.filemanager.connector,simple_cms.filemanager.popup,simple_cms.filemanager.filepicker,simple_cms.filemanager.tinymce',
                'description' => 'Admin Roles',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s')
            ],
            [
                'id'    => 3,
                'slug'  => 'investor-roles',
                'name'  => 'Investor Roles',
                'permissions' => 'simple_cms.dashboard.backend.index,simple_cms.acl.backend.user.profile,simple_cms.acl.backend.user.update_profile,simple_cms.acl.backend.user.password,simple_cms.acl.backend.user.update_password,simple_cms.acl.backend.user.activity,simple_cms.acl.backend.user.setting,simple_cms.pmg.backend.index,simple_cms.pmg.backend.petunjuk_penggunaan',
                'description' => 'Investor Roles',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s')
            ],
            [
                'id'    => 4,
                'slug'  => 'umkm-roles',
                'name'  => 'UMKM Roles',
                'permissions' => 'simple_cms.dashboard.backend.index,simple_cms.acl.backend.user.profile,simple_cms.acl.backend.user.update_profile,simple_cms.acl.backend.user.password,simple_cms.acl.backend.user.update_password,simple_cms.pmg.backend.index,simple_cms.pmg.backend.domain,simple_cms.pmg.backend.domain,simple_cms.pmg.backend.grafik,simple_cms.pmg.backend.petunjuk_penggunaan',
                'description' => 'UMKM Roles',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s')
            ]
        ];
        RoleModel::insert($roles);
    }
}
