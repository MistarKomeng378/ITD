<?php
class M_subscript extends CI_Model {

    private $q_param = array();
    private $db_jasgir;
    function __construct()
    {                                     
        parent::__construct();           
        $this->db_jasgir = $this->load->database('dbjasgir',true);
    }
    
    function subs_list_bank_by_code($bank_code)
    {
        $query=$this->db_jasgir->query("exec [subs_list_bank_by_code] '{$bank_code}'");
        $data=$query->result_array();
        return $data;
    }
    function add_subs($b_ccode='',$b_code='',$b_accno='',$b_desc='',$b_dt='1900-01-01',$b_nominal=0,$user_id='')
    { //echo "exec [add_trx] '{$c_code}','{$c_no}','{$c_dt}','{$c_catcode}','{$c_catdesc}','{$c_desc}','{$c_dc}',{$c_nominal},'{$user_id}'";
        $query=$this->db_jasgir->query("exec [subs_add_pending] '{$b_ccode}','{$b_code}','{$b_accno}','{$b_desc}','{$b_dt}',{$b_nominal},'{$user_id}'");
        $data=$query->result_array();
        return $data;
    }
    function edit_subs($b_id=0,$b_ccode='',$b_code='',$b_accno='',$b_desc='',$b_dt='1900-01-01',$b_nominal=0,$user_id='')
    { //echo "exec [subs_edit_pending] {$b_id},'{$b_code}','{$b_accno}','{$b_desc}','{$b_dt}',{$b_nominal},'{$user_id}'";
        $query=$this->db_jasgir->query("exec [subs_edit_pending] {$b_id},'{$b_ccode}','{$b_code}','{$b_accno}','{$b_desc}','{$b_dt}',{$b_nominal},'{$user_id}'");
        $data=$query->result_array();
        return $data;
    }
    function buku_subs($b_id=0,$b_dt='1900-01-01',$user_id='')
    { //echo "exec [subs_edit_pending] {$b_id},'{$b_code}','{$b_accno}','{$b_desc}','{$b_dt}',{$b_nominal},'{$user_id}'";
        $query=$this->db_jasgir->query("exec [subs_buku_pending] {$b_id},'{$b_dt}','{$user_id}'");
        $data=$query->result_array();
        return $data;
    }
    function del_subs($b_id=0,$user_id='')
    { //echo "exec [subs_edit_pending] {$b_id},'{$b_code}','{$b_accno}','{$b_desc}','{$b_dt}',{$b_nominal},'{$user_id}'";
        $query=$this->db_jasgir->query("exec [subs_del_pending] {$b_id},'{$user_id}'");
        $data=$query->result_array();
        return $data;
    }
    function cancel_buku_subs($b_id=0,$user_id='')
    { //echo "exec [subs_edit_pending] {$b_id},'{$b_code}','{$b_accno}','{$b_desc}','{$b_dt}',{$b_nominal},'{$user_id}'";
        $query=$this->db_jasgir->query("exec [subs_cancel_buku_pending] {$b_id},'{$user_id}'");
        $data=$query->result_array();
        return $data;
    }
    function list_subs($b_ccode='',$b_code='',$b_accno='',$b_dt='1900-01-01')
    {
        $query=$this->db_jasgir->query("exec subs_list '{$b_ccode}','{$b_code}','{$b_accno}','{$b_dt}'");
        $data=$query->result_array();
        return $data;
    }
    function list_client()
    {
        $query=$this->db_jasgir->query("exec list_client");
        $data=$query->result_array();
        return $data;
    }
    function get_last_balance_subs($b_ccode='',$b_code='',$b_accno='')
    {
        $query=$this->db_jasgir->query("exec subs_get_balance '{$b_ccode}','{$b_code}','{$b_accno}'");
        $data=$query->result_array();
        return $data;
    }
    
    function list_subs_dt($b_ccode='',$b_code='',$b_accno='',$b_dt='1900-01-01')
    {
        $query=$this->db_jasgir->query("exec subs_list_dt '{$b_ccode}','{$b_code}','{$b_accno}','{$b_dt}'");
        $data=$query->result_array();
        return $data;
    }
    function get_balance_subs_dt($b_ccode='',$b_code='',$b_accno='',$b_dt='1900-01-01')
    { //echo "exec subs_get_balance_dt '{$b_ccode}','{$b_code}','{$b_accno}','{$b_dt}'";
        $query=$this->db_jasgir->query("exec subs_get_balance_dt '{$b_ccode}','{$b_code}','{$b_accno}','{$b_dt}'");
        $data=$query->result_array();
        return $data;
    }
    function get_prev_balance_subs_dt($b_ccode='',$b_code='',$b_accno='',$b_dt='1900-01-01')
    { //echo "exec subs_get_balance_dt '{$b_ccode}','{$b_code}','{$b_accno}','{$b_dt}'";
        $query=$this->db_jasgir->query("exec subs_get_prev_balance_dt '{$b_ccode}','{$b_code}','{$b_accno}','{$b_dt}'");
        $data=$query->result_array();
        return $data;
    }
    function get_total_pending_subs($b_ccode='',$b_code='',$b_accno='',$b_dt='1900-01-01')
    { //echo "exec subs_get_total_pending '{$b_ccode}','{$b_code}','{$b_accno}','{$b_dt}'";
        $query=$this->db_jasgir->query("exec [subs_get_total_pending] '{$b_ccode}','{$b_code}','{$b_accno}','{$b_dt}'");
        $data=$query->result_array();
        return $data;
    }
    function update_balance_subs($b_ccode='',$b_code='',$b_accno='',$b_pending=0,$b_hiport=0,$b_saldo=0,$b_dt='1900-01-01',$user_id='')
    { // echo "exec subs_update_balance '{$b_ccode}','{$b_code}','{$b_accno}',{$b_pending},{$b_hiport},{$b_saldo},'{$b_dt}','{$user_id}'";
        $query=$this->db_jasgir->query("exec subs_update_balance '{$b_ccode}','{$b_code}','{$b_accno}',{$b_pending},{$b_hiport},{$b_saldo},'{$b_dt}','{$user_id}'");
        $data=$query->result_array();
        return $data;
    }
}
?>