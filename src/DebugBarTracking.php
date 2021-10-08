<?php

namespace DebugBar;

use DebugBar\Decorators\OutputDecorator;
use DebugBar\Entities\DebugBarInformationHolderEntity;
use DebugBar\Enums\OutputDecoratorRenderTypes;
use DebugBar\Enums\ProfilerTypes;
use DebugBar\SQL\Providers\AuraSql;
use DebugBar\SQL\Providers\PdoSql;
use DebugBar\SQL\SqlProfiler;

/**
 * Final class DebugBarTracking
 */
final class DebugBarTracking
{
    /**
     * @var $instance
     */
    private static $instance;
    /**
     * @var float|int
     */
    private float $memoryStart;
    /**
     * @var float
     */
    private float $timeStart;
    /**
     * @var array
     */
    private array $dispatch;

    /**
     * @var SqlProfiler $profiler
     */
    private SqlProfiler $profiler;

    /**
     * Construct
     */
    private function __construct()
    {
        $this->timeStart   = microtime(true);
        $this->memoryStart = memory_get_usage();
    }

    /**
     * Make clone magic method private, so nobody can clone instance.
     */
    private function __clone() {}

    /**
     * Make sleep magic method private, so nobody can serialize instance.
     */
    private function __sleep() {}

    /**
     * Make wakeup magic method private, so nobody can unserializable instance.
     */
    private function __wakeup() {}

    /**
     * @return DebugBarTracking
     */
    public static function getInstance(): ?DebugBarTracking
    {
        if(self::$instance === null) {
            self::$instance = new DebugBarTracking();
        }

        return self::$instance;
    }

    /**
     * @return DebugBarInformationHolderEntity
     */
    private function collectData(): DebugBarInformationHolderEntity
    {
        $debugBarHolderEntities = new DebugBarInformationHolderEntity();
        $debugBarHolderEntities->setUrl($this->getUrl());
        $debugBarHolderEntities->setDispatch($this->getDispatchResult());
        $debugBarHolderEntities->setClientIP($this->getClientIP());
        $debugBarHolderEntities->setRequestMethod($this->getRequestMethod());
        $debugBarHolderEntities->setRequestPost($this->getRequestPost());
        $debugBarHolderEntities->setRequestGet($this->getRequestGet());
        $debugBarHolderEntities->setSql($this->getSql());
        $debugBarHolderEntities->setUser($this->getUser());
        $debugBarHolderEntities->setMemory($this->getMemory());
        $debugBarHolderEntities->setTime($this->getTime());

        return $debugBarHolderEntities;
    }

    /**
     * @param OutputDecoratorRenderTypes|null $decorateType
     * @return string
     */
    public function render(OutputDecoratorRenderTypes $decorateType = null): string
    {
        $outputDecorator = new OutputDecorator($this->collectData());

        $decorate = OutputDecoratorRenderTypes::DECORATE_HTML();
        if(!empty($decorateType)) {
            $decorate = $decorateType;
        }

        return $outputDecorator->decorate($decorate);
    }

    /**
     * @return string
     */
    private function getUrl(): string
    {
        return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") ."://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }

    /**
     * @return string
     */
    private function getClientIP(): string
    {
        $clientIP = $_SERVER['REMOTE_ADDR'];
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $clientIP = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $clientIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }

        return $clientIP;
    }

    /**
     * @return string
     */
    private function getRequestMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * @return array[]
     */
    private function getRequestPost(): array
    {
        return $_POST;
    }

    /**
     * @return array[]
     */
    private function getRequestGet(): array
    {
        return $_GET;
    }

    /**
     * @return array[]
     */
    private function getDispatchResult(): array
    {
        return $this->dispatch;
    }

    /**
     * @param array[] $dispatch
     */
    public function setDispatchResult(array $dispatch)
    {
        $this->dispatch = $dispatch;
    }

    /**
     * @return array[]
     */
    private function getSql(): array
    {
        return $this->profiler->getProfileData();
    }

    /**
     * @param ProfilerTypes $type
     * @param $profiler
     * @throws \Exception
     */
    public function setSqlProfilerDriver(ProfilerTypes $type, $profiler)
    {
        switch ($type) {
            case ProfilerTypes::PROFILER_TYPE_AURASQL:
                $provider = new AuraSql($profiler);
                break;
            case ProfilerTypes::PROFILER_TYPE_PDO:
                $provider = new PdoSql($profiler);
                break;
            default:
                throw new \Exception('Invalid provider');
        }

        $this->profiler = new SqlProfiler($provider);
    }

    /**
     * @return array[]
     */
    private function getUser(): array
    {
        return empty($_SESSION) ? $_SESSION : array_merge(['is_logged_in' => $_SESSION['isLoggedIn']] , $_SESSION['user']);
    }

    /**
     * @return string
     */
    private function getMemory(): string
    {
        return round((memory_get_usage() - $this->memoryStart) / 1048576,2) .' MB';
    }

    /**
     * @return string
     */
    private function getTime(): string
    {
        return round(microtime(true) - $this->timeStart, 4) .'sec';
    }
}