<?php

namespace YoweliKachala\PackageGenerator\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use YoweliKachala\PackageGenerator\Models\Module;
use YoweliKachala\PackageGenerator\Models\Project;

/**
 * Class PackageGeneratorController
 * @package YoweliKachala\PackageGenerator\Controllers
 */
class PackageGeneratorController extends Controller
{


    /**
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {

        $project = Project::first();

        $modules = Module::all();


        if ($request->ajax()) {

            return [

                'project' => $project

            ];
        }


        return view('PackageGenerator::index', [

            'project' => $project,

            'modules' => $modules

        ]);

    }

    /**
     * Process Scaffolding
     */
    public function finish()
    {


        $modelsPath = base_path() . '/app/Models';

        $reposPath = base_path() . '/app/Repositories';

        $modules = Module::all();


        /** Create models and repository folders */
        if (!file_exists($modelsPath)) {

            File::makeDirectory($modelsPath, $mode = 0644, true, true);

            File::makeDirectory($reposPath, $mode = 0644, true, true);

        }


        foreach ($modules as $module) {

            $viewPath = $this->createDirectory($module->name);

            Artisan::call('create:view', ['modelName' => $module->name]);

            Artisan::call('create:controller', ['name' => $module->name . 'Controller']);

            Artisan::call('make:model', ['name' => "Models/" . $module->name]);

        }

    }

    /**
     * @param $name
     * @return string
     */
    private function createDirectory($name)
    {

        $viewPath = resource_path() . '/views/admin/' . strtolower($name);

        if (! is_dir($viewPath)) {

            File::makeDirectory($viewPath, $mode = 0755, true, true);

        }

        return $viewPath;
    }

}