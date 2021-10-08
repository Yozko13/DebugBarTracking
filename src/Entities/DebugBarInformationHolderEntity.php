<?php

namespace DebugBar\Entities;

/**
 * Class DebugBarInformationHolderEntity
 */
class DebugBarInformationHolderEntity
{
    /**
     * @var string
     */
    private string $url;
    /**
     * @var array
     */
    private array $dispatch;
    /**
     * @var string
     */
    private string $clientIP;
    /**
     * @var string
     */
    private string $requestMethod;
    /**
     * @var array
     */
    private array $requestPost;
    /**
     * @var array
     */
    private array $requestGet;
    /**
     * @var array
     */
    private array $sql;
    /**
     * @var array
     */
    private array $user;
    /**
     * @var string
     */
    private string $memory;
    /**
     * @var string
     */
    private string $time;

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return array
     */
    public function getDispatch(): array
    {
        return $this->dispatch;
    }

    /**
     * @param array $dispatch
     */
    public function setDispatch(array $dispatch): void
    {
        $this->dispatch = $dispatch;
    }

    /**
     * @return string
     */
    public function getClientIP(): string
    {
        return $this->clientIP;
    }

    /**
     * @param string $clientIP
     */
    public function setClientIP(string $clientIP): void
    {
        $this->clientIP = $clientIP;
    }

    /**
     * @return string
     */
    public function getRequestMethod(): string
    {
        return $this->requestMethod;
    }

    /**
     * @param string $requestMethod
     */
    public function setRequestMethod(string $requestMethod): void
    {
        $this->requestMethod = $requestMethod;
    }

    /**
     * @return array
     */
    public function getRequestPost(): array
    {
        return $this->requestPost;
    }

    /**
     * @param array $requestPost
     */
    public function setRequestPost(array $requestPost): void
    {
        $this->requestPost = $requestPost;
    }

    /**
     * @return array
     */
    public function getRequestGet(): array
    {
        return $this->requestGet;
    }

    /**
     * @param array $requestGet
     */
    public function setRequestGet(array $requestGet): void
    {
        $this->requestGet = $requestGet;
    }

    /**
     * @return array
     */
    public function getSql(): array
    {
        return $this->sql;
    }

    /**
     * @param array $sql
     */
    public function setSql(array $sql): void
    {
        $this->sql = $sql;
    }

    /**
     * @return array
     */
    public function getUser(): array
    {
        return $this->user;
    }

    /**
     * @param array $user
     */
    public function setUser(array $user): void
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getMemory(): string
    {
        return $this->memory;
    }

    /**
     * @param string $memory
     */
    public function setMemory(string $memory): void
    {
        $this->memory = $memory;
    }

    /**
     * @return string
     */
    public function getTime(): string
    {
        return $this->time;
    }

    /**
     * @param string $time
     */
    public function setTime(string $time): void
    {
        $this->time = $time;
    }

}