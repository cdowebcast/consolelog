PHP - Console Log
-----------------
*Chrome/Firebug colored output*   

#### Content
* [Getting Started](https://github.com/sasbro/consolelog#getting-started---instantiate-class "jump!")
* [Methods / Usage](https://github.com/sasbro/consolelog#methods--usage "jump!")

**Examples - log()**  
*	[Commit some variables](https://github.com/sasbro/consolelog#commit-some-variables "jump!")  
*	[Commit an Array](https://github.com/sasbro/consolelog#commit-an-array "jump!")  
*	[Commit an Object / JSON](https://github.com/sasbro/consolelog#commit-an-object--json "jump!")  

**Examples - obj()**  
* [Commit an Array](https://github.com/sasbro/consolelog#commit-an-array-1 "jump!")  
* [Commit JSON](https://github.com/sasbro/consolelog#commit-json "jump!")  
* [Commit an Object](https://github.com/sasbro/consolelog#commit-an-object "jump!")  
* [Commit variables](https://github.com/sasbro/consolelog#commit-variables "jump!")  
* [Call within another Class](https://github.com/sasbro/consolelog#call-within-another-class "jump!")  

#### Getting Started - Instantiate Class

```php
	require_once('class/consolelog.class.php');
	$log = new ConsoleLog();
```


#### Assign variables
```php

	$foo = 'bar';  
	$bar = 123;
	
	$log->log($foo, $bar);  
```
	
#### Chrome output
![screen_1](/readme/screen_1.png)

Methods / Usage
---------------
Output as String  
```php

	$log->log();  
```

Output as Object (Object/ Array/ JSON)  
```php

	$log->obj();  
```  

Examples - log()
----------------

> #### Commit some variables

```php  

	$foo = 'bar';  
	$bar = 123;  
	
	$log->log($foo, $bar);
	$log->log(1, 0.123, 'foo');
	$log->log(true, false, null);
```

> #### Result (Chrome)

![soutput_vars](/readme/output_log_vars.png)  

> #### Commit an Array

```php

	$var_array = array(
    1,
    2,
	    array(
	        'key_a' => 'val_a',
	        'key_b' => 'val_b',
	        array(
	            'b3',
	            'c4'
	        )
	    )
	);
	
	$log->log($var_array);
```

> #### Result (Chrome)

![soutput_array](/readme/output_log_array.png)

> #### Commit an Object / JSON

```php

	$json = '{"a":1,"b":2,"c":3,"d":4,"e":5}';
	$log->log($json);  
	
	$book = new stdClass();
	$book->title = "Some Book Title";
	$book->author = "Author Name";
	$book->publication = 1978;
	$log->log($book);
```

> #### Result (Chrome)

![soutput_array](/readme/output_log_object.png)

Examples - obj()
----------------

> #### Commit an Array

```php

	$var_array = array(
    1,
    2,
	    array(
	        'key_a' => 'val_a',
	        'key_b' => 'val_b',
	        array(
	            'b3',
	            'c4'
	        )
	    )
	);
	
	$log->obj($var_array);
```

> #### Result (Chrome)

![soutput_array](/readme/output_obj_array.png)

> #### Commit JSON

```php

	$json = '{"a":1,"b":2,"c":3,"d":4,"e":5}';
	$log->obj($json);
```

> #### Result (Chrome)

![soutput_array](/readme/output_obj_json.png)

> #### Commit an Object

```php

	$book = new stdClass();
	$book->title = "Some Book Title";
	$book->author = "Author Name";
	$book->publication = 1978;
	$log->obj($book);
```

> #### Result (Chrome)

![soutput_array](/readme/output_obj_object.png)

> #### Commit variables

```php

	$foo = 'bar';
	$log->obj($foo, 1);
```

> #### Result (Chrome)

![soutput_array](/readme/output_obj_error.png)

> #### Call within another Class

```php

	class JustTest{
		public function __construct()
		{
			$new_log = new ConsoleLog();
			$new_log->log('test', 36481723);
		}
	}
	$test = new JustTest();
```

> #### Result (Chrome)

![soutput_array](/readme/output_log_class.png)