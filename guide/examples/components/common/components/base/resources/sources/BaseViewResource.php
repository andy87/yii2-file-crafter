<?php declare(strict_types=1);

namespace app\components\common\components\base\resources\sources;

use yii\base\Model;

/**
 * Base class for all resources on view page
 *
 * @package common\components\base\resources
 *
 * @tag: #base #resource #template #view
 */
abstract class BaseViewResource extends BaseTemplateResource
{
    /** @var Model */
    public Model $model;
}