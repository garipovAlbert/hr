<?php

namespace frontend\components;

use yii\web\Application as baseApplication;

/**
 * @author Albert Garipov <bert320@gmail.com>
 */
class Application extends baseApplication
{

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        // redirect from "/index.php" to "/"
        if (parent::beforeAction($action)) {
            if (strpos($this->getRequest()->getUrl(), '/index.php') === 0) {
                $this->response->redirect('/', 301);
                $this->end();
            }
            return true;
        } else {
            return false;
        }
    }

}