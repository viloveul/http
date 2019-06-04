# Installation (this package based on zend diactoros)

make sure your php version > 7.0

```bash
composer require viloveul/http
```

## HOW

```php
require __DIR__ . '/vendor/autoload.php';

// e.x : http://yourdomain.com/path/to/something?param1=data1&param2=data2

$request = Viloveul\Http\Server\RequestFactory::fromGlobals();

$param1 = $request->getQuery('param1', 'nothing');
$param2 = $request->getQuery('param2', 'nothing');
$param3 = $request->getQuery('param3', 'nothing');

var_dump($param1, $param2, $param3);

// OR you can assign to object

class SampleParam implements Viloveul\Http\Contracts\ServerRequestAssignment
{
	protected $attributes = [];
	public function setAttributes(array $attributes): void
	{
		$this->attributes = $attributes;
	}
	public function getAttributes(): array
	{
		return $this->attributes;
	}
}

$data = $request->loadQueryTo(new SampleParam);

var_dump($data);

```
### Available Methods
- getQuery(key)
- getPost(key)
- getServer(key)
- loadQueryTo(object)
- loadPostTo(object)
- loadServerTo(object)