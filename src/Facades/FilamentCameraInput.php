<?php

namespace Machacekmartin\FilamentCameraInput\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Machacekmartin\FilamentCameraInput\FilamentCameraInput
 */
class FilamentCameraInput extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Machacekmartin\FilamentCameraInput\FilamentCameraInput::class;
    }
}
