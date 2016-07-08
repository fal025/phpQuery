<?php



    // set base url
    const IRCT_REST_BASE_URL = 'http://bd2k-picsure.hms.harvard.edu/';

    // set rest url
    const IRCT_CL_SERVICE_URL = IRCT_REST_BASE_URL . 'IRCT-CL/rest/';

    // set service urls
    const IRCT_RESOURCE_BASE_URL = IRCT_CL_SERVICE_URL . 'resourceService/';
    const IRCT_QUERY_BASE_URL = IRCT_CL_SERVICE_URL . 'queryRESTService/';
    const IRCT_RESULTS_BASE_URL = IRCT_CL_SERVICE_URL . 'resultService/';

    // set list resources
    const IRCT_LIST_RESOURCE_URL = IRCT_RESOURCE_BASE_URL . 'resources';

    // set query
    const IRCT_START_QUERY_URL = IRCT_QUERY_BASE_URL . 'startQuery';
    const IRCT_WHERE_QUERY_URL = IRCT_QUERY_BASE_URL . 'whereClause';
    const IRCT_RUN_QUERY_URL = IRCT_QUERY_BASE_URL . 'runQuery';

    // add select clause
    const IRCT_SELECT_QUERY_URL = IRCT_QUERY_BASE_URL . 'selectClause';

    // get results
    const IRCT_GET_JSON_RESULTS_URL = IRCT_RESULTS_BASE_URL . 'download/json';

    // sample clauses
    const RACE = 'NHANES Public/Public/Studies///NHANES/NHANES/demographics/RACE/';
    const SEX = 'NHANES Public/Public/Studies///NHANES/NHANES/demographics/SEX/';
    const AGE = 'NHANES Public/Public/Studies///NHANES/NHANES/demographics/AGE/';
    const MEAN_DIASTOLIC = 'NHANES Public/Public/Studies///NHANES/NHANES/examination/blood pressure/mean diastolic/';
    const MEAN_SYSTOLIC = 'NHANES Public/Public/Studies///NHANES/NHANES/examination/blood pressure/mean systolic/';
    const BMI = 'NHANES Public/Public/Studies///NHANES/NHANES/examination/body measures/Body Mass Index(kg/m**2)/';
    const STANDING_HEIGHT = 'NHANES Public/Public/Studies///NHANES/NHANES/examination/body measures/Standing Height(cm)/';
    const WEIGHT = 'NHANES Public/Public/Studies///NHANES/NHANES/examination/body measures/Weight (kg)/';
    const GLUCOSE_SERUM = 'NHANES Public/Public/Studies///NHANES/NHANES/laboratory/biochemistry/Glucose, serum(mg/dL)/';
    const URIC_ACID = 'NHANES Public/Public/Studies///NHANES/NHANES/laboratory/biochemistry/Uric acid(mg/dL)/';
    const TOTAL_CHOLESTEROL = 'NHANES Public/Public/Studies///NHANES/NHANES/laboratory/biochemistry/Total Cholesterol(mg/dL)/';
    
    //function that help to chop the id conversation id from string
    function chopToId($conversationId_)
    {
        $num=0;
        $sum=0;
        for($i = 0;;$i++)
        {   
            //echo $conversationId_[$i] . "\n";
            if(ord($conversationId_[$i]) == ord('"'))
            {
                $num++;
                if($num==4) {
                    break;
                }
                continue;
            }
            else if($num == 3) 
            {
                $sum*=10;
                $sum+=(ord($conversationId_[$i])-ord('0'));
            }
        }
        return $sum;        
    }

    //function that help to chop the id result id from string
    function chopToId2($resultId_)
    {
        $sum=0;
        for($i = 0;$i < strlen($resultId_) - 1;$i++)
        {
            //echo $resultId_[$i] . "\n";
            if($resultId_[$i] == ':')
                continue;
            $sum*=10;
            $sum+=(ord($resultId_[$i])-ord('0'));
        }
        //echo $sum . "\n";
        return $sum;        
    }

    // start a conversation
    $curl_session = curl_init(IRCT_START_QUERY_URL);
    curl_setopt($curl_session, CURLOPT_VERBOSE, 1);
    curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl_session, CURLOPT_COOKIEFILE, "");
    $response = curl_exec($curl_session);
    //$response = file(IRCT_START_QUERY_URL);  //same as GET()
    $conversationId = strchr($response,"\"cid\"");
    $conversationId = chopToId($conversationId);
    //echo $conversationId;
    //var_dump($_COOKIE);/*
    //node for where clause
    class whereNode
    {
        function __construct($field, $logicalOperator, $predicate,
            $conversationId, $curl_session)
        {

            $whereParameterList =
            array('type'=>'where', 'field'=>$field,
                'logicalOperator'=>$logicalOperator,
                'predicate'=>$predicate, 'data-encounter'=>'No',
                'cid'=>$conversationId);
            $query = http_build_query($whereParameterList);
            $query = str_replace("+", "%20", $query);

            // start a session
            curl_setopt($curl_session, CURLOPT_URL, 
                IRCT_WHERE_QUERY_URL . '?' . $query);
            $response = curl_exec($curl_session);
            //var_dump($response);
            //var_dump( curl_getinfo($curl_session));
            //var_dump($_COOKIE);

            //echo "\n" . $response . "\n";
            //$response = 
                //file_get_contents(IRCT_WHERE_QUERY_URL . '?' . $query);

        }
    }

    class selectNode
    {
        function __construct($field, $alias, $conversationId, $curl_session)
        {
            $selectParameterList = 
            array('type'=>'select', 'field'=>$field,'alias'=>$alias,'cid'=>
            $conversationId);
            $query = http_build_query($selectParameterList);
            $query = str_replace("+", "%20", $query);
            
            // start a session
            curl_setopt($curl_session, CURLOPT_URL, 
                IRCT_SELECT_QUERY_URL . '?' . $query);
            $response = curl_exec($curl_session);
                       // var_dump($response);

            //var_dump(curl_getinfo($curl_session));

            //echo "\n" . $response . "\n";

            //$response = 
            //    file_get_contents(IRCT_SELECT_QUERY_URL . '?' . $query);
            //var_dump($_COOKIE);
        }
    }
    
    new whereNode(
        "NHANES Public/Public Studies///NHANES/NHANES/demographics/RACE/",
        "AND", "CONTAINS", $conversationId, $curl_session);
    /*new whereNode(
        "NHANES Public/Public Studies///NHANES/NHANES/demographics/RACE/black/",
        "OR", "CONTAINS", $conversationId, $curl_session);*/
    new selectNode(
        "NHANES Public/Public Studies///NHANES/NHANES/demographics/AGE/",
        "AGE", $conversationId, $curl_session);
    /*new selectNode(
        "NHANES Public/Public Studies///NHANES/NHANES/examination/blood pressure/mean diastolic/",
        "AGE", $conversationId, $curl_session);
    new selectNode(
        "NHANES Public/Public Studies///NHANES/NHANES/examination/blood pressure/mean systolic/",
        "AGE", $conversationId, $curl_session);*/

    /*new selectNode(
        "NHANES Public/Public Studies///NHANES/NHANES/examination/blood pressure/60 sec HR(30 sec HR*2)/",
        "BLOODPRESSURE", $conversationId, $curl_session);*/


    // run the full query and store the result Id
    $runQueryList = array('cid'=>$conversationId);
    $query = http_build_query($runQueryList);
    curl_setopt($curl_session, CURLOPT_URL, IRCT_RUN_QUERY_URL . '?' . $query);
    $response = curl_exec($curl_session);
    //$response = file_get_contents(IRCT_RUN_QUERY_URL . '?' . $query);
    //echo $response;
    $resultId = strchr($response, ":");
    $resultId = chopToId2($resultId);
    //var_dump($_COOKIE);
    //echo $resultId;
    // retrieve results
    curl_setopt($curl_session, CURLOPT_URL, 
        IRCT_GET_JSON_RESULTS_URL . '/' . $resultId);
    $response = curl_exec($curl_session);
    //$response = file_get_contents(IRCT_GET_JSON_RESULTS_URL . '/' . $resultId);
    curl_exec($curl_session);
    //var_dump($_COOKIE);
    // pivot results
    //var_dump($response);
    $results = json_decode($response, true);
    //var_dump( $results);
    
    //echo count($results);

    $patientId = [];
    for($i = 0; $i < count($results); $i++)
    {
        $patientId[$i] = intval($results[$i]["PATIENT_NUM"]);
    }
    sort($patientId,SORT_NUMERIC);
    var_dump($patientId);
    echo $patientId[0];


    return $patientId;
?>
