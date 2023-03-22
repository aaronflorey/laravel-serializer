<?php

namespace Mochaka\LaravelSerializer\Support;

use DateInterval;
use DateTimeImmutable;
use DateTimeInterface;
use Psr\Cache\CacheItemInterface;

class CacheItem implements CacheItemInterface
{
	private mixed $value;

	private ?DateTimeInterface $expires = null;

	public function __construct(private readonly string $key, mixed $value = null, private readonly bool $hit = false)
	{
		$this->value = $this->hit ? $value : null;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getKey(): string
	{
		return $this->key;
	}

	/**
	 * {@inheritDoc}
	 */
	public function get(): mixed
	{
		if (!$this->isHit()) {
			return null;
		}

		return $this->value;
	}

	/**
	 * A cache hit occurs when a Calling Library requests an Item by key
	 * and a matching value is found for that key, and that value has
	 * not expired, and the value is not invalid for some other reason.
	 *
	 * Calling Libraries SHOULD make sure to verify isHit() on all get() calls.
	 *
	 * {@inheritDoc}
	 */
	public function isHit(): bool
	{
		if (!$this->hit) {
			return false;
		}

		if (is_null($this->expires)) {
			return true;
		}

		return $this->expires > new DateTimeImmutable();
	}

	/**
	 * {@inheritDoc}
	 */
	public function set(mixed $value): static
	{
		$this->value = $value;

		return $this;
	}

	/**
	 * {@inheritDoc}
	 */
	public function expiresAt(?DateTimeInterface $expires): static
	{
		if ($expires instanceof DateTimeInterface && !$expires instanceof DateTimeImmutable) {
			$timezone = $expires->getTimezone();
			$expires = DateTimeImmutable::createFromFormat('U', (string) $expires->getTimestamp(), $timezone);
			if ($expires) {
				$expires = $expires->setTimezone($timezone);
			}
		}

		$this->expires = $expires instanceof DateTimeInterface ? $expires : null;

		return $this;
	}

	/**
	 * {@inheritDoc}
	 */
	public function expiresAfter(int|DateInterval|null $time): static
	{
		if ($time === null) {
			$this->expires = null;

			return $this;
		}

		$this->expires = new DateTimeImmutable();

		if (!$time instanceof DateInterval) {
			$time = new DateInterval(sprintf('PT%sS', $time));
		}

		$this->expires = $this->expires->add($time);

		return $this;
	}

	public function getExpiresAt(): ?DateTimeInterface
	{
		return $this->expires;
	}
}
