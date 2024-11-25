<?php declare(strict_types=1);

namespace common\models\search\items;

use app\common\components\interfaces\models\SearchModelInterface;
use yii\db\ActiveQueryInterface;

/**
 * < Common > Модель с логикой поиска в `{{PascalCase}}` для окружения: common
 *
 * @package app\common\models\search\items
 *
 * @tag #common #search #{{snake_case}}
 */
class PascalCaseSearch extends \common\models\items\PascalCase implements SearchModelInterface
{
    // {{Boilerplate}}
    public function search(array $params): ActiveQueryInterface
    {
        // TODO: Implement search() method.
    }
}