@php
    use Astrogoat\CustomerExperience\Settings\CustomerExperienceSettings;
    use Astrogoat\CustomerExperience\Models\OpeningHours;
    use Astrogoat\CustomerExperience\Models\SupportLink;
    use Carbon\Carbon;

    $settings = app(CustomerExperienceSettings::class);
@endphp

@props([
    'chatEnabled' => false,
])

@if($settings->enabled)
    @php
        $currentTime = Carbon::now('UTC');

        // Chat
        $chatToday = OpeningHours::chat()->today()->first();
        $chatOpeningTime = $currentTime->copy()->setTimeFrom($chatToday->opening_time_in_utc);
        $chatClosingTime = $currentTime->copy()->setTimeFrom($chatToday->closing_time_in_utc);

        if ($chatClosingTime->lessThan($chatOpeningTime)) {
            $chatClosingTime->addDay();
        }

        $chatIsAvailable = $chatEnabled
            && $chatToday->enabled
            && $currentTime->greaterThanOrEqualTo($chatOpeningTime)
            && $currentTime->lessThan($chatClosingTime);
    @endphp

    <div
        data-area="cx"
        class="flex flex-col space-y-4"
        x-data="{
            clientTimezone: '',
            clientTimezoneAbbreviation: '',
            clientChatOpeningTime: '',
            clientChatClosingTime: '',
            convertToClientTimezone(time) {
                return dayjs.utc(time, 'HH:mm').tz(this.clientTimezone).format('h:mm A');
            }
        }"
        x-init="$nextTick(() => {
            clientTimezone = window.dayjs.tz.guess();
            clientTimezoneAbbreviation = dayjs().tz(clientTimezone).format('z');

            clientChatOpeningTime = convertToClientTimezone('{{ $chatToday->opening_time_in_utc }}');
            clientChatClosingTime = convertToClientTimezone('{{ $chatToday->closing_time_in_utc }}');
        })"
    >
        @if($chatEnabled)
          <div class="flex items-center justify-between {{ $this->css('cxMobileButtonContainer') }}">
              <div class="flex items-center space-x-2 {{ $this->css('cxMobileButtonCta') }}">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
                      <path d="M9.87891 7.8441C11.0505 6.81897 12.95 6.81897 14.1215 7.8441C15.2931 8.86923 15.2931 10.5313 14.1215 11.5564C13.9176 11.7348 13.6917 11.8822 13.4513 11.9985C12.7056 12.3594 12.0002 12.9968 12.0002 13.8253V14.5753M21 12.3253C21 17.2958 16.9706 21.3253 12 21.3253C7.02944 21.3253 3 17.2958 3 12.3253C3 7.35469 7.02944 3.32526 12 3.32526C16.9706 3.32526 21 7.35469 21 12.3253ZM12 17.5753H12.0075V17.5828H12V17.5753Z" stroke="#0F172A" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                  <span>Have a question?</span>
              </div>
              <button
                  data-area="chat-now"
                  x-on:click="{{ $settings->chat_button_action }}"
                  type="button"
                  class="cx-transition-colors cx-ease-in-out cx-duration cx-py-2 {{ $this->css('cxMobileButton') }}"
                  aria-label="chat-now"
                  {{ $chatIsAvailable ? '' : 'disabled' }}
              >
                  Chat Now
              </button>
          </div>
       @endif
    </div>
@endif
