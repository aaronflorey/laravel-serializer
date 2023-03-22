<?php

// config for Mochaka/LaravelSerializer
return [

	// Cache class metadata for faster parsing
	'cache' => true,

	/**
	 * Normalizers are what is used to map properties
	 */
	'normalizers' => [
		'dates'         => true, // Casts dates to DateTime objects
		'getterSetters' => true, // Allow Getters and Setters to map your properties
		'arrays'        => true,  // Allows creating arrays from annotations
		'enums'         => true, // Allows converting Enums
	],

	/**
	 * Encoders allow serializing/deserializing between formats
	 */
	'encoders' => [
		'json' => true,
		'yaml' => false,
		'xml'  => false,
		'csv'  => false,
	],
];
