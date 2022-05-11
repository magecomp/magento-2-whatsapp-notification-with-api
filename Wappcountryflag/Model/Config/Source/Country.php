<?php

namespace Magecomp\Wappcountryflag\Model\Config\Source;

class Country implements \Magento\Framework\Option\ArrayInterface
{
    protected $_countryCollection;
    protected $_options;

    public function __construct(\Magento\Directory\Model\ResourceModel\Country\Collection $countryCollection)
    {
        $this->_countryCollection = $countryCollection;
    }

    public function toOptionArray($isMultiselect = false, $foregroundCountries = '')
    {
        if (!$this->_options) {
            $this->_options = $this->_countryCollection->loadData()->setForegroundCountries(
                $foregroundCountries
            )->toOptionArray(
                false
            );
        }

        $options = $this->_options;


        return $options;
    }
}
