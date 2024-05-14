<?php

namespace Astrogoat\CustomerExperience\Peripherals;

use Astrogoat\CustomerExperience\Models\Faq;
use Helix\Lego\Settings\Peripherals\Peripheral;

class Faqs extends Peripheral
{
    public $faqs;
    public $faq_question;
    public $faq_answer;

    protected $listeners = [
        'updateOrder',
    ];

    public function rules(): array
    {
        return [
            'faq_question' => ['required'],
            'faq_answer' => ['required'],
        ];
    }

    public function mount()
    {
        $this->faqs = Faq::query()->orderBy('order')->get()->toArray();
        $this->resetInputs();
    }


    public function save()
    {
        $this->validate();

        $lastOrderId = collect($this->faqs)->sortBy('order')->last();

        Faq::create([
            'faq_question' => $this->faq_question,
            'faq_answer' => $this->faq_answer,
            'order' => ($lastOrderId->order ?? 0) + 1,
        ]);
        $this->resetInputs();
        $this->mount();
    }

    public function updateOrder($ordering)
    {
        $faqs = collect($this->faqs);
        foreach ($ordering as $order => $id) {
            $index = $faqs->search(fn($faq) => $faq['id'] == $id);
            data_set($this->faqs, "$index.order", $order + 1);
        }


        usort($this->faqs, function ($a, $b) {
            if ($a['order'] == $b['order']) {
                return 0;
            }

            return ($a['order'] < $b['order']) ? -1 : 1;
        });

        foreach ($this->faqs as $item) {
            $faq = FAQ::find($item['id']);
            if ($faq) {
                $faq->order = $item['order'];
                $faq->save();
            }
        }

        $this->resetInputs();
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
