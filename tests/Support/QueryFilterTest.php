<?php

namespace Tests\Support;

use App\Support\Filterable;
use App\Support\QueryFilter;
use Tests\TestCase;

class QueryFilterTest extends TestCase
{
    /** @test */
    public function it_can_toggle_a_filter_without_value()
    {
        $this->assertEquals('/?filter[value]', (new QueryFilter('/'))->filter('value'));

        $this->assertEquals('/?', (new QueryFilter('/?filter[value]'))->filter('value'));
    }

    /** @test */
    public function it_can_clear_a_filter_without_value()
    {
        $this->assertEquals('/?', (new QueryFilter('/?filter[value]'))->clear('value'));
    }

    /** @test */
    public function active_for_filter_without_value()
    {
        $this->assertTrue((new QueryFilter('/?filter[value]'))->isActive('value'));
        $this->assertFalse((new QueryFilter('/?filter'))->isActive('value'));
    }

    /** @test */
    public function it_can_toggle_a_single_value()
    {
        $this->assertEquals('/?filter[value]=a', (new QueryFilter('/'))->filter('value', new Dummy('a')));

        $this->assertEquals('/?', (new QueryFilter('/?filter[value]=a'))->filter('value', new Dummy('a')));

        $this->assertEquals('/?filter[value]=b', (new QueryFilter('/?filter[value]=a'))->filter('value', new Dummy('b')));
    }

    /** @test */
    public function it_can_clear_a_single_filter()
    {
        $this->assertEquals('/?', (new QueryFilter('/?filter[value]=a'))->clear('value'));
    }

    /** @test */
    public function active_for_single_filter()
    {
        $this->assertTrue((new QueryFilter('/?filter[value]=a'))->isActive('value', new Dummy('a')));
        $this->assertFalse((new QueryFilter('/?filter[value]=a'))->isActive('value', new Dummy('b')));
        $this->assertFalse((new QueryFilter('/?'))->isActive('value', new Dummy('a')));
    }

    /** @test */
    public function it_can_toggle_a_multi_filter()
    {
        $this->assertEquals('/?', (new QueryFilter('/?filter[value][]=a'))->filter('value[]', new Dummy('a')));
        $this->assertEquals('/?filter[value][]=a&filter[value][]=b', (new QueryFilter('/?filter[value][]=a'))->filter('value[]', new Dummy('b')));
        $this->assertEquals('/?filter[value][]=b', (new QueryFilter('/?filter[value][]=a&filter[value][]=b'))->filter('value[]', new Dummy('a')));
        $this->assertEquals('/?filter[value][]=a', (new QueryFilter('/'))->filter('value[]', new Dummy('a')));
    }

    /** @test */
    public function it_can_clear_a_multi_filter()
    {
        $this->assertEquals('/?', (new QueryFilter('/?filter[value][]=a&filter[value][]=b'))->clear('value[]'));
    }

    /** @test */
    public function active_for_multi_filter()
    {
        $this->assertTrue((new QueryFilter('/?filter[value][]=a'))->isActive('value[]', new Dummy('a')));
        $this->assertTrue((new QueryFilter('/?filter[value][]=a'))->isActive('value[]'));
        $this->assertFalse((new QueryFilter('/?filter[value][]=a'))->isActive('value[]', new Dummy('b')));
        $this->assertFalse((new QueryFilter('/?'))->isActive('value[]', new Dummy('a')));
    }
}

class Dummy implements Filterable
{
    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function getFilterValue()
    {
        return $this->value;
    }
}
