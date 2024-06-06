@php
    use Carbon\Carbon;
    use Astrogoat\CustomerExperience\Settings\CustomerExperienceSettings;
    use Astrogoat\CustomerExperience\Models\OpeningHours;
    use Astrogoat\CustomerExperience\Models\SupportLink;

    $settings = app(CustomerExperienceSettings::class);
@endphp

@if($settings->enabled)
    @php
        $currentTime = Carbon::now('UTC')->format('H:i:s');

        $chatToday = OpeningHours::chat()->today()->first();
        $chatIsAvailable = $settings->chat_enabled
            && $chatToday->enabled
            && ($currentTime >= $chatToday->opening_time_in_utc)
            && ($currentTime <= $chatToday->closing_time_in_utc);

        $callToday = OpeningHours::call()->today()->first();
        $callIsAvailable = $settings->call_enabled
            && $callToday->enabled
            && ($currentTime >= $callToday->opening_time_in_utc)
            && ($currentTime <= $callToday->closing_time_in_utc);
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

            clientChatOpeningTime = convertToClientTimezone('{{ $chatToday->opening_time_in_utc }}');
            clientChatClosingTime = convertToClientTimezone('{{ $chatToday->closing_time_in_utc }}');
            clientCallOpeningTime = convertToClientTimezone('{{ $callToday->opening_time_in_utc }}');
            clientCallClosingTime = convertToClientTimezone('{{ $callToday->closing_time_in_utc }}');
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
                        @if($settings->chat_enabled)
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

                                @if($chatToday->enabled)
                                    <div class="{{ $this->css('cxTimeZoneContainer') }}">
                                        <div>
                                            @if($chatIsAvailable)
                                                <div class="{{ $this->css('cxGreenDot') }}"></div>
                                            @else
                                                <div class="{{ $this->css('cxRedDot') }}"></div>
                                            @endif
                                        </div>
                                        <div class="{{ $this->css('cxTimeZoneText') }}">
                                            <span
                                                x-text="clientChatOpeningTime + ' - ' + clientChatClosingTime + ' ' + clientTimezoneAbbreviation"></span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif

                        @if($settings->call_enabled)
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

                                @if($callToday->enabled)
                                    <div class="{{ $this->css('cxTimeZoneContainer') }}">
                                        <div>
                                            @if($callIsAvailable)
                                                <div class="{{ $this->css('cxGreenDot') }}"></div>
                                            @else
                                                <div class="{{ $this->css('cxRedDot') }}"></div>
                                            @endif
                                        </div>
                                        <div class="{{ $this->css('cxTimeZoneText') }}">
                                            <span
                                                x-text="clientCallOpeningTime + ' - ' + clientCallClosingTime + ' ' + clientTimezoneAbbreviation"></span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if($settings->faq_enabled)
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
            @foreach(SupportLink::query()->limit(2)->get() as $link)
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
