<?php
include dirname(__DIR__)."/vendor/autoload.php";

class Parameter{
	private $attributes = [];

	function __construct(array $attributes = [])
	{
		$this->attributes = $attributes;
	}

	function set($key, $value)
	{
		$this->attributes[$key] = $value;
	}
}

class User{
	public $parameter;

	function __construct(Parameter $parameter)
	{
		$this->parameter = $parameter;
		$parameter->set('data2', 2);
	}
}

$serviceManager = new \Arvelyon\Service\ServiceManager();

// registers
$serviceManager->setService(new \Arvelyon\Service\Collection(User::class));
$serviceManager->setService(new \Arvelyon\Service\Collection(Parameter::class, new Parameter(['debug'=>true, 'version'=>'0.1.0-a', 'data'=>1])));
$serviceManager->setService(new \Arvelyon\Service\Collection('UnknownClass'));

echo '<h3>Check has service</h3>';
echo 'Has service UnknownService: ';
var_dump($serviceManager->hasService('UnknownService'));
echo '<br>';
echo 'Has service Parameter: ';
var_dump($serviceManager->hasService(Parameter::class));
echo '<h3>Test service</h3>';
echo '<pre>';
print_r($serviceManager->getService(User::class));
print_r($serviceManager->getService(Parameter::class));
print_r($serviceManager->getService(User::class));
