<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class BaseController extends Controller
{
    public function index()
    {
        return Inertia::render('Home/Index');
    }

    public function productspage()
    {
        return Inertia::render('Operations/Products');
    }

    public function orderspage()
    {
        return Inertia::render('Operations/Orders');
    }
}
