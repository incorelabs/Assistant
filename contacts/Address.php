<?php

/**
 * User: kbokdia
 * Date: 02/09/15
 * Time: 12:51 PM
 */
class Address
{
    var $address1;
    var $address2;
    var $address3;
    var $address4;
    var $address5;
    var $addressCity;
    var $addressCityCode;
    var $addressState;
    var $addressStateCode;
    var $addressCountry;
    var $addressCountryCode;
    var $addressArea;
    var $addressAreaCode;
    var $addressPhone1;
    var $addressPhone2;

    function __construct() {
        $this->initializeVar();
    }

    function  initializeVar(){
        $this->address1 = "NULL";
        $this->address2 = "NULL";
        $this->address3 = "NULL";
        $this->address4 = "NULL";
        $this->address5 = "NULL";
        $this->addressCity = "NULL";
        $this->addressCityCode = "NULL";
        $this->addressState = "NULL";
        $this->addressStateCode = "NULL";
        $this->addressCountry = "NULL";
        $this->addressCountryCode = "NULL";
        $this->addressArea = "NULL";
        $this->addressAreaCode = "NULL";
        $this->addressPhone1 = "NULL";
        $this->addressPhone2 = "NULL";
    }

    function getAddress(){
        return get_object_vars($this);
    }
}