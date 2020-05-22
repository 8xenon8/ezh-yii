<?php

namespace app\modules\api\controllers;

use app\models\Image;
use app\models\Tag;

class BindTagAction extends \yii\rest\Action
{
    public function run($id)
    {
        /** @var Image $image */
        $image = Image::findOne($id);
        if (!$image)
        {
            return \Yii::$app->response->setStatusCode(404);
        }
        /** @var Tag $tagName */
        $tagName = \Yii::$app->request->bodyParams["name"];
        $tag = Tag::findOne(["name" => $tagName]);
        if (!$tag)
        {
            return \Yii::$app->response->setStatusCode(400);
        }
        $image->link('tags', $tag);
    }
}

class UnbindTagAction extends \yii\rest\Action
{
    public function run($id, $tagName)
    {
        /** @var Image $image */
        $image = Image::findOne($id);
        if (!$image)
        {
            return \Yii::$app->response->setStatusCode(404);
        }
        /** @var Tag $tagName */
        $tag = Tag::findOne(["name" => $tagName]);
        if (!$tag)
        {
            return \Yii::$app->response->setStatusCode(400);
        }
        $image->unlink('tags', $tag, true);
    }
}