<?php

namespace app\modules\api\controllers;

use app\models\Image;
use app\models\Tag;

class ToggleTagAction extends \yii\rest\Action
{
    public function run($id, $tagName)
    {
        /** @var Image $image */
        $image = Image::findOne($id);
        if (!$image)
        {
            return \Yii::$app->response->setStatusCode(404, 'Image not found');
        }
        /** @var Tag $tag */
        $tag = Tag::findOne(["name" => $tagName]);
        if (!$tag)
        {
            return \Yii::$app->response->setStatusCode(404, 'Tag not found');
        }

        $method = \Yii::$app->request->method;

        if ($method === 'POST' && !$image->hasTag($tag->name))
        {
            $image->link('tags', $tag);
        }
        else if ($method === 'DELETE')
        {
            $image->unlink('tags', $tag, true);
        }
    }
}