<?php

namespace Mpwar\Test\Infrastructure;

use Faker\Factory;
use Faker\Generator;

class Stub
{
    public static function factory(): Generator
    {
        return Factory::create();
    }
}