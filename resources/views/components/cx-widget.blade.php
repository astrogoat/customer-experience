@if(settings(\Astrogoat\CustomerExperience\Settings\CustomerExperienceSettings::class, 'enabled') === true)
    @php
        $todayCallOpeningHours = \Astrogoat\CustomerExperience\Models\CxCall::where('day', now()->format('l'))->first();
        $day = \Illuminate\Support\Str::lower(now()->format('l'));


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
                                class="{{ $this->css('cxButton') }}"
                                aria-label="chat-now"
                                disabled
                            >
                                Chat Now
                            </button>
                            <div class="{{ $this->css('cxTimeZoneContainer') }}">
                                <div>
                                    @if($callIsAvailable)
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
                                class="{{ $this->css('cxButton') }}"
                                aria-label="chat-now"
                                disabled
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
                    <details class="{{ $this->css('cxFaqWrapper') }}">
                        <summary class="{{ $this->css('cxFaqTitleContainer') }}">
                            <div class="{{ $this->css('cxFaqTitleIcon') }}">
                                @svg('helix-sleep.award', 'w-7 text-dawn-yellow')
                            </div>
                            <div class="{{ $this->css('cxFaqTitleAndChevron') }}">
                                <div class="{{ $this->css('cxFaqTitle') }}">
                                    What is covered under my 10-15 year mattress warranty?
                                </div>
                                <div class="{{ $this->css('cxFaqChevron') }}">
                                    <x-dynamic-component component="{{ $this->resources('cx-faqs-chevron') }}" />
                                </div>
                            </div>
                        </summary>
                        <div>
                            <div class="{{ $this->css('cxFaqDescription') }}">
                                <p>
                                    Each Helix Mattress is covered by a 10 year limited warranty. Each  Helix Plus and Helix Luxe Mattress is covered by a 15 year limited warranty. This limited warranty gives you specific legal rights, and  covers all manufacturing defects
                                </p>
                            </div>
                        </div>
                    </details>
                    <details class="{{ $this->css('cxFaqWrapper') }}">
                        <summary class="{{ $this->css('cxFaqTitleContainer') }}">
                            <div class="{{ $this->css('cxFaqTitleIcon') }}">
                                @svg('helix-sleep.lamb', 'w-7 text-dusk-raspberry')
                            </div>
                            <div class="{{ $this->css('cxFaqTitleAndChevron') }}">
                                <div class="{{ $this->css('cxFaqTitle') }}">
                                    What is the 100 night sleep trial?
                                </div>
                                <div class="{{ $this->css('cxFaqChevron') }}">
                                    <x-dynamic-component component="{{ $this->resources('cx-faqs-chevron') }}" />
                                </div>
                            </div>
                        </summary>
                        <div>
                            <div class="{{ $this->css('cxFaqDescription') }}">
                                <p>
                                    Each Helix Mattress is covered by a 10 year limited warranty. Each  Helix Plus and Helix Luxe Mattress is covered by a 15 year limited warranty. This limited warranty gives you specific legal rights, and  covers all manufacturing defects
                                </p>
                            </div>
                        </div>
                    </details>
                    <details class="{{ $this->css('cxFaqWrapper') }}">
                        <summary class="{{ $this->css('cxFaqTitleContainer') }}">
                            <div class="{{ $this->css('cxFaqTitleIcon') }}">
                                @svg('helix-sleep.truck', 'w-7 text-moonlight-light-blue')
                            </div>
                            <div class="{{ $this->css('cxFaqTitleAndChevron') }}">
                                <div class="{{ $this->css('cxFaqTitle') }}">
                                    Have questions about shipping?
                                </div>
                                <div class="{{ $this->css('cxFaqChevron') }}">
                                    <x-dynamic-component component="{{ $this->resources('cx-faqs-chevron') }}" />
                                </div>
                            </div>
                        </summary>
                        <div>
                            <div class="{{ $this->css('cxFaqDescription') }}">
                                <p>
                                    Each Helix Mattress is covered by a 10 year limited warranty. Each  Helix Plus and Helix Luxe Mattress is covered by a 15 year limited warranty. This limited warranty gives you specific legal rights, and  covers all manufacturing defects
                                </p>
                            </div>
                        </div>
                    </details>
                </div>
            </div>
        </div>

        <div class="{{ $this->css('cxFooter') }}">
            <a href="https://support.helixsleep.com/hc/en-us" class="{{ $this->css('cxLeftFooterLink') }}">View All FAQ’s</a>
            <a href="https://go.helixsleep.com/helix-showroom-partners" target="_blank"  class="{{ $this->css('cxRightFooterLink') }}">Find a Store</a>
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
