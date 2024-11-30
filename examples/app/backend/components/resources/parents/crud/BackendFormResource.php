<?php declare(strict_types=1);

namespace app\backend\components\resources\parents\crud;

use app\backend\models\forms\items\PascalCaseForm;
use app\common\components\base\services\resources\crud\BaseFormResource;

/**
 * < Backend > Родительский класс для ресурса с формой в окружении `backend`
 *
 * @property ?PascalCaseForm $form
 *
 * @package app\backend\components\resources\parents\crud
 *
 * @tag: #abstract #backend #parent #crud #resource #form
 */
abstract class BackendFormResource extends BaseFormResource
{
    // {{Boilerplate}}
}