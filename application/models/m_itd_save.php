<?php
class M_itd_save extends CI_Model {

    private $q_param = array();

    function __construct()
    {                                     
        parent::__construct();           
        $this->load->database('default');
    }
    /*function save_client($user_id='',$client_id=0,$client_code='',$client_name='',$acc_no='',$acc_name='',$bank_name='',$acc_cif='')
    {
        $query=$this->db->query("exec save_client  '{$user_id}',{$client_id},'{$client_code}','{$client_name}','{$acc_no}','{$acc_name}','{$bank_name}','{$acc_cif}'");
    } */
    //update client has tax on 07/05/2013 by gw
    function save_client($user_id='',$client_id=0,$client_code='',$client_name='',$acc_no='',$acc_name='',$bank_name='',$acc_cif='',$h_tax=0,$g_code='')
    {
        $query=$this->db->query("exec save_client  '{$user_id}',{$client_id},'{$client_code}','{$client_name}','{$acc_no}','{$acc_name}','{$bank_name}','{$acc_cif}',{$h_tax},'{$g_code}'");
    }
    function submit_approve_client($user_id='',$client_id=0)
    {                                                                 
        $query=$this->db->query("exec submit_approve_client '{$user_id}',{$client_id}");
        $data=$query->result_array();
        return $data;
    }
    function save_pic($user_id='',$pic_id=0,$bank_name='',$bank_rek='',$bank_acc_name='',$pic_name='',$bank_telp='',$bank_fax='',$pic_remark1='',$pic_remark2='')
    {
        $query=$this->db->query("exec save_pic  '{$user_id}',{$pic_id},'{$bank_name}','{$bank_rek}','{$bank_acc_name}','{$pic_name}','{$bank_telp}','{$bank_fax}','{$pic_remark1}','{$pic_remark2}'");
    }
    function insert_user($user_id='',$user_name='',$user_pass='',$user_lvl=10,$user_active=1,$user_group=1)
    {    
        $query=$this->db->query("exec insert_user '{$user_id}','{$user_name}','{$user_pass}',{$user_lvl},{$user_group},{$user_active}");
    }
    function update_user($user_id='',$user_name='',$user_lvl=10,$user_active=1,$user_group=1,$user_lock=0)
    {    
        $query=$this->db->query("exec update_user '{$user_id}','{$user_name}',{$user_lvl},{$user_group},{$user_active},'{$user_lock}'");
    }
    function update_pass($user_id='',$pass='')
    {    
        $query=$this->db->query("exec update_pass '{$user_id}','{$pass}'");
    }
    function submit_new_trx($user_id="",$param)
    { 
        $query=$this->db->query("exec submit_new_trx '{$param["trx_to"]}','{$param["trx_remark1"]}','{$param["trx_up"]}',
        '{$param["trx_telp"]}','{$param["trx_fax"]}','{$param["trx_dt"]}','{$param["trx_client_id"]}','{$param["trx_c_code"]}',
        '{$param["trx_c_name"]}','{$param["trx_acc_no"]}','{$param["trx_acc_name"]}','{$param["trx_bank_name"]}','{$param["trx_type"]}',
        '{$param["trx_dep_type"]}','{$param["trx_val_dt"]}','{$param["trx_due_dt"]}','{$param["trx_tax_status"]}','{$param["trx_pay_type"]}',
        {$param["trx_nominal"]},{$param["trx_rate"]},{$param["trx_due_type"]},'{$user_id}','{$param["trx_other"]}','{$param["trx_break_dt"]}',
        '{$param["trx_curr"]}',{$param["trx_id_master"]},{$param["trx_id"]},'{$param["trx_mov_bil"]}','{$param["bank_rek"]}',
        '{$param["bank_rek_name"]}','{$param["pic_pid"]}','{$param["trx_rbreak"]}'");
        $data=$query->result_array();
        return $data;
    }
    function submit_edit_trx($user_id="",$param)
    {   
        /*echo "exec submit_edit_trx {$param["trx_id"]},'{$user_id}','{$param["trx_to"]}','{$param["trx_remark1"]}','{$param["trx_up"]}',
        '{$param["trx_telp"]}','{$param["trx_fax"]}','{$param["trx_dt"]}','{$param["trx_client_id"]}','{$param["trx_c_code"]}',
        '{$param["trx_c_name"]}','{$param["trx_acc_no"]}','{$param["trx_acc_name"]}','{$param["trx_bank_name"]}','{$param["trx_type"]}',
        '{$param["trx_dep_type"]}','{$param["trx_val_dt"]}','{$param["trx_due_dt"]}','{$param["trx_tax_status"]}','{$param["trx_pay_type"]}',
        {$param["trx_nominal"]},{$param["trx_rate"]},{$param["trx_due_type"]},'{$param["trx_other"]}','{$param["trx_note"]}','{$param["trx_break_dt"]}','{$param["trx_curr"]}','{$param["trx_mov_bil"]}'";
        return array();*/
        $query=$this->db->query("exec submit_edit_trx {$param["trx_id"]},'{$user_id}','{$param["trx_to"]}','{$param["trx_remark1"]}','{$param["trx_up"]}',
        '{$param["trx_telp"]}','{$param["trx_fax"]}','{$param["trx_dt"]}','{$param["trx_client_id"]}','{$param["trx_c_code"]}',
        '{$param["trx_c_name"]}','{$param["trx_acc_no"]}','{$param["trx_acc_name"]}','{$param["trx_bank_name"]}','{$param["trx_type"]}',
        '{$param["trx_dep_type"]}','{$param["trx_val_dt"]}','{$param["trx_due_dt"]}','{$param["trx_tax_status"]}','{$param["trx_pay_type"]}',
        {$param["trx_nominal"]},{$param["trx_rate"]},{$param["trx_due_type"]},'{$param["trx_other"]}','{$param["trx_note"]}',
        '{$param["trx_break_dt"]}','{$param["trx_curr"]}','{$param["trx_mov_bil"]}','{$param["bank_rek"]}','{$param["bank_rek_name"]}'
        ,'{$param["pic_pid"]}','{$param["trx_rbreak"]}'");
        $data=$query->result_array();
        return $data;
    }
    function submit_revise_trx($user_id="",$param)
    {
        $query=$this->db->query("exec submit_revise_trx '{$user_id}','{$param["trx_id"]}','{$param["trx_note"]}'");
    }
    function submit_approve_trx($user_id="",$trx_id="")
    {
        $query=$this->db->query("exec submit_approve_trx '{$user_id}','{$trx_id}'");
        $data=$query->result_array();
        return $data;
    }
    function submit_approve_trx1($user_id="",$user_pass="",$trx_id="")
    {
        $query=$this->db->query("exec submit_approve_trx1 '{$user_id}','" . md5($user_pass) . "','{$trx_id}'");
        $data=$query->result_array();
        return $data;
    }
    function submit_cancel_trx($user_id="",$trx_id="",$trx_note)
    {
        $query=$this->db->query("exec submit_cancel_trx '{$user_id}','{$trx_id}','{$trx_note}'");
        $data=$query->result_array();
        return $data;
    }
    function submit_trx_ticket_print($user_id="",$param)
    {
        $query=$this->db->query("exec set_print_f '{$user_id}','{$param["trx_code"]}','{$param["trx_cname"]}','{$param["trx_type"]}'
                ,'{$param["trx_type_other"]}','{$param["trx_bank"]}','{$param["trx_setdate"]}','{$param["trx_term"]}','{$param["trx_rate"]}','{$param["trx_year"]}'
                ,'{$param["trx_nominal"]}','{$param["trx_ref"]}','{$param["trx_rate_amount"]}','{$param["trx_tax"]}','{$param["trx_stamp_type"]}'
                ,'{$param["trx_stamp"]}','{$param["trx_stamp_amount"]}','{$param["trx_net"]}','{$param["trx_tid"]}','{$param["trx_note"]}','{$param["trx_taxamount"]}'");
    }
    function save_client_group($user_id='',$g_id='',$g_code='',$g_name='',$g_ena=1,$g_mail='',$g_mail_cc='')
    {
       $query=$this->db->query("exec save_client_group  '{$user_id}','{$g_id}','{$g_code}','{$g_name}','{$g_ena}','{$g_mail}','{$g_mail_cc}'");
    }

   
}
?>