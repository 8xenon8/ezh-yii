<?php
/**
 * Created by PhpStorm.
 * User: Xenon
 * Date: 16.12.2019
 * Time: 5:01
 */

namespace app\modules\api\controllers;


use app\models\Tag;
use yii\rest\ActiveController;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class TagController extends ActiveController
{
    public $modelClass = 'app\models\Tag';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['update']);
        unset($actions['view']);
        unset($actions['index']);
        unset($actions['create']);
        unset($actions['delete']);
        return $actions;
    }

    public function actionCreate(string $tagName)
    {
        $tag = new Tag();
        $tag->name = $tagName;
        if (!$tag->save())
        {
            throw new BadRequestHttpException(implode('; ', $tag->getErrorSummary(true)));
        }
        \Yii::$app->response->setStatusCode(200);
        return $tag;
    }

    public function actionDelete(string $tagName)
    {
        $tag = Tag::findOne(['name' => $tagName]);
        if (!$tag)
        {
            throw new NotFoundHttpException('No tag with such name!');
        }
        if (!$tag->delete())
        {
            throw new BadRequestHttpException(implode('; ', $tag->getErrorSummary()));
        }
        return \Yii::$app->response->setStatusCode(204);
    }
}