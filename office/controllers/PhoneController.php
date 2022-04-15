<?php

namespace office\controllers;

class PhoneController extends \yii\rest\Controller
{
    public function actionCall()
    {
        return [
            'call' => 'yup'
        ];
    }
}