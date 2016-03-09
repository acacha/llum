<?php

use Acacha\Llum\LaravelPackage;
use Illuminate\Config\Repository;

/**
 * Class LaravelPackageTest
 */
class LaravelPackageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @group failing
     *
     * test LaravelPackage
     */
    public function testLaravelPackage()
    {
//        $package = new LaravelPackage;
//
//        $package->name('sociliate')->composerName('laravel/socialite')->providers(['Laravel\Socialite\Facades\Socialite::class'])->aliases(['Socialite' => 'Laravel\Socialite\Facades\Socialite::class']);
//
//        echo json_encode($package);
//
//        $json = '{"name":"sociliate","composerName":"laravel\/socialite","providers":["Laravel\\Socialite\\Facades\\Socialite::class"],"aliases":{"Socialite":"Laravel\\Socialite\\Facades\\Socialite::class"}}';
//
////        $json = '{"a":1,"b":2,"c":3,"d":4,"e":5}';
//
//        $json = '{"name":"sociliate"}';
//
//        echo "\n\n\n";
//        var_dump(json_decode($json));


        $configPath = __DIR__ . '/../src/config/';
        $config = new Repository(require $configPath . 'packages.php');

        // Get config using the get method
        var_dump ($config->get('Socialite.providers'));

//        echo "AdminLTE coming from config/packages.php: <hr>" . $config->get('packages.AdminLTE') . "<br><br><br>";
    }

}