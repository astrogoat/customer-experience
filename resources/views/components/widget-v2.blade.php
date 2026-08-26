@php
    use Astrogoat\CustomerExperience\Settings\CustomerExperienceSettings;
    use Astrogoat\CustomerExperience\Models\OpeningHours;
    use Astrogoat\CustomerExperience\Models\SupportLink;
    use Carbon\Carbon;

    $settings = app(CustomerExperienceSettings::class);
@endphp

@props([
    'chatEnabled' => false,
    'callEnabled' => false,
    'faqEnabled' => false,
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


        // Call
        $callToday = OpeningHours::call()->today()->first();
        $callOpeningTime = $currentTime->copy()->setTimeFrom($callToday->opening_time_in_utc);
        $callClosingTime = $currentTime->copy()->setTimeFrom($callToday->closing_time_in_utc);

        if ($callClosingTime->lessThan($callOpeningTime)) {
            $callClosingTime->addDay();
        }

        $callIsAvailable = $callEnabled
            && $callToday->enabled
            && $currentTime->greaterThanOrEqualTo($callOpeningTime)
            && $currentTime->lessThan($callClosingTime);
    @endphp

    <div
        data-area="cx"
        class="BB-CXWidget {{ $this->css('cxBackground') }}"
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
        @unless($callEnabled || $faqEnabled)
            <div>
                <div class="cx-flex cx-gap-2 {{ $this->css('cxHeaderContainer') }}">
                    <div class="cx-w-full cx-flex cx-justify-between cx-text-base cx-leading-6 cx-font-semibold {{ $this->css('cxHeaderContentArea') }}">
                        <div class="cx-flex cx-items-center cx-gap-2">
                            <svg class="{{ $this->css('cxV2QuestionMarkIcon') }}" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M7.62891 5.26884C8.80048 4.24372 10.7 4.24372 11.8715 5.26884C13.0431 6.29397 13.0431 7.95603 11.8715 8.98116C11.6676 9.15958 11.4417 9.30695 11.2013 9.42326C10.4556 9.78415 9.75023 10.4216 9.75023 11.25V12M18.75 9.75C18.75 14.7206 14.7206 18.75 9.75 18.75C4.77944 18.75 0.75 14.7206 0.75 9.75C0.75 4.77944 4.77944 0.75 9.75 0.75C14.7206 0.75 18.75 4.77944 18.75 9.75ZM9.75 15H9.7575V15.0075H9.75V15Z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>

                            <span class="{{ $this->css('cxMobileHeaderTitle') }}">Have questions?</span>
                        </div>

                        @if($chatEnabled)
                            <button
                                data-area="chat-now"
                                x-on:click="{{ $settings->chat_button_action }}"
                                type="button"
                                class="cx-text-sm cx-font-normal cx-leading-6 cx-transition-colors cx-ease-in-out cx-duration {{ $chatIsAvailable ?  $this->css('cxV2MobileButton') : ' cx-bg-opacity-20 ' . $this->css('cxV2ButtonDisabled') }}"
                                aria-label="chat-now"
                                {{ $chatIsAvailable ? '' : 'disabled' }}
                            >
                                Chat Now
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <div class="cx-flex cx-gap-2 {{ $this->css('cxHeaderContainer') }}">
                <div class="cx-w-full cx-flex cx-flex-col cx-text-base cx-leading-6 cx-font-semibold {{ $this->css('cxHeaderContentArea') }}">
                    <span class="{{ $this->css('cxHeaderTitle') }}" >Have questions?</span>
                    <span class="md:hidden {{ $this->css('cxHeaderSubtitle') }}">Chat with a Sleep Expert</span>
                    <div>
                        <div class="cx-text-sm cx-font-normal {{ $this->css('cxHeaderDescription') }}">
                            Our Sleep Experts will help you feel confident in your mattress choice!
                        </div>
                        <div class="cx-flex cx-gap-4 {{ $this->css('cxHeaderCtas') }}">
                            @if($chatEnabled)
                                <div class="cx-flex-1 cx-w-full cx-flex cx-flex-col cx-gap-2 {{ $this->css('cxHeaderButtonContainer') }}">
                                    <button
                                        data-area="chat-now"
                                        x-on:click="{{ $settings->chat_button_action }}"
                                        type="button"
                                        class="cx-w-full cx-text-base cx-font-normal cx-leading-6 cx-transition-colors cx-ease-in-out cx-duration cx-py-4 {{ $chatIsAvailable ?  $this->css('cxButton') : ' cx-bg-opacity-20 ' . $this->css('cxButtonDisabled') }}"
                                        aria-label="chat-now"
                                        {{ $chatIsAvailable ? '' : 'disabled' }}
                                    >

                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"  width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon" class="cta-leading-icon flex" data-icon-name="ChatBubbleBottomCenterTextIcon">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z"></path>
                                        </svg>
                                        Chat Now
                                    </button>

                                    @if($chatToday->enabled)
                                        <div class="cx-flex cx-gap-1 {{ $this->css('cxTimeZoneContainer') }}">
                                            <div class="cx-mt-3 cx-text-xs cx-font-normal {{ $this->css('cxTimeZoneText') }}">
                                                <span
                                                    x-text="clientChatOpeningTime + ' - ' + clientChatClosingTime + ' ' + clientTimezoneAbbreviation"
                                                ></span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            @if($callEnabled)
                                <div class="cx-flex-1 cx-w-full cx-flex cx-flex-col cx-gap-2 {{ $this->css('cxHeaderButtonContainer') }}">
                                    <button
                                        data-area="call-now"
                                        @click="window.location.href='tel:{{ app(Helix\Lego\Settings\ContactInformationSettings::class)->contact_phone_number }}'"
                                        type="button"
                                        class="cx-w-full cx-text-base cx-font-normal cx-leading-6 cx-transition-colors cx-ease-in-out cx-duration cx-py-4 {{ $callIsAvailable ?  $this->css('cxButton') : ' cx-bg-opacity-20 ' . $this->css('cxButtonDisabled') }}"
                                        aria-label="chat-now"
                                        {{ $callIsAvailable ? '' : 'disabled' }}
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon" class="cta-leading-icon" data-icon-name="PhoneIcon">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"></path>
                                        </svg>

                                        Call Us
                                    </button>

                                    @if($callToday->enabled)
                                        <div class="cx-flex cx-gap-1 {{ $this->css('cxTimeZoneContainer') }}">
                                            <div class="cx-mt-3 cx-text-xs cx-font-normal {{ $this->css('cxTimeZoneText') }}">
                                                <span
                                                    x-text="clientCallOpeningTime + ' - ' + clientCallClosingTime + ' ' + clientTimezoneAbbreviation"
                                                ></span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @if($faqEnabled)
                <div class="{{ $this->css('cxFaqBackground') }}">
                    <div class="{{ $this->css('cxFaqDivider') }}">
                        @foreach(\Astrogoat\CustomerExperience\Models\Faq::all() as $faq)
                            <details class="cx-group cx-w-full cx-px-4 {{ $this->css('cxFaqText') }}">
                                <summary class="cx-w-full cx-flex cx-gap-2 cx-cursor-pointer cx-list-none cx-items-center cx-py-4 cx-text-sm cx-font-semibold">
                                    <div class="cx-w-full cx-flex cx-gap-3 cx-justify-between cx-items-center {{ $this->css('cxFaqTitleAndChevron') }}">
                                        <div class="{{ $this->css('cxFaqTitle') }}">
                                            {{ $faq->faq_question }}
                                        </div>
                                        <div class="cx-flex cx-justify-end cx-items-center {{ $this->css('cxFaqChevron') }}">
                                            <x-dynamic-component component="{{ $this->resources('cxFaqChevron') }}" class="h-2"/>
                                        </div>
                                    </div>
                                </summary>
                                <div>
                                    <div class="cx-transition-all cx-ease-in-out cx-delay-150 cx-pb-4 cx-text-sm cx-font-normal {{ $this->css('cxFaqAnswer') }}">
                                        <p>
                                            {!! $faq->faq_answer !!}
                                        </p>
                                    </div>
                                </div>
                            </details>
                        @endforeach
                    </div>
                </div>
            @endif
        @endunless
        @php
            $enabledSupportLinks = SupportLink::where('enabled', true)->limit(2)->get();
        @endphp

        @if($enabledSupportLinks->isNotEmpty())
            <div class="cx-flex cx-items-center cx-gap-6 cx-font-semibold cx-text-base {{ $this->css('cxFooter') }}">
                @foreach($enabledSupportLinks as $link)
                    <a
                        href="{{ $link->link_url }}"
                        class="cx-flex-1 cx-underline cx-capitalize {{ $loop->index == 0 ? 'cx-text-right ' : '' }} {{ $this->css('cxFooterLink') }} {{ count($enabledSupportLinks) === 1 ? 'cx-text-center' : '' }}"
                    >
                        {{ $link->link_copy }}
                    </a>
                @endforeach
            </div>
        @endif
    </div>
@endif
