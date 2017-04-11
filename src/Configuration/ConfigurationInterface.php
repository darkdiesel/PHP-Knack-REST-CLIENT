<?php

namespace KnackRestApi\Configuration;

/**
 * Interface ConfigurationInterface.
 */
interface ConfigurationInterface
{
    /**
     * Knack host.
     *
     * @return string
     */
    public function getKnackHost();

    /**
     * Knack api version.
     *
     * @return string
     */
    public function getKnackApiVersion();

    /**
     * Knack url.
     *
     * @return string
     */
    public function getKnackApiUrl();

    /**
     * Knack Application ID.
     *
     * @var string
     */
    public function getKnackAppId();

    /**
     * Knack Rest API Key.
     *
     * @var string
     */
    public function getKnackRestApiKey();

    /**
     * Path to log file.
     *
     * @return string
     */
    public function getKnackLogFile();

    /**
     * Log level (DEBUG, INFO, ERROR, WARNING).
     *
     * @return string
     */
    public function getKnackLogLevel();

    /**
     * Curl options CURLOPT_SSL_VERIFYHOST.
     *
     * @return bool
     */
    public function isCurlOptSslVerifyHost();

    /**
     * Curl options CURLOPT_SSL_VERIFYPEER.
     *
     * @return bool
     */
    public function isCurlOptSslVerifyPeer();

    /**
     * Curl options CURLOPT_VERBOSE.
     *
     * @return bool
     */
    public function isCurlOptVerbose();
}
