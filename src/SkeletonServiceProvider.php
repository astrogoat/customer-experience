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
    public function registerApp(LegoManager $lego)
    {
        $lego->registerApp(function (App $app) {
            return $app
                ->name('skeleton')
                ->settings(SkeletonSettings::class);
        })
            ->addRoutesToBackend(__DIR__.'/../routes/backend.php')
            ->addRoutesToFrontend(__DIR__.'/../routes/frontend.php')
            ->addMigrations([
                __DIR__ . '/../database/migrations',
                __DIR__ . '/../database/migrations/settings',
            ]);
    }

    public function registeringPackage()
    {
        $this->callAfterResolving('lego', function (LegoManager $lego) {
            $this->registerApp($lego);
        });
    }

    public function configurePackage(Package $package): void
    {
        $package
            ->name('skeleton')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_skeleton_table')
            ->hasCommand(SkeletonCommand::class);
    }
}
