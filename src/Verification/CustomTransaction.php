<?php

namespace PimPay\Verification;


class CustomTransaction
{
    public $value;
    public $comment;

    public  function __construct($value, $comment)
    {
        $this->value = $value;
        $this->comment = $comment;
    }
}