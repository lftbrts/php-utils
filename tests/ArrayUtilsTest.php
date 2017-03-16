<?php
namespace lftbrts\Tests;

use lftbrts\Utils\Arr as ArrayUtils;

/**
 *
 * @author Ulf Tiburtius <ulf@idea-works.de>
 * @since April 12, 2015
 */
class ArrayUtilsTest extends \PHPUnit_Framework_TestCase
{

    public function testArray_is_assoc()
    {
        $arr = array(
            'foo',
            'baz'
        );
        $this->assertFalse(ArrayUtils::array_is_assoc($arr));

        $arr = array(
            'foo',
            array(
                'baz'
            )
        );
        $this->assertFalse(ArrayUtils::array_is_assoc($arr));

        $arr = array(
            'pink' => 'panther',
            'foo' => array(
                'baz'
            )
        );
        $this->assertTrue(ArrayUtils::array_is_assoc($arr));
    }

    public function testArray_remove_key()
    {
        $arr = array(
            'foo' => 'baz',
            'pink',
            'panther'
        );
        $res = ArrayUtils::array_remove_key($arr, 'foo');
        $this->assertArrayNotHasKey('foo', $res);

        $arr = array(
            'foo' => 'baz',
            'pink',
            'panther'
        );
        $res = ArrayUtils::array_remove_key($arr, 0);
        $this->assertNotContains('pink', $res);

        $arr = array(
            'foo' => 'baz',
            'pink',
            'panther'
        );
        $res = ArrayUtils::array_remove_key($arr, 1, 0, 'foo');
        $this->assertEmpty($res);

        $arr = array(
            'foo' => 'baz',
            'pink',
            'panther'
        );
        $res = ArrayUtils::array_remove_key($arr, 1, 0, 'lol');
        $this->assertArrayHasKey('foo', $res);
        $this->assertNotContains('pink', $res);
        $this->assertNotContains('panther', $res);
    }

    public function testArray_remove_value()
    {
        $arr = array(
            'foo' => 'baz',
            'pink',
            'panther'
        );
        $res = ArrayUtils::array_remove_value($arr, 'panther');
        $this->assertNotContains('panther', $res);

        $arr = array(
            'foo' => 'baz',
            'pink',
            'panther'
        );
        $res = ArrayUtils::array_remove_value($arr, 'baz');
        $this->assertArrayNotHasKey('foo', $res);

        $arr = array(
            'foo' => 'baz',
            'pink',
            'panther'
        );
        $res = ArrayUtils::array_remove_value($arr, 'foo', 'panther');
        $this->assertContains('pink', $res);
        $this->assertNotContains('foo', $res);
        $this->assertNotContains('panther', $res);

        $arr = array(
            'foo' => 'baz',
            'pink',
            'panther'
        );
        $res = ArrayUtils::array_remove_value($arr, 'lion');
        $this->assertEquals($arr, $res);
    }

    public function testArray_remove_empty_value()
    {
        $arr = array(
            'a' => null,
            'b' => '',
            'c' => ' ',
            'pinkpanther'
        );
        $newarr = ArrayUtils::array_remove_empty_value($arr);
        $this->assertContains('pinkpanther', $newarr);
        $this->assertArrayHasKey('c', $newarr);
        $this->assertNotContains('b', $newarr);
        $this->assertNotContains('a', $newarr);
    }

    public function testArray_walkup()
    {
        $arr = array(
            'foo' => 'baz',
            'pink' => array(
                'panther',
                array(
                    'juice' => 'lemon'
                )
            )
        );
        $keys = ArrayUtils::array_walkup('lemon', $arr);
        // so the structure should be $arr['pink'][1]['juice']
        $this->assertNotFalse($keys);
        $this->assertCount(3, $keys);
        $this->assertContains('pink', $keys);
        $this->assertContains(1, $keys);
        $this->assertContains('juice', $keys);
        $this->assertEquals('lemon', $arr[$keys[0]][$keys[1]][$keys[2]]);

        $arr = array(
            'foo' => 'baz',
            'pink' => array(
                'panther',
                array(
                    'juice' => 'lemon'
                )
            )
        );
        $keys = ArrayUtils::array_walkup('strawberry', $arr);
        $this->assertFalse($keys);
    }

    public function testArray_change_key()
    {
        $arr = array('foo' => 'baz', 'baz' => 'foo');
        $arr = ArrayUtils::array_change_key($arr, 'foo', 'Foo');
        $arr = ArrayUtils::array_change_key($arr, 'baz', 'Baz');

        $this->assertArrayHasKey('Foo', $arr);
        $this->assertArrayHasKey('Baz', $arr);
    }

    public function testArray_contains_keys()
    {
        $haystack = array('foo' => 'baz', 'baz' => 'foo', 'lorem' => 'ipsum');
        $needle = array('foo', 'lorem');

        $this->assertTrue(ArrayUtils::array_contain_keys($needle, $haystack));
        $this->assertFalse(ArrayUtils::array_contain_keys(array('lirum'), $haystack));
    }

    public function testArray_reverse_sets()
    {
        $arr = array(1,2,3,4,5,6,7,8,9,10,11,12);
        $out = ArrayUtils::array_reverse_sets($arr, 6);
        $this->assertEquals($out, array(7,8,9,10,11,12,1,2,3,4,5,6));

        $out = ArrayUtils::array_reverse_sets($arr, 2);
        $this->assertEquals($out, array(11,12,9,10,7,8,5,6,3,4,1,2));

        $out = ArrayUtils::array_reverse_sets($arr, 3);
        $this->assertEquals($out, array(10,11,12,7,8,9,4,5,6,1,2,3));
    }

}
