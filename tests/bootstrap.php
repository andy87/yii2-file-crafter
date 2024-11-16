<?php

require_once __DIR__ . '/../vendor/autoload.php'; // Подключение автозагрузчика Composer
require_once __DIR__ . '/../vendor/yiisoft/yii2/Yii.php'; // Подключение Yii

Yii::setAlias('@vendor', __DIR__ . '/../vendor'); // Установка алиаса @vendor