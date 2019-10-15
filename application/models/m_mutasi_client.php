<?php
class M_mutasi_client extends CI_Model {

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
    function list_client_by_code($client_code)
    {
        $query=$this->db_jasgir->query("exec mutasi_list_client_by_code '{$client_code}'");
        $data=$query->result_array();
        return $data;
    }
    function list_client()
    {
        $query=$this->db_jasgir->query("exec list_client");
        $data=$query->result_array();
        return $data;
    }
    function get_client($c_id=0)
    {
        $query=$this->db_jasgir->query("exec get_client {$c_id}");
        $data=$query->result_array();
        return $data;
    }
    function add_client($c_code='',$c_name='',$acc_no='',$c_cif='',$c_cbest='',$user_id='',$c_user='',$c_bank='',$c_internal=1,$c_jasgir=1,$c_type=1)
    { //echo "exec [add_trx] '{$c_code}','{$c_no}','{$c_dt}','{$c_catcode}','{$c_catdesc}','{$c_desc}','{$c_dc}',{$c_nominal},'{$user_id}'";
        $query=$this->db_jasgir->query("exec [add_client] '{$c_code}','{$c_name}','{$acc_no}','{$c_cif}','{$c_cbest}','{$user_id}','{$c_user}','{$c_bank}',{$c_internal},{$c_jasgir},{$c_type}");
        $data=$query->result_array();
        return $data;
    }
    function edit_client($c_id=0,$c_code='',$c_name='',$acc_no='',$c_cif='',$c_cbest='',$user_id='',$c_user='',$c_bank='',$c_internal=1,$c_jasgir=1,$c_type=1)
    { //echo "exec [add_trx] '{$c_code}','{$c_no}','{$c_dt}','{$c_catcode}','{$c_catdesc}','{$c_desc}','{$c_dc}',{$c_nominal},'{$user_id}'";
        $query=$this->db_jasgir->query("exec [edit_client] {$c_id},'{$c_code}','{$c_name}','{$acc_no}','{$c_cif}','{$c_cbest}','{$user_id}','{$c_user}','{$c_bank}',{$c_internal},{$c_jasgir},{$c_type}");
        $data=$query->result_array();
        return $data;
    }
    function edit_rek_client($c_code1='',$acc_no1='',$c_code2='',$acc_no2='',$user_id='')
    {
        $query=$this->db_jasgir->query("exec [change_client_code_or_rek_mutasi] '{$c_code1}','{$acc_no1}','{$c_code2}','{$acc_no2}','{$user_id}'");
        $data=$query->result_array();
        return $data;
    }
    function search_client($c_code='',$c_name='',$acc_no='',$c_cif='',$c_cbest='',$c_user='')
    {
        $query=$this->db_jasgir->query("exec [search_client] '{$c_code}','{$c_name}','{$acc_no}','{$c_cif}','{$c_cbest}','{$c_user}'");
        $data=$query->result_array();
        return $data;
    }
}
?>