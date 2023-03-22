<?php

namespace Mochaka\LaravelSerializer\Support;

use Symfony\Component\Serializer\Serializer;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\YamlEncoder;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\EncoderInterface;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\BackedEnumNormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\NameConverter\MetadataAwareNameConverter;
use Symfony\Component\Serializer\Mapping\Factory\CacheClassMetadataFactory;

class SerializerBuilder
{
	public function getSerializer(): Serializer
	{
		return new Serializer(
			array_merge(
				$this->normalizers(),
				[
					$this->objectNormalizer(),
				]
			),
			$this->encoders(),
		);
	}

	private function metadataFactory(): CacheClassMetadataFactory|ClassMetadataFactory
	{
		if (\config('serializer.cache')) {
			return new CacheClassMetadataFactory(
				new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader())),
				new CacheItemPool(),
			);
		}

		return new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
	}

	private function normalizers(): array
	{
		$normalizers = [
			DateTimeNormalizer::class     => \config('serializer.normalizers.dates'),
			GetSetMethodNormalizer::class => \config('serializer.normalizers.getterSetters'),
			ArrayDenormalizer::class      => \config('serializer.normalizers.arrays'),
			BackedEnumNormalizer::class   => \config('serializer.normalizers.enums'),
		];

		return array_keys(array_filter($normalizers));
	}

	private function objectNormalizer(): ObjectNormalizer
	{
		$classMetadataFactory = $this->metadataFactory();

		return new ObjectNormalizer(
			$this->metadataFactory(),
			new MetadataAwareNameConverter($classMetadataFactory),
			PropertyAccess::createPropertyAccessor(),
			new PropertyInfoExtractor([], [
				new PhpDocExtractor(),
				new ReflectionExtractor(),
			])
		);
	}

	private function encoders(): array
	{
		$encoders = [
			JsonEncoder::class => \config('serializer.encoders.json'),
			YamlEncoder::class => \config('serializer.encoders.yaml'),
			XmlEncoder::class  => \config('serializer.encoders.xml'),
			CsvEncoder::class  => \config('serializer.encoders.csv'),
		];

		return array_map(fn (string $class): EncoderInterface => new $class(), array_keys(array_filter($encoders)));
	}
}
