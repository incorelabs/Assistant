<?php
	function random_string($length) {
	    $key = '';
	    $keys = array(0,1,2,3,4,5,6,7,8,9);

	    for ($i = 0; $i < $length; $i++) {
	        $key .= $keys[array_rand($keys)];
	    }

	    return $key;
	}
?>