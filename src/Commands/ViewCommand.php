<?php

namespace YoweliKachala\PackageGenerator\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class ViewCommand
 * @package YoweliKachala\PackageGenerator\Commands
 */
class ViewCommand extends Command
{

    /**
     * @var string
     */
    protected $signature = 'create:view {modelName}';

    /** @var bool */
    protected $hidden = true;


    /**
     * @var string
     */
    protected $description = 'Create module views';

    /**
     * The views that need to be exported.
     *
     * @var array
     */
    protected $views = [
        __DIR__ . '/stubs/views/add.stub' => '/views/admin/model/add.blade.php',
        __DIR__ . '/stubs/views/edit.stub' => '/views/admin/model/edit.blade.php',
        __DIR__ . '/stubs/views/form.stub' => '/views/admin/model/form.blade.php',
        __DIR__ . '/stubs/views/index.stub' => '/views/admin/model/index.blade.php',
        __DIR__ . '/stubs/views/view.stub' => '/views/admin/model/view.blade.php',
    ];

    /**
     * SetupCommand constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * process command
     */
    public function handle()
    {
        $this->exportViews();
    }


    /**
     * Export the authentication views.
     *
     * @return void
     */
    protected function exportViews()
    {
        $modelName = $this->argument()['modelName'];

        foreach ($this->views as $key => $value) {

            if (!file_exists(resource_path() . str_replace('model', strtolower($modelName), $value))) {

                /** Create view */
                copy($key,
                    resource_path() . str_replace('model', strtolower($modelName), $value)
                );

                $this->updateViewPlaceHolders($modelName, $value);

            }
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            array('modelName', InputArgument::REQUIRED, 'Basic slice config path')
        );
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array(
            array('modelName', null, InputOption::VALUE_REQUIRED, 'Age of the new user')
        );
    }

    /**
     * @param $modelName
     * @param $value
     */
    private function updateViewPlaceHolders($modelName, $value)
    {
        // replace placeholders
        $oldList = 'list';
        $oldItem = 'item';

        $newList = str_plural(strtolower($modelName));
        $newItem = strtolower($modelName);

        //get the file
        $fileName = resource_path() . str_replace('model', strtolower($modelName), $value);
        //read the entire string
        $file = file_get_contents($fileName);
        $file = str_replace("$oldList", "$newList", $file);
        $file = str_replace("$oldItem", "$newItem", $file);
        //write the entire string
        file_put_contents($fileName, $file);
    }

}