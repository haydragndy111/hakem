<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum AppointmentStatus: int implements HasLabel, HasColor
{
    case Created = 1;
    case Confirmed = 2;
    case Canceled = 3;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Created => 'created',
            self::Confirmed => 'confirmed',
            self::Canceled => 'canceled',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Created => 'warning',
            self::Confirmed => 'success',
            self::Canceled => 'danger',
        };
    }
}
