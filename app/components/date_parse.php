<?php


class DateParseComponent extends Object  {
    var $uses = array('Sanitize','Utility');
    
    function getDate($date, $delimiter) {
    	if($date){
    		//echo "Jose";
    		$aux = explode($delimiter, $date);
            $data = array(
                    'day'=> intval(str_replace($delimiter, "", $aux[0])),
                    'month'=> intval(str_replace($delimiter, "", $aux[1])),
                    'year'=> intval(str_replace($delimiter, "", $aux[2]))
                    );
        	return $data;
    	}else{
    		return array(
        					'month'=>'',
        					'day'=>'',
        					'year'=>''
        				);
    		
    	}
    }


    function getProsecutionNumber($number){

        $prosecutionNumber = substr($number, 0, 5).".".substr($number, 5,6)."/".substr($number, 11,4)."-".substr($number, -2);

        return $prosecutionNumber;
    }
}

?>