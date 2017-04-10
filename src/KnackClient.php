<?php

namespace KnackRestApi;

use KnackRestApi\Configuration\ConfigurationInterface;
use Monolog\Logger as Logger;
use Monolog\Handler\StreamHandler;

class KnackClient
{
    /**
     * HTTP response code.
     *
     * @var string
     */
    protected $http_response;

    /**
     * Knack Rest API Configuration.
     *
     * @var ConfigurationInterface
     */
    protected $configuration;

    /**
     * Constructor.
     *
     * @param ConfigurationInterface $configuration
     * @param Logger $logger
     * @throws \Exception
     */
    public function __construct(ConfigurationInterface $configuration = null, Logger $logger = null)
    {
        // ensure Curl is installed
        if (!extension_loaded("curl")) {
            throw(new \Exception("The Curl extension is required for the client to function."));
        }

        $this->configuration = $configuration;

        // create logger
        if ($logger) {
            $this->log = $logger;
        } else {
            $this->log = new Logger('KnackClient');
            $this->log->pushHandler(new StreamHandler(
                $configuration->getKnackLogFile(),
                $this->convertLogLevel($configuration->getKnackLogLevel())
            ));
        }

        $this->http_response = 200;
    }

    /**
     * Convert log level.
     *
     * @param $log_level
     *
     * @return int
     */
    private function convertLogLevel($log_level)
    {
        switch ($log_level) {
            case 'DEBUG':
                return Logger::DEBUG;
            case 'INFO':
                return Logger::INFO;
            case 'ERROR':
                return Logger::ERROR;
            default:
                return Logger::WARNING;
        }
    }

    /**
     * Knack Rest API Configuration.
     *
     * @return ConfigurationInterface
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

}