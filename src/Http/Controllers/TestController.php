<?php


namespace amirgonvt\Press\Http\Controllers;


use Illuminate\Routing\Controller;

class TestController extends Controller
{
    public function index(): string
    {
        return "This message sent from controller";
    }
}