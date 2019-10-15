<?php
class M_tc5 extends CI_Model {

    private $q_param = array();

    function __construct()
    {                                     
        parent::__construct();           
        $this->load->database('default');
    }
    function get_login_info($user,$pass)
    {                                                                                
        $query=$this->db->query("exec get_user_info '{$user}','" . md5($pass) . "'");
        $data=$query->result_array();
        return $data;
    }
    function list_unapproved($uid="")
    {
        $query=$this->db->query("select * from itd_tax_status");
        $data=$query->result_array();
        return $data;
    }
    function list_tc5($trx_date,$client_code="",$bnf_bank="",$bnf_name="")
    {
        //echo "exec list_trx '{$trx_date}','{$user_id}'";
        $query=$this->db->query("exec list_tc5 '{$trx_date}','{$client_code}','{$bnf_bank}','{$bnf_name}'");
       // echo "exec list_tc5 '{$trx_date}','{$client_code}','{$bnf_bank}','{$bnf_name}'";
        $data=$query->result_array();
        return $data;
    }
    function get_tc5($tc5_id,$trx_id,$trx_unix)
    {
        //echo "exec list_trx '{$trx_date}','{$user_id}'";
        $query=$this->db->query("exec get_tc5 '{$tc5_id}','{$trx_id}','{$trx_unix}'");
        $data=$query->result_array();
        return $data;
    }
    function save_tc5($param,$uid)
    {
        //echo "exec list_trx '{$trx_date}','{$user_id}'";
        $query=$this->db->query("exec update_tc5 {$param["unixno"]},{$param["tca5id"]},{$param["trxid"]},
                        '{$param["bnf_name"]}','{$param["bnf_rek"]}','{$param["bnf_bank"]}','{$param["src_rek"]}',
                        '{$param["msg1"]}','{$param["sender1"]}',{$param["charges"]},'{$uid}'");
        $data=$query->result_array();
        return $data;
    }
    
}
?>