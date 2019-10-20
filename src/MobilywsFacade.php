<?php
namespace Greatsami\Mobilyws;

use Illuminate\Support\Facades\Facade;

class MobilywsFacade extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'mobilyws';
    }

}
