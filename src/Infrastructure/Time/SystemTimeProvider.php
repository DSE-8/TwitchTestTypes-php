<?php

declare(strict_types=1);

namespace TwitchAnalytics\Infrastructure\Time;

use TwitchAnalytics\Application\Services\TimeProvider;
use Datetime;

class SystemTimeProvider implements TimeProvider{
    public function now(): Datetime{
        return new Datetime();
    } 
}