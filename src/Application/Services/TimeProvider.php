<?php

declare(strict_types=1);

namespace TwitchAnalytics\Application\Services;

use Datetime;

interface TimeProvider{
    public function now(): Datetime;
}