<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index(): array
    {
        return [
            "status" => 200,
            "message" => "The system is up."
        ];
    }
}
