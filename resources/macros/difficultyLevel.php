<?php

HTML::macro('difficultyLevel', function ($level) {
    switch ($level) {
        case 1: return 'Fácil';
        case 2: return 'Media';
        case 3: return 'Difícil';
    }
});
