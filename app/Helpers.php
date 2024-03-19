<?php

function getPrice($priceImDecimal) {
    $price = floatval($priceImDecimal) / 100;

    return number_format($price, 2, ',',' ') . ' XOF';
}