<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends MainController
{
    public function __construct()
    {
        parent::__construct();
        $this->setClass('home');
    }
    public function index()
    {
        return view('web.home.index');
    }
}
