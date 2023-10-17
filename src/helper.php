<?php 

/**
 * merge two arrays including first level of nesting
 * 
 * indexed merging nested array inside them
 * acts like "+" array operation but not to overwrite arrays inside,
 * instead merge them
 * 
 * @param array $array1
 * @param array $array2
 * @return array
 */
function array_merge_index(Array $array1, Array $array2){
    $new = [];
    foreach($array1 as $idx1 => $value1){
        foreach($array2 as $idx2 => $value2){
            if( ($idx1 == $idx2) && is_array($value1) && is_array($value2)){
                $new[$idx1] = array_merge($value1 , $value2) ;
            }elseif(! array_key_exists($idx2, $new)){
                $new[$idx2] = $value2 ;
            }
        }
        if(! array_key_exists($idx1, $new)){
            $new[$idx1] = $value1 ;
        }
    }
    return $new ;
}