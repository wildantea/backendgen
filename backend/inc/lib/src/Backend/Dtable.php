<?php
namespace Backend;
//error_reporting(0);
/**
 * Script:    DataTables PDO server-side script for PHP and MySQL
 * CopyLeft: March 2016 - wildantea, wildantea.com
 * Email : wildannudin@gmail.com
 **/
class DTable extends Database
{
    private $total_filtered;
    private $record_total;
    private $offset;
    private $data = array();
    private $request;
    private $search_request;
    private $is_numbering = 0;
    private $order_by="";
    private $group_by="";
    private $disable_search = array();
    private $callback = array();
    public $debug = 0;

    public $debug_sql="";

     function __construct($host,$port,$db_username,$db_password,$db_name)
    {
        parent::__construct($host,$port,$db_username,$db_password,$db_name);
    }

    //filter data
    public function getColumn($col)
    {
        $col = array_diff($col, $this->getDisableSearch());
        foreach ($col as $key) {
            $keys   = $key . " LIKE ?";
            $mark[] = $keys;
        }

        $im = implode(' OR  ', $mark);
        return $im;
    }

    public function getValue($col, $value)
    {
        $col = array_diff($col, $this->getDisableSearch());
        foreach ($col as $key) {
            $val      = '%' . $value . '%';
            $result[] = $val;
        }

        return $result;
    }


    public function resultData($sql,$prepare_data=null)
    {
        $result = $this->query($sql,$prepare_data);
        if ($this->getErrorMessage()!="") {
            $this->setCallback(array('error_data' => $this->getErrorMessage(),'query_detail_result' => $sql));
        } else {
           return $result;
        }



    }

    public function getBetween($content,$start,$end){
        $r = explode($start, $content);
        if (isset($r[1])){
            $r = explode($end, $r[1]);
            return 'from '.$r[0];
        }
            return '';
    }

    /**
     * exclude column searching datatable
     * @param array $data array column 
     */
    public function setDisableSearchColumn($data) {
        $this->disable_search = array($data);
    }
    public function getDisableSearch() {
       return $this->disable_search;
    }



    public function setTotalRecord($sql,$prepare_data=null)
    {

        if ($this->getGroupBy()!="") {
            $sql_for_counting = $this->getBetween($sql,'from','group by');
            $count_data = $this->fetchCustomSingle("select count(DISTINCT ".$this->getGroupBy().") as jml ".$sql_for_counting,$prepare_data);
            $data_count = $count_data->jml;
        } else {
            $sql_for_counting = stristr($sql, 'from');
            //$sql_for_counting = str_replace("having", "where", $sql_for_counting);
      
            $count_data = $this->fetchCustomSingle("select count(*) as jml ".$sql_for_counting,$prepare_data);
            $data_count = $count_data->jml;
        }

        if ($this->getErrorMessage()!="") {
            $this->setCallback(array('error_data' => $this->getErrorMessage(),'query_detail_total' => "select count(*) as jml ".$sql_for_counting));
        } else {
            //total filtered default
            $this->record_total = $data_count;
        }


    }


    public function setTotalFiltered($sql,$prepare_data=null)
    {
        if ($this->getGroupBy()!="") {
            $sql_for_counting = $this->getBetween($sql,'from','group by');
            $count_data = $this->fetchCustomSingle("select count(DISTINCT ".$this->getGroupBy().") as jml ".$sql_for_counting,$prepare_data);
            $data_count = $count_data->jml;
        } else {
            $sql_for_counting = stristr($sql, 'from');
            //$sql_for_counting = str_replace("having", "where", $sql_for_counting);
      
            $count_data = $this->fetchCustomSingle("select count(*) as jml ".$sql_for_counting,$prepare_data);
            $data_count = $count_data->jml;
        }

        if ($this->getErrorMessage()!="") {
            $this->setCallback(array('error_data' => $this->getErrorMessage(),'query_detail_filter' => "select count(*) as jml ".$sql_for_counting));
        } else {
            //total filtered default
            $this->total_filtered = $data_count;
        }


    }


    public function joinValue($search_value,$where_data=array())
    {

        if ($where_data!=null) {
            $where_data = array_values($where_data);
        } else {
            $where_data = array();
        }
        $res = array_merge($where_data,$search_value);
        return $res;
    }


    //create numbering column
    public function number($number)
    {
        $requestData   = $_REQUEST['start']+$number;
        return $requestData;

    }

    public function setNumberingStatus($status) {
         $this->is_numbering = $status;
    }

    public function get_numbering_status()
    {
        return $this->is_numbering;
    }

