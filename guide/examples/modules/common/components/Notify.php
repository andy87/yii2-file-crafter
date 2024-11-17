<?php

namespace app\common\components;

use app\common\components\base\Logger;
use app\common\components\base\services\items\core\BaseService;
use Yii;

/**
 * Class Notify
 *
 * @package app\common\components
 *
 * @tag: #notify
 */
class Notify
{
    public const INFO = 'info';
    public const ERROR = 'error';
    public const WARNING = 'warning';
    public const SUCCESS = 'success';



    /**
     * @param string $message
     * @param string $type
     *
     * @return bool
     */
    public static function send( string $message, string $type = self::INFO ): bool
    {
        try
        {
            $session = Yii::$app->session;

            $session->setFlash( $type, $message );

            return true;

        } catch (\Exception $e) {

            Logger::logCatch($e, __METHOD__, 'Catch! Notify::send()',[
                'message' => $message,
                'type' => $type,
            ]);
        }

        return false;
    }
}