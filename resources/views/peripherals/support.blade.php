<div>

    <x-fab::layouts.panel>

        <x-fab::forms.checkbox
            label="Enable Call Buttons"
            wire:model="call_enabled"
        />


        @foreach($this->cx_call_settings->toArray() as $settings)

            <div class="flex justify-between mt-4 items-center" x-data="{
                call_enabled: @entangle('call_enabled'),
                call_day_is_available: @entangle('cx_call_settings.'.$loop->index.'.call_is_available')}"
            >
                <x-fab::forms.checkbox
                    label="{{$cx_call_settings[$loop->index]['day']}}"
                    wire:key="day-{{$cx_call_settings[$loop->index]['id']}}"
                    wire:model="cx_call_settings.{{$loop->index}}.call_is_available"
                    x-bind:disabled="!call_enabled"
                />


                <div class="grid grid-cols-2 gap-2">
                    <x-fab::forms.input
                        label="Opened Time in EST"
                        type="time"
                        wire:key="{{$this->cx_call_settings[$loop->index]['id']}}"
                        wire:model="cx_call_settings.{{$loop->index}}.opening_time"
                        x-bind:disabled="!call_enabled || !call_day_is_available"
                    />

                    <x-fab::forms.input
                        label="Closed Time in EST"
                        type="time"
                        wire:key="closing-time-{{$this->cx_call_settings[$loop->index]['id']}}"
                        wire:model="cx_call_settings.{{$loop->index}}.closing_time"
                        x-bind:disabled="!call_enabled || !call_day_is_available"
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
            label="Enable Chat Buttons"
            class="mt-4"
            wire:model="chat_enabled"
        />


        @foreach($this->cx_chat_settings->toArray() as $settings)

            <div class="flex justify-between mt-4 items-center"
                 x-data="{chat_enabled: @entangle('chat_enabled'),
                 chat_day_is_available: @entangle('cx_chat_settings.'.$loop->index.'.chat_is_available')}"
            >
                <x-fab::forms.checkbox
                    label="{{$cx_chat_settings[$loop->index]['day']}}"
                    wire:key="day-{{$cx_chat_settings[$loop->index]['id']}}"
                    wire:model="cx_chat_settings.{{$loop->index}}.chat_is_available"
                    x-bind:disabled="!chat_enabled"

                />


                <div class="grid grid-cols-2  gap-2">
                    <x-fab::forms.input
                        label="Opened Time in EST"
                        type="time"
                        wire:key="{{$this->cx_chat_settings[$loop->index]['id']}}"
                        wire:model="cx_chat_settings.{{$loop->index}}.opening_time"
                        x-bind:disabled="!chat_enabled || !chat_day_is_available "

                    />

                    <x-fab::forms.input
                        label="Closed Time in EST"
                        type="time"
                        wire:key="closing-time-{{$this->cx_chat_settings[$loop->index]['id']}}"
                        wire:model="cx_chat_settings.{{$loop->index}}.closing_time"
                        x-bind:disabled="!chat_enabled || !chat_day_is_available"
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
