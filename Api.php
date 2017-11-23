<?php

namespace PimPay;

use PimPay\SOAP\Client;
use PimPay\Security\CryptoHandler;

use PimPay\Customer\AcceptParams;
use PimPay\Customer\Info;

use PimPay\Order\Details;
use PimPay\Order\Payment;
use PimPay\Order\State;

use PimPay\Verification\Params;
use PimPay\Verification\StatusResponse;

class Api
{
    /** @var string Сжатый WSDL */
    protected $_wsdlEncoded = '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';

    /** @var string API токер */
    protected $_token;

    /** @var string Содержимое WSDL */
    protected $_wsdl;

    /** @var Client SOAP клиент */
    protected $_soapClient;

    /**
     * @param  string                   $token            API токен
     * @param  CryptoHandler $cryptoHandler    Крипто-обработчик (OpenSSL/GnuPG)
     * @throws \Exception
     */
    public function __construct($token, CryptoHandler $cryptoHandler)
    {
        $this->_token         = $token;
        $this->_cryptoHandler = $cryptoHandler;

        foreach (array('zlib', 'dom', 'soap') as $extension)
        {
            if (!extension_loaded($extension))
            {
                throw new \Exception("$extension extension is not loaded.");
            }
        }

        $this->_initSoapClient();
    }

    /**
     * @return CryptoHandler
     */
    public function getCryptoHandler()
    {
        return $this->_cryptoHandler;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->_token;
    }

    /**
     * Добавить клиента
     *
     * @param  AcceptParams $params  Параметры клиента
     * @return Info                  Возвратная информация по клиенту
     */
    public function acceptClient(AcceptParams $params)
    {
        return $this->_getSoapClient()->acceptClient($this->_token, $params);
    }

    /**
     * Получить информацию по клиенту
     *
     * @param  string                $tin  ИНН клиента
     * @return Info        Возвратная информация по клиенту
     */
    public function getClient($tin)
    {
        return $this->_getSoapClient()->getClient($this->_token, $tin);
    }

    /**
     * Добавить/обновить заказы
     *
     * @param  Details[] $orders   Карточка заказа
     * @return $response                   Информация о добавленных заказах
     */
    public function upsertOrders($orders)
    {
        return $this->_getSoapClient()->upsertOrders($this->_token, $orders);
    }

    /**
     * Добавить/обновить исторические заказы
     *
     * @param  Details[] $orders   Карточка заказа
     * @return $response                   Информация о добавленных заказах
     */
    public function upsertHistoricalOrders($orders)
    {
        return $this->_getSoapClient()->upsertHistoricalOrders($this->_token, $orders);
    }

    /**
     * Обновить статусы заказов
     *
     * @param  State[] $ordersStates Статусы заказов
     * @return int                                  Кол-во заказов
     */
    public function updateStateForOrders($ordersStates)
    {
        return $this->_getSoapClient()->updateStateForOrders($this->_token, $ordersStates);
    }

    /**
     * Проверить работоспособность подписи
     *
     * @return bool
     */
    public function testHeaderSignature()
    {
        return $this->_getSoapClient()->testHeaderSignature($this->_token);
    }

    /**
     * Отправить сверку
     *
     * @param string                      $tin          ИНН клиента
     * @param string                      $id           Идентификатор сверки в вашей системе
     * @param Payment                     $paymentOrder Платежное поручение
     * @param Params[] $rows         Строки сверки
     * @return mixed
     */
    public function sendVerification($tin, $id, Payment $paymentOrder, array $rows)
    {
        $requestRows = [];
        foreach ($rows as $row)
        {
            $itemXml = '<item';
            foreach (array('oid' => $row->orderId, 'ptp' => $row->paymentToPimPay, 'pfr' => $row->paymentFromRecipient, 'dc' => $row->deliveryCost, 'cs' => $row->cashService, 'ins' => $row->insurance) as $attr => $val)
            {
                if (!empty($val))
                {
                    $itemXml .= " $attr=\"$val\"";
                }
            }

            if (is_array($row->customTransactions) && $row->customTransactions)
            {
                $itemXml .= '><ns1:txs>';

                foreach ($row->customTransactions as $ctx)
                {
                    $itemXml .= '<item val="' . $ctx->value . '" comment="' . $ctx->comment . '"/>';
                }

                $itemXml .= '</ns1:txs></item>';
            }
            else
            {
                $itemXml .= '/>';
            }

            $requestRows[] = new SoapVar($itemXml, XSD_ANYXML);
        }

        return $this->_getSoapClient()->sendVerification($this->_token, $tin, $id, $paymentOrder, $requestRows);
    }

