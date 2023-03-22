<?php

namespace Mochaka\LaravelSerializer;

use Symfony\Component\Serializer\Serializer;
use Mochaka\LaravelSerializer\Support\SerializerBuilder;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;

/**
 * @see Serializer
 */
class LaravelSerializer
{
	private readonly Serializer $serializer;
	private array $context = [];

	public function __construct()
	{
		$this->serializer = (new SerializerBuilder())->getSerializer();
	}

	/**
	 * @param 'csv'|'json'|'xml'|'yaml' $format
	 */
	public function encode(mixed $data, string $format, array $context = []): string
	{
		return $this->serializer->encode($data, $format, array_merge($this->context, $context));
	}

	/**
	 * @param 'csv'|'json'|'xml'|'yaml' $format
	 */
	public function decode(string $data, string $format, array $context = []): mixed
	{
		return $this->serializer->decode($data, $format, array_merge($this->context, $context));
	}

	/**
	 * @param 'csv'|'json'|'xml'|'yaml' $format
	 */
	public function serialize(mixed $data, string $format, array $context = []): string
	{
		return $this->serializer->serialize($data, $format, array_merge($this->context, $context));
	}

	/**
	 * @template T
	 *
	 * @param class-string<T>           $type
	 * @param 'csv'|'json'|'xml'|'yaml' $format
	 *
	 * @return T
	 */
	public function deserialize(mixed $data, string $type, string $format, array $context = []): mixed
	{
		return $this->deserialize($data, $type, $format, array_merge($this->context, $context));
	}

	/**
	 * By default, the Serializer will preserve properties containing a null value.
	 */
	public function skipNullValues(bool $value = true): self
	{
		$this->context[AbstractObjectNormalizer::SKIP_NULL_VALUES] = $value;

		return $this;
	}

	/**
	 * In PHP, typed properties have an uninitialized state which is different from the default null
	 * of untyped properties. When you try to access a typed property before giving it an explicit value,
	 * you get an error.
	 *
	 * To avoid the Serializer throwing an error when serializing or normalizing an object with uninitialized
	 * properties, by default the object normalizer catches these errors and ignores such properties.
	 *
	 * You can disable this behavior by setting this to false
	 */
	public function skipUninitializedProperties(bool $value = false): self
	{
		$this->context[AbstractObjectNormalizer::SKIP_UNINITIALIZED_VALUES] = $value;

		return $this;
	}

	/**
	 * When denormalizing a payload to an object with typed properties, you'll get an exception
	 * if the payload contains properties that don't have the same type as the object.
	 *
	 * In those situations, this option to collect all exceptions at once,
	 * and to get the object partially denormalized:
	 */
	public function collectionTypeErrors(bool $value = true): self
	{
		$this->context[DenormalizerInterface::COLLECT_DENORMALIZATION_ERRORS] = $value;

		return $this;
	}

	public function getSerializer(): Serializer
	{
		return $this->serializer;
	}
}
