<?php declare(strict_types=1);

namespace app\common\components\core\resources\sources;

use app\common\components\resources\source\base\BaseResource;

/**
 * < Common > Base class for all resources with template
 *
 * @package app\common\components\core\resources
 *
 * @tag: #core #abstract #common #resource #template
 */
abstract class CoreTemplateResource extends BaseResource
{
    /** @var string Title */
    public string $title;

    /** @var string Template name for rendering */
    public string $template;
}