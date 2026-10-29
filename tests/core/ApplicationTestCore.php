<?php declare(strict_types=1);

namespace andy87\yii2\file_crafter\tests\core;

use Yii;
use yii\helpers\FileHelper;
use yii\web\Application;
use andy87\yii2\file_crafter\Crafter;

/**
 * Provides an isolated web application and temporary files for integration tests.
 *
 * @package andy87\yii2\file_crafter\tests\core
 */
abstract class ApplicationTestCore extends UnitTestCore
{
    /** @var string Directory owned exclusively by the current test. */
    protected string $testRoot;

    /** @var array Aliases to restore after the test. */
    private array $aliases;

    /** @var array Request globals to restore after the test. */
    private array $requestGlobals;

    /**
     * Create a real Yii application with an isolated SQLite database.
     *
     * @return void
     * @throws \Exception When the temporary environment cannot be created.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->aliases = Yii::$aliases;
        $this->requestGlobals = [$_SERVER, $_GET, $_POST];
        $this->testRoot = sys_get_temp_dir() . '/yii2-file-crafter-' . bin2hex(random_bytes(8));
        FileHelper::createDirectory($this->testRoot . '/runtime');
        FileHelper::createDirectory($this->testRoot . '/web/assets');

        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
        $_SERVER['HTTP_HOST'] = 'localhost';
        $_GET = $_POST = [];

        new Application([
            'id' => 'file-crafter-test',
            'basePath' => $this->testRoot,
            'vendorPath' => dirname(__DIR__, 2) . '/vendor',
            'components' => [
                'request' => [
                    'cookieValidationKey' => 'file-crafter-test',
                    'scriptFile' => __FILE__,
                    'scriptUrl' => '/index.php',
                ],
                'assetManager' => ['basePath' => $this->testRoot . '/web/assets', 'baseUrl' => '/assets'],
                'db' => ['class' => \yii\db\Connection::class, 'dsn' => 'sqlite::memory:'],
            ],
        ]);

        Yii::setAlias('@vendor/andy87/yii2-file-crafter', dirname(__DIR__, 2));
        Yii::setAlias('@bower', Yii::getAlias('@vendor') . '/bower-asset');
        Yii::$app->request->setPathInfo('gii/fileCrafter');
        Yii::$app->request->setUrl('/gii/fileCrafter');
        Yii::$app->request->setQueryParams([]);
        Yii::$app->request->setBodyParams([]);
    }

    /**
     * Close the test database and remove only the directory created by setUp().
     *
     * @return void
     * @throws \yii\base\ErrorException When temporary files cannot be removed.
     */
    protected function tearDown(): void
    {
        Yii::$app->db->close();
        Yii::$app = null;
        Yii::$aliases = $this->aliases;
        [$_SERVER, $_GET, $_POST] = $this->requestGlobals;
        FileHelper::removeDirectory($this->testRoot);

        parent::tearDown();
    }

    /**
     * Configure a generator and prepare its selected panel without user templates.
     *
     * @param array $options Options required by the current scenario.
     * @return Crafter Initialized generator.
     */
    protected function createCrafter(array $options = []): Crafter
    {
        $crafter = new Crafter([
            'template' => 'default',
            'options' => array_replace(['templates' => ['default' => []]], $options),
        ]);
        $crafter->formView();

        return $crafter;
    }

    /**
     * Populate a browser-like request, optionally with a valid CSRF token.
     *
     * @param array $body Submitted form values; an empty array represents GET.
     * @param array $query URL parameters.
     * @param bool $csrf Whether to include the application's valid token.
     * @return void
     */
    protected function setRequest(array $body = [], array $query = [], bool $csrf = true): void
    {
        $_SERVER['REQUEST_METHOD'] = $body ? 'POST' : 'GET';
        if ($body && $csrf) {
            $body[Yii::$app->request->csrfParam] = Yii::$app->request->getCsrfToken();
        }
        $_POST = $body;
        $_GET = $query;
        Yii::$app->request->setBodyParams($body);
        Yii::$app->request->setQueryParams($query);
    }
}
