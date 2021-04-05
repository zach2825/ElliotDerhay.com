<?php

namespace App\Traits;

use Carbon\Carbon;
use Carbon\CarbonInterface;

trait DisplaysTimeElapsed
{
	public string $timeElapsed;

	protected function setTimeElapsedString(Carbon $date): void
	{
		$this->timeElapsed = $date->diffForHumans(now(), CarbonInterface::DIFF_RELATIVE_TO_NOW);
	}
}
