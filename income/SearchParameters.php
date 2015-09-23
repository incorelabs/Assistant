<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 23/09/15
 * Time: 7:23 PM
 */

namespace Assistant\Income;


class SearchParameters
{
    function getIncomeNameClause($value){
        return " LOWER(IncomeName) LIKE LOWER('%".$value."%') " ;
    }

    function getHolderNameClause($value){
        return " HolderCode in ( SELECT FamilyCode FROM Table107 WHERE LOWER(FamilyName) LIKE LOWER('%".$value."%') ) ";
    }
}