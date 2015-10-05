<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 05/10/15
 * Time: 4:53 PM
 */

namespace Assistant\Assets;


class SearchParameters
{
    function getAssetNameClause($value){
        return " LOWER(AssetName) LIKE LOWER('%".$value."%') " ;
    }

    function getHolderNameClause($value){
        return " HolderCode in ( SELECT FamilyCode FROM Table107 WHERE LOWER(FamilyName) LIKE LOWER('%".$value."%') ) ";
    }
}