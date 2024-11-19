<?php declare(strict_types=1);

namespace app\components\common\components\base\resources\sources;

use Yii;
use app\components\common\components\base\resources\BaseResource;

/**
 * < Common > Base class for all resources with template
 *
 * @package app\common\components\base\resources
 *
 * @tag: #base #resource #template
 */
class BaseTemplateResource extends BaseResource
{
    /** @var string Title */
    public string $title;

    /** @var string Template name for rendering */
    public string $template;



    /**
     * @return string
     */
    public function render(): string
    {
        return Yii::$app->view->render($this->template, $this->release());
    }
}