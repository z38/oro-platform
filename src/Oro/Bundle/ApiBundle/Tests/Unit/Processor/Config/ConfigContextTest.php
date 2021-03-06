<?php

namespace Oro\Bundle\ApiBundle\Tests\Unit\Processor\Config;

use Oro\Bundle\ApiBundle\Config\FiltersConfig;
use Oro\Bundle\ApiBundle\Config\FiltersConfigExtra;
use Oro\Bundle\ApiBundle\Config\SortersConfig;
use Oro\Bundle\ApiBundle\Config\SortersConfigExtra;
use Oro\Bundle\ApiBundle\Processor\Config\ConfigContext;
use Oro\Bundle\ApiBundle\Tests\Unit\Processor\TestConfigExtra;
use Oro\Bundle\ApiBundle\Util\ConfigUtil;

class ConfigContextTest extends \PHPUnit_Framework_TestCase
{
    /** @var ConfigContext */
    protected $context;

    protected function setUp()
    {
        $this->context = new ConfigContext();
    }

    public function testClassName()
    {
        $this->assertNull($this->context->getClassName());

        $this->context->setClassName('test');
        $this->assertEquals('test', $this->context->getClassName());
        $this->assertEquals('test', $this->context->get(ConfigContext::CLASS_NAME));
    }

    public function testMaxRelatedEntities()
    {
        $this->assertNull($this->context->getMaxRelatedEntities());

        $this->context->setMaxRelatedEntities(123);
        $this->assertEquals(123, $this->context->getMaxRelatedEntities());
        $this->assertEquals(123, $this->context->get(ConfigContext::MAX_RELATED_ENTITIES));
    }

    public function testExtras()
    {
        $this->assertSame([], $this->context->getExtras());
        $this->assertSame([], $this->context->get(ConfigContext::EXTRA));
        $this->assertFalse($this->context->has('test'));

        $extras = [new TestConfigExtra('test')];
        $this->context->setExtras($extras);
        $this->assertEquals($extras, $this->context->getExtras());
        $this->assertEquals(['test'], $this->context->get(ConfigContext::EXTRA));
        $this->assertTrue($this->context->has('test'));

        $this->context->setExtras([]);
        $this->assertSame([], $this->context->getExtras());
        $this->assertSame([], $this->context->get(ConfigContext::EXTRA));
    }

    public function testFilters()
    {
        $this->assertFalse($this->context->hasFilters());
        $this->assertNull($this->context->getFilters());

        $filters = new FiltersConfig();

        $this->context->setFilters($filters);
        $this->assertTrue($this->context->hasFilters());
        $this->assertEquals($filters, $this->context->getFilters());
        $this->assertEquals($filters, $this->context->get(FiltersConfigExtra::NAME));

        $this->context->setFilters(null);
        $this->assertTrue($this->context->hasFilters());
    }

    public function testSorters()
    {
        $this->assertFalse($this->context->hasSorters());
        $this->assertNull($this->context->getSorters());

        $sorters = new SortersConfig();

        $this->context->setSorters($sorters);
        $this->assertTrue($this->context->hasSorters());
        $this->assertEquals($sorters, $this->context->getSorters());
        $this->assertEquals($sorters, $this->context->get(SortersConfigExtra::NAME));

        $this->context->setSorters(null);
        $this->assertTrue($this->context->hasSorters());
    }
}
