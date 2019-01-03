<?php

namespace YoweliKachala\PackageGenerator\Controllers;

use App\Http\Controllers\Controller;
use YoweliKachala\PackageGenerator\Commands\SetupCommand;
use YoweliKachala\PackageGenerator\Helpers\SetupHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use YoweliKachala\PackageGenerator\Models\Module;
use YoweliKachala\PackageGenerator\Models\Project;
use Illuminate\Filesystem\Filesystem;

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

        SetupCommand::CopyNewRouteFile();

        $modelsPath = base_path() . '/app/Models';

        $reposPath = base_path() . '/app/Repositories';

        $modules = Module::all();


        /** Create models and repository folders */
        if (!file_exists($modelsPath)) {

            File::makeDirectory($modelsPath, $mode = 0755, true, true);

            File::makeDirectory($reposPath, $mode = 0755, true, true);

        }


        /** Models need to be recreated in case of changes */
        $this->clearModels();

        /** Clear old Views */
        $this->clearViews();

        /** clear old migrations */
        $this->clearOldMigrations();

        foreach ($modules as $module) {

            $this->createMenuItem($module->name);

            $this->addRoutes($module->name);

            $this->createDirectory($module->name);

            $this->createViews($module->name);

            $this->createControllers($module->name);

            $this->createModels($module->name);

            $this->createMigration($module->name);

        }

        $this->runNewMigrations($modules);

    }


    /**
     * run new migrations
     */
    private function runNewMigrations($modules)
    {
        Artisan::call('migrate');
    }

    /**
     * @param $name
     */
    private function createControllers ($name)
    {
        /** Clear existing controller */
        $file = new Filesystem;
        $file->Delete(base_path() . '/app/Http/Controllers/' . $name . 'Controller.php');


        Artisan::call('create:controller', ['name' => $name . 'Controller']);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function deleteModule(Request $request)
    {
        /** @var Module $module */
        $module = Module::find($request->moduleId);
        $module->delete();

        return ["Deleted"];
    }

    /**
     * @param $name
     */
    private function createMigration($name) {
        /** Drop table from database */
        Schema::dropIfExists(str_plural($name));
        Artisan::call('make:migration', ['name' => "create" . str_plural($name) . '_table']);
    }


    private function clearModels()
    {
        /** Clear existing model */
        $file = new Filesystem;
        $file->cleanDirectory(base_path() . '/app/Models');
    }

    private function clearOldMigrations()
    {

        foreach (File::files(base_path() . '/database/migrations') as $filename) {

            $file = $filename->getFilename();

            if (!str_contains($file , ['create_users', 'create_password_resets'])) {
                /** Clear existing migrations */
                File::delete(base_path() . '/database/migrations/' . $file);
            }

        }

    }

    private function clearViews()
    {
        /** Clear existing views */
        $file = new Filesystem;
        $file->cleanDirectory(resource_path() . '/views/admin/');
    }

    /**
     * @param $name
     */
    private function createViews($name)
    {
        Artisan::call('create:view', ['modelName' => $name]);
    }

    /**
     * @param $name
     */
    private function createModels($name)
    {
        Artisan::call('make:model', ['name' => "Models/" . $name]);

    }

    /**
     * @param Request $request
     */
    public function add(Request $request)
    {
        $projectExists = Project::first();

        if ($projectExists) {
            $project = $projectExists;
        } else {
            $project = new Project();
            $project->id = 1;
            $project->project_status = 1;
            $project->start_date = now();
        }

        $project->name = $request->input('name');

        $project->save();
    }


    /**
     * @param Request $request
     */
    public function addModule(Request $request)
    {
        $module = new Module();
        $module->id = Module::count() + 1;
        $module->name = ucfirst($request->input('name'));
        $module->save();
    }

    /**
     * @param $name
     * @return string
     */
    private function createDirectory($name)
    {

        $viewPath = resource_path() . '/views/admin/' . strtolower($name);

        if (!is_dir($viewPath)) {

            File::makeDirectory($viewPath, $mode = 0755, true, true);

        }

        return $viewPath;
    }


    /**
     * @param $modelName
     */
    private function createMenuItem($modelName)
    {

        $replaceString = "<span style='display: none'>--menu-items--</span>";

        $fullUrl = "<li class='nav-item'><a href= '{{ url('" . strtolower(str_plural($modelName)) . "') }}' class='nav-link'>" . str_plural($modelName) . "</a></li>";

        $oldString = "$replaceString\n";

        $newString = "$fullUrl\n $replaceString\n";

        $fileName = resource_path() . '/views/layouts/app.blade.php';
        //read the entire string
        $file = file_get_contents($fileName);

        if (!str_contains($file , $fullUrl)) {

            //replace something in the file string - this is a VERY simple example
            $file = str_replace("$oldString", "$newString", $file);

            //write the entire string
            file_put_contents($fileName, $file);
        }
    }

    /**
     * @param $modelName
     */
    private function addRoutes($modelName)
    {
        $routes = [
            'index' => 'get',
            'create' => 'get',
            'store' => 'post',
            'show' => 'get',
            'edit' => 'get',
            'update' => 'post',
            'destroy' => 'get'
        ];

        foreach ($routes as $route => $method) {

            $this->addRoute($modelName, $route, $method);

        }

    }

    /**
     * @param $modelName
     * @param $route
     * @param $method
     */
    private function addRoute($modelName, $route, $method)
    {
        $oldString = "//{{replace}}";

        $replaceString = "Route::" . $method . "('$route-" . strtolower($modelName) . "', '" . $modelName . "Controller@" . $route . "');\n";

        if ($route == 'show' || $route == 'edit' || $route == 'destroy') {
            $replaceString = "Route::" . $method . "('$route-" . strtolower($modelName) . "/{" . strtolower($modelName) . "}', '" . $modelName . "Controller@" . $route . "');\n";
        }

        if ($route == 'index') {
            $replaceString = "\nRoute::" . $method . "('" . strtolower(str_plural($modelName)) . "', '" . $modelName . "Controller@" . $route . "');\n";
        }

        $newString = "$replaceString $oldString";

        $fileName = base_path() . '/routes/web.php';
        //read the entire string
        $file = file_get_contents($fileName);

        //replace something in the file string - this is a VERY simple example
        $file = str_replace("$oldString", "$newString", $file);

        //write the entire string
        file_put_contents($fileName, $file);
    }

}