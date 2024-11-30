<?php declare(strict_types=1);

namespace app\common\components\base\services\resources\crud;

use yii\data\ActiveDataProvider;
use app\common\components\interfaces\models\SearchModelInterface;
use app\common\components\base\resources\items\BaseTemplateResource;

/**
 * < Common > Базовый родительский класс для ресурса индекса
 *
 * @package app\common\components\base\resources
 *
 * @tag: #abstract #common #resource #base #crud #view
 */
abstract class BaseListViewResource extends BaseTemplateResource
{
    /** @var ActiveDataProvider */
    public ActiveDataProvider $activeDataProvider;

    /** @var SearchModelInterface */
    public SearchModelInterface $searchModel;
}