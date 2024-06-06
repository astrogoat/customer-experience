@php
    use Carbon\Carbon;
    use Astrogoat\CustomerExperience\Settings\CustomerExperienceSettings;

    $cxAppSettingIsEnabled = fn($setting) => settings(\Astrogoat\CustomerExperience\Settings\CustomerExperienceSettings::class, $setting) === true;
    $settings = app(\Astrogoat\CustomerExperience\Settings\CustomerExperienceSettings::class)
@endphp

@if($cxAppSettingIsEnabled('enabled'))
    @php
        $chatIsEnabledInApp = $settings->chat_enabled === true;
        $callIsEnabledInApp = $cxAppSettingIsEnabled('call_enabled');

        $currentTime = Carbon::now('UTC')->format('H:i:s');

        $todayChatOpeningHours = \Astrogoat\CustomerExperience\Models\OpeningHours::chat()->today()->first();
        $chatIsAvailable = $todayChatOpeningHours->enabled;
        $chatOpeningTime = $todayChatOpeningHours->opening_time_in_utc;
        $chatClosingTime = $todayChatOpeningHours->closing_time_in_utc;
        $chatIsAvailable = $chatIsEnabledInApp && $todayChatOpeningHours->enabled && $currentTime >= $chatOpeningTime && $currentTime <= $chatClosingTime;

        $todayCallOpeningHours = \Astrogoat\CustomerExperience\Models\OpeningHours::call()->today()->first();
        $callOpeningTime = $todayCallOpeningHours->opening_time_in_utc;
        $callClosingTime = $todayCallOpeningHours->closing_time_in_utc;
        $callIsAvailable = $callIsEnabledInApp && $todayCallOpeningHours->enabled && $callOpeningTime <= $currentTime && $currentTime <= $callClosingTime;
    @endphp

    <div
        data-area="cx"
        class="{{ $this->css('cxBackground') }}"
        x-data="{
            clientTimezone: '',
            clientTimezoneAbbreviation: '',
            clientChatOpeningTime: '',
            clientChatClosingTime: '',
            clientCallOpeningTime: '',
            clientCallClosingTime: '',
            convertToClientTimezone(time) {
                return dayjs.utc(time, 'HH:mm').tz(this.clientTimezone).format('h:mm A');
            }
        }"
        x-init="$nextTick(() => {
            clientTimezone = window.dayjs.tz.guess();
            clientTimezoneAbbreviation = dayjs().tz(clientTimezone).format('z');

            clientChatOpeningTime = convertToClientTimezone('{{ $chatOpeningTime }}');
            clientChatClosingTime = convertToClientTimezone('{{ $chatClosingTime }}');
            clientCallOpeningTime = convertToClientTimezone('{{ $callOpeningTime }}');
            clientCallClosingTime = convertToClientTimezone('{{ $callClosingTime }}');
        })"
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
                        @if($cxAppSettingIsEnabled('chat_enabled'))
                            <div class="{{ $this->css('cxHeaderButtonContainer') }}">
                                <button
                                    data-area="chat-now"
                                    @click="zE('messenger', 'open');"
                                    type="button"
                                    class="{{ $chatIsAvailable  ? $this->css('cxButton') : $this->css('cxButtonDisabled') }}"
                                    aria-label="chat-now"
                                    {{ $chatIsAvailable ? '' : 'disabled' }}
                                >
                                    Chat Now
                                </button>
                                @if($todayCallOpeningHours->enabled)
                                    <div class="{{ $this->css('cxTimeZoneContainer') }}">
                                        <div>
                                            @if($chatIsAvailable)
                                                <div class="{{ $this->css('cxGreenDot') }}"></div>
                                            @else
                                                <div class="{{ $this->css('cxRedDot') }}"></div>
                                            @endif
                                        </div>
                                        <div class="{{ $this->css('cxTimeZoneText') }}">
                                            <span x-text="clientChatOpeningTime + ' - ' + clientChatClosingTime + ' ' + clientTimezoneAbbreviation"></span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif

                        @if($cxAppSettingIsEnabled('call_enabled'))
                            <div class="{{ $this->css('cxHeaderButtonContainer') }}">
                                <button
                                    data-area="call-now"
                                    @click="window.location.href='tel:{{ app(Helix\Lego\Settings\ContactInformationSettings::class)->contact_phone_number }}'"
                                    type="button"
                                    class="{{ $callIsAvailable ? $this->css('cxButton') : $this->css('cxButtonDisabled') }}"
                                    aria-label="chat-now"
                                    {{ $callIsAvailable ? '' : 'disabled' }}
                                >
                                    Call Us
                                </button>
                                @if($todayCallOpeningHours->enabled)
                                    <div class="{{ $this->css('cxTimeZoneContainer') }}">
                                        <div>
                                            @if($callIsAvailable)
                                                <div class="{{ $this->css('cxGreenDot') }}"></div>
                                            @else
                                                <div class="{{ $this->css('cxRedDot') }}"></div>
                                            @endif
                                        </div>
                                        <div class="{{ $this->css('cxTimeZoneText') }}">
                                            <span x-text="clientCallOpeningTime + ' - ' + clientCallClosingTime + ' ' + clientTimezoneAbbreviation"></span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if($cxAppSettingIsEnabled('faq_enabled'))
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
                                            <x-dynamic-component component="{{ $this->resources('cx-faq-chevron') }}"/>
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
        @endif
        <div class="{{ $this->css('cxFooter') }}">
            @foreach(\Astrogoat\CustomerExperience\Models\SupportLink::limit(2)->get() as $link)
                <a
                    href="{{ $link->link_url }}"
                    class="{{ $loop->index == 0 ? $this->css('cxLeftFooterLink') : $this->css('cxRightFooterLink') }}"
                >
                    {{ $link->link_copy }}
                </a>
            @endforeach
        </div>
    </div>
@endif
