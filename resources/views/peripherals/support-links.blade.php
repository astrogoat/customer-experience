<div>
    <x-fab::layouts.panel
        class="mt-8 space-y-4"
        title="Support Links"
        description="Customer Experience Support Links"
    >
        <div>
            <div>
                <x-fab::forms.checkbox
                    label="Enable Support Link #1"
                    wire:model="support_link_one_enabled"
                />
                <span class="fab-mt-1 fab-text-sm fab-text-gray-500 dark:fab-text-slate-400">This will show the link #1 in app.</span>
            </div>


            <div class="grid grid-cols-2 gap-2 mt-4">

                <x-fab::forms.input
                    label="Support Link #1 Copy"
                    type="text"
                    wire:model="support_link_one_copy"
                />

                <x-fab::forms.input
                    label="Support Link #1 Url"
                    type="url"
                    wire:model="support_link_one_url"
                />
            </div>

        </div>

        <div>

            <div>
                <x-fab::forms.checkbox
                    label="Enable Support Link #2"
                    wire:model="support_link_two_enabled"
                />
                <span class="fab-mt-1 fab-text-sm fab-text-gray-500 dark:fab-text-slate-400">This will show the link #2 in app.</span>

            </div>

            <div class="grid grid-cols-2 gap-2 mt-4">

                <x-fab::forms.input
                    label="Support Link #2 Copy"
                    type="text"
                    wire:model="support_link_two_copy"
                />

                <x-fab::forms.input
                    label="Support Link #2 Url"
                    type="url"
                    wire:model="support_link_two_url"
                />
            </div>

        </div>

        <div class="w-full flex justify-end">
            <x-fab::elements.button primary wire:click="save">
                Save
            </x-fab::elements.button>
        </div>

    </x-fab::layouts.panel>
</div>
