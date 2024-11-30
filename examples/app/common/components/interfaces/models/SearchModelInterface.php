<?php declare(strict_types=1);

namespace app\common\components\interfaces\models;

use yii\db\ActiveQueryInterface;

/**
 * < Common >
 *
 * @package app\common\components\interfaces\models
 *
 * @tag: #abstract #common #interface #searchModel
 */
interface SearchModelInterface
{
    /**
     * @param array $params
     *
     * @return ActiveQueryInterface
     */
    public function search( array $params ): ActiveQueryInterface;

    /**
     * @param $data
     * @param $formName
     *
     * @return mixed
     */
    public function load( $data, $formName = null );
}