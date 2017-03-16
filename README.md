## PHP Utils

[![Build Status](https://travis-ci.org/ut42/php-utils.svg?branch=master)](https://travis-ci.org/ut42/php-utils) [![License](https://poser.pugx.org/ideaworks/php-utils/license.svg)](https://packagist.org/packages/ideaworks/php-utils)

A collection of String, Date and Array manipulations and checks.

## Requirements

* PHP >= 5.3

## Installation

Install the package through [Composer](http://getcomposer.org/). Edit your project's composer.json file by adding:

```php
"require": {
	"lftbrts/php-utils": "dev-master"
}
```

Next, run the Composer update command from the terminal:

	composer update --no-dev
	
If you want to run the phpunit tests, run Composer from the terminal:

	composer update

	
## Usage

* [Arr](#arr) A collection of methods to manipulate and check arrays.
* [Dt](#dt) A collection of methods for calculating and checking dates.
* [Str](#str) A collection of methods to manipulate and check strings.


###Arr  

A collection of methods to manipulate and check arrays.

**Arr::array_is_assoc($array)**  
Determine if an array is associative.

```php
	if (true == Arr::array_is_assoc(
		array(
			'foo' => 'baz', 
			'lemonade' => array('juice' => 'lemon')
		))) {
			echo 'the array is an associative array.';
	}
```

**Arr::array_remove_key($array, ...)**  
Remove key(s) from an array.

```php
	$arr = array(
    	'foo' => 'baz',
        'pink',
        'panther'
    );
    
    $res = Arr::array_remove_key($arr, 'foo'); // $res contains indexes 0 and 1
    
    $res = Arr::array_remove_key($arr, 1, 0, 'foo'); // $res is empty
    
    $res = Arr::array_remove_key($arr, 'baz'); // $res == $arr
```

**Arr::array_change_key($array, $oldkey, $newkey)**  
Change a key of an associative array.

```php
    $arr = array('foo', 'baz');
    $arr = Arr::array_change_key($arr, 'foo', 'Foo'); // $arr contains key 'Foo'
```

**Arr::array_contain_keys(array $needle, array $haystack)**  
Check if an associative array contains certain keys.
Searches haystack for needle.

**Arr::array_remove_value($array, ...)**  
Remove value(s) from an array.

```php
	$arr = array(
        'foo' => 'baz',
        'pink',
        'panther'
    );
    $res = ArrayUtils::array_remove_value($arr, 'panther'); // $res contains 'foo' and 'pink'
    
    $res = Arr::array_remove_value($arr, 'baz'); // $res contains 'pink' and 'panther'
    
    $res = Arr::array_remove_value($arr, 'foo', 'panther'); // $res contains only 'pink'
    
    $res = Arr::array_remove_value($arr, 'lion'); // $res == $arr
```

**Arr::array_remove_empty_value($array)**  
Remove all empty values from an array.

```php
	$arr = array(
        'a' => null,
        'b' => '',
        'c' => "    ",
        'pinkpanther'
	);
	
	$res = Arr::array_remove_empty_value($arr); // $res contains 'pinkpanther' and 'c'
```

**Arr::array_walkup($needle, array $haystack)**  
Search for the structure by a given value on a multidimensional array.  
This will break execution on the first occurrence of the matched value.

```php
	$arr = array(
        'foo' => 'baz',
        'pink' => array(
            'panther',
            array(
                'juice' => 'lemon'
            )
        )
    );
    
    if (false !== ($structure = Arr::array_walkup('lemon', $arr))) {
    	/*
     	 * $structure = array(3) {
  	 	 *		[0]=> string(4) "pink"
  	 	 *		[1]=> int(1)
  	 	 *		[2]=> string(4) "juice"
	 	 * }
     	 */
     	
     	// output below is $arr['pink'][1]['juice'];
		echo 'lemon has been found in $arr[' . implode('][', $structure) .']';
    }
```

**Arr::array_reverse_sets($array, integer)**  
Reverses the order of an array group-wise.

```php
	$arr = array(1,2,3,4,5,6,7,8,9,10,11,12);
	
	// cut the $arr into 3 groups in reversed order
	$res = Arr::array_reverse_sets($arr, 3); // $res = [10,11,12,7,8,9,4,5,6,1,2,3]
```


###Dt  
A collection of methods for calculating and checking dates.

**Dt::getDateRangeDays(DateTime, DateTime)**  
Retrieve the days between two dates.

```php
	$start = \DateTime::createFromFormat('Y-m-d', '2015-02-01');
   	$end = \DateTime::createFromFormat('Y-m-d', '2015-03-01');
   	
   	$days = Dt::getDateRangeDays($start, $end);
   	
   	echo $days; // output 28
```

**Dt::checkInDateRange(DateTime, DateTime, DateTime)**  
Check if a date is within two dates (total days).

```php
	$start = \DateTime::createFromFormat('Y/m/d', '2015/04/12');
    $end = clone $start;
    $check = clone $start;
    $end->modify('+1 hour');
    $check->modify('+10 minutes');
    
    if (true == Dt::checkInDateRange($start, $end, $check)) {
    	echo $check->format('Y-m-d') . 
    	' is between ' . 
    	$start->format('Y-m-d') . ' and ' . $end->format('Y-m-d');
    }
```

**Dt::intersectDateRanges(DateTime, DateTime, DateTime, DateTime)**  
Determine if two date-ranges intersects. If so, the total days between the dates will be returned.

```php
	$start1 = \DateTime::createFromFormat('Y-m-d', '2015-02-01');
    $end1 = \DateTime::createFromFormat('Y-m-d', '2015-03-25');
    $start2 = \DateTime::createFromFormat('Y-m-d', '2015-03-20');
    $end2 = \DateTime::createFromFormat('Y-m-d', '2015-06-01');
    
    if (false !== ($days = Dt::intersectDateRanges($start1, $end1, $start2, $end2))) {
    	echo 'the dates intersect with ' . $days . ' days'; // $days == 6
    }
```

**Dt::addMonths(DateTime, $months)**  
Makes sure that adding months always ends up in the month you would expect.  
Works for positive and negative values.

```php
	$date = \DateTime::createFromFormat('Y-m-d', '2012-02-29');
   	$enddate = Dt::addMonths($date, 36); // add three years
   	
   	echo $enddate->format('Y-m-d'); // outputs 2015-02-28, because 2015 isn't a leap year
```

**Dt::addYears(DateTime, $years)**  
Makes sure that adding years always ends up in the month you would expect.  
Works for positive and negative values.

```php
	$date = \DateTime::createFromFormat('Y-m-d', '2012-02-29');
	$enddate = Dt::addYears($date, 3);
	
	echo $enddate->format('Y-m-d'); // outputs 2015-02-28
```

###Str  
A collection of methods to manipulate and check strings.

**Str::areEqual($param1, $param2, $casesensitive = true)**  
Determine if two strings are equal.

```php
	if (false == Str::areEqual('pinkpanther', 'PiNKpanther')) {
		echo 'the strings are not equal.';
	}

	// ignore case sensitivity
	if (true == Str::areEqual('pinkpanther', 'PiNKpanther', false)) {
		echo 'the strings are equal.';
	}
```

**Str::areEqualReverse($param1, $param2, $casesensitive = true)**  
Determine if a string is equal to a reversed string.

```php
	if (true == Str::areEqualReverse('password', 'drowssap')) {
		echo 'the reversed string is equal to the first string.';
	}
	
	// ignore case sensitivity
	if (true == Str::areEqualReverse('PASSword', 'drowssap', false)) {
		echo 'the reversed string is equal to the first string.';
	}
	
	if (false == Str::areEqualReverse('password', 'password')) {
		echo 'the reversed string is not equal to the first string.';
	}
	
```

**Str::maxLength($str, $length)**  
Check whether a string is smaller or equal a given length.

```php
	if (false == Str::maxLength('pinkpanther', 5)) {
		echo 'the string is larger than five chars.';
	}
	
	if (true == StringUtils::maxLength('paul', 4)) {
		echo 'the string is smaller or equal four chars.';
	}
```

**Str::minLength($str, $length)**  
Check whether a string is larger or equal a given length.

```php
	if (false == Str::minLength('pinkpanther', 5)) {
		echo 'the string is larger than five chars.';
	}
	
	if (true == StringUtils::minLength('paul', 4)) {
		echo 'the string is larger or equal four chars.';
	}
	
	if (false == Str::minLength('paul', 5)) {
		echo 'the string is smaller than five chars.';
	}
```

**Str::isEmpty($str)**  
Determine if a string is empty or contains only white spaces.

```php
	if (true == Str::isEmpty("   ") || true == Str::isEmpty(null) || true == Str::isEmpty('')) {
		echo 'The string is empty or contains only white spaces.';
	}
```

##License  
The MIT License (MIT)

Copyright (c) 2015 Ulf Tiburtius

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
