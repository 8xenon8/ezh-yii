<?php

declare(strict_types=1);

namespace app\helpers;

use yii\helpers\Url;

class TagUrlHelper
{
    public static function combineTagQueryString(string $tag, array $selectedTags): string
    {
        if (in_array($tag, $selectedTags)) {
            $selectedTags = array_filter($selectedTags, function($i) use ($tag) {
                return $i !== $tag;
            });
        } else {
            $selectedTags[] = $tag;
        }

        sort($selectedTags);

        return Url::toRoute('site/tags') . "/" . implode(',', $selectedTags);
    }
}