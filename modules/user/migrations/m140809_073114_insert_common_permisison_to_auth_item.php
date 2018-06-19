<?php

use yii\db\Schema;
use yii\db\Migration;
use app\modules\user\models\rbacDB\Permission;

class m140809_073114_insert_common_permisison_to_auth_item extends Migration
{
    public function safeUp()
    {
        Permission::create(Yii::$app->getModule('user')->commonPermissionName);
    }

    public function safeDown()
    {
        $permission = Permission::findOne(['name' => Yii::$app->getModule('user')->commonPermissionName]);

        if ($permission) {
            $permission->delete();
        }
    }
}
