<div>
    @php($call_enabled = settings(\Astrogoat\CustomerExperience\Settings\CustomerExperienceSettings::class,'call_enabled'))
    @php($chat_enabled = settings(\Astrogoat\CustomerExperience\Settings\CustomerExperienceSettings::class,'chat_enabled'))
    <x-fab::layouts.panel
        title="Calls"
        description="Customer Experience Calls Opening and Closing time"
    >
        @foreach($this->cx_call_settings->toArray() as $settings)
            <div class="flex justify-between mt-4 items-center"
                 x-data="{call_day_is_available: @entangle('cx_call_settings.'.$loop->index.'.call_is_available')}"
            >
                <div class="h-6">
                    <input
                        id="day-{{$cx_call_settings[$loop->index]['id']}}"
                        type="checkbox"
                        value="{{$cx_call_settings[$loop->index]['id']}}"
                        wire:key="day-{{$cx_call_settings[$loop->index]['id']}}"
                        wire:model="cx_call_settings.{{$loop->index}}.call_is_available"
                        class="h-4 w-4 rounded border-gray-300 {{ $call_enabled ? 'text-indigo-600' : 'text-gray-500' }} focus:ring-indigo-600"
                    >
                    <label>{{$cx_call_settings[$loop->index]['day']}}</label>
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <x-fab::forms.input
                        label="Opened Time in EST"
                        type="time"
                        wire:key="{{$this->cx_call_settings[$loop->index]['id']}}"
                        wire:model="cx_call_settings.{{$loop->index}}.opening_time"
                        x-bind:disabled="!call_day_is_available"
                    />

                    <x-fab::forms.input
                        label="Closed Time in EST"
                        type="time"
                        wire:key="closing-time-{{$this->cx_call_settings[$loop->index]['id']}}"
                        wire:model="cx_call_settings.{{$loop->index}}.closing_time"
                        x-bind:disabled="!call_day_is_available"
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

    <x-fab::layouts.panel class="mt-8"
                          title="Chats"
                          description="Customer Experience Chats Opening and Closing time"
    >


        @foreach($this->cx_chat_settings->toArray() as $settings)

            <div class="flex justify-between mt-4 items-center"
                 x-data="{chat_day_is_available: @entangle('cx_chat_settings.'.$loop->index.'.chat_is_available')}"
            >
                <div class="h-6">
                    <input
                        id="day-{{$cx_chat_settings[$loop->index]['id']}}"
                        type="checkbox"
                        value="{{$cx_chat_settings[$loop->index]['id']}}"
                        wire:key="day-{{$cx_chat_settings[$loop->index]['id']}}"
                        wire:model="cx_chat_settings.{{$loop->index}}.chat_is_available"
                        class="h-4 w-4 rounded border-gray-300 {{ $chat_enabled ? 'text-indigo-600' : 'text-gray-500' }} focus:ring-indigo-600"
                    >
                    <label>{{$cx_chat_settings[$loop->index]['day']}}</label>
                </div>

                <div class="grid grid-cols-2  gap-2">
                    <x-fab::forms.input
                        label="Opened Time in EST"
                        type="time"
                        wire:key="{{$this->cx_chat_settings[$loop->index]['id']}}"
                        wire:model="cx_chat_settings.{{$loop->index}}.opening_time"
                        x-bind:disabled="!chat_day_is_available"

                    />

                    <x-fab::forms.input
                        label="Closed Time in EST"
                        type="time"
                        wire:key="closing-time-{{$this->cx_chat_settings[$loop->index]['id']}}"
                        wire:model="cx_chat_settings.{{$loop->index}}.closing_time"
                        x-bind:disabled="!chat_day_is_available"
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
