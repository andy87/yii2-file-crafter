<?php declare(strict_types=1);

namespace app\components\common\components\base\resources\sources;

use yii\base\Model;

/**
 * Base class for all resources on page with form
 *
 * @package common\components\base\resources
 *
 * @tag: #base #resource #template #form
 */
abstract class BaseFormResource extends BaseTemplateResource
{
    /** @var Model */
    public Model $model;
}