<?php

namespace PimPay\Security;

interface CryptoHandler
{
    /**
     * @param  string $data
     * @return string
     */
    function sign($data);

    /**
     * @param string  $requestXml
     * @param SoapClient $soapClient
     * @return string Request XML
     */
    function injectSignature($requestXml, SoapClient $soapClient);
}