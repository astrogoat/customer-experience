@if(settings(\Astrogoat\CustomerExperience\Settings\CustomerExperienceSettings::class, 'enabled') === true)
    @php
        $chatIsEnabled = settings(\Astrogoat\CustomerExperience\Settings\CustomerExperienceSettings::class, 'chat_enabled') === true;
        $callIsEnabled = settings(\Astrogoat\CustomerExperience\Settings\CustomerExperienceSettings::class, 'call_enabled') === true;

        $todayChatOpeningHours = \Astrogoat\CustomerExperience\Models\CxChat::where('day', now()->format('l'))->first();

        $day = \Illuminate\Support\Str::lower(now()->format('l'));

        $chatIsAvailable = $todayChatOpeningHours->chat_is_available;
        $chatOpeningTime = $todayChatOpeningHours->opening_time;
        $chatClosingTime = $todayChatOpeningHours->closing_time;

        $todayCallOpeningHours = \Astrogoat\CustomerExperience\Models\CxCall::where('day', now()->format('l'))->first();

        $callIsAvailable = $todayCallOpeningHours->call_is_available;
        $callOpeningTime = $todayCallOpeningHours->opening_time;
        $callClosingTime = $todayCallOpeningHours->closing_time;

    @endphp

    <div
        data-area="cx"
        class="{{ $this->css('cxBackground') }}"
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
                                class="{{ $chatIsEnabled ? $this->css('cxButton') : $this->css('cxButtonDisabled') }}"
                                aria-label="chat-now"
                                {{ $chatIsEnabled ? '' : 'disabled' }}
                            >
                                Chat Now
                            </button>
                            <div class="{{ $this->css('cxTimeZoneContainer') }}">
                                @dd($chatIsAvailable, $chatIsEnabled)
                                <div>
                                    @if($chatIsAvailable && $chatIsEnabled)
                                        <div class="{{ $this->css('cxGreenDot') }}"></div>
                                    @else
                                        <div class="{{ $this->css('cxRedDot') }}"></div>
                                    @endif
                                </div>
                                <div class="{{ $this->css('cxTimeZoneText') }}">M-Su 10AM-10PM EST {{ $day }}</div>
                            </div>
                        </div>
                        <div class="{{ $this->css('cxHeaderButtonContainer') }}">
                            <button
                                data-area="chat-now"
                                type="button"
                                class="{{ $callIsEnabled ? $this->css('cxButton') : $this->css('cxButtonDisabled') }}"
                                aria-label="chat-now"
                                {{ $callIsEnabled ? '' : 'disabled' }}
                            >
                                Call Us
                            </button>
                            <div class="{{ $this->css('cxTimeZoneContainer') }}">
                                <div>
                                    <div class="{{ $this->css('cxRedDot') }}"></div>
                                </div>
                                <div class="{{ $this->css('cxTimeZoneText') }}">M-F 11AM-6PM EST</div>
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

        <script>
            window.dayjs().format()

            window.dayjs.extend(window.dayjs_plugin_utc);
            window.dayjs.extend(window.dayjs_plugin_timezone);

            clientTimeZone = window.dayjs.tz.guess();

            estTimeZone = 'America/New_York';

            console.log('2024-01-01 {{ $callClosingTime }}');

            clientTime = window.dayjs.utc('2024-01-01 {{ $callClosingTime }}').tz(estTimeZone).format('HH:mm:ss');

            // converted to client's timezone
            console.log(clientTime);
        </script>
    @endpush
@endif
