<?php declare(strict_types=1);

namespace app\components\common\components\base\resources\sources\crud;

use app\components\common\components\base\resources\sources\BaseTemplateResource;
use yii\data\ActiveDataProvider;
use app\common\components\interfaces\models\SearchModelInterface;

/**
 * < Common > Base class for all resources on index page
 *
 * @package app\common\components\base\resources
 *
 * @tag: #base #resource #template #index
 */
abstract class BaseListViewResource extends BaseTemplateResource
{
    /** @var ActiveDataProvider */
    public ActiveDataProvider $activeDataProvider;

    /** @var SearchModelInterface */
    public SearchModelInterface $searchModel;
}