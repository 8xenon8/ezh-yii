<?php

namespace app\modules\admin\controllers;

use app\models\Image;
use app\models\Tag;
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
        $query = Image::find();

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
            'sort' => [
                'defaultOrder' => [
                    'order' => SORT_DESC
                ]
            ]
        ]);

        return $this->render('images', [
            'dataProvider' => $provider
        ]);
    }

    public function actionSorting()
    {
        return $this->render('sortings');
    }

    public function actionTags()
    {
        $query = Tag::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
//            'sort' => [
//                'defaultOrder' => [
//                    'order' => SORT_DESC
//                ]
//            ]
        ]);

        return $this->render('tags', ['dataProvider' => $dataProvider]);
    }

    public function actions()
    {
        return [
            'sortItem' => [
                'class' => SortableAction::class,
                'activeRecordClassName' => Image::class,
                'orderColumn' => 'order',
            ],
        ];
    }
}
