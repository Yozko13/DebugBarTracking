<?php

namespace DebugBar\SQL\Providers;


use DebugBar\Interfaces\SqlProviderInterface;

class PdoSql implements SqlProviderInterface
{
    public function __construct($profiler)
    {
    }

    public function getProfileData()
    {
        // TODO: Implement getProfileData() method.
    }
}