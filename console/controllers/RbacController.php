<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
/**
 * Инициализатор RBAC выполняется в консоли php yii rbac/init
 */
class RbacController extends Controller {

    public function actionInit() {
        $auth = Yii::$app->authManager;

        $auth->removeAll();

        $admin = $auth->createRole('admin');
        $editor = $auth->createRole('editor');
        $user = $auth->createRole('user');

        $auth->add($admin);
        $auth->add($editor);
        $auth->add($user);

        $auth->assign($admin, 1);
        $auth->assign($editor, 2);
        $auth->assign($user, 3);
    }
}

