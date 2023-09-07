<?php

use Emycakes\Pipeline;

if (! function_exists('pipe')) {
    function pipe($value)
    {
        return new Pipeline($value);
    }
}
