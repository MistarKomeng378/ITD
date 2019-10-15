<?php
class M_mutasi_coa extends CI_Model {

    private $q_param = array();
    private $db_itd;
    private $db_jasgir;
    function __construct()
    {                                     
        parent::__construct();           
        $this->db_itd = $this->load->database('default',true);
        $this->db_jasgir = $this->load->database('dbjasgir',true);
    }
    function get_login_info($user,$pass)
    {                                                                                
        $query=$this->db->query("exec get_user_info '{$user}','" . md5($pass) . "'");
        $data=$query->result_array();
        return $data;
    }
    function get_coa($c_no='')
    {
        $query=$this->db_jasgir->query("exec get_coa {$c_no}");
        $data=$query->result_array();
        return $data;
    }
    
    function save_coa($coa_no='',$coa_desc='',$coa_dc='',$coa_enable=1,$coa_order=1000,$user_id='')
    { //echo "exec [save_coa] '{$coa_no}','{$coa_desc}','{$coa_dc}',{$coa_enable},{$coa_order},'{$user_id}'";
        $query=$this->db_jasgir->query("exec [save_coa] '{$coa_no}','{$coa_desc}','{$coa_dc}',{$coa_enable},{$coa_order},'{$user_id}'");
        $data=$query->result_array();
        return $data;
    }
    
}
?>