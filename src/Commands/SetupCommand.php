<?php

namespace YoweliKachala\PackageGenerator\Commands;


use Illuminate\Console\Command;


class SetupCommand extends Command
{
    protected $signature = 'setup:packagegenerator';

    protected $description = 'Initial Package Setup';

    public function __construct() {
        parent::__construct();
    }

    public function handle() {
        echo 'Yipee';
    }
}