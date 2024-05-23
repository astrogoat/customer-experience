@php
    use Carbon\Carbon;

    $cxAppSettingIsEnabled = fn($setting) => settings(\Astrogoat\CustomerExperience\Settings\CustomerExperienceSettings::class, $setting) === true;
@endphp

@if($cxAppSettingIsEnabled('enabled'))
    @php
        $chatIsEnabledInApp = $cxAppSettingIsEnabled('chat_enabled');
        $callIsEnabledInApp = $cxAppSettingIsEnabled('call_enabled');

        $currentTime = Carbon::now('UTC')->format('H:i:s');
        $currentDay = Carbon::now('UTC')->format('l');

        $todayChatOpeningHours = \Astrogoat\CustomerExperience\Models\CxChat::where('day', $currentDay)->first();
        $chatIsAvailable = $todayChatOpeningHours->chat_is_available;
        $chatOpeningTime = $todayChatOpeningHours->opening_time;
        $chatClosingTime = $todayChatOpeningHours->closing_time;
        $chatIsAvailable = $chatIsEnabledInApp && $todayChatOpeningHours->chat_is_available && $chatOpeningTime <= $currentTime && $currentTime <= $chatClosingTime;

        $todayCallOpeningHours = \Astrogoat\CustomerExperience\Models\CxCall::where('day', $currentDay)->first();
        $callOpeningTime = $todayCallOpeningHours->opening_time;
        $callClosingTime = $todayCallOpeningHours->closing_time;
        $callIsAvailable = $callIsEnabledInApp && $todayCallOpeningHours->call_is_available && $callOpeningTime <= $currentTime && $currentTime <= $callClosingTime;
    @endphp

    <div
        data-area="cx"
        class="{{ $this->css('cxBackground') }}"
        x-data="{
            clientTimezone: '',
            clientChatOpeningTime: '',
            clientChatClosingTime: '',
            clientCallOpeningTime: '',
            clientCallClosingTime: '',
            convertToClientTimezone(time) {
                return dayjs.utc(time, 'HH:mm:ss').tz(this.clientTimezone).format('h:mm A');
            }
        }"
        x-init="() => {
            const { dayjs_plugin_utc, dayjs_plugin_timezone, dayjs_plugin_customParseFormat } = window;
            dayjs.extend(dayjs_plugin_utc);
            dayjs.extend(dayjs_plugin_timezone);
            dayjs.extend(dayjs_plugin_customParseFormat);

            clientTimezone = window.dayjs.tz.guess();

            clientChatOpeningTime = convertToClientTimezone('{{ $chatOpeningTime }}');
            clientChatClosingTime = convertToClientTimezone('{{ $chatClosingTime }}');
            clientCallOpeningTime = convertToClientTimezone('{{ $callOpeningTime }}');
            clientCallClosingTime = convertToClientTimezone('{{ $callClosingTime }}');
        }"
    >
        <div class="{{ $this->css('cxHeaderContainer') }}">
            <div>
                <img src="{{ asset('images/cx-avatar.png') }}" class="{{ $this->css('cxAvatarStyle') }}">
            </div>
            <div class="{{ $this->css('cxHeaderContentArea') }}">
                <span>Have questions?</span>
                <span>Chat with a Sleep Expert</span>
                <div>
                    <div class="{{ $this->css('cxHeaderDescription') }}">
                        Our Sleep Experts will help you feel confident in your mattress choice!
                    </div>
                    <div class="{{ $this->css('cxHeaderCtas') }}">
                        <div class="{{ $this->css('cxHeaderButtonContainer') }}">
                            <button
                                data-area="chat-now"
                                type="button"
                                class="{{ $chatIsAvailable  ? $this->css('cxButton') : $this->css('cxButtonDisabled') }}"
                                aria-label="chat-now"
                                {{ $chatIsAvailable ? '' : 'disabled' }}
                            >
                                Chat Now
                            </button>
                            <div class="{{ $this->css('cxTimeZoneContainer') }}">
                                <div>
                                    @if($chatIsAvailable)
                                        <div class="{{ $this->css('cxGreenDot') }}"></div>
                                    @else
                                        <div class="{{ $this->css('cxRedDot') }}"></div>
                                    @endif
                                </div>
                                <div class="{{ $this->css('cxTimeZoneText') }}">
                                    <span x-text="clientChatOpeningTime"></span> - <span x-text="clientChatClosingTime"></span> <span x-text="clientTimezone"></span>
                                </div>
                            </div>
                        </div>
                        <div class="{{ $this->css('cxHeaderButtonContainer') }}">
                            <button
                                data-area="chat-now"
                                type="button"
                                class="{{ $callIsAvailable ? $this->css('cxButton') : $this->css('cxButtonDisabled') }}"
                                aria-label="chat-now"
                                {{ $callIsAvailable ? '' : 'disabled' }}
                            >
                                Call Us
                            </button>
                            <div class="{{ $this->css('cxTimeZoneContainer') }}">
                                <div>
                                    @if($callIsAvailable)
                                        <div class="{{ $this->css('cxGreenDot') }}"></div>
                                    @else
                                        <div class="{{ $this->css('cxRedDot') }}"></div>
                                    @endif
                                </div>
                                <div class="{{ $this->css('cxTimeZoneText') }}">
                                    <span x-text="clientCallOpeningTime"></span> - <span x-text="clientCallClosingTime"></span> <span x-text="clientTimezone"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="{{ $this->css('cxFaqBackground') }}">
            <div>
                <div class="{{ $this->css('cxFaqDivider') }}">
                    @foreach(\Astrogoat\CustomerExperience\Models\Faq::all() as $faq)
                        <details class="{{ $this->css('cxFaqWrapper') }}">
                            <summary class="{{ $this->css('cxFaqTitleContainer') }}">
                                <div class="{{ $this->css('cxFaqTitleArea') }}">
                                    {!! $faq->getFirstMedia('Icon')->class($this->css('cxFaqTitleIcon')) !!}
                                </div>
                                <div class="{{ $this->css('cxFaqTitleAndChevron') }}">
                                    <div class="{{ $this->css('cxFaqTitle') }}">
                                        {{ $faq->faq_question }}
                                    </div>
                                    <div class="{{ $this->css('cxFaqChevron') }}">
                                        <x-dynamic-component component="{{ $this->resources('cx-faq-chevron') }}" />
                                    </div>
                                </div>
                            </summary>
                            <div>
                                <div class="{{ $this->css('cxFaqDescription') }}">
                                    <p>
                                        {!! $faq->faq_answer !!}
                                    </p>
                                </div>
                            </div>
                        </details>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="{{ $this->css('cxFooter') }}">
            @foreach(\Astrogoat\CustomerExperience\Models\SupportLink::limit(2)->get() as $link)
                <a href="{{ $link->link_url }}" class="{{ $loop->index == 0 ? $this->css('cxLeftFooterLink') : $this->css('cxRightFooterLink') }}">{{ $link->link_copy }}</a>
            @endforeach
        </div>
    </div>

    @push('footer')
        <script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/dayjs@1/plugin/utc.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/dayjs@1/plugin/timezone.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/dayjs@1/plugin/customParseFormat.js"></script>
    @endpush
@endif
