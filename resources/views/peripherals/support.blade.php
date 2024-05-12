<div>

    <x-fab::layouts.panel>

        <x-fab::forms.checkbox
            label="Enable Call Button"
            wire:model="call_enabled"
        />


    @foreach($this->cx_call_settings as $settings)

        <div class="flex justify-between mt-4 items-center">
            <x-fab::forms.checkbox
                label="{{$cx_call_settings[$loop->index]['day']}}"
                wire:key="day-{{$cx_call_settings[$loop->index]['id']}}"
                wire:model="cx_call_settings.{{$loop->index}}.call_is_available"
            />


            <div class="grid grid-cols-2 gap-2">
                <x-fab::forms.input
                    label="Open Time in EST"
                    type="time"
                    wire:key="{{$this->cx_call_settings[$loop->index]['id']}}"
                    wire:model="cx_call_settings.{{$loop->index}}.opening_time"

                />

                <x-fab::forms.input
                    label="Closed Time in EST"
                    type="time"
                    wire:key="closing-time-{{$this->cx_call_settings[$loop->index]['id']}}"
                    wire:model="cx_call_settings.{{$loop->index}}.closing_time"
                />
            </div>
        </div>

    @endforeach

        <div class="w-full flex justify-end mt-6">
            <x-fab::elements.button primary wire:click="saveCallSettings">
                Save
            </x-fab::elements.button>
        </div>

    </x-fab::layouts.panel>

    <x-fab::layouts.panel class="mt-8">

        <x-fab::forms.checkbox
            label="Enable Chat Button"
            class="mt-4"
            wire:model="chat_enabled"

        />


        @foreach($this->cx_chat_settings as $settings)

        <div class="flex justify-between mt-4 items-center">
            <x-fab::forms.checkbox
                label="{{$cx_chat_settings[$loop->index]['day']}}"
                wire:key="day-{{$cx_chat_settings[$loop->index]['id']}}"
                wire:model="cx_chat_settings.{{$loop->index}}.chat_is_available"
            />


            <div class="grid grid-cols-2 gap-2">
                <x-fab::forms.input
                    label="Open Time in EST"
                    type="time"
                    wire:key="{{$this->cx_chat_settings[$loop->index]['id']}}"
                    wire:model="cx_chat_settings.{{$loop->index}}.opening_time"

                />

                <x-fab::forms.input
                    label="Closed Time in EST"
                    type="time"
                    wire:key="closing-time-{{$this->cx_chat_settings[$loop->index]['id']}}"
                    wire:model="cx_chat_settings.{{$loop->index}}.closing_time"
                />
            </div>
        </div>

        @endforeach



        <div class="w-full flex justify-end mt-6">
            <x-fab::elements.button primary wire:click="saveChatSettings">
                Save
            </x-fab::elements.button>
        </div>

    </x-fab::layouts.panel>
</div>
