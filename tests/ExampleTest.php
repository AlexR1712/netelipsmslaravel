<?php

namespace AlexR1712\NetelipLaravel\Tests;

use Orchestra\Testbench\TestCase;
use AlexR1712\NetelipLaravel\NetelipLaravelServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [NetelipLaravelServiceProvider::class];
    }
    
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
