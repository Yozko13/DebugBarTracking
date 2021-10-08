<?php

namespace DebugBar\SQL\Providers;


use DebugBar\Interfaces\SqlProviderInterface;

/**
 * Class PdoSql
 */
class PdoSql implements SqlProviderInterface
{
    /**
     * @param $profiler
     */
    public function __construct($profiler){}

    /**
     * @return mixed|void
     */
    public function getProfileData(){}
}