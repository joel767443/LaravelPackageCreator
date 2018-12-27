<?php

namespace YoweliKachala\PackageGenerator\Controllers;

use App\Http\Controllers\Controller;

class PackageGeneratorController  extends Controller
{
    public function index() {
       return view('PackageGenerator::index');
    }
}