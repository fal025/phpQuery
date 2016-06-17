/*
 * Name: Fangchen Li
 * Filename: getPatientId.php
 * Date: June 16th, 2016
 * Description: this file contains the functionality of query with BD2k center 
 * to get patients' Id with the given information and will return the patient id
 *
 */
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

    //set a list for doing the search
    $List = new stdClass();

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

    //node for query clause
    class queryNode
    {

        private $type;
        private $field;
        private $alias;
        private $cid;

        __construct($type_, $field_, $alias_, $cid_)
        {
            $this->type = $type_;
            $this->field = $field_;
            $this->alias = $alias_;
            $this->cid = $cid_;
        }
    }

    //node for where clause
    class whereNode
    {
        private $type = 'where';
        private $field;
        private $logicalOperator;
        private $predicate;
        private $cid;
        
        __construct($field, $logicalOperator, $predicate, $cid)
        {
            $this->field = $field;
            $this->logicalOperator = $logicalOperator;
            $this->predicate = $predicate;
            $this->cid = $cid;
        }
        function where()
	    {
		    $whereParameterList = list($this->type,
		    $this->field=$where_field,
		    $this->logicalOperator,
		    $this->predicate,
		    'NO',
		    $this->cid=$conversationId);
		    $response = file_get_contents(IRCT_WHERE_QUERY_URL);
            echo $response;
        }
    }

    class queryList
    {
        private $list_where = array(NULL);
        private $list_select = array(NULL);
        private $length_where = 0;
        private $length_select = 0;

        /*
         * function name: add_select
         * description: add new node into the list
         * parameter:
         *  arg1 -- type -- the type you want to search
         *  can be selected
         *  arg2 -- field -- the field you want to find
         *  can only be an url
         *  arg3 -- the alias -- 
         */
        function add_select($type, $field, $alias, $cid)
        {
            $this->list_select[$length_select] = 
                new queryNode($type, $field, $alias, $cid);
            $this->length_select++;
        }

        /*
         * function name: add_where
         * description: add new node into the list
         * parameter:
         *  arg1 -- type -- the type you want to search
         *  can be selected
         *  arg2 -- field -- the field you want to find
         *  can only be an url
         *  arg3 -- the alias -- 
         */
        function add_where($type, $field, $logicalOperator, $predicate, $cid)
        {
            $this->list_where[$length_where] = 
                new whereNode($type, $field, $logicalOperator,
                    $predicate, $cid);
            $this->length_where++;
        }

        /*
         * function name : remove
         * description: remove the node and do the where
         *
         */
        function remove_where()
        {
            $list_where[$length_where]->where();
            unset(list_where[$length_where]);
            $length_where--;
        }

        /*
         * function name : remove
         * description: remove the node and do the where
         *
         */
        function remove_select()
        {
            $list_select[$length_select]->select();
            unset(list_select[$length_select]);
            $length_select--;
        }

        /*
         * function name: isEmpty_where
         * Description: to check if the where array is empty
         *
         */
        function isEmpty_where()
        {
            return !($length_where == 0);
        }

        /*
         * function name: isEmpty_where
         * Description: to check if the where array is empty
         *
         */
        function isEmpty_select()
        {
            return !($length_select == 0);
        }
        
    }

    settype($List, "queryList");

    //input should be take start here
    


    //the query starts here
    while(!($List->isEmpty_where()))
    {
        $List->remove_where();
    }
    while(!($List->isEmpty_select()))
    {
        $List->remove_select();
    }

    //<!-- start a conversation -->
    $temp_response = file(IRCT_START_QUERY_URL);  //same as GET()
    var_dump($temp_response);
	//$response = json_decode($temp_response);  //decode the temp result
	//$response = file_get_contents(IRCT_START_QUERY_URL);
    $conversationId = strchr($temp_response[0],"\"cid\"");
    $conversationId = chopToId($conversationId);
    echo $conversationId;


    $runQueryList = list(conversationId);

    
