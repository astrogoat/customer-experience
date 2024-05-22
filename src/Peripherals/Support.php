<?php

namespace Astrogoat\CustomerExperience\Peripherals;

use Helix\Fabrick\Notification;
use Helix\Lego\Settings\Peripherals\Peripheral;
use Astrogoat\CustomerExperience\Models\CxCall;
use Astrogoat\CustomerExperience\Models\CxChat;
use Helix\Lego\Http\Livewire\Traits\ProvidesFeedback;
use Astrogoat\CustomerExperience\Helpers\DateTimeConverter;

class Support extends Peripheral
{
    use ProvidesFeedback;

    public $cx_chat_settings;
    public $cx_call_settings;

    public function rules()
    {
        return [
            'cx_chat_settings.*.opening_time' => ['required'],
            'cx_chat_settings.*.closing_time' => ['required'],
            'cx_chat_settings.*.chat_is_available' => ['required'],
            'cx_call_settings.*.opening_time' => ['required'],
            'cx_call_settings.*.closing_time' => ['required'],
            'cx_call_settings.*.call_is_available' => ['required'],
        ];
    }

    public function mount(): void
    {

        $this->runDatabaseDayUpsert();

        $this->cx_chat_settings = CxChat::query()->get();
        $this->cx_call_settings = CxCall::query()->get();

        $this->cx_chat_settings = $this->cx_chat_settings->map(function ($item) {
            $est_opening_time = DateTimeConverter::utcToEst($item->opening_time);
            $est_closing_time = DateTimeConverter::utcToEst($item->closing_time);
            $item['opening_time'] = $est_opening_time;
            $item['closing_time'] = $est_closing_time;

            return $item;
        });

        $this->cx_call_settings = $this->cx_call_settings->map(function ($item) {
            $est_opening_time = DateTimeConverter::utcToEst($item->opening_time);
            $est_closing_time = DateTimeConverter::utcToEst($item->closing_time);
            $item['opening_time'] = $est_opening_time;
            $item['closing_time'] = $est_closing_time;

            return $item;
        });

    }

    public function runDatabaseDayUpsert(): void
    {
        if (CxChat::count() == 0) {

            CxChat::upsert([
                ['day' => 'Monday', 'opening_time' => '09:00',
                    'closing_time' => '18:00', 'chat_is_available' => true],
                ['day' => 'Tuesday', 'opening_time' => '09:00',
                    'closing_time' => '18:00', 'chat_is_available' => true],
                ['day' => 'Wednesday', 'opening_time' => '09:00',
                    'closing_time' => '18:00', 'chat_is_available' => true],
                ['day' => 'Thursday', 'opening_time' => '09:00',
                    'closing_time' => '18:00', 'chat_is_available' => true],
                ['day' => 'Friday', 'opening_time' => '09:00',
                    'closing_time' => '18:00', 'chat_is_available' => true],
                ['day' => 'Saturday', 'opening_time' => '09:00',
                    'closing_time' => '18:00', 'chat_is_available' => false],
                ['day' => 'Sunday', 'opening_time' => '09:00',
                    'closing_time' => '18:00', 'chat_is_available' => false],

            ], ['id', 'day']);
        }


        if (CxCall::count() == 0) {

            CxCall::upsert([
                ['day' => 'Monday', 'opening_time' => '09:00',
                    'closing_time' => '18:00', 'call_is_available' => true],
                ['day' => 'Tuesday', 'opening_time' => '09:00',
                    'closing_time' => '18:00', 'call_is_available' => true],
                ['day' => 'Wednesday', 'opening_time' => '09:00',
                    'closing_time' => '18:00', 'call_is_available' => true],
                ['day' => 'Thursday', 'opening_time' => '09:00',
                    'closing_time' => '18:00', 'call_is_available' => true],
                ['day' => 'Friday', 'opening_time' => '09:00',
                    'closing_time' => '18:00', 'call_is_available' => true],
                ['day' => 'Saturday', 'opening_time' => '09:00',
                    'closing_time' => '18:00', 'call_is_available' => false],
                ['day' => 'Sunday', 'opening_time' => '09:00',
                    'closing_time' => '18:00', 'call_is_available' => false],

            ], ['id', 'day']);
        }
    }

    public function saveCallSettings(): void
    {
        $this->validate();

        foreach ($this->cx_call_settings->toArray() as $settings) {
            $call_setting = CxCall::find($settings['id']);

            ray(is_string($settings['call_is_available']));
            $call_setting->opening_time = DateTimeConverter::estToUtc($settings['opening_time']);
            $call_setting->closing_time = DateTimeConverter::estToUtc($settings['closing_time']);
            $call_setting->call_is_available = $settings['call_is_available'];
            $call_setting->save();
        }

        $this->notify(Notification::success(message: 'Saved')->autoDismiss());
    }

    public function saveChatSettings(): void
    {
        $this->validate();

        foreach ($this->cx_chat_settings->toArray() as $settings) {
            $chat_setting = CxChat::find($settings['id']);
            $chat_setting->opening_time = DateTimeConverter::estToUtc($settings['opening_time']);
            $chat_setting->closing_time = DateTimeConverter::estToUtc($settings['closing_time']);
            $chat_setting->chat_is_available = $settings['chat_is_available'];
            $chat_setting->save();
        }

        $this->notify(Notification::success(message: 'Saved')->autoDismiss());
    }

    public function render()
    {
        return view('customer-experience::peripherals.support');
    }
}
