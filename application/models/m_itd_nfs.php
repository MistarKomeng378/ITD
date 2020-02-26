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
        $description,$si_reference,$status,$approve,$checked,$pending,$reject_reason,$acct_no,$acct_name,
        $WITHDRAWAL_DATE, $NEW_PRINCIPLE_AMOUNT, $NEW_INTEREST_RATE, $NEW_MATURITY_DATE, $ROLLOVER_DATE, 
        $ADJUSTMENT_INTEREST_RATE
    )
    {
        $this->db->query("exec gw_nfs_insert_temp '{$client_code}','{$transaction_status}','{$action_type}','{$input_type}','{$im_name}','{$fund_code}',
            '{$fund_name}','{$placement_bank_code}','{$placement_bank_name}','{$branch_code}','{$branch_name}',
            '{$placement_bank_security}','{$placement_bank_cash}','{$ccy}','{$principle}',
            '{$interest_rate}','{$placement_date}','{$maturity_date}','{$sharia_deposit }',
            '{$contact_person}','{$telephone_no}','{$fax_no}','{$reference_no}','{$parent_reference_no }',
            '{$description}','{$si_reference}','{$status}','{$approve}','{$checked}','{$pending}','{$reject_reason }','{$acct_no}','{$acct_name}',
            '{$WITHDRAWAL_DATE}', '{$NEW_PRINCIPLE_AMOUNT}', '{$NEW_INTEREST_RATE}', '{$NEW_MATURITY_DATE}', '{$ROLLOVER_DATE}',
            '{$ADJUSTMENT_INTEREST_RATE}'
        ");   
        
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
                b.type_desc,
                a.trx_id,
                a.trx_valuta_date,
                a.trx_due_date,
                a.trx_client_code,
                a.trx_client_name,
                a.nfs_bank_code,
                a.trx_rate,
                a.trx_nominal,
                a.trx_to
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
        $data = $this->db->query(" 
            EXEC gw_list_pending_parent 
            '{$param['trx_valuta_date']}',
            '{$param['trx_due_date']}',
            '{$param['trx_client_code']}',
            '{$param['trx_rate']}',
            '{$nominal}',
            '{$param['branch_name']}'
        ");
        
        return $data->result_array();
    }

    public function pending_to_submit($param)
    {
        $unapprove = $this->db->query(" 
            SELECT 
                * 
            FROM
                itd_trx_unapproved b 
            WHERE
                b.trx_id_upper = '".$param['parent']."'
            ORDER BY
                trx_id ASC
        ");
        $unapprove = $unapprove->result_array();

        $approved = $this->db->query(" 
            SELECT 
                * 
            FROM
                itd_trx_approved b 
            WHERE
                b.trx_id_upper = '".$param['parent']."'
            ORDER BY
                trx_id ASC
        ");
        $approved = $approved->result_array();

        if (count($unapprove) > 0 ) {
            return 'Data parent sudah pernah dijadikan acuan intruksi deposito dengan status submitted';
        }
        if (count($approved) > 0) {
            return 'Data parent sudah pernah dijadikan acuan intruksi deposito dengan status approved';
        }

        $pending = $this->db->query(" 
            SELECT 
                * 
            FROM
                itd_trx_pending b 
            WHERE
                b.trx_id = '".$param['child']."'
            ORDER BY
                trx_id ASC
        ");
        $pending = $pending->result_array();
        
        $SQL = "";
        foreach ($pending as $key => $value) {
            $approved = $this->db->query(" 
                SELECT 
                    * 
                FROM
                    itd_trx_approved b 
                WHERE
                    b.trx_id = '".$param['parent']."'
                ORDER BY
                    trx_id ASC
            ");

            $approved = $approved->result_array();

            if( $approved[0]['trx_id_master'] == 0){
                $value['trx_id_master'] = $approved[0]['trx_id'] ;
            }else if( $approved[0]['trx_id_master'] > 0){
                $value['trx_id_master'] = $approved[0]['trx_id_master'] ;
            }

            // jika perpanjangan
            if( $value['trx_type'] == '2' ){
                $value['trx_nominal'] = $value['NEW_PRINCIPLE_AMOUNT'];
                $value['trx_rate'] = $value['NEW_INTEREST_RATE'];
                $value['trx_due_date'] = $value['NEW_MATURITY_DATE'];
                $value['trx_valuta_date'] = $value['ROLLOVER_DATE'];
            }
            
            if( $value['trx_type'] == '3' ){
                $value['trx_date'] = $value['trx_break_dt'];
            }

            $SQL = "INSERT INTO itd_trx_unapproved (
                trx_id_master, 
                trx_id_upper,
                trx_to,
                trx_remark1,
                trx_up,
                trx_from,
                trx_from_fax,
                trx_telp,
                trx_fax,
                trx_ref,
                trx_date,
                trx_client_id,
                trx_client_code,
                trx_client_name,
                trx_acc_no,
                trx_acc_name,
                trx_bank_name,
                trx_type,
                trx_deposit_type,
                trx_deposit_tenor,
                trx_deposit_tenor_hr,
                trx_deposit_tenor_bln,
                trx_valuta_date,
                trx_due_date,
                trx_tax_status,
                trx_rate_payment,
                trx_nominal,
                trx_rate,
                trx_due_date_type,
                trx_validation_key,
                trx_other,
                trx_revise_note,
                trx_break_dt,
                trx_curr,
                trx_create_dt,
                trx_create_by,
                trx_modified_dt,
                trx_progress_status,
                trx_progress_by,
                trx_bilyet_flag_no,
                bank_acc_no,
                bank_acc_name,
                pic_id,
                trx_rate_break,
                nfs_sino,
                nfs_trxstatus,
                nfs_trxtype,
                nfs_td,
                nfs_code,
                nfs_bank_code,
                nfs_refno,
                nfs_refno_parent,
                itd_kategori
                
            ) VALUES (
                '".$value['trx_id_master']."',
                '".$param['parent']."',
                '".$value['trx_to']."', 
                '".$value['trx_remark1']."', 
                '".$value['trx_up']."', 
                '".$value['trx_from']."', 
                '".$value['trx_from_fax']."', 
                '".$value['trx_telp']."', 
                '".$value['trx_fax']."', 
                '".$value['trx_ref']."', 
                '".$value['trx_date']->format('Y-m-d H:i:s')."', 
                '".$value['trx_client_id']."', 
                '".$value['trx_client_code']."', 
                '".$value['trx_client_name']."', 
                '".$value['trx_acc_no']."', 
                '".$value['trx_acc_name']."', 
                '".$value['trx_bank_name']."', 
                '".$value['trx_type']."', 
                '".$value['trx_deposit_type']."', 
                '".$value['trx_deposit_tenor']."', 
                '".$value['trx_deposit_tenor_hr']."', 
                '".$value['trx_deposit_tenor_bln']."', 
                '".$value['trx_valuta_date']->format('Y-m-d H:i:s')."', 
                '".$value['trx_due_date']->format('Y-m-d H:i:s')."', 
                '".$value['trx_tax_status']."', 
                '".$value['trx_rate_payment']."', 
                '".$value['trx_nominal']."', 
                '".$value['trx_rate']."', 
                '".$value['trx_due_date_type']."', 
                '".$value['trx_validation_key']."', 
                '".$value['trx_other']."', 
                '".$value['trx_revise_note']."', 
                '".$value['trx_break_dt']->format('Y-m-d H:i:s')."', 
                '".$value['trx_curr']."', 
                '".$value['trx_create_dt']->format('Y-m-d H:i:s')."', 
                '".$value['trx_create_by']."', 
                '".$value['trx_modified_dt']->format('Y-m-d H:i:s')."', 
                '".$value['trx_progress_status']."', 
                '".$value['trx_progress_by']."', 
                '".$value['trx_bilyet_flag_no']."', 
                '".$value['bank_acc_no']."', 
                '".$value['bank_acc_name']."', 
                '".$value['pic_id']."', 
                '".$value['trx_rate_break']."', 
                '".$value['nfs_sino']."', 
                '".$value['nfs_trxstatus']."', 
                '".$value['nfs_trxtype']."', 
                '".$value['nfs_td']."', 
                '".$value['nfs_code']."', 
                '".$value['nfs_bank_code']."', 
                '".$value['nfs_refno']."', 
                '".$value['nfs_refno_parent']."', 
                '".$value['itd_kategori']."'
            );";
        }
        $insert = $this->db->query($SQL);
        $delete = false;
        if($insert){
            $delete = $this->db->query("
                DELETE 
                    itd_trx_pending
                WHERE 
                    trx_id = '".$param['child']."'
            ");
        } 
        return $delete;
    }

    public function hapus_list_pending($param)
    {
        $unapprove = $this->db->query(" 
            DELETE FROM itd_trx_pending WHERE trx_id = '".$param['trx_id']."'
        ");

        if($unapprove){
            return 'Data berhasil dihapus.';
        }
        return 'Data gagal dihapus.';
    }
}
?>
