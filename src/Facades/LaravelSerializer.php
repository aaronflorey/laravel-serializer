<?php

namespace Mochaka\LaravelSerializer\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mochaka\LaravelSerializer\LaravelSerializer
 */
class LaravelSerializer extends Facade
{
	protected static function getFacadeAccessor()
	{
		return \Mochaka\LaravelSerializer\LaravelSerializer::class;
	}
}
