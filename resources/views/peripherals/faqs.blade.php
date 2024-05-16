<div
    x-data
>
    <x-fab::layouts.panel
        class="mt-8"
        title="FAQs"
        description="Customer Experience FAQs"
    >
        <x-fab::elements.button type="link" :url="route('lego.customer-experience.faqs.index')">
            <span>FAQs</span>
        </x-fab::elements.button>
    </x-fab::layouts.panel>
</div>
