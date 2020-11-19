<?php


namespace PcWeb\BitrixApi;


class BitrixSettings
{
    public string $webhookUrl;
    public string $logDir;
    public bool $log = false;
    public bool $dump = true;
    public bool $ignoreSsl = false;

    /**
     * BitrixSettings constructor.
     * @param string $webhookUrl
     * @param string $logDir
     * @param bool $log
     * @param bool $dump
     * @param bool $ignoreSsl
     */
    public function __construct(string $webhookUrl, string $logDir, bool $log = false, bool $dump = true, bool $ignoreSsl= false)
    {
        $this->webhookUrl = $webhookUrl;
        $this->logDir = $logDir;
        $this->log = $log;
        $this->dump = $dump;
        $this->ignoreSsl = $ignoreSsl;
    }

}
