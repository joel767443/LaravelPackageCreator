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
        SetupHelper::setupEnvFile();
        Artisan::call('migrate');
        exec('xdg-open http://localhost:8000/project');
        Artisan::call('serve');
    }
}