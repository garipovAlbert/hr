<?php

use common\components\BackendUrlManager;
use common\components\FrontendUrlManager;
use common\components\lang\ILangApplication;
use common\models\Account;
use yii\BaseYii;
use yii\web\Application;
use yii\web\DbSession;
use yii\web\Request;
use yii\web\Response;
use yii\web\User;

/**
 * IDE autocomplete helper
 */

/**
 * 
 */
class Yii extends BaseYii
{

    /**
     * @var MyApp the application instance
     */
    public static $app;

}

/**
 * @property Account $identity
 */
class MyUser extends User
{
    
}

/**
 * @property Request $request
 * @property Response $response
 * @property \yii\authclient\Collection $authClientCollection
 * @property MyUser $user
 * @property FrontendUrlManager $frontendUrlManager
 * @property BackendUrlManager $backendUrlManager
 * @property DbSession $session
 */
class MyApp extends Application implements ILangApplication
{

    /**
     * @inheritdoc
     */
    public function getLang()
    {
        
    }

}