<?php

/**
 * Русская форма множественного числа: 1 товар, 2 товара, 5 товаров.
 */
function plural_ru(int $number, string $one, string $few, string $many): string
{
    $number = abs($number);
    $mod10 = $number % 10;
    $mod100 = $number % 100;

    if ($mod10 === 1 && $mod100 !== 11) {
        return $one;
    }

    if ($mod10 >= 2 && $mod10 <= 4 && ($mod100 < 12 || $mod100 > 14)) {
        return $few;
    }

    return $many;
}
