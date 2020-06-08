<?php

namespace app\modules\admin\controllers;

use app\models\Image;
use app\models\LoginForm;
use app\models\Tag;
use himiklab\sortablegrid\SortableGridAction;
use richardfan\sortable\SortableAction;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * Default controller for the `admin` module
 */
class DefaultController extends Controller
{
    /**
     * @return array|array[]
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => false,
                        'actions' => ['login'],
                        'roles' => ['@'],
                    ],
//                    [
//                        'allow' => false,
//                        'roles' => ['?'],
//                    ],
                    [
                        'allow' => true,
                        'roles' => ['?'],
                        'actions' => ['login']
                    ],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goBack();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect('/admin');
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * @return string
     */
    public function actionImages()
    {
        $imagesQuery = Image::find()->joinWith('tags' );
        $tags = Tag::find()->asArray()->all();

        $imagesProvider = new ActiveDataProvider([
            'query' => $imagesQuery,
            'pagination' => false,
            'sort' => [
                'defaultOrder' => [
                    'order' => SORT_DESC
                ]
            ]
        ]);

        return $this->render('images', [
            'imagesDataProvider' => $imagesProvider,
            'tags' => $tags
        ]);
    }

    /**
     * @return string
     */
    public function actionSorting()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Image::find()->asArray()
        ]);

        return $this->render('sorting', [
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * @return string
     */
    public function actionTags()
    {
        $query = Tag::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
            'sort' => [
                'defaultOrder' => [
                    'order' => SORT_DESC
                ]
            ]
        ]);

        return $this->render('tags', ['dataProvider' => $dataProvider]);
    }
}
