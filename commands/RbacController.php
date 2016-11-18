<?php
/**
 * Created by PhpStorm.
 * User: zmievskaya
 * Date: 18.11.16
 * Time: 10:59
 */

namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        $user = $auth->createRole('user');
        $auth->add($user);

        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $user);
    }
}