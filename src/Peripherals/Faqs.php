<?php

namespace Astrogoat\CustomerExperience\Peripherals;

use Astrogoat\CustomerExperience\Models\Faq;
use Helix\Lego\Http\Livewire\Traits\ProvidesFeedback;
use Helix\Lego\Settings\Peripherals\Peripheral;
class Faqs extends Peripheral
{
    use ProvidesFeedback;


    public $faqs;
    public $faq_question;
    public $faq_answer;

    public function rules(): array
    {
        return [
            'faq_question' => ['required'],
            'faq_answer' => ['required'],
        ];
    }

    public function mount()
    {
        $this->faqs = Faq::query()->get();
        $this->resetInputs();
    }


    public function save()
    {
        $this->validate();

        $lastOrderId = collect(Faq::query()->get())->sortBy('order')->last();

        Faq::create([
            'faq_question' => $this->faq_question,
            'faq_answer' => $this->faq_answer,
            'order' => ($lastOrderId->order ?? 0) + 1,
        ]);
        $this->mount();
    }

    public function resetInputs()
    {
        $this->faq_question = '';
        $this->faq_answer = '';
    }

    public function remove($id)
    {
        Faq::find($id)->delete();
        $this->mount();
    }

    public function render()
    {
        return view('customer-experience::peripherals.faqs');
    }
}
