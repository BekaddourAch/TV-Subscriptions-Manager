<?php

    function formatPrice($value) {
        $value=floatval($value);
        return  number_format($value, 2 ,".", "") . " DA";
    }

    function formatDate($value) {
        return date('d/m/Y', strtotime($value));
    }

    function formatTwoDecimal($value) {
        return number_format($value, 2 ,".", "") ;
    }

    function formatDateDMYWithMonthNameFR($date) {
        setlocale (LC_TIME, 'fr_FR');
        return strftime('%d %b %Y', strtotime($date));
    }
