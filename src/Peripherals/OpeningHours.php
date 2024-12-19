<?php

namespace Astrogoat\CustomerExperience\Peripherals;

use Astrogoat\CustomerExperience\Models\OpeningHours as OpeningHoursModel;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Helix\Fabrick\Notification;
use Helix\Lego\Apps\AppToken;
use Helix\Lego\Http\Livewire\Traits\ProvidesFeedback;
use Helix\Lego\Settings\Peripherals\Peripheral;
use Helix\Lego\Strata;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class OpeningHours extends Peripheral
{
    use ProvidesFeedback;

    public $chat;
    public $call;
    public string $chatButtonAction;
    public $chatButtonActionProvider = null;
    protected $chatButtonActionToken;

    public function rules()
    {
        return [
            'chat.*.enabled' => ['required'],
            'chat.*.opening_time' => ['required'],
            'chat.*.closing_time' => ['required'],
            'call.*.enabled' => ['required'],
            'call.*.opening_time' => ['required'],
            'call.*.closing_time' => ['required'],
            'chatButtonActionProvider' => ['required'],
            'chatButtonAction' => ['required'],
        ];
    }

    public function mount(): void
    {
        $this->seedDatabase();

        $this->chat = OpeningHoursModel::query()->chat()->get();
        $this->call = OpeningHoursModel::query()->call()->get();
        $this->chatButtonActionProvider = $this->settings->chat_button_action_provider;
        $this->chatButtonAction = $this->settings->chat_button_action;
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

    public function chatButtonActionProviders(): Collection
    {
        return collect(app(Strata::class)->appTokens())
            ->put('custom', [
                AppToken::name('Custom action')
                    ->group('custom')
                    ->key('custom')
                    ->value('custom')
                    ->description('Add your own custom onclick Javascript action')
                    ->type(AppToken::TYPE_TEXT),
            ]);
    }

    protected function findTokenByProviderKey(string $providerKey): ?AppToken
    {
        $group = Str::before($providerKey, ':');
        $key = Str::after($providerKey, ':');

        if (blank($providerKey) || blank($group)) {
            return null;
        }

        return collect($this->chatButtonActionProviders()[$group])
            ->firstWhere(fn (AppToken $appToken) => $appToken->key == $key);
    }

    public function updatedChatButtonActionProvider(string $providerKey): void
    {
        $token = $this->findTokenByProviderKey($providerKey);

        $this->chatButtonAction = $token?->value ?: '';
        $this->chatButtonActionToken = $token;
    }

    public function saveChat(): void
    {
        $this->validate();

        foreach ($this->chat as $day) {
            $day->save();
        }

        $this->settings->chat_button_action_provider = $this->chatButtonActionProvider;
        $this->settings->chat_button_action = $this->chatButtonAction;
        $this->settings->save();

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
