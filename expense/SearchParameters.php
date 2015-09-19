<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 19/09/15
 * Time: 3:42 PM
 */

namespace Assistant\Expense;


class SearchParameters
{
    function getExpenseNameClause($value){
        return " LOWER(ExpenseName) LIKE LOWER('%".$value."%') " ;
    }

    function getHolderNameClause($value){
        return " HolderCode in ( SELECT FamilyCode FROM Table107 WHERE LOWER(FamilyName) LIKE LOWER('%".$value."%') ) ";
    }
}