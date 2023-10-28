<?php

namespace ArrayType;

use \WsdlToPhp\PackageBase\AbstractStructArrayBase;

/**
 * This class stands for ArrayOfChannelRules ArrayType
 * @subpackage Arrays
 */
class ArrayOfChannelRules extends AbstractStructArrayBase
{
    /**
     * The ChannelRule
     * Meta information extracted from the WSDL
     * - form: qualified
     * - maxOccurs: unbounded
     * - minOccurs: 0
     * - nillable: true
     * @var \StructType\ChannelRule[]
     */
    public $ChannelRule;
    /**
     * Constructor method for ArrayOfChannelRules
     * @uses ArrayOfChannelRules::setChannelRule()
     * @param \StructType\ChannelRule[] $channelRule
     */
    public function __construct(array $channelRule = array())
    {
        $this
            ->setChannelRule($channelRule);
    }
    /**
     * Get ChannelRule value
     * An additional test has been added (isset) before returning the property value as
     * this property may have been unset before, due to the fact that this property is
     * removable from the request (nillable=true+minOccurs=0)
     * @return \StructType\ChannelRule[]|null
     */
    public function getChannelRule()
    {
        return isset($this->ChannelRule) ? $this->ChannelRule : null;
    }
    /**
     * This method is responsible for validating the values passed to the setChannelRule method
     * This method is willingly generated in order to preserve the one-line inline validation within the setChannelRule method
     * @param array $values
     * @return string A non-empty message if the values does not match the validation rules
     */
    public static function validateChannelRuleForArrayConstraintsFromSetChannelRule(array $values = array())
    {
        $message = '';
        $invalidValues = [];
        foreach ($values as $arrayOfChannelRulesChannelRuleItem) {
            // validation for constraint: itemType
            if (!$arrayOfChannelRulesChannelRuleItem instanceof \StructType\ChannelRule) {
                $invalidValues[] = is_object($arrayOfChannelRulesChannelRuleItem) ? get_class($arrayOfChannelRulesChannelRuleItem) : sprintf('%s(%s)', gettype($arrayOfChannelRulesChannelRuleItem), var_export($arrayOfChannelRulesChannelRuleItem, true));
            }
        }
        if (!empty($invalidValues)) {
            $message = sprintf('The ChannelRule property can only contain items of type \StructType\ChannelRule, %s given', is_object($invalidValues) ? get_class($invalidValues) : (is_array($invalidValues) ? implode(', ', $invalidValues) : gettype($invalidValues)));
        }
        unset($invalidValues);
        return $message;
    }
    /**
     * Set ChannelRule value
     * This property is removable from request (nillable=true+minOccurs=0), therefore
     * if the value assigned to this property is null, it is removed from this object
     * @throws \InvalidArgumentException
     * @param \StructType\ChannelRule[] $channelRule
     * @return \ArrayType\ArrayOfChannelRules
     */
    public function setChannelRule(array $channelRule = array())
    {
        // validation for constraint: array
        if ('' !== ($channelRuleArrayErrorMessage = self::validateChannelRuleForArrayConstraintsFromSetChannelRule($channelRule))) {
            throw new \InvalidArgumentException($channelRuleArrayErrorMessage, __LINE__);
        }
        if (is_null($channelRule) || (is_array($channelRule) && empty($channelRule))) {
            unset($this->ChannelRule);
        } else {
            $this->ChannelRule = $channelRule;
        }
        return $this;
    }
    /**
     * Add item to ChannelRule value
     * @throws \InvalidArgumentException
     * @param \StructType\ChannelRule $item
     * @return \ArrayType\ArrayOfChannelRules
     */
    public function addToChannelRule(\StructType\ChannelRule $item)
    {
        // validation for constraint: itemType
        if (!$item instanceof \StructType\ChannelRule) {
            throw new \InvalidArgumentException(sprintf('The ChannelRule property can only contain items of type \StructType\ChannelRule, %s given', is_object($item) ? get_class($item) : (is_array($item) ? implode(', ', $item) : gettype($item))), __LINE__);
        }
        $this->ChannelRule[] = $item;
        return $this;
    }
    /**
     * Returns the current element
     * @see AbstractStructArrayBase::current()
     * @return \StructType\ChannelRule|null
     */
    public function current()
    {
        return parent::current();
    }
    /**
     * Returns the indexed element
     * @see AbstractStructArrayBase::item()
     * @param int $index
     * @return \StructType\ChannelRule|null
     */
    public function item($index)
    {
        return parent::item($index);
    }
    /**
     * Returns the first element
     * @see AbstractStructArrayBase::first()
     * @return \StructType\ChannelRule|null
     */
    public function first()
    {
        return parent::first();
    }
    /**
     * Returns the last element
     * @see AbstractStructArrayBase::last()
     * @return \StructType\ChannelRule|null
     */
    public function last()
    {
        return parent::last();
    }
    /**
     * Returns the element at the offset
     * @see AbstractStructArrayBase::offsetGet()
     * @param int $offset
     * @return \StructType\ChannelRule|null
     */
    public function offsetGet($offset)
    {
        return parent::offsetGet($offset);
    }
    /**
     * Returns the attribute name
     * @see AbstractStructArrayBase::getAttributeName()
     * @return string ChannelRule
     */
    public function getAttributeName()
    {
        return 'ChannelRule';
    }
}
