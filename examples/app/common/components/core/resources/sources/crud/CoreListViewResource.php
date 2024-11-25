<?php declare(strict_types=1);

namespace app\common\components\core\resources\sources\crud;

use yii\data\ActiveDataProvider;
use app\common\components\interfaces\models\SearchModelInterface;
use app\common\components\core\resources\sources\CoreTemplateResource;

/**
 * < Common > Базовый родительский класс для ресурса индекса
 *
 * @package app\common\components\core\resources
 *
 * @tag: #core #abstract #common #resource #index
 */
abstract class CoreListViewResource extends CoreTemplateResource
{
    /** @var ActiveDataProvider */
    public ActiveDataProvider $activeDataProvider;

    /** @var SearchModelInterface */
    public SearchModelInterface $searchModel;
}