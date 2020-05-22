<?php

$customClasses = [
	'app\services\ImageProcessingService' => __DIR__ . '/../services/ImageProcessingService.php'
];

Yii::$classMap = array_merge(Yii::$classMap, $customClasses);