<?php

namespace Andreshg112\DatosAbiertos\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Andreshg112\DatosAbiertos\Datasets\OrganismoTransito
 */
class OrganismoTransito extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'organismo-transito';
    }
}
