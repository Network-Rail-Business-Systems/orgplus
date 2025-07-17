<?php

namespace NetworkRailBusinessSystems\OrgPlus\Tests;

use NetworkRailBusinessSystems\OrgPlus\OrgPlusServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->app->setBasePath(
            dirname(__DIR__),
        );
    }

    protected function getPackageProviders($app): array
    {
        return [
            OrgPlusServiceProvider::class,
        ];
    }
}
