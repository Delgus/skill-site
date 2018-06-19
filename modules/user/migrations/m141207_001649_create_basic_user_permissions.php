<?php

use app\modules\user\models\rbacDB\AuthItemGroup;
use app\modules\user\models\rbacDB\Permission;
use app\modules\user\models\rbacDB\Role;
use app\modules\user\models\rbacDB\Route;
use yii\db\Migration;

class m141207_001649_create_basic_user_permissions extends Migration
{
    public function safeUp()
    {
        Route::refreshRoutes();

        Role::create('Admin');

        // ================= User management permissions =================
        $group = new AuthItemGroup();
        $group->name = 'User management';
        $group->code = 'userManagement';
        $group->save(false);


        Role::assignRoutesViaPermission('Admin', 'viewUsers', [
            '/user/user/index',
            '/user/user/view',
            '/user/user/grid-page-size',
        ], 'View users', $group->code);

        Role::assignRoutesViaPermission('Admin', 'createUsers', ['/user/user/create'], 'Create users', $group->code);

        Role::assignRoutesViaPermission('Admin', 'editUsers', [
            '/user/user/update',
            '/user/user/bulk-activate',
            '/user/user/bulk-deactivate',
        ], 'Edit users', $group->code);

        Role::assignRoutesViaPermission('Admin', 'deleteUsers', [
            '/user/user/delete',
            '/user/user/bulk-delete',
        ], 'Delete users', $group->code);

        Role::assignRoutesViaPermission('Admin', 'changeUserPassword',
            ['/user/user/change-password'], 'Change user password', $group->code);

        Role::assignRoutesViaPermission('Admin', 'assignRolesToUsers', [
            '/user/user-permission/set',
            '/user/user-permission/set-roles',
        ], 'Assign roles to users', $group->code);


        Permission::assignRoutes('viewVisitLog', [
            '/user/user-visit-log/index',
            '/user/user-visit-log/grid-page-size',
            '/user/user-visit-log/view',
        ], 'View visit log', $group->code);


        Permission::create('viewUserRoles', 'View user roles', $group->code);
        Permission::create('viewRegistrationIp', 'View registration IP', $group->code);
        Permission::create('viewUserEmail', 'View user email', $group->code);
        Permission::create('editUserEmail', 'Edit user email', $group->code);
        Permission::create('bindUserToIp', 'Bind user to IP', $group->code);


        Permission::addChildren('assignRolesToUsers', ['viewUsers', 'viewUserRoles']);
        Permission::addChildren('changeUserPassword', ['viewUsers']);
        Permission::addChildren('deleteUsers', ['viewUsers']);
        Permission::addChildren('createUsers', ['viewUsers']);
        Permission::addChildren('editUsers', ['viewUsers']);
        Permission::addChildren('editUserEmail', ['viewUserEmail']);


        // ================= User common permissions =================
        $group = new AuthItemGroup();
        $group->name = 'User common permission';
        $group->code = 'userCommonPermissions';
        $group->save(false);

        Role::assignRoutesViaPermission('Admin', 'changeOwnPassword', ['/user/auth/change-own-password'], 'Change own password', $group->code);
    }

    public function safeDown()
    {
        Permission::deleteAll(['name' => [
            'viewUsers',
            'createUsers',
            'editUsers',
            'deleteUsers',
            'changeUserPassword',
            'assignRolesToUsers',
            'viewVisitLog',
            'viewUserRoles',
            'viewRegistrationIp',
            'viewUserEmail',
            'editUserEmail',
            'bindUserToIp',
        ]]);

        Permission::deleteAll(['name' => [
            'changeOwnPassword',
        ]]);

        Role::deleteIfExists(['name' => 'Admin']);

        AuthItemGroup::deleteAll([
            'code' => [
                'userManagement',
                'userCommonPermissions',
            ],
        ]);
    }
}
