<?php

namespace console\controllers;

use common\models\Account;
use Yii;
use yii\console\Controller;

/**
 * Allows you to create or rewrite the admin (superuser) account.
 * 
 * @author Albert Garipov <bert320@gmail.com>
 */
class CreateAdminController extends Controller
{

    /**
     * Rewrite account record's data if it exists.
     * @var boolean
     */
    public $rewrite = false;

    /**
     * @var string
     */
    public $password = null;

    /**
     * @var string
     */
    public $email = null;

    /**
     * @inheritdoc
     */
    public function options($actionID)
    {
        $options = array_merge(parent::options($actionID), [
            'rewrite', 'password', 'email',
        ]);
        return $options;
    }

    /**
     * php yii create-admin --email=admin@site.com
     */
    public function actionIndex()
    {
        if (!$this->email) {
            print("E-mail should be specified.\n");
            return;
        }

        $account = Account::findOne(1);
        if ($account !== null && !$this->rewrite) {
            print("Error: account (ID=1) already exists. Set rewrite=true to rewrite it.\n");
            return;
        }

        if ($account === null) {
            $account = new Account;
            $account->id = 1;
            $account->username = 'admin';
        } else {
            if ($account->role !== Account::ROLE_ADMIN) {
                print("Error: account (ID=1) should have 'admin' role.\n");
                return;
            }
        }

        $account->generateAuthKey();

        if ($this->password) {
            $password = $this->password;
        } else {
            $password = Yii::$app->security->generateRandomString(12);
            print("pass: \"{$password}\"\n");
        }
        $account->setPassword($password);

        $account->role = Account::ROLE_ADMIN;

        $account->status = Account::STATUS_ACTIVE;

        $account->email = $this->email;


        $account->save(false) ? print("Ok.\n") : print("Fail.\n");
    }

}