<?php

namespace Astrogoat\CustomerExperience\Http\Livewire\Models;

use Astrogoat\CustomerExperience\Models\Faq;
use Helix\Lego\Http\Livewire\Models\Index;

class FaqsIndex extends Index
{

    public function model(): string
    {
        return Faq::class;
    }

    public function columns(): array
    {
        return [
            'faq_question' => 'Question',
            'faq_answer' => 'Answer',
            'updated_at' => 'Last updated',
        ];
    }
    public function mainSearchColumn(): string|false
    {
        return 'faq_question';
    }

    public function render()
    {

        return view('customer-experience::models.faqs.index', [
            'models' => $this->getModels(),
        ])->extends('lego::layouts.lego');
    }


}
