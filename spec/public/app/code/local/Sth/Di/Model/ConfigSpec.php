<?php

namespace spec;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class Sth_Di_Model_ConfigSpec extends ObjectBehavior
{
    function it_should_be_a_core_config_model()
    {
        $this->shouldHaveType('Mage_Core_Model_Config');
    }
}
