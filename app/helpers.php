<?php

use App\Services\TiptapConverter;

if (!function_exists('tiptap_converter')) {
    function tiptap_converter()
    {
        return new TiptapConverter();
    }
}
