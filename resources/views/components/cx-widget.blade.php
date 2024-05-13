<div
    data-area="cx"
    class="flex flex-col gap-6 {{ $this->css('cxBackground') }} p-6"
>
    <div class="flex gap-2">
        <div>
            @svg("icon-helix-sleep.cx-avatar", 'w-[50px] h-[50px')
        </div>
        <div class="w-full flex flex-col text-base leading-6 font-semibold">
            <span>Have questions?</span>
            <span>Chat with a Sleep Expert</span>
            <div>
                <div class="mt-1 text-sm font-normal">
                    Our Sleep Experts will help you feel confident in your mattress choice!
                </div>
                <div class="mt-4 grid grid-cols-2 gap-4">
                    <div class="w-full flex flex-col gap-2">
                        <button
                            data-area="chat-now"
                            type="button"
                            class="w-full cursor-pointer {{ $this->css('cxButton') }}"
                            aria-label="chat-now"
                            disabled
                        >
                            Chat Now
                        </button>
                        <div class="flex gap-1">
                            <div>
                                <div class="w-[10px] h-[10px] rounded-full bg-twilight-green"></div>
                            </div>
                            <div class="-mt-[3px] text-xs font-normal">M-Su 10AM-10PM EST</div>
                        </div>
                    </div>
                    <div class="w-full flex flex-col gap-2">
                        <button
                            data-area="chat-now"
                            type="button"
                            class="w-full cursor-pointer {{ $this->css('cxButton') }}"
                            aria-label="chat-now"
                            disabled
                        >
                            Call Us
                        </button>
                        <div class="flex gap-1">
                            <div>
                                <div class="w-[10px] h-[10px] shrink-1 rounded-full bg-coral"></div>
                            </div>
                            <div class="-mt-[3px] text-xs font-normal">M-F 11AM-6PM EST</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="{{ $this->css('cxFaqBackground') }}">
        <div class="">
            <div class="{{ $this->css('cxFaqDivider') }}">
                <div class="flex gap-[6px] sm:gap-3">
                    <div class="w-[50px] pl-4 flex items-center">
                        @svg('helix-sleep.award', 'w-7 text-dawn-yellow')
                    </div>
                    <details class="w-full group pr-4">
                        <summary class="flex gap-1 cursor-pointer list-none items-center justify-between py-4 text-sm font-semibold">
                            <div class="text-base font-semibold">
                                What is covered under my 10-15 year mattress warranty?
                            </div>
                            <div>
                                <x-dynamic-component component="{{ $this->resources('cx-faq-chevron') }}" />
                            </div>
                        </summary>
                        <div class="pb-4 text-base font-normal pr-[11px]">
                            Each Helix Mattress is covered by a 10 year limited warranty. Each  Helix Plus and Helix Luxe Mattress is covered by a 15 year limited warranty. This limited warranty gives you specific legal rights, and  covers all manufacturing defects
                        </div>
                    </details>
                </div>
                <div class="flex gap-[6px] sm:gap-3">
                    <div class="w-[50px] pl-4 flex items-center">
                        @svg('helix-sleep.lamb', 'w-7 text-dusk-raspberry')
                    </div>
                    <details class="w-full group pr-4">
                        <summary class="flex gap-1 cursor-pointer list-none items-center justify-between py-4 text-sm font-semibold">
                            <div class="text-base font-semibold">
                                What is the 100 night sleep trial?
                            </div>
                            <div class="text-coral">
                                <svg width="11" height="6" viewBox="0 0 11 6" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0.71967 0.46967C1.01256 0.176777 1.48744 0.176777 1.78033 0.46967L5.5 4.18934L9.21967 0.469671C9.51256 0.176777 9.98744 0.176777 10.2803 0.469671C10.5732 0.762564 10.5732 1.23744 10.2803 1.53033L6.03033 5.78033C5.88968 5.92098 5.69891 6 5.5 6C5.30109 6 5.11032 5.92098 4.96967 5.78033L0.71967 1.53033C0.426777 1.23744 0.426777 0.762563 0.71967 0.46967Z" />
                                </svg>
                            </div>
                        </summary>
                        <div class="pb-4 text-base font-normal pr-[11px]">
                            Each Helix Mattress is covered by a 10 year limited warranty. Each  Helix Plus and Helix Luxe Mattress is covered by a 15 year limited warranty. This limited warranty gives you specific legal rights, and  covers all manufacturing defects
                        </div>
                    </details>
                </div>
                <div class="flex gap-[6px] sm:gap-3">
                    <div class="w-[50px] pl-4 flex items-center">
                        @svg('helix-sleep.truck', 'w-7 text-moonlight-light-blue')
                    </div>
                    <details class="w-full group pr-4">
                        <summary class="flex gap-1 cursor-pointer list-none items-center justify-between py-4 text-sm font-semibold">
                            <div class="text-base font-semibold">
                                Have questions about shipping?
                            </div>
                            <div>
                                <svg width="11" height="6" viewBox="0 0 11 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0.71967 0.46967C1.01256 0.176777 1.48744 0.176777 1.78033 0.46967L5.5 4.18934L9.21967 0.469671C9.51256 0.176777 9.98744 0.176777 10.2803 0.469671C10.5732 0.762564 10.5732 1.23744 10.2803 1.53033L6.03033 5.78033C5.88968 5.92098 5.69891 6 5.5 6C5.30109 6 5.11032 5.92098 4.96967 5.78033L0.71967 1.53033C0.426777 1.23744 0.426777 0.762563 0.71967 0.46967Z" fill="#EB0F21"/>
                                </svg>
                            </div>
                        </summary>
                        <div class="pb-4 text-base font-normal pr-[11px]">
                            Each Helix Mattress is covered by a 10 year limited warranty. Each  Helix Plus and Helix Luxe Mattress is covered by a 15 year limited warranty. This limited warranty gives you specific legal rights, and  covers all manufacturing defects
                        </div>
                    </details>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-6 font-semibold text-base">
        <div class="underline text-right">View All FAQ’s</div>
        <div class="underline">Find a Store</div>
    </div>

</div>