    /**
     * Получить статус отправленной сверки
     *
     * @param string $id Идентификатор сверки в вашей системе
     * @return StatusResponse
     */
    public function getVerificationStatus($id)
    {
        return $this->_getSoapClient()->getVerificationStatus($id);
    }

    /**
     * @param $token
     * @param $tin
     * @param array $postIds
     * @return RussianPostPaymentsResponse
     */
    public function getRussianPostPayments($tin, array $postIds)
    {
        return $this->_getSoapClient()->getRussianPostPayments($this->_token, $tin, $postIds);
    }

    /**
     * @param $token
     * @param $tin
     * @param array $postIds
     * @return RussianPostClaimAnswersResponse
     */
    public function getRussianPostClaimAnswers($tin, array $postIds)
    {
        return $this->_getSoapClient()->getRussianPostClaimAnswers($this->_token, $tin, $postIds);
    }

    /**
     * @param  mixed $data
     * @return string
     */
    public function sign($data)
    {
        return $this->_cryptoHandler->sign($data);
    }

    /**
     * @param     $request
     * @param     $location
     * @param     $action
     * @param     $version
     * @param int $one_way
     */
    public function beforeSoapClientRequest($request, $location, $action, $version, $one_way = 0)
    {
        // You do stuff here like logging, reporting, etc...
    }

    /**
     * @param mixed $response
     */
    public function afterSoapClientRequest($response)
    {
        // You do stuff here like logging, reporting, etc...
    }

    /**
     * Инициализация SOAP клиента
     */
    protected function _initSoapClient()
    {
        $this->_wsdl = gzuncompress(base64_decode($this->_wsdlEncoded));

        $this->_soapClient = new Client($this, 'data://text/xml;base64,' . base64_encode($this->_wsdl), array(
                'classmap' => array(
                    'AcceptClientParams'          => 'PimPay\Customer\AcceptParams',
                    'ClientInfo'                  => 'PimPay\Customer\Info',
                    'Order'                       => 'PimPay\Order\Details',
                    'OrderBase'                   => 'PimPay\Order\Base',
                    'OrderParams'                 => 'PimPay\Order\Params',
                    'OrderState'                  => 'PimPay\Order\State',
                    'OrderItem'                   => 'PimPay\Order\Item',
                    'DeliveryStatusHistoryItem'   => 'PimPay\Delivery\StatusHistory\Item',
                    'Address'                     => 'PimPay\Delivery\Params\Address',
                    'Recipient'                   => 'PimPay\Delivery\Params\Recipient',
                    'F103'                        => 'PimPay\Delivery\Params\F103',
                    'PaymentOrder'                => 'PimPay\Order\Payment',
                    'VerificationRow'             => 'PimPay\Verification\Params',
                    'CustomTransaction'           => 'PimPay\Verification\CustomTransaction',
                    'VerificationStatusResponse'  => 'PimPay\Verification\StatusResponse',
                    'VerificationError'           => 'PimPay\Verification\Error',
                    'UpsertResultResponse'        => 'PimPay\Upsert\ResultResponse',
                    'UpsertResultItem'            => 'PimPay\Upsert\ResultItem',
                    'RussianPostPaymentsResponse' => 'PimPay\Order\RussianPost\PaymentsResponse',
                    'RussianPostPaymentInfo'      => 'PimPay\Order\RussianPost\PaymentInfo',
                    'RussianPostPayment'          => 'PimPay\Order\RussianPost\Payment',
                ),
            )
        );
    }

    /**
     * @return Client
     */
    protected function _getSoapClient()
    {
        return $this->_soapClient;
    }
}