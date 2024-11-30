<?php declare(strict_types=1);

namespace app\common\components\system;

use Yii;
use Exception;
use JsonException;
use app\common\components\interfaces\CatcherInterface;

/**
 * < Common > Logger
 *
 * @package app\common\components\core
 *
 * @see self::logError()
 * @see self::logInfo()
 * @see self::logWarning()
 *
 * @tag: #common #component #logger
 */
class Logger implements CatcherInterface
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
        return self::logCatch($e, $method, $message, $data );
    }

    /**
     * @param Exception $e
     * @param string $method
     * @param string $message
     * @param array $params
     *
     * @return bool
     *
     * @throws JsonException
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
            $json = json_encode($log, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

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
     *
     * @throws JsonException
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
     *
     * @throws JsonException
     */
    public static function logInfo( string $method, string $message, array $params ): bool
    {
        try
        {
            $log = self::createLogData( $method, $message, $params );

            Yii::info($log);

        } catch (Exception $e ) {

            self::logCatch($e, __METHOD__, 'Catch! logInfo()', func_get_args() );
        }

        return true;
    }

    /**
     * @param string $method
     * @param string $message
     * @param array $params
     *
     * @return bool
     *
     * @throws JsonException
     */
    public static function logWarning( string $method, string $message, array $params ): bool
    {
        try
        {
            $log = self::createLogData( $method, $message, $params );

            Yii::warning($log);

        } catch (Exception $e ) {

            self::logCatch($e, __METHOD__, 'Catch! logWarning()', func_get_args() );
        }

        return true;
    }

    /**
     * @param string $method
     * @param string $message
     * @param array $params
     * @param ?array $data
     *
     * @return array
     */
    public static function createLogData( string $method, string $message, array $params, ?array $data = null ): array
    {
        $log = [
            date(self::FORMAT) => $method,
            'message' => $message,
            'arguments' => $params
        ];

        if ( $data ) {
            $log['data'] = $data;
        }

        if ( Yii::$app instanceof yii\console\Controller ) {
            echo PHP_EOL . print_r($log, true) . PHP_EOL;
        }

        return $log;
    }
}