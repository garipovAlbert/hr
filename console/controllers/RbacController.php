<?php

namespace console\controllers;

use common\models\Account;
use common\Rbac;
use Yii;
use yii\console\Controller;
use yii\rbac\DbManager;

/**
 * Adds roles and permissions to application RBAC structure.
 * @author Albert Garipov <bert320@gmail.com>
 */
class RbacController extends Controller
{

    public function actionInit()
    {
        /* @var $auth DbManager */
        $auth = Yii::$app->authManager;

        $auth->removeAll();


        /* Rules */

        
        
        
        /* Permissions */
        
        // showBackend
        $showBackend = $auth->createPermission(Rbac::TASK_SHOW_BACKEND);
        $auth->add($showBackend);
        

        
        /* Roles */

        // admin
        $roleAdmin = $auth->createRole(Account::ROLE_ADMIN);
        $auth->add($roleAdmin);
        $auth->addChild($roleAdmin, $showBackend);

        // controller
        $roleController = $auth->createRole(Account::ROLE_CONTROLLER);
        $auth->add($roleController);
        $auth->addChild($roleController, $showBackend);

        // cinema
        $roleCinema = $auth->createRole(Account::ROLE_CINEMA);
        $auth->add($roleCinema);
        $auth->addChild($roleCinema, $showBackend);

        // guest
        $roleGuest = $auth->createRole(Account::ROLE_GUEST);
        $auth->add($roleGuest);


        print("rbac/init: Ok!\n");
    }

}