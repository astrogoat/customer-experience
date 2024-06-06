<?php

namespace Astrogoat\CustomerExperience\Peripherals;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Astrogoat\CustomerExperience\Models\OpeningHours as OpeningHoursModel;
use Helix\Fabrick\Notification;
use Helix\Lego\Http\Livewire\Traits\ProvidesFeedback;
use Helix\Lego\Settings\Peripherals\Peripheral;

class OpeningHours extends Peripheral
{
    use ProvidesFeedback;

    public $chat;
    public $call;

    public function rules()
    {
        return [
            'chat.*.enabled' => ['required'],
            'chat.*.opening_time' => ['required'],
            'chat.*.closing_time' => ['required'],
            'call.*.enabled' => ['required'],
            'call.*.opening_time' => ['required'],
            'call.*.closing_time' => ['required'],
        ];
    }

    public function mount(): void
    {
        $this->seedDatabase();

        $this->chat = OpeningHoursModel::query()->chat()->get();
        $this->call = OpeningHoursModel::query()->call()->get();
    }

    public function seedDatabase(): void
    {
        $defaultOpeningTime = Carbon::createFromTime(hour: 9, tz: config('app.timezone'));
        $defaultClosingTime = Carbon::createFromTime(hour: 18, tz: config('app.timezone'));
        $days = [CarbonInterface::MONDAY, CarbonInterface::TUESDAY, CarbonInterface::WEDNESDAY, CarbonInterface::THURSDAY, CarbonInterface::FRIDAY, CarbonInterface::SATURDAY, CarbonInterface::SUNDAY];

        if (OpeningHoursModel::call()->count() == 0) {
            foreach ($days as $day) {
                OpeningHoursModel::query()->create([
                    'day' => $day,
                    'opening_time' => $defaultOpeningTime->format('H:i'),
                    'closing_time' => $defaultClosingTime->format('H:i'),
                    'enabled' => ! in_array($day, [CarbonInterface::SATURDAY, CarbonInterface::SUNDAY]),
                    'type' => OpeningHoursModel::CALL,
                ]);
            }
        }

        if (OpeningHoursModel::chat()->count() == 0) {
            foreach ($days as $day) {
                OpeningHoursModel::query()->create([
                    'day' => $day,
                    'opening_time' => $defaultOpeningTime->format('H:i'),
                    'closing_time' => $defaultClosingTime->format('H:i'),
                    'enabled' => ! in_array($day, [CarbonInterface::SATURDAY, CarbonInterface::SUNDAY]),
                    'type' => OpeningHoursModel::CHAT,
                ]);
            }
        }
    }

    public function saveChat(): void
    {
        $this->validate();

        foreach ($this->chat as $day) {
            $day->save();
        }

        $this->notify(Notification::success(title: 'Saved', message: 'Chat opening times have been saved.')->autoDismiss());
    }

    public function saveCall(): void
    {
        $this->validate();

        foreach ($this->call as $day) {
            $day->save();
        }

        $this->notify(Notification::success(title: 'Saved', message: 'Call opening times have been saved.')->autoDismiss());
    }

    public function render()
    {
        return view('customer-experience::peripherals.opening-hours');
    }
}
