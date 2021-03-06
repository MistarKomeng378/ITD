<?php
class M_itd extends CI_Model {

    private $q_param = array();

    function __construct()
    {                                     
        parent::__construct();           
        $this->load->database('default');
    }
    function get_user_pass_parameter()
    {                                                                                
        $query=$this->db->query("exec get_user_pass_parameter");
        $data=$query->result_array();
        return $data;
    }
    function get_login_info($user,$pass)
    {                                                                                
        $query=$this->db->query("exec get_user_info '{$user}','" . md5($pass) . "'");
        $data=$query->result_array();
        return $data;
    }
    function set_user_info($user,$type,$nil_tiny=0,$nil_int=0,$nil_char='',$nil_date='1900-01-01')
    {                                                                                
        //$query=$this->db->query("exec get_user_info '{$user}','" . md5($pass) . "'");
        $query=$this->db->query("exec update_user_info '{$user}','{$type}',{$nil_tiny},{$nil_int},'{$nil_char}','{$nil_date}'");
        $data=$query->result_array();
        return $data;
    }
    function change_pass($user_id='',$user_pass='')
    {
        $query=$this->db->query("exec update_user_reset_pass '{$user_id}','".md5($user_pass)."'");
        $data=$query->result_array();
        return $data;
    }
    function list_unapproved($uid="")
    {
        $query=$this->db->query("select * from itd_tax_status");
        $data=$query->result_array();
        return $data;
    }
    function list_trx($trx_date,$user_id,$prevdays=7)
    {
        //echo "exec list_trx '{$trx_date}','{$user_id}'";
        $query=$this->db->query("exec list_trx '{$trx_date}','{$user_id}',{$prevdays}");
        $data=$query->result_array();
        return $data;
    }
    function list_user($u_unit=0)
    {
        $query=$this->db->query("exec list_user {$u_unit}");
        $data=$query->result_array();
        return $data;
    }
    function list_unit()
    {
        $query=$this->db->query("exec list_unit");
        $data=$query->result_array();
        return $data;
    }
    function list_pic($page=0,$size=0)
    {
        $query=$this->db->query("exec list_pic {$page},{$size}");
        $data=$query->result_array();
        return $data;
    }
    function list_pic_by_bank($bank_name)
    {
        $query=$this->db->query("exec list_pic_by_bank '{$bank_name}'");
        $data=$query->result_array();
        return $data;
    }
    function list_client($page=0,$size=0)
    {
        $query=$this->db->query("exec list_client {$page},{$size}");
        $data=$query->result_array();
        return $data;
    }       
    function list_client_by_code($client_code)
    {
        $query=$this->db->query("exec list_client_by_code '{$client_code}'");
        $data=$query->result_array();
        return $data;
    }
    function list_client_distinct($client_code)
    {
        $query=$this->db->query("exec list_client_distinct '{$client_code}'");
        $data=$query->result_array();
        return $data;
    }
    function get_client($client_id=0)
    {
        $query=$this->db->query("exec get_client {$client_id}");
        $data=$query->result_array();
        return $data;
    }
    function get_client_by_code($client_code)
    {
        $query=$this->db->query("exec get_client_by_code '{$client_code}'");
        $data=$query->result_array();
        return $data;
    }
    function search_client($client_code='',$client_name='')
    {
        $query=$this->db->query("exec search_client '{$client_code}','{$client_name}'");
        $data=$query->result_array();
        return $data;
    }
    function get_pic($pic_id=0)
    {
        $query=$this->db->query("exec get_pic {$pic_id}");
        $data=$query->result_array();
        return $data;
    }
    function search_pic($b_name='',$c_name='',$c_remark1='')
    {
        $query=$this->db->query("exec search_pic '{$b_name}','{$c_name}','{$c_remark1}'");
        $data=$query->result_array();
        return $data;
    }
    function get_user($user_id=0)
    {
        $query=$this->db->query("exec get_user {$user_id}");
        $data=$query->result_array();
        return $data;
    }
    function get_trx($user_id="",$trx_id=0,$trx_unix=1)
    {                 //echo "exec get_trx '{$user_id}',{$trx_id},{$trx_unix}";
        $query=$this->db->query("exec get_trx '{$user_id}',{$trx_id},{$trx_unix}");
        $data=$query->result_array();
        return $data;
    }
    function get_itd_print($user_id="",$trx_id=0,$trx_unix=1)
    {                 
        $itd_print = $this->db->query(" SELECT
                f1 AS trx_client_code,
                f2 AS trx_client_name,
                f3 AS trx_type,
                f5 AS trx_to,
                f6 AS trx_due_date,
                f7 AS trx_deposit_tenor_hr,
                f8 AS trx_rate_break,
                f8 AS trx_rate,
                replace(f10, ',', '') AS trx_nominal,
                f11 AS trx_ref,
                replace(f12, ',', '') AS ac_mount,
                f13 AS trx_tax_ticket,
                replace(f17, ',', '') AS bt_mount,
                f18 AS trx_id,
                f19 AS trx_other,
                replace(f20, ',', '') AS tax_mount
            FROM
                itd_print 
            WHERE
                f18 = '".$trx_id."' 
        ");
        if( count($itd_print->result_array()) > 0 ){
            $query = $itd_print;
        }else{
            $query = $this->db->query("exec get_trx '{$user_id}',{$trx_id},{$trx_unix}");
        }
        
        $data = $query->result_array();
        return $data;
    }
    function get_trx_print($user_id="",$trx_id=0)
    {                 
        $query=$this->db->query("exec get_trx_print '{$user_id}',{$trx_id}");
        $data=$query->result_array();
        return $data;
    }
    function get_trx_info($user_id="",$trx_id=0,$trx_unix=1)
    {                 //echo "exec get_trx '{$user_id}',{$trx_id},{$trx_unix}";
        $query=$this->db->query("exec get_trx_status '{$user_id}',{$trx_id},{$trx_unix}");
        $data=$query->result_array();
        return $data;
    }
    function get_trx_unapproved($trx_id=0)
    {
        $query=$this->db->query("exec get_trx_unapproved {$trx_id}");
        $data=$query->result_array();
        return $data;
    }
    function get_trx_approved($trx_id=0)
    {
        $query=$this->db->query("exec get_trx_approved {$trx_id}");
        $data=$query->result_array();
        return $data;
    }
    function search_trx_approved($trx_to='',$trx_ccode='',$trx_cname='',$trx_stype=0,$trx_ntype=0,$trx_nominal=0,$trx_sdate='01/01/1900',$trx_edate='01/01/1900',$user_id='',$trx_id=0, $status=0)
    {                        
        //echo "exec search_trx_approved '{$trx_to}','{$trx_ccode}','{$trx_cname}',{$trx_stype},{$trx_ntype},{$trx_nominal},'{$trx_sdate}','{$trx_edate}','{$user_id}'";
        $approved   = array();
        $unapproved = array();
        if ($status == 0 || $status == 2) {
            $approved  =   $this->db->query("exec search_trx_approved '{$trx_to}','{$trx_ccode}','{$trx_cname}','{$trx_stype}','{$trx_ntype}','{$trx_nominal}','{$trx_sdate}','{$trx_edate}','{$user_id}','{$trx_id}'");
            $approved  =   $approved->result_array();  
        }
        
        if ($status == 0 || $status == 1) {
            $unapproved  =   $this->db->query("exec search_trx_unapproved '{$trx_to}','{$trx_ccode}','{$trx_cname}','{$trx_stype}','{$trx_ntype}','{$trx_nominal}','{$trx_sdate}','{$trx_edate}','{$user_id}','{$trx_id}'");
            $unapproved  =   $unapproved->result_array(); 
        }

        $data = array_merge($unapproved,$approved);
        return $data;
    }
    function is_trx_editable($trx_id=0,$user_id="")
    {
        $query=$this->db->query("exec is_editable_trx {$trx_id},'{$user_id}'");
        $data=$query->result_array();
        return $data;
    }
    function get_trx_ticket_print($user_id="")
    {
        $query=$this->db->query("exec  get_print_f '{$user_id}'");
        $data=$query->result_array();
        return $data;
    }
    function list_client_group()
    {
        $query=$this->db->query("exec list_client_group");
        $data=$query->result_array();
        return $data;
    }
    function get_client_group($g_code)
    {
        $query=$this->db->query("exec get_client_group '{$g_code}'");
        $data=$query->result_array();
        return $data;
    }
}
?>