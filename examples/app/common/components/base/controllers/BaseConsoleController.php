<?php declare(strict_types=1);

namespace app\common\components\base\controllers;

use yii\helpers\BaseConsole;
use app\common\components\base\controllers\items\source\SourceConsoleController;

/**
 * < Common > Родительский класс для всех консольных контроллеров
 *
 * @package app\common\components\base\controllers
 *
 * @tag: #abstract #common #base #controller #console
 */
abstract class BaseConsoleController extends SourceConsoleController
{
    /** @var string  */
    protected const MESSAGE_SUCCESS = 'Success!';

    /** @var string  */
    protected const MESSAGE_ERROR = 'Error!';

    /** @var string  */
    protected const DATETIME_FORMAT = 'Y-m-d H:i:s';



    /**
     * @param string $__METHOD__
     *
     * @return string
     */
    protected function printConsoleFuncStart(string $__METHOD__ ): string
    {
        return $this->printConsole($__METHOD__ . '|Start');
    }

    /**
     * @param string $__METHOD__
     *
     * @return string
     */
    protected function printConsoleFuncEnd(string $__METHOD__ ): string
    {
        return $this->printConsole($__METHOD__ . '|Finish');
    }

    /**
     * @param string $message
     *
     * @return string
     */
    protected function printConsole(string $message ): string
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