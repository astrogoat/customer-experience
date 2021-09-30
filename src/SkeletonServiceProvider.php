<?php

namespace VendorName\Skeleton;

use Helix\Lego\Apps\App;
use Helix\Lego\LegoManager;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use VendorName\Skeleton\Commands\SkeletonCommand;
use VendorName\Skeleton\Settings\SkeletonSettings;

class SkeletonServiceProvider extends PackageServiceProvider
{
    public function registeringPackage()
    {
        $this->callAfterResolving('lego', function (LegoManager $lego) {
            $lego
                ->registerApp(function (App $app) {
                    return $app
                        ->name('skeleton')
                        // ->models([
                        //     //
                        // ])
                        // ->resources([
                        //     'css' => [
                        //         '/vendor/skeleton/css/skeleton.css'
                        //     ],
                        // ])
                        ->settings(SkeletonSettings::class);
                })
                ->addRoutesToBackend(__DIR__.'/../routes/backend.php')
                ->addRoutesToFrontend(__DIR__.'/../routes/frontend.php')
                ->addMigrations([
                    __DIR__ . '/../database/migrations',
                    __DIR__ . '/../database/migrations/settings',
                ]);

            return $lego;
        });
    }

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('skeleton')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_skeleton_table')
            ->hasCommand(SkeletonCommand::class);
    }
}
