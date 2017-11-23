<?php

namespace PimPay\Verification;

class Params
{
    public $orderId;
    public $paymentFromRecipient;
    public $paymentToPimPay;
    public $deliveryCost;
    public $cashService;
    public $insurance;
    /** @var CustomTransaction[] $customTransactions */
    public $customTransactions = array();
}