/*
 * Name: Fangchen Li/Chengze Shen
 * Filename: temp_solution.php
 * Date: June 19th, 2016
 * Description: this file contains the functionality of query with BD2k center 
 * to get patients' Id with the given information and will return the patient id
 *
 */

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

    // start a conversation
    $response = file(IRCT_START_QUERY_URL);  //same as GET()
    $conversationId = strchr($response[0],"\"cid\"");
    $conversationId = chopToId($conversationId);

    //function that help to chop the id conversation id from string
    function chopToId($conversationId_)
    {
        $num=0;
        $sum=0;
        for($i = 0;;$i++)
        {
            if($conversationId_[$i] == '"')
            {
                $num++;
                if($num==4) {
                    break;
                }
                continue;
            }
            if($num == 3) 
            {
                $sum*=10;
                $sum+=($conversationId_[$i]-'0');
            }
        }
        return $sum;        
    }

    //node for where clause
    class whereNode
    {
        function __construct($field, $logicalOperator, $predicate)
        {
		$whereParameterList =
		array('type'=>'where', 'field'=>$field,
			'logicalOperator'=>$logicalOperator,
			'predicate'=>$predicate, 'data_encounter'=>'No',
			'cid'=>$conversationId);
		$query = http_build_query($whereParameterList);
		$response = 
		file_get_contents(IRCT_WHERE_QUERY_URL . '?' . $query);
	}
    }

    class selectNode
    {
	function __construct($field, $alias)
	{
	    $selectParameterList = 
	    array('type'=>'select', 'field'=>$field,'alias'=>$alias,'cid'=>
	    $conversationId);
	    $query = http_build_query($selectParameterList);
	    $response = 
	    file_get_contents(IRCT_SELECT_QUERY_URL . '?' . $query);
	}
    }

    // run the full query and store the result Id
    $runQueryList = array('cid'=>$conversationId);
    $query = http_build_query($runQueryList);
    $response = file_get_contents(IRCT_RUN_QUERY_URL . '?' . $query);
    $resultId = strchr($response[0], "\"resultId\"");
    $resultId = chopToId($resultId);

    // retrieve results
    $response = file_get_contents(IRCT_GET_JSON_RESULTS_URL . '/' . $resultId);

    // pivot results
    $results = json_decode($response);
?>
