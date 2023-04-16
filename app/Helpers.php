<?php

    function formatPrice($value) {
        $value=floatval($value);
        return  number_format($value, 2 ,".", "") . " DA";
    }
