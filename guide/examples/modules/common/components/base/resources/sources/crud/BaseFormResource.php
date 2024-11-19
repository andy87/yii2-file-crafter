<?php declare(strict_types=1);

namespace app\components\common\components\base\resources\sources\crud;

use app\common\components\base\moels\items\core\BaseModel;

/**
 * < Common > Base class for all resources on page with form
 *
 * @package app\common\components\base\resources
 *
 * @tag: #base #resource #template #form
 */
abstract class BaseFormResource extends BaseTemplateResource
{
    /** @var BaseModel */
    public BaseModel $form;
}