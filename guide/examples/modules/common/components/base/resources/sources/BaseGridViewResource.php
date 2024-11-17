<?php declare(strict_types=1);

namespace app\components\common\components\base\resources\sources;

use yii\data\ActiveDataProvider;
use interfaces\models\SearchModelInterface;

/**
 * Base class for all resources on index page
 *
 * @package app\common\components\base\resources
 *
 * @tag: #base #resource #template #index
 */
abstract class BaseGridViewResource extends BaseTemplateResource
{
    /** @var ActiveDataProvider */
    public ActiveDataProvider $activeDataProvider;

    public SearchModelInterface $searchModel;
}