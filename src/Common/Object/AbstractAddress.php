<?php
namespace Omniship\Common\Object;

use Omniship\Common\ParametersTrait;

abstract class AbstractAddress {
    
    use ParametersTrait;

    function __construct(array $data) {
        $this->initialize($data);
    }

    function setName($value) {
        $this->setParameter("name", $value);
    }

    function setAddress($value) {
        $this->setParameter('address', $value);
    }

    function setCity($value) {
        $this->setParameter('city', $value);
    }

    function setZip($value) {
        $this->setParameter('zip', $value);
    }

    function setCountry($value) {
        $this->setParameter('country', $value);
    }

    function setPhone($value) {
        $this->setParameter('phone', $value);
    }
  
    function getName() {
        return $this->getParameter("name");
    }

    function getAddress() {
       return $this->getParameter('address');
    }

    function getCity() {
        return $this->getParameter('city');
    }

    function getZip() {
        return $this->setParameter('zip');
    }

    function getCountry() {
        return $this->getParameter('country');
    }

    function getPhone() {
        return $this->getParameter('phone');
    }
}
