@php
    use Astrogoat\CustomerExperience\Settings\CustomerExperienceSettings;
    use Astrogoat\CustomerExperience\Models\OpeningHours;
    use Astrogoat\CustomerExperience\Models\SupportLink;
    use Carbon\Carbon;

    $settings = app(CustomerExperienceSettings::class);
@endphp

@push('strata:frontend:head')
    <link rel="stylesheet" href="{{ mix('css/customer-experience.css', 'vendor/customer-experience') }}">
@endpush

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
        <div class="cx-flex cx-gap-2 {{ $this->css('cxHeaderContainer') }}">
            <div>
                <img src="{{ $this->resources('cxAvatar') }}" class="cx-w-[50px] {{ $this->css('cxAvatarStyle') }}">
            </div>
            <div class="cx-w-full cx-flex cx-flex-col cx-text-base cx-leading-6 cx-font-semibold {{ $this->css('cxHeaderContentArea') }}">
                <span>Have questions?</span>
                <span>Chat with a Sleep Expert</span>
                <div>
                    <div class="cx-mt-1 cx-text-sm cx-font-normal {{ $this->css('cxHeaderDescription') }}">
                        Our Sleep Experts will help you feel confident in your mattress choice!
                    </div>
                    <div class="cx-mt-4 cx-grid cx-grid-cols-2 cx-gap-4 {{ $this->css('cxHeaderCtas') }}">
                        @if($settings->chat_enabled)
                            <div class="cx-flex-1 cx-w-full cx-flex cx-flex-col cx-gap-2 {{ $this->css('cxHeaderButtonContainer') }}">
                                <button
                                    data-area="chat-now"
                                    x-on:click="{{ $settings->chat_button_action }}"
                                    type="button"
                                    class="cx-w-full cx-text-base cx-font-normal cx-leading-6 cx-transition-colors cx-ease-in-out cx-duration cx-py-4 {{ $chatIsAvailable ?  $this->css('cxButton') : ' cx-bg-opacity-20 ' . $this->css('cxButtonDisabled') }}"
                                    aria-label="chat-now"
                                    {{ $chatIsAvailable ? '' : 'disabled' }}
                                >
                                    Chat Now
                                </button>

                                @if($chatToday->enabled)
                                    <div class="cx-flex cx-gap-1 {{ $this->css('cxTimeZoneContainer') }}">
                                        <div>
                                            @if($chatIsAvailable)
                                                <div class="cx-w-[10px] cx-h-[10px] cx-rounded-full {{ $this->css('cxGreenDot') }}"></div>
                                            @else
                                                <div class="cx-w-[10px] cx-h-[10px] cx-rounded-full {{ $this->css('cxRedDot') }}"></div>
                                            @endif
                                        </div>
                                        <div class="cx--mt-[3px] cx-text-xs cx-font-normal {{ $this->css('cxTimeZoneText') }}">
                                            <span
                                                x-text="clientChatOpeningTime + ' - ' + clientChatClosingTime + ' ' + clientTimezoneAbbreviation"
                                            ></span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif

                        @if($settings->call_enabled)
                            <div class="cx-flex-1 cx-w-full cx-flex cx-flex-col cx-gap-2 {{ $this->css('cxHeaderButtonContainer') }}">
                                <button
                                    data-area="call-now"
                                    @click="window.location.href='tel:{{ app(Helix\Lego\Settings\ContactInformationSettings::class)->contact_phone_number }}'"
                                    type="button"
                                    class="cx-w-full cx-text-base cx-font-normal cx-leading-6 cx-transition-colors cx-ease-in-out cx-duration cx-py-4 {{ $callIsAvailable ?  $this->css('cxButton') : ' cx-bg-opacity-20 ' . $this->css('cxButtonDisabled') }}"
                                    aria-label="chat-now"
                                    {{ $callIsAvailable ? '' : 'disabled' }}
                                >
                                    Call Us
                                </button>

                                @if($callToday->enabled)
                                    <div class="cx-flex cx-gap-1 {{ $this->css('cxTimeZoneContainer') }}">
                                        <div>
                                            @if($callIsAvailable)
                                                <div class="cx-w-[10px] cx-h-[10px] cx-rounded-full {{ $this->css('cxGreenDot') }}"></div>
                                            @else
                                                <div class="cx-w-[10px] cx-h-[10px] cx-rounded-full {{ $this->css('cxRedDot') }}"></div>
                                            @endif
                                        </div>
                                        <div class="cx--mt-[3px] cx-text-xs cx-font-normal {{ $this->css('cxTimeZoneText') }}">
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

        @if($settings->faq_enabled)
            <div class="{{ $this->css('cxFaqBackground') }}">
                <div>
                    <div class="cx-divide-y-2 {{ $this->css('cxFaqDivider') }}">
                        @foreach(\Astrogoat\CustomerExperience\Models\Faq::all() as $faq)
                            <details class="cx-group cx-w-full cx-group cx-px-4 {{ $this->css('cxFaqText') }}">
                                <summary class="cx-w-full cx-flex cx-gap-2 cx-cursor-pointer cx-list-none cx-items-center cx-py-4 cx-text-sm cx-font-semibold">
                                    <div class="cx-w-8 cx-flex cx-items-center {{ $this->css('cxFaqTitleArea') }}">
                                        {!! $faq->getFirstMedia('Icon')->class('cx-w-full cx-object-contain ' . $this->css('cxFaqTitleIcon')) !!}
                                    </div>
                                    <div class="cx-w-full cx-flex cx-gap-3 cx-justify-between cx-items-center {{ $this->css('cxFaqTitleAndChevron') }}">
                                        <div class="cx-text-sm cx-font-semibold">
                                            {{ $faq->faq_question }}
                                        </div>
                                        <div class="cx-flex cx-justify-end cx-items-center cx-transition-all cx-duration-300 group-open:cx-rotate-180 {{ $this->css('cxFaqChevron') }}">
                                            <x-dynamic-component component="{{ $this->resources('cxFaqChevron') }}" class="h-6"/>
                                        </div>
                                    </div>
                                </summary>
                                <div>
                                    <div class="cx-transition-all cx-ease-in-out cx-delay-150 cx-pb-4 cx-text-sm cx-font-normal cx-pl-[40px] cx-pr-[11px]">
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

        <div class="cx-grid cx-grid-cols-2 cx-gap-6 cx-font-semibold cx-text-base {{ $this->css('cxFooter') }}">
            @foreach(SupportLink::query()->limit(2)->get() as $link)
                <a
                    href="{{ $link->link_url }}"
                    class="cx-underline cx-capitalize {{ $loop->index == 0 ? 'cx-text-right ' : '' }} {{ $this->css('cxFooterLink') }}"
                >
                    {{ $link->link_copy }}
                </a>
            @endforeach
        </div>
    </div>
@endif
