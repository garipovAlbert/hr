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

        // show backend
        $showBackend = $auth->createPermission(Rbac::TASK_SHOW_BACKEND);
        $auth->add($showBackend);

        // manage account
        $manageAccount = $auth->createPermission(Rbac::TASK_MANAGE_ACCOUNT);
        $auth->add($manageAccount);

        // manage objects
        $manageObjects = $auth->createPermission(Rbac::TASK_MANAGE_OBJECTS);
        $auth->add($manageObjects);

        // manage objects
        $deleteApplicant = $auth->createPermission(Rbac::TASK_DELETE_APPLICANT);
        $auth->add($deleteApplicant);



        /* Roles */

        // admin
        $roleAdmin = $auth->createRole(Account::ROLE_ADMIN);
        $auth->add($roleAdmin);
        $auth->addChild($roleAdmin, $showBackend);
        $auth->addChild($roleAdmin, $manageAccount);
        $auth->addChild($roleAdmin, $manageObjects);
        $auth->addChild($roleAdmin, $deleteApplicant);

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