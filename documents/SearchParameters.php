<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 13/10/15
 * Time: 3:12 PM
 */

namespace Assistant\Document;


class SearchParameters
{
    function getDocumentNameClause($value){
        return " LOWER(DocumentName) LIKE LOWER('%".$value."%') " ;
    }

    function getHolderNameClause($value){
        return " HolderCode in ( SELECT FamilyCode FROM Table107 WHERE LOWER(FamilyName) LIKE LOWER('%".$value."%') ) ";
    }
}