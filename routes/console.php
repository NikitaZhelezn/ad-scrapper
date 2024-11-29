<?php

use App\Console\Commands\PriceChangeObserverCommand;
use Illuminate\Support\Facades\Schedule;

Schedule::command(PriceChangeObserverCommand::class)->hourly();
