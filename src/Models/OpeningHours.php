<?php

namespace Astrogoat\CustomerExperience\Models;

use DateTimeZone;
use Carbon\Carbon;
use Carbon\CarbonTimeZone;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class OpeningHours extends Model
{
    const string CALL = 'call';
    const string CHAT = 'chat';

    public $casts = [
        'enabled' => 'bool'
    ];

    protected $table = 'customer_experience_opening_hours';
    protected $guarded = [];

    public function scopeCall(Builder $query): Builder
    {
        return $query->where('type', OpeningHours::CALL);
    }

    public function scopeChat(Builder $query): Builder
    {
        return $query->where('type', OpeningHours::CHAT);
    }

    public function scopeToday(Builder $query): Builder
    {
        return $query->where('day', now('UTC')->format('w'));
    }

    public function dayDisplayName(): string
    {
        return match ($this->day) {
            CarbonInterface::MONDAY => __('Monday'),
            CarbonInterface::TUESDAY => __('Tuesday'),
            CarbonInterface::WEDNESDAY => __('Wednesday'),
            CarbonInterface::THURSDAY => __('Thursday'),
            CarbonInterface::FRIDAY => __('Friday'),
            CarbonInterface::SATURDAY => __('Saturday'),
            CarbonInterface::SUNDAY => __('Sunday'),
        };
    }

    public function openingTime(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value) {
                return Carbon::createFromTimeString($value, 'UTC')
                    ->setTimezone(config('app.timezone'))
                    ->format('H:i');
            },
            set: function (mixed $value) {
                return Carbon::createFromTimeString($value, config('app.timezone'))
                    ->setTimezone('UTC')
                    ->format('H:i');
            },
        );
    }

    public function closingTime(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value) {
                return Carbon::createFromTimeString($value, 'UTC')
                    ->setTimezone(config('app.timezone'))
                    ->format('H:i');
            },
            set: function (mixed $value) {
                return Carbon::createFromTimeString($value, config('app.timezone'))
                    ->setTimezone('UTC')
                    ->format('H:i');
            },
        );
    }

    public function openingTimeInUtc(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                return Carbon::createFromTimeString($attributes['opening_time'], 'UTC')
                    ->format('H:i');
            },
        );
    }

    public function closingTimeInUtc(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                return Carbon::createFromTimeString($attributes['closing_time'], 'UTC')
                    ->format('H:i');
            },
        );
    }
}
