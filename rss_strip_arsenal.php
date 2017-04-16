<?php

/*
 * ArsenalFC News feed Combert to "Alexa Flash Breafing"'s Json Format.
 * 
 * 15 April 2017
 * Sitopp.
 * 
 */
$rss_url   = "http://feeds.arsenal.com/arsenal-news?format=xml";
$rss_data  = simplexml_load_file( $rss_url, 'SimpleXMLElement', LIBXML_NOCDATA );
$json = json_encode($rss_data);
$array = json_decode($json,TRUE);


$result_array=array();
$i=0;
foreach($array as $key1 => $value1) {

    if ($key1=='channel'){
        foreach ($value1 as $key2 => $value2) {
            
            if ($key2=='item'){
                foreach ($value2 as $key3 => $value3) {
                    $i++;
                    if ($i>5){
                        break;
                    }


                    $add_array=array();
    
                    foreach ($value3 as $key4 => $value4) {

                        if ($key4=='pubDate'){                
                            $pubDate=strip_tags($value4);
                            $pubDate = substr($pubDate, 0, 25);  
                            //Fri, 14 Apr 2017 22:30:01
                            //yyyy-MM-dd'T'HH:mm:ss'.0Z'. 
                            $yyyy=substr($pubDate, 12, 4); 
                            $MM=substr($pubDate, 8, 3); 
                            $dd=substr($pubDate, 5, 2); 
                            $HH=substr($pubDate, 17, 2); 
                            $mm=substr($pubDate, 20, 2); 
                            $ss=substr($pubDate, 23, 2);  

                            $MM=month_format($MM);
                            
                            $pubDate = $yyyy.'-'.$MM.'-'.$dd.'T'.$HH.':'.$mm.':'.$ss.'.0Z';
                        }
                        if ($key4=='title'){
                            $title=strip_tags($value4);

                        }
                        if ($key4=='description'){                
                            $description=strip_tags($value4);

                        }
                        if ($key4=='link'){
                            $link=$value4;                            
                        }
                        
                    }

                    $add_array=array(
                        array(
                        "uid"=> "urn:uuid:".$i,
                        "updateDate"=> $pubDate,
                        "titleText"=> $title,
                        "mainText"=> $description,
                        "redirectionUrl"=> $link
                    ));


                   $result_array = array_merge($result_array,$add_array);

                }
            }
        }
    }
}


$json = json_encode($result_array) ;


header("Content-Type: application/json;charset=UTF-8");
echo $json;

exit;



function month_format ($MM){

    switch ($MM) {
        
    case ("Jan") :
        $MM='01';
        break;
    case ("Feb") :
        $MM='02';
        break;
    case ("Mar") :
        $MM='03';
        break;
    case ("Apr") :
        $MM='04';
        break;
    case ("May") :
        $MM='04';
        break;
    case ("Jun") :
        $MM='05';
        break;
    case ("Jul") :
        $MM='06';
        break;
    case ("Aug") :
        $MM='07';
        break;
    case ("Sep") :
        $MM='08';
        break;
    case ("Oct") :
        $MM='09';
        break;
    case ("Nov") :
        $MM='10';
        break;
    case ("Dec") :
        $MM='11';
        break;
    default :
        $MM='12';
        break;
    }
    return $MM;
}

?>
