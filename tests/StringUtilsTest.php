<?php
namespace Ideaworks\Tests;

use Ideaworks\Utils\Str as StringUtils;

/**
 * @author Ulf Tiburtius <ulf@idea-works.de>
 * @since April 12, 2015
 */
class StringUtilsTest extends \PHPUnit_Framework_TestCase
{

<<<<<<< HEAD
=======
    public function setUp()
    {
        echo ' ' . $this->getName() . PHP_EOL;
    }

>>>>>>> feature/arrayutils
    public function testAreEqualReverse()
    {
        $this->assertTrue(StringUtils::areEqualReverse('password', 'drowssap'));
        $this->assertTrue(StringUtils::areEqualReverse('Password', 'drowssap', false));
        $this->assertFalse(StringUtils::areEqualReverse('Розовая Пантера', 'Розовая Пантера'));
    }

    public function testAreEqual()
    {
        $this->assertTrue(StringUtils::areEqual('paul', 'paul'));
        $this->assertFalse(StringUtils::areEqual('paul', 'PAUL'));

        $this->assertTrue(StringUtils::areEqual('PAuL', 'paul', false));
        $this->assertTrue(StringUtils::areEqual('paul', 'PAUL', false));
    }

    public function testMaxLength()
    {
        $this->assertTrue(StringUtils::maxLength('paul', 4));
        $this->assertFalse(StringUtils::maxLength('paul', 1));
        $this->assertFalse(StringUtils::maxLength('pinkpanther', 5));
    }

    public function testMinLength()
    {
        $this->assertTrue(StringUtils::minLength('paul', 4));
        $this->assertTrue(StringUtils::minLength('pinkpanther', 5));
        $this->assertFalse(StringUtils::minLength('paul', 5));
    }

    public function testIsEmpty()
    {
        $this->assertTrue(StringUtils::isEmpty("   "));
        $this->assertTrue(StringUtils::isEmpty(null));
        $this->assertTrue(StringUtils::isEmpty(''));
        $this->assertFalse(StringUtils::isEmpty(' pink panther '));
    }
}