    public function setOrderBy($val)
    {
        $this->order_by = $val;
    }

    public function getOrderBy()
    {
        return $this->order_by;
    }

    public function setGroupBy($val)
    {
        $this->group_by = $val;
    }

    public function getGroupBy()
    {
        return $this->group_by;
    }


    //custom query datatable
    public function execQuery($sql, $columns,$prepare_data=array())
    {

        if ($prepare_data!==null) {
        $prepare_data=array_values($prepare_data);
        }

        //all data request
        $requestData   = $_REQUEST;
        $this->request = $requestData;


             $offset       = $requestData['start'];
             $offsets      = $offset ? $offset : 0;
             $this->offset = $offsets;




             if ($requestData['draw']==1) {
                $do_order = "ORDER BY ".$this->getOrderBy();

             } /*elseif ($requestData['start']>0) {

                 $do_order = $this->order_by;
                 $do_order_type = $this->order_type;
             } elseif ($requestData['start']==0 && $requestData['order'][0]['column']==0) {
                $do_order = $this->order_by;
                 $do_order_type = $this->order_type;
             }*/
              else {
                if ($this->is_numbering==true && $requestData['order'][0]['column']!=0) {
                    $do_order_by = "ORDER BY ".$columns[$requestData['order'][0]['column']-1];
                    $do_order_type = $requestData['order'][0]['dir'];
                } else {
                    $do_order_by = "ORDER BY ".$columns[$requestData['order'][0]['column']];
                    $do_order_type = $requestData['order'][0]['dir'];
                }

                $do_order = $do_order_by.' '.$do_order_type;

             }

            // $this->setCallback(array('do_order' =>$do_order,'order_type' => $do_order_type));
//echo $do_order;
        if (!empty($requestData['search']['value'])) {

            $this->search_request  = $requestData['search']['value'];


            $after_remove = preg_replace('#\((([^()]+|(?R))*)\)#', "", $sql);

            if (strpos(strtolower($after_remove), "where")) {
                $condition = "and";
            } elseif (strpos(strtolower($after_remove), "having")) {
                $condition = "and";
            } else {
                $condition = "where";
            }

              //get search value
            $search_value = $this->getValue($columns, $this->search_request);

            //join search with where data and extract where data value
            $join = $this->joinValue($search_value,$prepare_data);


            $sql = $sql;
            $sql .= " $condition (" . $this->getColumn($columns).")";

       /*     echo $sql;
            print_r($join);*/
            if ($this->group_by!="") {
                $sql .= " group by ".$this->getGroupBy()." ".$do_order;
            } else {
                $sql .= " ".$do_order;
            }
            
            //set total filtered
            $this->setTotalFiltered($sql,$join);
            
            if($requestData['length']<0) {
                $length = "";
            } else {
                $length = " LIMIT " . $requestData['start'].",".$requestData['length'];
            }
            $sql .= ' '.$length;

            $result = $this->resultData($sql,$join);

            if ($this->debug==1) {
                $this->setCallback(array('detail_sql_total' => $sql));
            }


        } else {

            if ($this->group_by!="") {
                $sql .= " group by ".$this->getGroupBy()." ".$do_order;
            } else {
                $sql .= " ".$do_order;
            }


            $this->setTotalRecord($sql,$prepare_data);

            $this->setTotalFiltered($sql,$prepare_data);

         /*   if ($orderBy!=$this->order_by && $orderByType!=$this->order_type) {

            }*/




            //$result = $sql;

            if($requestData['length']<0) {
                $length = "";
            } else {
                $length = " LIMIT " . $requestData['start'].",".$requestData['length'];
            }
            $sql .= $length;



            $result = $this->resultData($sql,$prepare_data);

            if ($this->debug==1) {
                $this->setCallback(array('detail_sql_total' => $sql));
            }

        }

        //$data = $this->table_data($result,$columns);
        //
        return $result;
    }

    public function setCallback($callback) {
        $this->callback = $callback;
    }
    public function getCallback() {
        return $this->callback;
    }

    public function set_debug($debug) {
        $this->debug = $debug;
    }

    public function setData($data)
    {
        $this->data = $data;
    }
    
    public function createData()
    {
        $data      = $this->data;
        $json_data = array(
            "draw" => intval($this->request['draw']),
            "recordsTotal" => intval($this->record_total),
            "recordsFiltered" => intval($this->total_filtered),
            "data" => $data // total data array
        );
        if (!empty($this->getCallback())) {
            $json_data = array_merge($this->getCallback(),$json_data); 
        }
        echo json_encode($json_data);
        // send data as json format
    }

}

?>