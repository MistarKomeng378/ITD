<?php
class M_itd_nfs extends CI_Model {

    private $q_param = array();
    private $dbnfs;
    function __construct()
    {                                     
        parent::__construct();           
        $this->load->database('default');
        $this->dbnfs = $this->load->database('dbnfs',true);
    }
    function list_trx($trx_date,$user_id,$prevdays=3)
    {
        //echo "exec list_trx '{$trx_date}','{$user_id}'";
        $query=$this->db->query("exec gw_nfs_list_trx '{$trx_date}','{$user_id}',{$prevdays}");
        $data=$query->result_array();
        return $data;
    }
    function clear_tmp()
    {
        $query=$this->db->query("exec gw_nfs_clear_temp");
        //$data=$query->result_array();
        //return $data;
    }
    function insert_tmp($client_code,$transaction_status,$action_type,$input_type,$im_name,$fund_code,
                $fund_name,$placement_bank_code,$placement_bank_name,$branch_code,$branch_name,
                $placement_bank_security,$placement_bank_cash,$ccy,$principle ,
                $interest_rate,$placement_date,$maturity_date,$sharia_deposit ,
                $contact_person,$telephone_no,$fax_no,$reference_no,$parent_reference_no ,
                $description,$si_reference,$status,$approve,$checked,$pending,$reject_reason,$acct_no,$acct_name )
    {
        $this->db->query("exec gw_nfs_insert_temp '{$client_code}','{$transaction_status}','{$action_type}','{$input_type}','{$im_name}','{$fund_code}',
        '{$fund_name}','{$placement_bank_code}','{$placement_bank_name}','{$branch_code}','{$branch_name}',
        '{$placement_bank_security}','{$placement_bank_cash}','{$ccy}','{$principle}',
        '{$interest_rate}','{$placement_date}','{$maturity_date}','{$sharia_deposit }',
        '{$contact_person}','{$telephone_no}','{$fax_no}','{$reference_no}','{$parent_reference_no }',
        '{$description}','{$si_reference}','{$status}','{$approve}','{$checked}','{$pending}','{$reject_reason }','{$acct_no}','{$acct_name}'");   
        
    }
    function insert_rev_tmp($client_code,$transaction_status,$action_type,$input_type,$im_name,$fund_code,
                $fund_name,$placement_bank_code,$placement_bank_name,$branch_code,$branch_name,
                $placement_bank_security,$placement_bank_cash,$ccy,$principle ,
                $interest_rate,$placement_date,$maturity_date,$sharia_deposit ,
                $contact_person,$telephone_no,$fax_no,$reference_no,$parent_reference_no ,
                $description,$si_reference,$status,$approve,$checked,$pending,$reject_reason,$acct_no,$acct_name )
    {
        $this->db->query("exec gw_nfs_REV_insert_temp '{$client_code}','{$transaction_status}','{$action_type}','{$input_type}','{$im_name}','{$fund_code}',
        '{$fund_name}','{$placement_bank_code}','{$placement_bank_name}','{$branch_code}','{$branch_name}',
        '{$placement_bank_security}','{$placement_bank_cash}','{$ccy}','{$principle}',
        '{$interest_rate}','{$placement_date}','{$maturity_date}','{$sharia_deposit }',
        '{$contact_person}','{$telephone_no}','{$fax_no}','{$reference_no}','{$parent_reference_no }',
        '{$description}','{$si_reference}','{$status}','{$approve}','{$checked}','{$pending}','{$reject_reason }','{$acct_no}','{$acct_name}'");        
    }
    function down_trx($pdt)
    {
        $query=$this->dbnfs->query("select * from NFS_TD_INS_INQ_TEMP where INPUT_TYPE='{$pdt}'");
        $data=$query->result_array();
        return $data;
    }
    function down_trx_rev($pdt)
    {
        $query=$this->dbnfs->query("select * from NFS_TD_REV_INQ_TEMP where INPUT_date>='{$pdt}'");
        $data=$query->result_array();
        return $data;
    }
    function move_tmp($uid)
    {
        $query=$this->db->query("exec gw_nfs_move_temp '{$uid}'");
        //$data=$query->result_array();
        //return $data;
    }
    function move_rev_tmp($uid)
    {
        $query=$this->db->query("exec gw_nfs_rev_move_temp '{$uid}'");
        //$data=$query->result_array();
        //return $data;
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
}
?>
