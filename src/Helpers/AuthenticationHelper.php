<?php

namespace YoweliKachala\PackageGenerator\Helpers;


use Illuminate\Support\Facades\Artisan;

class AuthenticationHelper
{
    public static function CreateAuthenticationLogic() {

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