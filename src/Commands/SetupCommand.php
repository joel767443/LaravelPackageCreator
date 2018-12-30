<?php

namespace YoweliKachala\PackageGenerator\Commands;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use YoweliKachala\PackageGenerator\Helpers\AuthenticationHelper;
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
       AuthenticationHelper::CreateAuthenticationLogic();

        $this->CopyNewRouteFile();

        SetupHelper::setupEnvFile();

        Artisan::call('migrate');

        exec('xdg-open http://localhost:8000/project');

        Artisan::call('serve');
    }


    private function CopyNewRouteFile()
    {
        copy(__DIR__ . '/stubs/web.stub',
            base_path() . '/routes/web.php'
        );
    }
}