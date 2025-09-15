<?php

namespace Modules\Irentcar\Support;

class PriceHelper
{
    /**
     * get total price in USD (Used when create a reservations)
     */
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

    /**
     * Summary of convert COP To EUR
     */
    public static function convertCopToEur(array $rates, float $copAmount)
    {
        $usdRates = $rates['USDRates'] ?? [];

        if (!isset($usdRates['COP'], $usdRates['EUR'])) {
            \Log::info('COP or EUR rate missing in USDRates');
            return null;
        }

        $usd = $copAmount / (float) $usdRates['COP'];
        $eur = $usd * (float) $usdRates['EUR'];

        return round($eur, 2);
    }

    /**
     * Get Price Conversions from Global SETTING (Used from APIs)
     */
    public static function getPriceConversions2($price): ?array
    {
        if (is_null($price))
            return null;

        $currency = setting('irentcar::showInCurrencies');

        $rates = getConversionRates();
        $usdRates = $rates['USDRates'] ?? [];

        if (!$currency || empty($usdRates)) {
            \Log::info('No currency setting or rates available for conversion');
            return null;
        }

        $prices = [];

        if ($currency === 'USD' && isset($usdRates['COP'])) {
            $prices['USD'] = self::getTotalPriceInUsd($rates, $price);
        }

        if ($currency === 'EUR') {
            $prices['EUR'] = self::convertCopToEur($rates, $price);
        }

        return $prices;
    }

    /**
     * @param mixed $price
     * @param mixed $usdRates (Format from N8N)
     */
    public static function getPriceConversions($price, $usdRates = null): ?array
    {
        if (is_null($price)) {
            return null;
        }

        $rates = $usdRates ?? getConversionRates();

        $currencies = setting('irentcar::showInCurrencies');
        $usdRates = $rates['USDRates'] ?? [];

        if (empty($currencies) || empty($usdRates)) {
            \Log::info('No currency setting or rates available for conversion');
            return null;
        }

        $prices = [];

        foreach ($currencies as $currency) {
            if ($currency === 'USD' && isset($usdRates['COP'])) {
                $prices['usd'] = self::getTotalPriceInUsd($rates, $price);
            }

            if ($currency === 'EUR') {
                $prices['eur'] = self::convertCopToEur($rates, $price);
            }
        }

        return $prices;
    }
}
