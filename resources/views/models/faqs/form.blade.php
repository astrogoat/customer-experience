<x-fab::layouts.page
    title="{{$model->faq_question ?: 'New Faqs'}}"
    :breadcrumbs="[
        ['title' => 'Home', 'url' => route('lego.dashboard')],
        ['title' => 'Apps', 'url' => route('lego.apps.index')],
		['title' => 'Customer Experience', 'url' => route('lego.apps.edit', 'customer-experience')],
        ['title' => 'FAQs','url' => route('lego.customer-experience.faqs.index')],
        ['title' => $model->faq_question ?: 'New FAQs'],
    ]"
    x-data="{ showColumnFilters: false }"
    x-on:keydown.meta.s.window.prevent="$wire.call('save')" {{-- For Mac --}}
    x-on:keydown.ctrl.s.window.prevent="$wire.call('save')" {{-- For PC  --}}
>
     <x-slot name="actions">
        @include('lego::models._includes.forms.page-actions')
    </x-slot>

    <x-lego::feedback.errors class="mb-4" />

    <x-fab::layouts.main-with-aside>
        <x-slot name="aside">
            @if($model->exists)
                <x-lego::media-panel :model="$model" />
            @else
                <x-fab::feedback.alert type="info">
                    Please save faqs before you can attach media to it.
                </x-fab::feedback.alert>
            @endif
        </x-slot>

        <x-fab::layouts.panel>
            <x-fab::forms.input
                label="Question"
                wire:model.lazy="model.faq_question"
            />
        </x-fab::layouts.panel>

        <x-fab::layouts.panel>
            <x-fab::forms.textarea
                label="Answer"
                wire:model.lazy="model.faq_answer"
            />
        </x-fab::layouts.panel>
    </x-fab::layouts.main-with-aside>
</x-fab::layouts.page>
