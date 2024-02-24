<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\FacebookRequest;
use App\Models\Product;
use App\User;
use App\Http\Controllers\Controller;

class ApplicationController extends Controller
{
    public function index()
    {
        return view('app');
    }
}
