<?php

namespace Oro\Bundle\ApiBundle\Processor\NormalizeValue\Rest;

use Oro\Bundle\ApiBundle\Processor\NormalizeValue\AbstractProcessor;

class NormalizeBoolean extends AbstractProcessor
{
    const REQUIREMENT = '0|1|true|false|yes|no';

    /**
     * {@inheritdoc}
     */
    protected function getDataTypeString()
    {
        return 'boolean';
    }

    /**
     * {@inheritdoc}
     */
    protected function getDataTypePluralString()
    {
        return 'booleans';
    }

    /**
     * {@inheritdoc}
     */
    protected function getRequirement()
    {
        return self::REQUIREMENT;
    }

    /**
     * {@inheritdoc}
     */
    protected function normalizeValue($value)
    {
        switch ($value) {
            case '1':
            case 'true':
            case 'yes':
                return true;
            case '0':
            case 'false':
            case 'no':
                return false;
        }

        throw new \UnexpectedValueException(
            sprintf('Expected %s value. Given "%s".', $this->getDataTypeString(), $value)
        );
    }
}
