<?php

if (!function_exists('formatRupiah')) {
    /**
     * Format a number as Indonesian Rupiah.
     *
     * @param  float  $number
     * @return string
     */
    function formatRupiah($number)
    {
        return 'Rp ' . number_format($number, 0, ',', '.');
    }
}