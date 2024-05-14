<?php

namespace Astrogoat\CustomerExperience\Peripherals;

use Astrogoat\CustomerExperience\Models\CxChat;
use Astrogoat\CustomerExperience\Models\CxCall;
use Helix\Lego\Settings\Peripherals\Peripheral;

class Support extends Peripheral
{

public bool $chat_enabled;
public bool $call_enabled;
public  $cx_chat_settings;
public  $cx_call_settings;

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
    if (CxChat::count() == 0) {

        CxChat::upsert([
            ['day' => 'monday', 'opening_time' => '09:00',
                'closing_time' => '18:00', 'chat_is_available' => true],
            ['day' => 'tuesday', 'opening_time' => '09:00',
                'closing_time' => '18:00', 'chat_is_available' => true],
            ['day' => 'wednesday', 'opening_time' => '09:00',
                'closing_time' => '18:00', 'chat_is_available' => true],
            ['day' => 'thursday', 'opening_time' => '09:00',
                'closing_time' => '18:00', 'chat_is_available' => true],
            ['day' => 'friday', 'opening_time' => '09:00',
                'closing_time' => '18:00', 'chat_is_available' => true],
            ['day' => 'saturday', 'opening_time' => '09:00',
                'closing_time' => '18:00', 'chat_is_available' => false],
            ['day' => 'sunday', 'opening_time' => '09:00',
                'closing_time' => '18:00', 'chat_is_available' => false],

        ], ['id', 'day']);
    }


    if (CxCall::count() == 0) {

        CxCall::upsert([
            ['day' => 'monday', 'opening_time' => '09:00',
                'closing_time' => '18:00', 'call_is_available' => true],
            ['day' => 'tuesday', 'opening_time' => '09:00',
                'closing_time' => '18:00', 'call_is_available' => true],
            ['day' => 'wednesday', 'opening_time' => '09:00',
                'closing_time' => '18:00', 'call_is_available' => true],
            ['day' => 'thursday', 'opening_time' => '09:00',
                'closing_time' => '18:00', 'call_is_available' => true],
            ['day' => 'friday', 'opening_time' => '09:00',
                'closing_time' => '18:00', 'call_is_available' => true],
            ['day' => 'saturday', 'opening_time' => '09:00',
                'closing_time' => '18:00', 'call_is_available' => false],
            ['day' => 'sunday', 'opening_time' => '09:00',
                'closing_time' => '18:00', 'call_is_available' => false],

        ], ['id', 'day']);
    }

    $this->cx_chat_settings = CxChat::query()->get();
    $this->cx_call_settings = CxCall::query()->get();
    $this->checkIfCallIsEnabled();
    $this->checkIfChatIsEnabled();
}

public function checkIfCallIsEnabled(): void
{

    $count_enabled = 0;
    foreach($this->cx_call_settings as $settings){

        if($settings->call_is_available == 1)
        {
            $count_enabled +=1;
        }
    }

    if($count_enabled >= 4){
        $this->call_enabled = true;
    }
}


public function checkIfChatIsEnabled(): void
{

    $count_enabled = 0;
    foreach($this->cx_chat_settings as $settings){

        if($settings->chat_is_available == 1)
        {
            $count_enabled +=1;
        }
    }

    if($count_enabled >= 4){
        $this->chat_enabled = true;
    }
}


public function saveCallSettings(): void
{

    $this->validate();

    foreach ($this->cx_call_settings->toArray() as $settings) {
        $call_setting = CxCall::find($settings['id']);
        $call_setting->opening_time = $settings['opening_time'];
        $call_setting->closing_time = $settings['closing_time'];
        $call_setting->call_is_available = $settings['call_is_available'] ?? false;
        $call_setting->save();
    }
}


public function saveChatSettings(): void
{
    $this->validate();

    foreach ($this->cx_chat_settings->toArray() as $settings) {
        $chat_setting = CxChat::find($settings['id']);
        $chat_setting->opening_time = $settings['opening_time'];
        $chat_setting->closing_time = $settings['closing_time'];
        $chat_setting->chat_is_available = $settings['chat_is_available'] ?? false;
        $chat_setting->save();
    }
}

public function updatedChatEnabled(): void
{

    foreach ($this->cx_chat_settings as $settings) {
        $settings->chat_is_available = $this->chat_enabled;
        $settings->save();
    }
    $this->mount();

}

public function updatedCallEnabled(): void
{

    foreach ($this->cx_call_settings as $settings) {
        $settings->call_is_available = $this->call_enabled;
        $settings->save();
    }
    $this->mount();
}


public function render()
{
    return view('customer-experience::peripherals.support');
}

}
