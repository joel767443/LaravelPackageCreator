<?php

namespace YoweliKachala\PackageGenerator\Commands;


use Illuminate\Console\GeneratorCommand;


class ControllerCommand extends GeneratorCommand
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'create:controller';


    /** @var bool  */
    protected $hidden = true;

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Controller';

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Http\Controllers';
    }

    /**
     * Build the class with the given name.
     *
     * Remove the base controller import if we are already in base namespace.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {

        $modelName = str_replace("App\\Http\\Controllers\\", '', $name);

        $modelName = str_replace('Controller', '', $modelName);

        $replace = [];

        $replace['DummyFullModelClass'] = 'App\\Models\\' . $modelName;
        $replace['DummyModelClass'] = $modelName;
        $replace['titlePlaceHolder'] = $modelName;
        $replace['$DummyModelVariable'] = '$' . lcfirst($modelName);
        $replace['viewFolder'] = lcfirst($modelName);
        $replace['DummyModelVariables'] = lcfirst(str_plural($modelName));

        return str_replace(
            array_keys($replace), array_values($replace), parent::buildClass($name)
        );
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__. '/stubs/controller.stub';
    }
}