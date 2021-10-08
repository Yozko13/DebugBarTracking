<?php
namespace DebugBar\SQL;

use DebugBar\Interfaces\SqlProviderInterface;

/**
 * Class SqlProfiler
 */
class SqlProfiler
{
    /**
     * @var \DebugBar\Interfaces\SqlProviderInterface
     */
    private SqlProviderInterface $provider;

    /**
     * @param SqlProviderInterface $provider
     */
    public function __construct(SqlProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    /**
     * @return mixed
     */
    public function getProfileData()
    {
        return $this->provider->getProfileData();
    }
}