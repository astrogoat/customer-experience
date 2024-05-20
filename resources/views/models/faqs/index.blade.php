<x-fab::layouts.page
    title="Faqs"
    :breadcrumbs="[
        ['title' => 'Home', 'url' => route('lego.dashboard')],
		['title' => 'Apps', 'url' => route('lego.apps.index')],
        ['title' => 'Customer Experience', 'url' => route('lego.customer-experience.index')],
        ['title' => 'FAQs', 'url' => route('lego.customer-experience.faqs.index')],
    ]"
>
    <x-slot name="actions">
        <x-fab::elements.button type="link" :url="route('lego.customer-experience.faqs.create')">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            <span>Create</span>
        </x-fab::elements.button>
    </x-slot>

    <x-fab::lists.table>
        <x-slot name="headers">
            @include('lego::models._includes.indexes.headers')
            <x-fab::lists.table.header :hidden="true">Edit</x-fab::lists.table.header>
        </x-slot>

        @foreach($models as $faq)
            <x-fab::lists.table.row :odd="$loop->odd">
                @if($this->shouldShowColumn('faq_question'))
                    <x-fab::lists.table.column primary>
                        <a href="{{ route('lego.customer-experience.faqs.edit', $faq) }}">{{ $faq->faq_question }}</a>
                    </x-fab::lists.table.column>
                @endif

                @if($this->shouldShowColumn('faq_answer'))
                    <x-fab::lists.table.column>
                        <a href="{{ route('lego.customer-experience.faqs.edit', $faq) }}">{{ $faq->faq_answer }}</a>
                    </x-fab::lists.table.column>
                @endif

                @if($this->shouldShowColumn('updated_at'))
                    <x-fab::lists.table.column>
                        {{ $faq->updated_at->toFormattedDateString() }}
                    </x-fab::lists.table.column>
                @endisset

                <x-fab::lists.table.column align="left" slim>
                    <a href="{{ route('lego.customer-experience.faqs.edit', $faq) }}">Edit</a>
                </x-fab::lists.table.column>
            </x-fab::lists.table.row>
        @endforeach
    </x-fab::lists.table>

    @include('lego::models._includes.indexes.pagination')
</x-fab::layouts.page>
