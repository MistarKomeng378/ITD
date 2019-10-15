<?php
class M_subsrd_bank extends CI_Model {

    private $q_param = array();
    private $db_jasgir;
    function __construct()
    {                                     
        parent::__construct();           
        $this->db_jasgir = $this->load->database('dbjasgir',true);
    }
    
    function list_bank()
    {
        $query=$this->db_jasgir->query("exec subsrd_list_bank");
        $data=$query->result_array();
        return $data;
    }
    
    function add_bank($b_ccode='',$b_cname='',$user_id='')
    { //echo "exec [add_trx] '{$c_code}','{$c_no}','{$c_dt}','{$c_catcode}','{$c_catdesc}','{$c_desc}','{$c_dc}',{$c_nominal},'{$user_id}'";
        $query=$this->db_jasgir->query("exec [subsrd_add_bank] '{$b_ccode}','{$b_cname}','{$user_id}'");
        $data=$query->result_array();
        return $data;
    }
    function edit_bank($b_ccode='',$b_cname='',$user_id='')
    {   //echo "exec [subsrd_edit_bank] '{$b_ccode}','{$b_cname}','{$b_rto}','{$b_rup}','{$b_rtelp}','{$b_rfax}','{$user_id}'";
        $query=$this->db_jasgir->query("exec [subsrd_edit_bank] '{$b_ccode}','{$b_cname}','{$user_id}'");
        $data=$query->result_array();
        return $data;
    }  
    function get_bank($b_id='')
    { //echo "exec [add_trx] '{$c_code}','{$c_no}','{$c_dt}','{$c_catcode}','{$c_catdesc}','{$c_desc}','{$c_dc}',{$c_nominal},'{$user_id}'";
        $query=$this->db_jasgir->query("exec [subsrd_get_bank] '{$b_id}'");
        $data=$query->result_array();
        return $data;
    }
    
         
}
?>