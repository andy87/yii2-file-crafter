<?php declare(strict_types=1);

namespace app\components\common\components\base\resources\sources\crud;

use yii\data\ActiveDataProvider;
use app\common\components\interfaces\models\SearchModelInterface;
use app\components\common\components\base\resources\sources\BaseTemplateResource;

/**
 * < Common > Базовый родительский класс для ресурса индекса
 *
 * @package app\common\components\base\resources
 *
 * @tag: #common #base #resource #index
 */
abstract class BaseGridViewResource extends BaseTemplateResource
{
    /** @var ActiveDataProvider */
    public ActiveDataProvider $activeDataProvider;

    /** @var SearchModelInterface */
    public SearchModelInterface $searchModel;
}