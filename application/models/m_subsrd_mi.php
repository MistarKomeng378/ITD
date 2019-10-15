<?php
class M_subsrd_mi extends CI_Model {

    private $q_param = array();
    private $db_jasgir;
    function __construct()
    {                                     
        parent::__construct();           
        $this->db_jasgir = $this->load->database('dbjasgir',true);
    }
    
    function list_mi()
    {
        $query=$this->db_jasgir->query("exec subsrd_list_mi");
        $data=$query->result_array();
        return $data;
    }
    
    function add_mi($b_ccode='',$b_cname='',$user_id='')
    { //echo "exec [add_trx] '{$c_code}','{$c_no}','{$c_dt}','{$c_catcode}','{$c_catdesc}','{$c_desc}','{$c_dc}',{$c_nominal},'{$user_id}'";
        $query=$this->db_jasgir->query("exec [subsrd_add_mi] '{$b_ccode}','{$b_cname}','{$user_id}'");
        $data=$query->result_array();
        return $data;
    }
    function edit_mi($b_ccode='',$b_cname='',$user_id='')
    { ////echo "exec [subs_edit_mi] {$b_id},'{$b_cname}','{$b_bname}','{$user_id}'";
        $query=$this->db_jasgir->query("exec [subsrd_edit_mi] '{$b_ccode}','{$b_cname}','{$user_id}'");
        $data=$query->result_array();
        return $data;
    }  
    function get_mi($b_id='')
    { //echo "exec [add_trx] '{$c_code}','{$c_no}','{$c_dt}','{$c_catcode}','{$c_catdesc}','{$c_desc}','{$c_dc}',{$c_nominal},'{$user_id}'";
        $query=$this->db_jasgir->query("exec [subsrd_get_mi] '{$b_id}'");
        $data=$query->result_array();
        return $data;
    }
    
         
}
?>