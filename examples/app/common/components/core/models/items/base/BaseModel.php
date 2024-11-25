<?php declare(strict_types=1);

namespace app\common\components\core\moels\items\base;

use yii\db\ActiveRecord;

/**
 * < Common > Родительский класс для всех моделей базы данных
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 *
 * @see BaseModel::SINGULAR
 * @see BaseModel::PLURAL
 *
 * @package app\common\components\core\models\items
 *
 * @tag: #abstract #base #model
 */
abstract class BaseModel extends ActiveRecord
{
    public const SINGULAR = 'Объект';
    public const PLURAL = 'Объекты';
    // {{Parent}}
}