<?php

namespace PimPay\SOAP;

use PimPay\Api;

class Client extends \SoapClient
{
    /** @var Api */
    protected $_api;

    /** @var resource stream context */
    protected $_context;

    /**
     * @param Api $api
     * @param array     $wsdl
     * @param array     $options
     */
    public function __construct(Api $api, $wsdl, array $options = null)
    {
        $this->_context = stream_context_create();
        $options = array_merge($options, array('stream_context' => $this->_context));

        parent::__construct($wsdl, $options);

        $this->_api = $api;

        $clientHeader    = new \SoapHeader('urn:PlatformApiWsdl', 'client',    'phpSdk @ 2017-11-23 20:37:45', false);
        $versionHeader   = new \SoapHeader('urn:PlatformApiWsdl', 'version',   'v2_6', false);
        $signatureHeader = new \SoapHeader('urn:PlatformApiWsdl', 'signature', null, false);
        $this->__setSoapHeaders(array($clientHeader, $versionHeader, $signatureHeader));
    }

    /**
     * @return resource
     */
    public function getStreamContext()
    {
        return $this->_context;
    }

    /**
     * @param string $request
     * @param string $location
     * @param string $action
     * @param int    $version
     * @param int    $one_way
     * @return string
     */
    public function __doRequest($request, $location, $action, $version, $one_way = 0)
    {
        $request = $this->_api->getCryptoHandler()->injectSignature($request, $this);

        $this->_api->beforeSoapClientRequest($request, $location, $action, $version, $one_way);

        $response = parent::__doRequest($request, $location, $action, $version, $one_way);

        $this->_api->afterSoapClientRequest($response);

        return $response;
    }
}