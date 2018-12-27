<?php

namespace YoweliKachala\PackageGenerator\Controllers;

use App\Http\Controllers\Controller;

/**
 * Class PackageGeneratorController
 * @package YoweliKachala\PackageGenerator\Controllers
 */
class PackageGeneratorController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('PackageGenerator::index');
    }

    /**
     *
     */
    public function create()
    {
        //return view('PackageGenerator::create');
        // create project
    }
}