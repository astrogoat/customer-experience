<?php

namespace Astrogoat\CustomerExperience\Http\Livewire\Models;

use Astrogoat\CustomerExperience\Models\Faq;
use Helix\Lego\Http\Livewire\Models\Form;

class FaqsForm extends Form
{
    public function rules()
    {
        return [
            'model.faq_question' => 'required',
            'model.faq_answer' => 'required',
        ];
    }

    public function mount($faq = null)
    {
        $this->setModel($faq);
    }

    public function view(): string
    {
        return 'customer-experience::models.faqs.form';
    }

    public function model(): string
    {
        return Faq::class;
    }

}



