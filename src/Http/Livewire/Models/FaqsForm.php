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
        if (! $this->model->exists) {
            $this->model->indexable = true;
            $this->model->layout = array_key_first(siteLayouts());
        }

    }

    public function updated($property, $value)
    {
        parent::updated($property, $value);

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
