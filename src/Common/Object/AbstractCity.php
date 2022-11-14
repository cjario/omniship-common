<?php
namespace Omniship\Common\Object;

use Omniship\Common\ParametersTrait;

abstract class AbstractCity {
  
    use ParametersTrait;
 
   function __construct(array $data = []) {
        $this->initialize($data);
    }
  
    function setName($value) {
        $this->setParameter("name", $value);
    }

    function setZipCode($value) {
        $this->setParameter('zip_code', $value);
    }
  
    function setShortName($value) {
        $this->setParameter('short_name', $value);
    }
  
    function getName() {
      return $this->getParameter('name');
    }
  
    function getShortName() {
      return $this->getParameter('short_name');
    }
  
    function getZipCode() {
        return $this->setParameter('zip_code');
    }
  
}
