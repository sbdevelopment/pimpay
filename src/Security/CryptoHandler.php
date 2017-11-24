<?php

namespace PimPay\Security;

use PimPay\SOAP\Client;

interface CryptoHandler
{
    /**
     * @param  string $data
     * @return string
     */
    function sign($data);

    /**
     * @param string  $requestXml
     * @param Client $soapClient
     * @return string Request XML
     */
    function injectSignature($requestXml, Client $soapClient);
}