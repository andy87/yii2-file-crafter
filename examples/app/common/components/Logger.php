<?php declare(strict_types=1);

namespace app\common\components;

use Yii, Exception;
use yii\console\Controller;
use app\common\components\interfaces\LoggerInterface;

/**
 * < Common > Logger
 *
 * @package app\common\components\core
 *
 * @see self::logError()
 * @see self::logInfo()
 * @see self::logWarning()
 *
 * @tag: #component #logger
 */
class Logger implements LoggerInterface
{
    /** @var string format for logs */
    protected const FORMAT = 'Y-m-d H:i:s';



    /**
     * @param Exception $e
     * @param ?string $method
     * @param ?string $message
     * @param ?array $data
     *
     * @return bool
     *
     * @throws Exception
     */
    public function catcher(Exception $e, ?string $method, ?string $message, ?array $data = []): bool
    {
        return $this->logCatch($e, $method, $message, $data );
    }

    /**
     * @param Exception $e
     * @param string $method
     * @param string $message
     * @param array $params
     *
     * @return bool
     */
    public static function logCatch( Exception $e, string $method, string $message, array $params = [] ): bool
    {
        $log = self::createLogData( $method, $message, $params, [
            'message' => $e->getMessage(),
            'position' => $e->getFile() . ':' . $e->getLine(),
            'trace' => $e->getTrace()
        ]);

        if ( YII_ENV_DEV && Yii::$app instanceof \yii\web\Controller )
        {
            $json = json_encode( $log, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE );

            Yii::$app->response?->headers?->add( 'catch', $json );
        }

        return true;
    }

    /**
     * @param string $method
     * @param string $message
     * @param array $params
     * @param ?array $exception
     *
     * @return bool
     */
    public static function logError( string $method, string $message, array $params, ?array $exception = null ): bool
    {
        try
        {
            $log = self::createLogData( $method, $message, $params, $exception );

            Yii::error($log);

        } catch (Exception $e ) {

            Logger::logCatch($e, __METHOD__, 'Catch! logError()', func_get_args() );
        }

        return true;
    }

    /**
     * @param string $method
     * @param string $message
     * @param array $params
     *
     * @return bool
     */
    public static function logInfo( string $method, string $message, array $params ): bool
    {
        try
        {
            $log = self::createLogData( $method, $message, $params );

            Yii::info($log);

        } catch (Exception $e ) {

            Logger::logCatch($e, __METHOD__, 'Catch! logInfo()', func_get_args() );
        }

        return true;
    }

    /**
     * @param string $method
     * @param string $message
     * @param array $params
     *
     * @return bool
     */
    public static function logWarning( string $method, string $message, array $params ): bool
    {
        try
        {
            $log = self::createLogData( $method, $message, $params );

            Yii::warning($log);

        } catch (Exception $e ) {

            Logger::logCatch($e, __METHOD__, 'Catch! logWarning()', func_get_args() );
        }

        return true;
    }

    /**
     * @param string $method
     * @param string $message
     * @param array $params
     * @param ?array $exception
     *
     * @return array
     */
    public static function createLogData( string $method, string $message, array $params, ?array $exception = null ): array
    {
        $log = [
            date(self::FORMAT) => $method,
            'message' => $message,
            'arguments' => $params
        ];

        if ( $exception ) $log['exception'] = $exception;

        if ( Yii::$app instanceof Controller ) echo PHP_EOL . print_r($log, true) . PHP_EOL;

        return $log;
    }
}