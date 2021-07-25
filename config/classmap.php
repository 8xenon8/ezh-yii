<?php

$customClasses = [
	'app\services\ImageService' => __DIR__ . '/../services/ImageService.php'
];

Yii::$classMap = array_merge(Yii::$classMap, $customClasses);