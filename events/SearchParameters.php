<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 10/10/15
 * Time: 4:20 PM
 */

namespace Assistant\Events;


class SearchParameters
{
    function getEventNameClause($value){
        return " LOWER(EventName) LIKE LOWER('%".$value."%') " ;
    }
}