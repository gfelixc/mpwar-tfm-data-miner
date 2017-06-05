<?php

namespace Mpwar\Test\Infrastructure;

use Mockery;
use PHPUnit\Framework\TestCase;

class UnitTestCase extends TestCase
{
    public function mock($interface): Mockery\MockInterface
    {
        return Mockery::mock($interface);
    }

    public function tearDown()
    {
        Mockery::close();
        parent::tearDown();
    }
}