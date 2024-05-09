<div
    x-data
>
    <x-fab::layouts.panel class="mt-8" x-data="{showFaqForm: false}">
        <x-fab::elements.button
            x-on:click="showFaqForm = !showFaqForm"
        >
            Add FAQ
        </x-fab::elements.button>


        <div x-show="showFaqForm">

            <x-fab::forms.editor
                wire:model="faq_question"
                label="FAQ Question"
                class="mt-4"
            />

            <x-fab::forms.editor
                label="FAQ Answer"
                wire:model="faq_answer"
                class="mt-4"
            />


            <div class="w-full flex justify-end mt-6">
                <x-fab::elements.button primary wire:click="save">
                    Save
                </x-fab::elements.button>
            </div>
        </div>

        @if($this->faqs)
            <div class="w-full  mb-4">
                <ul>
                    @foreach($this->faqs as $faq)
                        <li class="flex gap-4 items-center" >
                            <x-fab::elements.icon
                                :icon="Helix\Fabrick\Icon::MENU"
                                class="sh-w-5 sh-h-5 sh-ml-4 w-4 h-4 sh-text-gray-600 sh-cursor-move "
                                x-sortable.defaults.handle
                            />
                            <div class="flex-grow" x-data="{ collapsed: true }">
                                <button type="button" :aria-expanded="! collapsed"
                                        class="flex font-bold cursor-pointer text-left gold:text-black dark-gray:text-black"
                                        x-on:click="collapsed = ! collapsed">
                                    <span aria-label="expand" x-show="collapsed"
                                          class="w-5"> + </span>
                                    <span aria-label="collapse" x-show="! collapsed"
                                          class="w-5"> - </span>
                                    {!! $faq->faq_question !!}
                                </button>
                                <div class="py-4 leading-tight gold:text-black dark-gray:text-black"
                                     x-show="! collapsed">
                                    {!! $faq->faq_answer !!}
                                </div>
                            </div>

                            <x-fab::elements.icon
                                :icon="Helix\Fabrick\Icon::X_CIRCLE"
                                class="sh-w-6 sh-h-6 mr-4 w-4 h-4  group-hover:sh-text-red-600 cursor-pointer"
                                wire:click="remove({{$faq->id}})"
                            />
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

    </x-fab::layouts.panel>
</div>
