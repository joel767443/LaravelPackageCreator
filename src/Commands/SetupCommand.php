<?php

namespace YoweliKachala\PackageGenerator\Commands;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use YoweliKachala\PackageGenerator\Helpers\SetupHelper;


/**
 * Class SetupCommand
 * @package YoweliKachala\PackageGenerator\Commands
 */
class SetupCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'setup:packagegenerator';

    /** @var bool */
    protected $hidden = true;


    /**
     * @var string
     */
    protected $description = 'Initial Package Setup';

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
        //create login register methods
        $this->CreateAuthenticationLogic();

        SetupHelper::setupEnvFile();

        Artisan::call('migrate');

        exec('xdg-open http://localhost:8000/project');

        Artisan::call('serve');
    }

    private function CreateAuthenticationLogic() {

        Artisan::call('make:auth', ['--force' => true]);

        $oldString = "@else\n";

        $replaceString = "<span style='display: none'>--menu-items--</span>";

        $newString = "@else\n $replaceString\n";

        $fileName = resource_path() . '/views/layouts/app.blade.php';
        //read the entire string
        $file = file_get_contents($fileName);

        //replace something in the file string - this is a VERY simple example
        $file = str_replace("$oldString", "$newString", $file);

        //write the entire string
        file_put_contents($fileName, $file);
    }
}