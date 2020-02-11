<?php
class M_itd_nfs extends CI_Model {

    private $q_param = array();
    private $dbnfs;
    function __construct()
    {                                     
        parent::__construct();           
        $this->load->database('default');
        $this->dbnfs = $this->load->database('dbnfs',true);
        $this->db_jasgir = $this->load->database('dbjasgir',true);
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
        $this->db->query("exec gw_nfs_move_temp '{$uid}'");
        $this->db->query("exec gw_nfs_move_pending '{$uid}'");
        $this->db->query("exec gw_nfs_to_unapproved");
        
        // $query = $this->db->query("SELECT
        //         * 
        //     FROM
        //         itd_trx_approved 
        //     WHERE
        //         nfs_td = 1 
        //         AND trx_type <> 1 
        //         AND trx_id_upper <> 0 
        //         AND trx_valuta_date = '".$tanggal."'"
        // );
        // $data = $query->result_array();
        // $move_to_mutasi = $this->move_to_mutasi($data);
        // return $move_to_mutasi;
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

    public function list_pending()
    {
        $query=$this->db->query("
            SELECT
                b.type_desc,a.trx_id, a.trx_valuta_date,a.trx_due_date,a.trx_client_code,a.nfs_bank_code,a.trx_rate,a.trx_nominal
            FROM
                itd_trx_pending a
            LEFT JOIN itd_trx_type b on b.type_id = a.trx_type
        ");
        $data=$query->result_array();
        return $data;
    }

    public function list_pending_parent($param)
    {

        $nominal = str_replace( ',', '', $param['trx_nominal']);
        $id = $this->db->query(" 
            SELECT 
                trx_id 
            FROM
                itd_trx_approved b 
            WHERE
                b.nfs_td = 1 
                AND b.trx_id_upper = 0 
                AND b.trx_type = 1 
                AND b.trx_valuta_date = '".$param['trx_valuta_date']."' 
                AND b.trx_due_date = '".$param['trx_due_date']."' 
                AND b.trx_client_code = '".$param['trx_client_code']."' 
                AND b.nfs_bank_code = '".$param['nfs_bank_code']."' 
                AND b.trx_rate = '".$param['trx_rate']."' 
                AND b.trx_nominal = '".$nominal."'
            ORDER BY
                trx_id ASC
        ");
        $id = $id->result_array();
        $trx_id = '';
        foreach ($id as $key => $value) {
            $trx_id = $trx_id."'".$value['trx_id']."',";
        }
        $trx_id = rtrim($trx_id, ", ");

        $query=$this->db->query(" 
            SELECT
                b.type_desc, a.trx_id, a.trx_id_upper, a.trx_valuta_date,a.trx_due_date,a.trx_client_code,a.nfs_bank_code,a.trx_rate,a.trx_nominal
            FROM
                itd_trx_approved a
            LEFT JOIN itd_trx_type b on b.type_id = a.trx_type
            WHERE
                ( trx_id IN ( ".$trx_id." ) OR trx_id_upper IN ( ".$trx_id." ) ) AND a.trx_progress_status <> 11
            ORDER BY a.trx_id, a.trx_id_upper ASC;
        ");
        
        $data = $query->result_array();
        return $data;
    }

    public function pending_to_submit($param)
    {
        $pending = $this->db->query(" 
            SELECT 
                * 
            FROM
                itd_trx_pending b 
            WHERE
                b.trx_id = '".$param['child']."'
                trx_id ASC
        ");
        $pending = $pending->result_array();

        foreach ($pending as $key => $value) {
            $this->db->query(" 
                INSERT INTO itd_trx_unapproved (trx_id, trx_id_unaprroved) VALUES ('".$value['itd_trx']."','".$value['itd_trx_upper']."' );
            ");
        }
    }
}
?>
