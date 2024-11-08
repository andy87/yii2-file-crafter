<?php declare(strict_types=1);

namespace common\components\base;

use Yii;
use Exception;
use interfaces\LoggerInterface;

/**
 * Logger
 *
 * @package app\common\components
 *
 * @tag: #component #logger
 */
class Logger implements LoggerInterface
{
    /** @var string format for logs */
    protected const FORMAT = 'Y-m-d H:i:s';



    /**
     * @param mixed $log
     *
     * @return bool
     *
     * @throws Exception
     */
    public function log( mixed $log ): bool
    {
        try {
            Yii::error([
                date(static::FORMAT) => $log,
            ]);

            return true;

        } catch ( Exception $e ) {

            $this->catcher( $e, __METHOD__, 'Error! on log', $log );
        }

        return false;
    }

    /**
     * @param Exception $e
     * @param ?string $method
     * @param ?string $message
     * @param ?array $data
     *
     * @return void
     *
     * @throws Exception
     */
    public function catcher(Exception $e, ?string $method, ?string $message, ?array $data = []): void
    {
        try {
            Yii::error([
                date(static::FORMAT) => $method,
                'message' => $message,
                'exception' => [
                    'message' => $e->getMessage(),
                    'position' => $e->getFile() . ':' . $e->getLine(),
                    'trace' => $e->getTrace(),
                ],
                'arguments' => $data
            ]);

        } catch (Exception $e ) {

            throw new Exception( $e->getMessage() );
        }
    }
}