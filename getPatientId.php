/*
 * Name: Fangchen Li
 * Filename: getPatientId.php
 * Date: June 16th, 2016
 * Description: this file contains the functionality of query with BD2k center 
 * to get patients' Id with the given information and will return the patient id
 *
 */
<?php

    $List = new stdClass();

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
    class whereNode
    {
        private $type;
        private $field;
        private $logicalOperator;
        private $predicate;
        private $cid;
        
        __construct($type, $field, $logicalOperator, $predicate, $cid)
        {
            $this->type = $type;
            $this->field = $field;
            $this->logicalOperator = $logicalOperator;
            $this->predicate = $predicate;
            $this->cid = $cid;
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

    $runQueryList = list(conversationId);

    
