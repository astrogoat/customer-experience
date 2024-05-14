<?php

namespace Astrogoat\CustomerExperience\Peripherals;

use Astrogoat\CustomerExperience\Models\SupportLink;

use Helix\Lego\Settings\Peripherals\Peripheral;

class SupportLinks extends Peripheral
{
    public $support_link_one_enabled;
    public $support_link_two_enabled;
    public $support_link_one_copy;
    public $support_link_one_url;
    public $support_link_two_copy;
    public $support_link_two_url;

    public function mount()
    {
        $supportLinkOne = SupportLink::find(1);
        $supportLinkTwo = SupportLink::find(2);

        if ($supportLinkOne) {
            $this->support_link_one_enabled = $supportLinkOne->enabled;
            $this->support_link_one_copy = $supportLinkOne->link_copy;
            $this->support_link_one_url = $supportLinkOne->link_url;
        }

        if ($supportLinkTwo) {
            $this->support_link_two_enabled = $supportLinkTwo->enabled;
            $this->support_link_two_copy = $supportLinkTwo->link_copy;
            $this->support_link_two_url = $supportLinkTwo->link_url;
        }
    }

    public function rules(): array
    {
        return [
            'support_link_one_enabled' => ['boolean'],
            'support_link_two_enabled' => ['boolean'],
            'support_link_one_copy' => ['nullable'],
            'support_link_one_url' => ['nullable', 'url'],
            'support_link_two_copy' => ['nullable'],
            'support_link_two_url' => ['nullable', 'url'],
        ];

    }


    public function save()
    {

        $this->validate();

        SupportLink::updateOrCreate(
            ['id' => 1],
            [
                'enabled' => $this->support_link_one_enabled,
                'link_copy' => $this->support_link_one_copy,
                'link_url' => $this->support_link_one_url,
            ]
        );

        SupportLink::updateOrCreate(
            ['id' => 2],
            [
                'enabled' => $this->support_link_two_enabled,
                'link_copy' => $this->support_link_two_copy,
                'link_url' => $this->support_link_two_url,
            ]
        );
    }

    public function render()
    {
        return view('customer-experience::peripherals.support-links');
    }
}
