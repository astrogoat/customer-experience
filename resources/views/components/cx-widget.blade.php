@if(settings(\Astrogoat\CustomerExperience\Settings\CustomerExperienceSettings::class, 'enabled') === true)
    <div
        data-area="cx"
        class="{{ $this->css('cxBackground') }}"
    >
        <div class="{{ $this->css('cxHeaderContainer') }}">
            <div class="{{ $this->css('cxAvatarStyle') }}">
                <x-dynamic-component component="{{ $this->resources('cx-avatar') }}" />
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
                                    <div class="{{ $this->css('cxGreenDot') }}"></div>
                                </div>
                                <div class="{{ $this->css('cxTimeZoneText') }}">M-Su 10AM-10PM EST</div>
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
@endif
