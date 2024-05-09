<?php

namespace Astrogoat\CustomerExperience\Peripherals;
use Astrogoat\CustomerExperience\Models\CxChat;
use Astrogoat\CustomerExperience\Models\CxCall;
use Helix\Lego\Settings\Peripherals\Peripheral;
use Helix\Lego\Http\Livewire\Traits\ProvidesFeedback;
class Support extends Peripheral
{
    use ProvidesFeedback;

    public  $cx_chat_settings;
    public  $cx_call_settings;
    public  $call;
    public $call_enabled;
    public $chat_enabled;


    public function rules()
    {
        return [
            'call_enabled' => ['boolean'],
            'chat_enabled' => ['boolean'],
            'call.*.call_is_available' => ['nullable','boolean'],
        ];
    }

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



        $this->cx_chat_settings = CxChat::query()->get();
        $this->cx_call_settings = CxCall::query()->get();
    }


   public function saveCallSettings()
   {

        foreach ($this->call as $id => $settings) {
            $call_setting = CxCall::find($id);

            $call_setting->opening_time = $settings['opening_time'];
            $call_setting->closing_time = $settings['closing_time'];
            $call_setting->call_is_available = $settings['call_is_available'] ?? false;

            $call_setting->save();
        }


   }




    public function updatedCallEnabled()
    {

        ray($this->validate()['call_enabled']);

        foreach($this->cx_call_settings as $settings){
            $settings->update([
                'call_is_available' => $this->validate()['call_enabled'],
            ]);
        }

    }

    public function updatedChatEnabled()
    {
        $this->validate()['chat_enabled'];

        foreach($this->cx_chat_settings as $settings){
            $settings->update([
                'chat_is_available' => $this->validate()['chat_enabled'],
            ]);
        }
    }


    public function render()
    {
        return view('customer-experience::peripherals.support');
    }
}
