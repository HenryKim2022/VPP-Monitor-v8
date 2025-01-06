<?php

use Illuminate\Contracts\Support\DeferringDisplayableValue;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Arr;
use Illuminate\Support\Env;
use Illuminate\Support\HigherOrderTapProxy;
use Illuminate\Support\Optional;
use Illuminate\Support\Sleep;
use Illuminate\Support\Str;

if (!function_exists('base_url')) {
    /**
     * Generate a URL for an asset using the base URL.
     *
     * @param  string  $path
     * @param  bool|null  $secure
     * @return string
     */
    function base_url($path, $secure = null)
    {
        $base = config('app.url');
        return app('url')->asset($base.'/'.$path, $secure);
    }
}
