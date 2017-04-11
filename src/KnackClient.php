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
     * Execute REST request.
     *
     * @param string $context Rest API context (ex.:issue, search, etc..)
     * @param string|array $data
     * @param string $custom_request [PUT|DELETE]
     *
     * @return string
     *
     * @throws KnackException
     */
    public function exec($context, $data = array(), $custom_request = null)
    {
        $url = $this->createUrlByContext($context);

        $data_str = '';
        $headers = array();

        if (is_array($data)) {
            if (count($data) > 0) {
                foreach ($data as $key => $value) {
                    $data_str .= "{$key}=" . urlencode($value) . "&";
                }
                $data_str = rtrim($data_str, '&');
            }
        } else {
            // if not array, expect $data to be json
            $data_str = $data;
            array_push($headers, "Content-Type: application/json");
        }

        $this->log->addDebug("Curl $url Data=" . $data_str);

        $ch = curl_init();

        // post_data
        if (!is_null($data)) {
            if (!is_null($custom_request) && $custom_request == 'POST') {
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_str);
            }
            else if (!is_null($custom_request) && $custom_request == 'PUT') {
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_str);
            }
            else if (!is_null($custom_request) && $custom_request == 'DELETE') {
                curl_setopt($ch, CURLOPT_URL, "{$url}?{$data_str}");
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
            } else {
                curl_setopt($ch, CURLOPT_URL, "{$url}?{$data_str}");
            }
        }

        curl_setopt($ch, CURLOPT_HEADER, false);           // Return the header along with the body received from the remote host
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    // Return the content rather than TRUE/FALSE when running curl_exec()
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

        $this->authorization($headers);

        //array_push($headers, "Accept: */*");

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, $this->getConfiguration()->isCurlOptSslVerifyHost());
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->getConfiguration()->isCurlOptSslVerifyPeer());

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_VERBOSE, $this->getConfiguration()->isCurlOptVerbose());

        $this->log->addDebug('Curl exec=' . $url);

        $response = curl_exec($ch);

        // if request failed.
        if (!$response) {
            $this->http_response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $body = curl_error($ch);
            curl_close($ch);

            //The server successfully processed the request, but is not returning any content.
            if ($this->http_response == 204) {
                return true;
            }

            // HostNotFound, No route to Host, etc Network error
            $msg = sprintf("CURL Error: http response=%d, %s", $this->http_response, $body);

            $this->log->addError($msg);
            throw new KnackException($msg);
        } else {
            // if request was ok, parsing http response code.
            $this->http_response = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            curl_close($ch);

            // don't check 301, 302 because setting CURLOPT_FOLLOWLOCATION
            if ($this->http_response != 200 && $this->http_response != 201) {
                throw new KnackException('CURL HTTP Request Failed: Status Code : '
                    . $this->http_response . ', URL:' . $url
                    . "\nError Message : " . $response, $this->http_response);
            }
        }

        return $response;
    }

    /**
     * Get URL by context.
     *
     * @param string $context
     *
     * @return string
     */
    protected function createUrlByContext($context)
    {
        $api_url = $this->getConfiguration()->getKnackApiUrl();

        return $api_url . '/' . preg_replace('/(\/+)/', '/', $context, 1);
    }

    /**
     * Add authorize headers to array that will be used for curl.
     *
     * @TODO session/oauth methods
     *
     * @param array $headers
     */
    protected function authorization(&$headers)
    {
        $app_id = $this->getConfiguration()->getKnackAppId();
        $rest_api_key = $this->getConfiguration()->getKnackRestApiKey();

        array_push($headers, "X-Knack-Application-Id: $app_id");
        array_push($headers, "X-Knack-REST-API-Key: $rest_api_key");
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