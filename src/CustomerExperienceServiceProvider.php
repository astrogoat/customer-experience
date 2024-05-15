<?php

namespace Astrogoat\CustomerExperience;

use Astrogoat\CustomerExperience\Http\Livewire\Models\FaqsForm;
use Astrogoat\CustomerExperience\Http\Livewire\Models\FaqsIndex;
use Astrogoat\CustomerExperience\Peripherals\Faqs;
use Astrogoat\CustomerExperience\Peripherals\Support;
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
            ->backendRoutes(__DIR__.'/../routes/backend.php')
            ->frontendRoutes(__DIR__.'/../routes/frontend.php');
    }

    public function registeringPackage()
    {
        $this->callAfterResolving('lego', function (LegoManager $lego) {
            $lego->registerApp(fn (App $app) => $this->registerApp($app));
        });
    }

    public function bootingPackage()
    {
        Livewire::component('astrogoat.customer-experience.peripherals.support', Support::class);
        Livewire::component('astrogoat.customer-experience.peripherals.faqs', Faqs::class);
        Livewire::component('astrogoat.customer-experience.peripherals.support-links', SupportLinks::class);
        Livewire::component('astrogoat.customer-experience.http.livewire.models.faqs-form', FaqsForm::class);
        Livewire::component('astrogoat.customer-experience.http.livewire.models.faqs-index', FaqsIndex::class);
    }

    public function configurePackage(Package $package): void
    {
        $package->name('customer-experience')->hasConfigFile()->hasViews();
    }
}
