<?php
function price_format_rupiah($price)
{
    $price_rupiah =  number_format($price,0, ',' , '.'); 
    return $price_rupiah; 
}