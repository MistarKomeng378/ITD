<?php
class M_itd_save extends CI_Model {

    private $q_param = array();

    function __construct()
    {                                     
        parent::__construct();           
        $this->load->database('default');
        $this->db_jasgir = $this->load->database('dbjasgir',true);
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

    function PenempatanToMutasi($unapprove_id)
    {
        $coa = $this->db_jasgir->query(" SELECT * FROM coa WHERE coa_no = 'D002' ");
        $coa = $coa->result();
        
        $subsrd = $this->db->query("
            SELECT TOP (1)
                *
            FROM 
                itd_trx_approved
            WHERE
                trx_id_unapproved = '".$unapprove_id."'
                and trx_type = 1
        ");

        $mutasi_trx = '';
        foreach ($subsrd->result_array() as $key => $value) {

            $checkStatusMutasi = $this->get_last_balance_date(
                trim($value['trx_client_code']),
                trim($value['trx_acc_no']),
                $value['trx_valuta_date']->format('Y-m-d')
            );

            if( count($checkStatusMutasi) == 0 || $checkStatusMutasi[0]['curr_status'] == 1 || $checkStatusMutasi[0]['curr_status'] == 0){
                $mutasi_trx = $this->db_jasgir->query("
                IF NOT EXISTS ( SELECT*FROM mutasi_trx WHERE client_code='".trim($value['trx_client_code'])."' AND trx_date='".$value['trx_valuta_date']->format('Y-m-d')."' AND coa_no='".$coa[0]->coa_no."' AND acc_no='".trim($value['trx_acc_no'])."' AND subsrd_id='".$value['trx_id']."' )
                BEGIN
                    INSERT INTO [dbo].[mutasi_trx] (
                        [client_code],
                        [acc_no],
                        [trx_date],
                        [coa_no],
                        [coa_desc],
                        [trx_desc],
                        [trx_dc],
                        [trx_nominal],
                        [created_by],
                        [created_dt],
                        [modified_by],
                        [modified_dt],
                        [trx_status],
                        [subsrd_id]
                    )VALUES(
                        '".trim($value['trx_client_code'])."',
                        '".trim($value['trx_acc_no'])."',
                        '".$value['trx_valuta_date']->format('Y-m-d')."',
                        '".$coa[0]->coa_no."',
                        '".$coa[0]->coa_desc."',
                        '".$value['trx_to']."',
                        '".$coa[0]->coa_dc."',
                        '".$value['trx_nominal']."',
                        '".$value['trx_create_by']."',
                        '".$value['trx_date']->format('Y-m-d H:i:s')."',
                        '".$this->session->userdata('itd_uid')."',
                        '".date('Y-m-d H:i:s')."',
                        1,
                        '".$value['trx_id']."'
                    );
                END
                ");
            }else{
                $p = trim($value['trx_client_code']).' - '.trim($value['trx_acc_no']).' - '.$value['trx_valuta_date']->format('Y-m-d');
                $mutasi_trx = array('msg' => 'Data Penempatan Gagal Masuk Kemutasi, Status Mutasi ini ( '.$p.' ) Bukan Open');
                return $mutasi_trx;
            }
        }

        $mutasi_trx = $mutasi_trx ? array('msg' => 'Data Penempatan berhasil masuk ke mutasi') : array('msg' => '');
        return $mutasi_trx;
    }

    function PencairanToMutasi($unapprove_id)
    {
        $coa = $this->db_jasgir->query(" SELECT * FROM coa WHERE coa_no = 'C003' ");
        $coa = $coa->result();
        
        $subsrd = $this->db->query("
            SELECT TOP (1)
                *
            FROM 
                itd_trx_approved
            WHERE
                trx_id_unapproved = '".$unapprove_id."'
                and trx_type = 3
        ");

        $mutasi_trx = '';
        foreach ($subsrd->result_array() as $key => $value) {
            
            $checkStatusMutasi = $this->get_last_balance_date(
                trim($value['trx_client_code']),
                trim($value['trx_acc_no']),
                $value['trx_date']->format('Y-m-d')
            );

            if( count($checkStatusMutasi) == 0 || $checkStatusMutasi[0]['curr_status'] == 1 || $checkStatusMutasi[0]['curr_status'] == 0){
                $mutasi_trx = $this->db_jasgir->query("
                IF NOT EXISTS ( SELECT*FROM mutasi_trx WHERE client_code='".trim($value['trx_client_code'])."' AND trx_date='".$value['trx_valuta_date']->format('Y-m-d')."' AND coa_no='".$coa[0]->coa_no."' AND acc_no='".trim($value['trx_acc_no'])."' AND subsrd_id='".$value['trx_id']."' )
                BEGIN
                    INSERT INTO [dbo].[mutasi_trx] (
                        [client_code],
                        [acc_no],
                        [trx_date],
                        [coa_no],
                        [coa_desc],
                        [trx_desc],
                        [trx_dc],
                        [trx_nominal],
                        [created_by],
                        [created_dt],
                        [modified_by],
                        [modified_dt],
                        [trx_status],
                        [subsrd_id]
                    )VALUES(
                        '".trim($value['trx_client_code'])."',
                        '".trim($value['trx_acc_no'])."',
                        '".$value['trx_date']->format('Y-m-d')."',
                        '".$coa[0]->coa_no."',
                        '".$coa[0]->coa_desc."',
                        '".$value['trx_to']."',
                        '".$coa[0]->coa_dc."',
                        '".$value['trx_nominal']."',
                        '".$value['trx_create_by']."',
                        '".$value['trx_date']->format('Y-m-d H:i:s')."',
                        '".$this->session->userdata('itd_uid')."',
                        '".date('Y-m-d H:i:s')."',
                        1,
                        '".$value['trx_id']."'
                    );
                END
                ");
            }else{
                $p = trim($value['trx_client_code']).' - '.trim($value['trx_acc_no']).' - '.$value['trx_date']->format('Y-m-d');
                $mutasi_trx = array('msg' => 'Data Pencairan Gagal Masuk Kemutasi, Status Mutasi ini ( '.$p.' ) Bukan Open');
                return $mutasi_trx;
            }
        }
        $mutasi_trx = $mutasi_trx ? array('msg' => 'Data Pencairan berhasil masuk ke mutasi') : array('msg' => '');
        return $mutasi_trx;
    }

    public function submit_edit_trx($user_id="",$param)
    {
        $trx_id         = $param['trx_id'];
        $acc_no         = $param['trx_acc_no'];
        $client_code    = $param['trx_c_code'];
        $coa            = $param['coa'];

        $updating = false;
        $cekMutasi = $this->CheckDataMutasi($trx_id, $acc_no, $client_code, $coa);

        // $trx_date = date('Y-m-d', strtotime($param["trx_dt"]));
        // $trx_date_valuta = date('Y-m-d', strtotime($param["trx_val_dt"]));
        $data = array('msg' => '');

        // Jika data pencairan / penempatan ada pada mutasi maka check status mutasi Open/tidak
        // Jika data mutasi open maka data bisa di hapus dan jika tidak open maka data tidak bisa di hapus
        // Jika data pencairan / penempatan tidak ada pada mutasi data bisa di hapus
        if(count( $cekMutasi ) > 0){

            $checkStatusMutasi = $this->get_last_balance_date(
                $cekMutasi[0]['client_code'],
                $cekMutasi[0]['acc_no'],
                $cekMutasi[0]['trx_date']->format('Y-m-d')
            );

            // jika data status mutasi 0 / data mutasi belum pernah di open / close mmaka data bisa di hapus
            if(count($checkStatusMutasi) == 0){
                $updating = true;
            }else{
                // jika data status mutasi = 1 / open maka data bisa dihapus
                // selain status = 1 / open data tidak bisa di hapus
                if($checkStatusMutasi[0]['curr_status'] == 1 || $checkStatusMutasi[0]['curr_status'] == 0 ){
                    $updating = true;
               
                }else{
                    $updating = false;
                    $data = array('msg' => 'Data mutasi status bukan open');
                }
            }

        }else{
            $updating = true;
        }


        if($updating){
            if($param["trx_type"] == 1){                
                $trx_date_edit = date('Y-m-d', strtotime($param["trx_val_dt"])); 
            }else{
                $trx_date_edit = date('Y-m-d', strtotime($param["trx_dt"]));
            }
            $query  = $this->db_jasgir->query("
                UPDATE [mutasi_trx] 
                    SET 
                        [client_code]   = '".$param["trx_c_code"]."',
                        [acc_no]        = '".$param["trx_acc_no"]."',
                        [trx_date]      =  '".$trx_date_edit."',
                        [trx_nominal]   = ".$param["trx_nominal"].",
                        [trx_desc]      = '".$param["trx_to"]."',
                        [modified_by]   = '".$this->session->userdata('itd_uid')."',
                        [modified_dt]   = '".date('Y-m-d H:i:s')."',
                        [trx_status]    = 1
                WHERE
                    [subsrd_id] = '".$param["trx_id"]."'
            ");
            $query  = $this->db->query(" select nfs_td from itd_trx_approved where trx_id='".$param["trx_id"]."' ");
            $nfd_td = $query->result_array();
            $nfd_td = count( $nfd_td[0]['nfs_td']);

            $query=$this->db->query("exec submit_edit_trx  
                {$nfd_td},
                {$param["trx_id"]},
                '{$user_id}',
                '{$param["trx_to"]}',
                '{$param["trx_remark1"]}',
                '{$param["trx_up"]}',
                '{$param["trx_telp"]}',
                '{$param["trx_fax"]}',
                '{$param["trx_dt"]}',
                '{$param["trx_client_id"]}',
                '{$param["trx_c_code"]}',
                '{$param["trx_c_name"]}',
                '{$param["trx_acc_no"]}',
                '{$param["trx_acc_name"]}',
                '{$param["trx_bank_name"]}',
                '{$param["trx_type"]}',
                '{$param["trx_dep_type"]}',
                '{$param["trx_val_dt"]}',
                '{$param["trx_due_dt"]}',
                '{$param["trx_tax_status"]}',
                '{$param["trx_pay_type"]}',
                {$param["trx_nominal"]},
                {$param["trx_rate"]},
                {$param["trx_due_type"]},
                '{$param["trx_other"]}',
                '{$param["trx_note"]}',
                '{$param["trx_break_dt"]}',
                '{$param["trx_curr"]}',
                '{$param["trx_mov_bil"]}',
                '{$param["bank_rek"]}',
                '{$param["bank_rek_name"]}',
                '{$param["pic_pid"]}',
                '{$param["trx_rbreak"]}'
            ");
            $data   = $query->result_array();
            $data   = $query ? array('msg' => 'Data berhasil di Update') : array('msg' => 'Data gagal di Update');
        }

        return $data;
    }

    public function submit_cancel_trx($user_id="",$param)
    {
        $trx_id         = $param['trx_id'];
        $acc_no         = $param['acc_no'];
        $client_code    = $param['client_code'];
        $coa            = $param['coa'];
        $trx_note       = $param['trx_note'];
        $trx_unix_no    = $param['trx_unix_no'];

        $deleting = false;
        $cekMutasi = $this->CheckDataMutasi($trx_id, $acc_no, $client_code, $coa);
        $data = array('msg' => '');
        // Jika data pencairan / penempatan ada pada mutasi maka check status mutasi Open/tidak
        // Jika data mutasi open maka data bisa di hapus dan jika tidak open maka data tidak bisa di hapus
        // Jika data pencairan / penempatan tidak ada pada mutasi data bisa di hapus
        if(count( $cekMutasi ) > 0){

            $checkStatusMutasi = $this->get_last_balance_date(
                $cekMutasi[0]['client_code'],
                $cekMutasi[0]['acc_no'],
                $cekMutasi[0]['trx_date']->format('Y-m-d')
            );

            // echo json_encode($checkStatusMutasi);
            // die();
            // jika data status mutasi 0 / data mutasi belum pernah di open / close mmaka data bisa di hapus
            if(count($checkStatusMutasi) == 0){
                $deleting = true;
            }else{
                // jika data status mutasi = 1 / open maka data bisa dihapus
                // selain status = 1 / open data tidak bisa di hapus
                if($checkStatusMutasi[0]['curr_status'] == 1 || $checkStatusMutasi[0]['curr_status'] == 0 ){
                    $deleting = true;
               
                }else{
                    $deleting = false;
                    $data = array('msg' => 'Data mutasi status bukan open');
                }
            }


        }else{
            $deleting = true;
        }

        if($deleting){
            $query  = $this->db_jasgir->query("
                DELETE FROM mutasi_trx 
                WHERE 
                    subsrd_id = '".$trx_id."' and 
                    client_code = '".$client_code."' and 
                    acc_no = '".$acc_no."' and 
                    coa_no ='".$coa."' 
            ");
            $query  = $this->db->query("exec submit_cancel_trx '{$user_id}','{$trx_id}','{$trx_note}'");

            // oleh kurob -- hard reset
            // hapus dari tabel itd_trx_approved
            // untuk kebutuhan data deposito jatuh tempo
            if ($trx_unix_no == 1) {
                $this->db->query("DELETE FROM itd_trx_unapproved WHERE trx_id = '".$trx_id."' ");
                $data = $query->result_array();
                $data = $query ? array('msg' => 'Data berhasil di hapus') : array('msg' => 'Data gagal di hapus');
            }

            if ($trx_unix_no == 2) {
                $this->db->query("DELETE FROM itd_trx_approved WHERE trx_id = '".$trx_id."' ");
                $data   = $query->result_array();
                $data = $query ? array('msg' => 'Data berhasil di hapus') : array('msg' => 'Data gagal di hapus');
            }
            
        }

        return $data;
    }

    public function CheckDataMutasi($trx_id, $acc_no, $client_code, $coa)
    {
        $data = $this->db_jasgir->query(" 
            SELECT * FROM mutasi_trx 
            WHERE subsrd_id = '".$trx_id."' and 
                client_code = '".$client_code."' and 
                acc_no = '".$acc_no."' and 
                coa_no ='".$coa."' 
        ");
        return $data->result_array();
    }

    public function get_last_balance_date($client_code='',$acc_no='',$cdt='',$status=0)
    {
        $query=$this->db_jasgir->query("exec [get_last_balance_date] '{$client_code}','{$acc_no}','{$cdt}',{$status}");
        $data=$query->result_array();
        return $data;
    }

   
}
?>