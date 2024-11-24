<?php declare(strict_types=1);

namespace app\components\common\components\base\resources\sources\crud;

use app\common\components\base\moels\items\core\BaseModel;
use app\components\common\components\base\resources\sources\BaseTemplateResource;

/**
 * < Common > Base class for all resources on view page
 *
 * @package app\common\components\base\resources
 *
 * @tag: #base #resource #template #view
 */
abstract class BaseViewResource extends BaseTemplateResource
{
    /** @var ?BaseModel */
    public ?BaseModel $model = null;
}