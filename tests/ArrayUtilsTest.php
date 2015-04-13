<?php
namespace Ideaworks\Tests;

use Ideaworks\Utils\Arr as ArrayUtils;

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
        var_dump($keys);
        // so the structure should be $arr['pink'][1]['lime']
        $this->assertNotFalse($keys);
        $this->assertCount(3, $keys);
        $this->assertContains('pink', $keys);
        $this->assertContains(1, $keys);
        $this->assertContains('lime', $keys);
        $this->assertEquals('juice', $arr[$keys[0]][$keys[1]][$keys[2]]);

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

}
