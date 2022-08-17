<?php

namespace App\Traits;

use Illuminate\Support\Str;

Trait Tokenable
{
    public function generateAndSaveApiAuthToken(): object
    {
        $token = Str::random(55);
        $this->api_token = $token;
        $this->save();

        return $this;
    }
}
