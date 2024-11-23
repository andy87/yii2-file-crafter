<?php

namespace app\common\models\search\items;

use yii\db\ActiveQueryInterface;
use app\common\models\items\PascalCase;
use app\common\components\interfaces\models\SearchModelInterface;

/**
 * < Common > Модель с логикой поиска в `{{PascalCase}}` для окружения: common
 *
 * @package app\common\models\search\items
 *
 * @tag #common #search #{{snake_case}}
 */
class PascalCaseSearch extends PascalCase implements SearchModelInterface
{
    // {{Boilerplate}}
    public function search(array $params): ActiveQueryInterface
    {
        // TODO: Implement search() method.
    }
}