<?php

namespace PimPay\Order\RussianPost;


class PaymentInfo
{
    public $id;
    public $postId;
    /**
     * @var Payment[]
     */
    public $payments = [];
}