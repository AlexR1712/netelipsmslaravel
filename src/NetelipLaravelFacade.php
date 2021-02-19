<?php

namespace AlexR1712\NetelipLaravel;

use Illuminate\Support\Facades\Facade;

/**
 * @see \AlexR1712\NetelipLaravel\Skeleton\SkeletonClass
 */
class NetelipLaravelFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'netelip-laravel';
    }
}
