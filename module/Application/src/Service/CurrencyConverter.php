<?php
/**
 * Created by PhpStorm.
 * User: sergii
 * Date: 31.05.19
 * Time: 20:25
 */

namespace Application\Service;

/**
 * Class CurrencyConverter
 * @package Application\Service
 */
class CurrencyConverter
{
    /**
     * @param $amount
     * @return float
     */
    public function convertEurToUsd($amount)
    {
        return $amount * 1.25;
    }
}
