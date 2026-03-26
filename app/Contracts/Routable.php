<?php

namespace App\Contracts;

interface Routable 
{
    public function getMenuUrl(string $locale): string;
}