<?php

// Here you can add routes for the backend.
    use Astrogoat\CustomerExperience\Http\Livewire\Models\FaqForm;
    use Astrogoat\CustomerExperience\Http\Livewire\Models\FaqIndex;
    use Illuminate\Support\Facades\Route;

    Route::group([
        'as' => 'customer-experience.faqs.',
        'prefix' => 'customer-experience/faqs/'
    ], function () {
        Route::get('/', FaqIndex::class)->name('index');
        Route::get('/create', FaqForm::class)->name('create');
        Route::get('/{faq}/edit', FaqForm::class)->name('edit');
    });

    Route::get('/admin/apps/customer-experience',function(){
        return redirect('/admin/apps/customer-experience');
    })->name('customer-experience.index');

    Route::get('/admin/apps/',function(){
        return redirect('/admin/apps');
    })->name('apps.index');
