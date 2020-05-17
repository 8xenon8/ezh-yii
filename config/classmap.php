<?php

$customClasses = [
	'app\services\ImageProcessingService' => 'services/ImageProcessingService.php'
];

Yii::$classMap = array_merge(Yii::$classMap, $customClasses);