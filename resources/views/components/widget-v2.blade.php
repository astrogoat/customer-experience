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
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M7.5 8.25H16.5M7.5 11.25H12M2.25 12.7593C2.25 14.3604 3.37341 15.754 4.95746 15.987C6.08596 16.1529 7.22724 16.2796 8.37985 16.3655C8.73004 16.3916 9.05017 16.5753 9.24496 16.8674L12 21L14.755 16.8675C14.9498 16.5753 15.2699 16.3917 15.6201 16.3656C16.7727 16.2796 17.914 16.153 19.0425 15.9871C20.6266 15.7542 21.75 14.3606 21.75 12.7595V6.74056C21.75 5.13946 20.6266 3.74583 19.0425 3.51293C16.744 3.17501 14.3926 3 12.0003 3C9.60776 3 7.25612 3.17504 4.95747 3.51302C3.37342 3.74593 2.25 5.13956 2.25 6.74064V12.7593Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
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
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M2.25 6.75C2.25 15.0343 8.96573 21.75 17.25 21.75H19.5C20.7426 21.75 21.75 20.7426 21.75 19.5V18.1284C21.75 17.6121 21.3987 17.1622 20.8979 17.037L16.4747 15.9312C16.0355 15.8214 15.5734 15.9855 15.3018 16.3476L14.3316 17.6412C14.05 18.0166 13.563 18.1827 13.1223 18.0212C9.81539 16.8098 7.19015 14.1846 5.97876 10.8777C5.81734 10.437 5.98336 9.94998 6.3588 9.6684L7.65242 8.69818C8.01453 8.4266 8.17861 7.96445 8.06883 7.52533L6.96304 3.10215C6.83783 2.60133 6.38785 2.25 5.87163 2.25H4.5C3.25736 2.25 2.25 3.25736 2.25 4.5V6.75Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
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
                        <details class="cx-group cx-w-full cx-group cx-px-4 {{ $this->css('cxFaqText') }}">
                            <summary class="cx-w-full cx-flex cx-gap-2 cx-cursor-pointer cx-list-none cx-items-center cx-py-4 cx-text-sm cx-font-semibold">
                                <div class="cx-w-full cx-flex cx-gap-3 cx-justify-between cx-items-center {{ $this->css('cxFaqTitleAndChevron') }}">
                                    <div class="{{ $this->css('cxFaqTitle') }}">
                                        {{ $faq->faq_question }}
                                    </div>
                                    <div class="cx-flex cx-justify-end cx-items-center cx-transition-all cx-duration-300 group-open:cx-rotate-45 {{ $this->css('cxFaqChevron') }}">
                                        <x-dynamic-component component="{{ $this->resources('cxFaqChevron') }}" class="h-2"/>
                                    </div>
                                </div>
                            </summary>
                            <div>
                                <div class="cx-transition-all cx-ease-in-out cx-delay-150 cx-pb-4 cx-text-sm cx-font-normal">
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
