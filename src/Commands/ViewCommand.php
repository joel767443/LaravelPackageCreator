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

            if (!file_exists($value)) {

                copy($key,
                    resource_path() . str_replace('model', strtolower($modelName), $value)
                );
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

}