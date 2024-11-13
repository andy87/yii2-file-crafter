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
        require_once __DIR__ . '/../../vendor/autoload.php';

        parent::__construct($name);
    }
}