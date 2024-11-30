<?php declare(strict_types=1);

namespace app\common\components\base\moels\items\source;

use yii\db\ActiveRecord;
use app\common\components\interfaces\models\SourceModelInterface;

/**
 * < Common > Родительский класс для всех моделей базы данных
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 *
 * @see SourceModel::SINGULAR
 * @see SourceModel::PLURAL
 *
 * @package app\common\components\base\models\items
 *
 * @tag: #abstract #common #model #base #source
 */
abstract class SourceModel extends ActiveRecord implements SourceModelInterface
{
    /** @var string Единственное число */
    public const SINGULAR = 'Объект';

    /** @var string Множественное число */
    public const PLURAL = 'Объекты';
    // {{Parent}}
}