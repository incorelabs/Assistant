<?php

/**
 * User: kbokdia
 * Date: 09/09/15
 * Time: 8:02 PM
 */
namespace Assistant\Passwords;

class SearchParameters
{
    function getPasswordNameClause($value){
        return " LOWER(PasswordName) LIKE LOWER('%".$value."%') " ;
    }

    function getHolderNameClause($value){
        return " HolderCode in ( SELECT FamilyCode FROM Table107 WHERE LOWER(FamilyName) LIKE LOWER('%".$value."%') ) ";
    }
}