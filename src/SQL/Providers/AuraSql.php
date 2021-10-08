<?php
namespace DebugBar\SQL\Providers;

use DebugBar\Interfaces\SqlProviderInterface;

/**
 * Class AuraSql
 */
class AuraSql implements SqlProviderInterface
{
    /**
     * @var $profiler
     */
    private $profiler;

    /**
     * @param $profiler
     */
    public function __construct($profiler)
    {
        $profiler->setLogFormat("{function}---{duration}---{statement}---{backtrace}");

        $this->profiler = $profiler;
    }

    /**
     * @return array
     */
    public function getProfileData(): array
    {
        $trackMessages = $this->profiler->getLogger()->getMessages();
        $sqlLog = [];
        foreach ($trackMessages as $trackMessage) {
            $sqlLog[] = explode('---', $trackMessage);
        }

        return $sqlLog;
    }
}