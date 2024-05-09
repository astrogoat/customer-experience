<div>

    <x-fab::layouts.panel>

        <x-fab::forms.toggle
            label="Enable Call Button"
            wire:model="call_enabled"
        />

        @foreach($this->cx_call_settings as $settings)

        <div class="flex justify-between mt-4 items-center">
            <x-fab::forms.checkbox
                label="{{$settings->day}}"
                wire:key="day-{{$settings->id}}"
                wire:model="call.{{$settings->id}}.call_is_available"
            />


            <div class="grid grid-cols-2 gap-2">
                <x-fab::forms.input
                    label="Open Time in EST {{$settings->opening_time}}"
                    type="time"
                    wire:key="{{$settings->id}}"
                    wire:model="call.{{$settings->id}}.opening_time"

                />

                <x-fab::forms.input
                    label="Closed Time in EST"
                    type="time"
                    wire:key="closing-time-{{$settings->id}}"
                    wire:model="call.{{$settings->id}}.closing_time"
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

        <x-fab::forms.toggle
            label="Enable Chat Button"
            class="mt-4"
            wire:model="chat_enabled"

        />


        @foreach($this->cx_chat_settings as $settings)

        <div class="flex justify-between mt-4 items-center">
            <x-fab::forms.checkbox
                label="{{$settings->day}}"
                wire:model="chat.{{$settings->id}}.chat_is_available"
            />


            <div class="grid grid-cols-2 gap-2">
                <x-fab::forms.input
                    label="Open Time in EST {{$settings->opening_time}}"
                    type="time"
                    wire:model="chat.{{$settings->id}}.opening_time"
                />

                <x-fab::forms.input
                    label="Closed Time in EST"
                    type="time"
                    wire:model="chat.{{$settings->id}}.closing_time"
                />
            </div>
        </div>

        @endforeach



        <div class="w-full flex justify-end mt-6">
            <x-fab::elements.button primary wire:click="save">
                Save
            </x-fab::elements.button>
        </div>

    </x-fab::layouts.panel>
</div>
