<?php declare(strict_types=1);

namespace app\common\components\base\resources\items;

use app\common\components\base\services\resources\items\sources\SourceResource;

/**
 * < Common > Base class for all resources with template
 *
 * @package app\common\components\base\resources
 *
 * @tag: #abstract #common #resource #base #items
 */
abstract class BaseTemplateResource extends SourceResource
{
    /** @var string Title */
    public string $title;

    /** @var string Template name for rendering */
    public string $template;
}