<?php

namespace Astrogoat\CustomerExperience;

use Astrogoat\CustomerExperience\Http\Livewire\Models\FaqForm;
use Astrogoat\CustomerExperience\Http\Livewire\Models\FaqIndex;
use Astrogoat\CustomerExperience\Peripherals\Faqs;
use Astrogoat\CustomerExperience\Peripherals\OpeningHours;
use Astrogoat\CustomerExperience\Peripherals\SupportLinks;
use Astrogoat\CustomerExperience\Settings\CustomerExperienceSettings;
use Helix\Lego\Apps\App;
use Helix\Lego\LegoManager;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class CustomerExperienceServiceProvider extends PackageServiceProvider
{
    public function registerApp(App $app)
    {
        return $app
            ->name('customer-experience')
            ->settings(CustomerExperienceSettings::class)
            ->migrations([
                __DIR__ . '/../database/migrations',
                __DIR__ . '/../database/migrations/settings',
            ])
            ->publishOnInstall(['customer-experience-assets'])
            ->backendRoutes(__DIR__.'/../routes/backend.php');
    }

    public function registeringPackage()
    {
        $this->callAfterResolving('lego', function (LegoManager $lego) {
            $lego->registerApp(fn (App $app) => $this->registerApp($app));
        });
    }

    public function bootingPackage()
    {
        Livewire::component('astrogoat.customer-experience.peripherals.opening-hours', OpeningHours::class);
        Livewire::component('astrogoat.customer-experience.peripherals.faqs', Faqs::class);
        Livewire::component('astrogoat.customer-experience.peripherals.support-links', SupportLinks::class);
        Livewire::component('astrogoat.customer-experience.http.livewire.models.faqs-form', FaqForm::class);
        Livewire::component('astrogoat.customer-experience.http.livewire.models.faqs-index', FaqIndex::class);

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../public' => public_path('vendor/customer-experience/'),
            ], 'customer-experience-assets');
        }
    }

    public function configurePackage(Package $package): void
    {
        $package->name('customer-experience')->hasConfigFile()->hasViews();
    }
}
