<?php
class M_subsrd_sa extends CI_Model {

    private $q_param = array();
    private $db_jasgir;
    function __construct()
    {                                     
        parent::__construct();           
        $this->db_jasgir = $this->load->database('dbjasgir',true);
    }
    
    function list_sa($c_enable)
    {
        $query=$this->db_jasgir->query("exec subsrd_list_sa {$c_enable}");
        $data=$query->result_array();
        return $data;
    }
    function list_sa_by_name($sa_name,$c_code)
    {
        $query=$this->db_jasgir->query("exec subsrd_list_sa_by_name '{$sa_name}','{$c_code}'");
        $data=$query->result_array();
        return $data;
    }
    function list_sa_by_client($c_code)
    {
        $query=$this->db_jasgir->query("exec subsrd_list_sa_by_client '{$c_code}'");
        $data=$query->result_array();
        return $data;
    }
    
    function add_sa($b_cname='',$b_code='',$b_enable=1,$user_id='')
    { //echo "exec [subsrd_add_sa] '{$b_cname}','{$b_code}','{$b_bankcode}',{$b_enable},'{$b_to}','{$b_up}','{$b_telp}','{$b_fax}','{$user_id}'";
        $query=$this->db_jasgir->query("exec [subsrd_add_sa] '{$b_cname}','{$b_code}',{$b_enable},'{$user_id}'");
        $data=$query->result_array();
        return $data;
    }
    function edit_sa($b_id=0,$b_cname='',$b_code='',$b_enable=1,$user_id='')
    { //echo "exec [subsrd_edit_sa] {$b_id},'{$b_cname}','{$b_code}','{$b_bankcode}',{$b_enable},'{$b_to}','{$b_up}','{$b_telp}','{$b_fax}','{$user_id}'";
        $query=$this->db_jasgir->query("exec [subsrd_edit_sa] {$b_id},'{$b_cname}','{$b_code}',{$b_enable},'{$user_id}'");
        $data=$query->result_array();
        return $data;
    }
    function enable_client($b_id=0,$b_ena=0,$user_id='')
    { ////echo "exec [subs_edit_client] {$b_id},'{$b_cname}','{$b_bname}','{$user_id}'";
        $query=$this->db_jasgir->query("exec [subs_enable_client] {$b_id},'{$b_ena}','{$user_id}'");
        $data=$query->result_array();
        return $data;
    }
    function get_sa($b_id='')
    { //echo "exec [add_trx] '{$c_code}','{$c_no}','{$c_dt}','{$c_catcode}','{$c_catdesc}','{$c_desc}','{$c_dc}',{$c_nominal},'{$user_id}'";
        $query=$this->db_jasgir->query("exec [subsrd_get_sa] {$b_id}");
        $data=$query->result_array();
        return $data;
    }
    
    
}
?>