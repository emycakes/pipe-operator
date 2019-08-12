<?php

use MickPaliokas\Pipeline;

if (! function_exists('pipe')) {
    function pipe($value)
    {
        return new Pipeline($value);
    }
}
