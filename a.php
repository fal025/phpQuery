<?php
//<!-- set base url -->
    const IRCT_REST_BASE_URL = 'http://bd2k-picsure.hms.harvard.edu/';

//<!-- set rest url -->
	const IRCT_CL_SERVICE_URL = IRCT_REST_BASE_URL . 'IRCT-CL/rest/';

//<!-- set service urls -->
	const IRCT_RESOURCE_BASE_URL = IRCT_CL_SERVICE_URL . 'resourceService/';
	const IRCT_QUERY_BASE_URL = IRCT_CL_SERVICE_URL . 'queryRESTService/';
	const IRCT_RESULTS_BASE_URL = IRCT_CL_SERVICE_URL . 'resultService/';

//<!-- set list resources -->
	const IRCT_LIST_RESOURCE_URL = IRCT_RESOURCE_BASE_URL . 'resources';

//<!-- set query -->
	const IRCT_START_QUERY_URL = IRCT_QUERY_BASE_URL . 'startQuery';
	const IRCT_WHERE_QUERY_URL = IRCT_QUERY_BASE_URL . 'whereClause';
	const IRCT_RUN_QUERY_URL = IRCT_QUERY_BASE_URL . 'runQuery';

//<!-- add select clause -->
	const IRCT_SELECT_QUERY_URL = IRCT_QUERY_BASE_URL . 'selectClause';

//<!-- get results -->
	const IRCT_GET_JSON_RESULTS_URL = IRCT_RESULTS_BASE_URL . 'download/json';

//<!-- start a conversation -->
    $temp_response = file(IRCT_START_QUERY_URL);  //same as GET()
    var_dump($temp_response);
	//$response = json_decode($temp_response);  //decode the temp result
	//$response = file_get_contents(IRCT_START_QUERY_URL);
    $conversationId = strchr($temp_response[0],"\"cid\"");
    $conversationId = chopToId($conversationId);
    echo $conversationId;

//<!-- some constants for convenience -->
	const where_field = 'NHANES Public/Public Studies///NHANES/NHANES/demographics/RACE/white/';

//<!-- some list storages -->
	$whereParameterList = NULL;  //used as list storage for function where

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

	function where()
	{
		//$whereParameterList = list($this->type='where',
		//	$this->field=$where_field,
		//	$this->logicalOperator='AND',
		//	$this->predicate='CONTAINS',
		//	$this->'data-encounter'='NO',
		//	$this->cid=$conversationId);
		//$response = file_get_contents(IRCT_WHERE_QUERY_URL);
        echo $response;
    }
?>
