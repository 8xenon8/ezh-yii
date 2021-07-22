<?php

namespace app\controllers;

use app\models\Image;
use app\models\Tag;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
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
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
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
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function beforeAction($action)
    {
        $this->view->params['tags'] = Tag::find()->asArray()->all();

        if ($action->id === 'tags') {
            $tagString = $this->request->queryParams['tags'] ?? '';
            $this->view->params['selectedTags'] = $tagString ? explode(',', $tagString) : [];
        } else {
            $this->view->params['selectedTags'] = [];
        }

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionTags()
    {
        $images = Image::find()->joinWith('tags')->where(['publish' => true])->orderBy(['order' => SORT_DESC])->all();

        return $this->render('tags', [
            'images' => $images
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
}
