<?php

namespace Astrogoat\CustomerExperience;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Astrogoat\CustomerExperience\CustomerExperience
 */
class CustomerExperienceFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'customer-experience';
    }
}
