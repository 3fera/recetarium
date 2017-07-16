<?php

HTML::macro('priceLevel', function ($level) {
    switch ($level) {
        case 1: return 'Bajo';
        case 2: return 'Medio';
        case 3: return 'Alto';
    }
});
