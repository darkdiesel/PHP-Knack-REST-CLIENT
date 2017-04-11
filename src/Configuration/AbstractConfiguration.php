<?php

namespace KnackRestApi\Configuration;

/**
 * Class AbstractConfiguration.
 */
abstract class AbstractConfiguration implements ConfigurationInterface
{
    /**
     * Knack host.
     *
     * @var string
     */
    protected $knackHost;

    /**
     * Knack API version.
     *
     * @var string
     */
    protected $knackApiVersion;

    /**
     * Knack Application ID.
     *
     * @var string
     */
    protected $knackAppId;

    /**
     * Knack Rest API Key.
     *
     * @var string
     */
    protected $knackRestApiKey;

    /**
     * Path to log file.
     *
     * @var string
     */
    protected $knackLogFile;

    /**
     * Log level (DEBUG, INFO, ERROR, WARNING).
     *
     * @var string
     */
    protected $knackLogLevel;

    /**
     * Curl options CURLOPT_SSL_VERIFYHOST.
     *
     * @var bool
     */
    protected $curlOptSslVerifyHost;

    /**
     * Curl options CURLOPT_SSL_VERIFYPEER.
     *
     * @var bool
     */
    protected $curlOptSslVerifyPeer;

    /**
     * Curl options CURLOPT_VERBOSE.
     *
     * @var bool
     */
    protected $curlOptVerbose;

    /**
     * @return string
     */
    public function getKnackHost()
    {
        return $this->knackHost;
    }

    /**
     * Knack api version.
     *
     * @return string
     */
    public function getKnackApiVersion()
    {
        return $this->knackApiVersion;
    }

    /**
     * Knack url.
     *
     * @return string
     */
    public function getKnackApiUrl()
    {
        return "{$this->knackHost}/v{$this->knackApiVersion}";
    }

    /**
     * @return string
     */
    public function getKnackAppId()
    {
        return $this->knackAppId;
    }

    /**
     * @return string
     */
    public function getKnackRestApiKey()
    {
        return $this->knackRestApiKey;
    }

    /**
     * @return string
     */
    public function getKnackLogFile()
    {
        return $this->knackLogFile;
    }

    /**
     * @return string
     */
    public function getKnackLogLevel()
    {
        return $this->knackLogLevel;
    }

    /**
     * @return bool
     */
    public function isCurlOptSslVerifyHost()
    {
        return $this->curlOptSslVerifyHost;
    }

    /**
     * @return bool
     */
    public function isCurlOptSslVerifyPeer()
    {
        return $this->curlOptSslVerifyPeer;
    }

    /**
     * @return bool
     */
    public function isCurlOptVerbose()
    {
        return $this->curlOptVerbose;
    }
}
