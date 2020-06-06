<?php

namespace app\modules\admin\controllers;

use app\models\Image;
use app\models\Tag;
use himiklab\sortablegrid\SortableGridAction;
use richardfan\sortable\SortableAction;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Default controller for the `admin` module
 */
class DefaultController extends Controller
{
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
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

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

    public function actionSorting()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Image::find()->asArray()
        ]);

        return $this->render('sorting', [
            'dataProvider' => $dataProvider
        ]);
    }

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
