<?php

namespace Astrogoat\CustomerExperience\Peripherals;
use Astrogoat\CustomerExperience\Models\CxChat;
use Astrogoat\CustomerExperience\Models\CxCall;
use Helix\Lego\Settings\Peripherals\Peripheral;

class Support extends Peripheral
{

    public function mount()
    {
        if(CxChat::count() == 0){

            CxChat::upsert([
                ['day'=>'monday','opening_time'=> '09:00',
                'closing_time'=>'18:00','chat_is_available'=> true ],
                ['day'=>'tuesday','opening_time'=> '09:00',
                'closing_time'=>'18:00','chat_is_available'=> true ],
                ['day'=>'wednesday','opening_time'=> '09:00',
                'closing_time'=>'18:00','chat_is_available'=> true ],
                ['day'=>'thursday','opening_time'=> '09:00',
                'closing_time'=>'18:00','chat_is_available'=> true ],
                ['day'=>'friday','opening_time'=> '09:00',
                'closing_time'=>'18:00','chat_is_available'=> true ],
                ['day'=>'saturday','opening_time'=> '09:00',
                'closing_time'=>'18:00','chat_is_available'=> false ],
                ['day'=>'sunday','opening_time'=> '09:00',
                'closing_time'=>'18:00','chat_is_available'=> false ],

            ],['id','day']);
        }

        if(CxCall::count() == 0){

           CxCall::upsert([
                ['day'=>'monday','opening_time'=> '09:00',
                'closing_time'=>'18:00','call_is_available'=> true ],
                ['day'=>'tuesday','opening_time'=> '09:00',
                'closing_time'=>'18:00','call_is_available'=> true ],
                ['day'=>'wednesday','opening_time'=> '09:00',
                'closing_time'=>'18:00','call_is_available'=> true ],
                ['day'=>'thursday','opening_time'=> '09:00',
                'closing_time'=>'18:00','call_is_available'=> true ],
                ['day'=>'friday','opening_time'=> '09:00',
                'closing_time'=>'18:00','call_is_available'=> true ],
                ['day'=>'saturday','opening_time'=> '09:00',
                'closing_time'=>'18:00','call_is_available'=> false ],
                ['day'=>'sunday','opening_time'=> '09:00',
                'closing_time'=>'18:00','call_is_available'=> false ],

            ],['id','day']);
        }

        $this->cx_chat_settings = CxChat::query()->get()->toArray();

        $this->cx_call_settings = CxCall::query()->get()->toArray();

    }



   public function saveCallSettings()
   {

        foreach ($this->cx_call_settings as $settings) {
            $call_setting = CxCall::find($settings['id']);
            $call_setting->opening_time = $settings['opening_time'];
            $call_setting->closing_time = $settings['closing_time'];
            $call_setting->call_is_available = $settings['call_is_available'] ?? false;
            $call_setting->save();
        }


   }


    public function saveChatSettings()
   {

        foreach ($this->cx_chat_settings as $settings) {
            $chat_setting = CxChat::find($settings['id']);
            $chat_setting->opening_time = $settings['opening_time'];
            $chat_setting->closing_time = $settings['closing_time'];
            $chat_setting->chat_is_available = $settings['chat_is_available'] ?? false;
            $chat_setting->save();
        }
   }


    public function render()
    {
        return view('customer-experience::peripherals.support');
    }
}
