<?php
/**
 * Created by PhpStorm.
 * User: Xenon
 * Date: 16.12.2019
 * Time: 5:01
 */

namespace app\modules\api\controllers;


use app\models\Image;
use app\models\Tag;
use app\modules\api\controllers\actions\ToggleTagAction;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use yii\rest\ViewAction;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class TagController extends ActiveController
{
    public $modelClass = Tag::class;

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['view']);
        unset($actions['create']);
        unset($actions['delete']);

        return $actions;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
            'authMethods' => [
                QueryParamAuth::className(),
            ],
            'except' => ['index']
        ];

        return $behaviors;
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

    public function actionToggle(string $tagName, int $imageId)
    {
        /** @var Image $image */
        $image = Image::findOne($imageId);
        if (!$image) {
            return \Yii::$app->response->setStatusCode(404, 'Image not found');
        }
        /** @var Tag $tag */
        $tag = Tag::findOne(["name" => $tagName]);
        if (!$tag) {
            return \Yii::$app->response->setStatusCode(404, 'Tag not found');
        }

        $method = \Yii::$app->request->method;

        if ($method === 'POST' && !$image->hasTag($tag->name)) {
            $image->link('tags', $tag);
        } else if ($method === 'DELETE') {
            $image->unlink('tags', $tag, true);
        }
    }
}