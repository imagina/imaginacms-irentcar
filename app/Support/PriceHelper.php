<?php

namespace Modules\Irentcar\Support;

class PriceHelper
{
    public static function getTotalPriceInUsd($rates, $totalPrice)
    {

        $usdRates = $rates['USDRates'] ?? null;

        if (is_array($usdRates) && isset($usdRates['COP'])) {
            $copRate = (float) $usdRates['COP'];
            $totalPrice = (float) $totalPrice;

            return round($totalPrice / $copRate, 2);
        }

        return 0;
    }
}
