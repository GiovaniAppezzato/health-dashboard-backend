<?php

namespace App\Http\Controllers;

class TestConnectionController
{
    public function __invoke()
    {
        return response()->json(['message' => 'Connected with success!'], 200);
    }
}
