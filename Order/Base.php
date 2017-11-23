<?php

namespace PimPay\Order;

class Base
{
    public $postId;
    public $params;

    public function __construct($postIdOrParams)
    {
        if ($postIdOrParams instanceof Params)
        {
            $this->params = $postIdOrParams;
        }
        elseif (is_scalar($postIdOrParams))
        {
            $this->postId = $postIdOrParams;
        }
        else
        {
            throw new \Exception("Either postId or instance of PimPayApi_OrderParams was expected.");
        }
    }
}