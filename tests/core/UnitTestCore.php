<?php declare(strict_types=1);

namespace andy87\yii2\file_crafter\tests\core;

use PHPUnit\Framework\TestCase;

/**
 * @cli vendor/bin/phpunit tests/UnitTestCore.php --testdox
 *
 * @package andy87\yii2\file_crafter\test
 *
 * @tag: #test #unit_test #core
 */
abstract class UnitTestCore extends TestCase
{
    /**
     * UnitTestCore constructor.
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        $pathAutoload = __DIR__ . '/../../vendor/autoload.php';

        if (file_exists($pathAutoload)) {

            require_once $pathAutoload;

        } else {
            exit('Error: vendor/autoload.php not found');
        }

        parent::__construct($name);
    }
}