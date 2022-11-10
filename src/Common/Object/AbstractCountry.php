<?php
namespace Omniship\Common\Object;

use Omniship\Common\ParametersTrait;

abstract class AbstractCountry {
  
  use ParametersTrait;
  
  protected $cities = [];
  
  function setName($value) {
     $this->setParameter("name", $value);
  }
  
  function getName() {
    return $this->getParameter("name");
  }
  
  function setCode($value) {
     $this->setParameter("code", $value);
  }
  
  function getCode() {
    return $this->getParameter("code");
  }
  
  function getCountryCities() : array {
    return $this->cities;
  }
  
  function setCity($value) {
    $this->setParameter('city', $vlue);
  }
  
  function getCity() {
    return $this->setParameter('city');
  }
}
