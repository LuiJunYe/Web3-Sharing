<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class'  => AccessControl::className(),
                'except' => ['template'],
                'rules'  => [
                    [
                        'allow'   => true,
                        'roles'   => ['?'],
                        'actions' => ['index'],
                    ],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'template' => [
                'class'      => 'yii\web\ViewAction',
                'layout'     => 'blank',
                'viewPrefix' => 'template',
            ],
        ];
    }

    public function actionIndex()
    {
        $this->layout = 'user-main';

        $show_purchase = true;

        return $this->render('index',compact('show_purchase'));
    }
}
