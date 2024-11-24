<?php declare(strict_types=1);

namespace app\common\components\base\controllers\core;

use yii\console\Controller;
use yii\helpers\BaseConsole;

/**
 * < Common > Родительский класс для всех консольных контроллеров
 *
 * @package app\common\components\base\controllers
 *
 * @tag: #abstract #base #controller #console
 */
abstract class BaseConsoleController extends Controller
{
    protected const MESSAGE_SUCCESS = 'Success!';

    protected const MESSAGE_ERROR = 'Error!';

    protected const DATETIME_FORMAT = 'Y-m-d H:i:s';

    /**
     * @param string $__METHOD__
     *
     * @return string
     */
    protected function consolePrintFuncCallStart(string $__METHOD__ ): string
    {
        return $this->consolePrintLog($__METHOD__);
    }

    /**
     * @param string $__METHOD__
     *
     * @return string
     */
    protected function consolePrintFuncCallEnd(string $__METHOD__ ): string
    {
        return $this->consolePrintLog($__METHOD__);
    }

    /**
     * @param string $message
     *
     * @return string
     */
    protected function consolePrintLog(string $message ): string
    {
        return PHP_EOL . date(static::DATETIME_FORMAT) . ' | ' . $message;
    }

    /**
     * @param ?string $message
     *
     * @return void
     */
    protected function consolePrintSuccess(?string $message = null ): void
    {
        $this->stdout(static::MESSAGE_SUCCESS, BaseConsole::FG_GREEN);

        if( $message ) $this->stdout(PHP_EOL . $message );
    }

    /**
     * @param ?string $message
     *
     * @return void
     */
    protected function consolePrintError(?string $message = null ): void
    {
        $this->stdout(static::MESSAGE_ERROR, BaseConsole::FG_RED);

        if( $message ) $this->stdout(PHP_EOL . $message );
    }

}