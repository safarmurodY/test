<?php

namespace office\controllers;

use office\models\LoginForm;
use Yii;
use yii\rest\Controller;


/**
 * Site controller
 */
class SiteController extends Controller
{
    public function actionIndex()
    {
        return 'asdapi';
    }

    public function actionLogin()
    {
        $model = new LoginForm();
        $model->load($this->request->bodyParams, '');
        if ($token = $model->auth()){
            return $token;
        }else{
            return $model;
        }
    }


    protected function verbs()
    {
        return [
            'login' => ['post'],
        ];
    }

    public function actionOther()
    {
        return 's';
    }
}
