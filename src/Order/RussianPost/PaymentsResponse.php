<?php

namespace PimPay\Order\RussianPost;

class PaymentsResponse
{
    public $tin;
    /**
     * @var PaymentInfo[]
     */
    public $russianPostPaymentsInfo;
}