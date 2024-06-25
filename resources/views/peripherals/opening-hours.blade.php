@push('styles')
    <link href="{{ asset('vendor/customer-experience/css/customer-experience-backend.css') }}" rel="stylesheet">
@endpush

<div>
    <x-fab::layouts.panel
        title="Chat"
        description="All times should be entered in {{ config('app.timezone') }} timezone."
    >
        <x-fab::layouts.panel
            title="Opening hours"
            description="All times should be entered in {{ config('app.timezone') }} timezone."
        >
            @foreach($this->chat as $day)
                <div class="cx-flex cx-justify-between cx-mt-4 cx-items-center">
                    <div class="cx-h-6">
                        <x-fab::forms.toggle
                            label="{{ $day->dayDisplayName() }}"
                            :toggled="$day->enabled"
                            wire:key="day-{{ $day->id }}"
                            wire:model="chat.{{ $loop->index }}.enabled"
                        />
                    </div>

                    <div class="cx-grid cx-grid-cols-2 cx-gap-x-2">
                        <x-fab::forms.input
                            label="Opening time"
                            type="time"
                            wire:key="opening-time-{{ $day->id }}"
                            wire:model="chat.{{ $loop->index }}.opening_time"
                        />

                        <x-fab::forms.input
                            label="Closing time"
                            type="time"
                            wire:key="closing-time-{{ $day->id }}"
                            wire:model="chat.{{ $loop->index }}.closing_time"
                        />
                    </div>
                </div>
            @endforeach
        </x-fab::layouts.panel>

        <x-fab::layouts.panel title="Chat Button Action">
            <x-fab::forms.select
                wire:model="chatButtonActionProvider"
                label="Chat button action"
            >
                <option value="">-- Select option --</option>
                @foreach($this->chatButtonActionProviders() as $key => $providerTokens)
                    <optgroup label="{{ Str::headline($key) }}">
                    @foreach($providerTokens as $token)
                        <option value="{{ $key }}:{{ $token->key }}">{{ $token->name }}</option>
                    @endforeach
                @endforeach
            </x-fab::forms.select>

            <x-fab::forms.input
                label="Chat button action"
                wire:key="chat-button-action"
                wire:model.debounce.500ms="chatButtonAction"
                :disabled="$this->chatButtonActionProvider !== 'custom:custom'"
                :help="$this->findTokenByProviderKey($this->chatButtonActionProvider)?->description"
            />
        </x-fab::layouts.panel>

        <x-slot name="footer">
            <x-fab::elements.button primary wire:click="saveChat">Save</x-fab::elements.button>
        </x-slot>
    </x-fab::layouts.panel>

    <x-fab::layouts.panel
        title="Call"
        class="cx-mt-8"
        description="All times should be entered in {{ config('app.timezone') }} timezone."
    >
        @foreach($this->call as $day)
            <div class="cx-flex cx-justify-between cx-mt-4 cx-items-center">
                <div class="cx-h-6">
                    <x-fab::forms.toggle
                        label="{{ $day->dayDisplayName() }}"
                        :toggled="$day->enabled"
                        wire:key="day-{{ $day->id }}"
                        wire:model="call.{{ $loop->index }}.enabled"
                    />
                </div>

                <div class="cx-grid cx-grid-cols-2 cx-gap-x-2">
                    <x-fab::forms.input
                        label="Opening time"
                        type="time"
                        wire:key="opening-time-{{ $day->id }}"
                        wire:model="call.{{ $loop->index }}.opening_time"
                    />

                    <x-fab::forms.input
                        label="Closing time"
                        type="time"
                        wire:key="closing-time-{{ $day->id }}"
                        wire:model="call.{{ $loop->index }}.closing_time"
                    />
                </div>
            </div>
        @endforeach

        <x-slot name="footer">
            <x-fab::elements.button primary wire:click="saveCall">Save</x-fab::elements.button>
        </x-slot>
    </x-fab::layouts.panel>
</div>
