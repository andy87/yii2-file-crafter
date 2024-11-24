<?php declare(strict_types=1);

namespace app\backend\components\resources\items\snake_case;

use app\backend\models\items\PascalCase;
use app\backend\components\resources\crud\BackendCreateResource;

/**
 * < Backend > Boilerplate для ресурса создания модели `{{PascalCase}}`
 *
 * @property {{PascalCase}} $form
 *
 * @property ?PascalCase $form
 *
 * @package app\backend\components\resources\items\{{snake_case}}
 *
 * @tag: #backend #resource #template #create
 */
class PascalCaseCreateResource extends BackendCreateResource
{
    // {{Boilerplate}}
}