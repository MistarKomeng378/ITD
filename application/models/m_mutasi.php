<?php
class M_mutasi extends CI_Model {

    private $q_param = array();
    private $db_itd;
    private $db_jasgir;
    function __construct()
    {                                     
        parent::__construct();           
        $this->db_itd = $this->load->database('default',true);
        $this->db_jasgir = $this->load->database('dbjasgir',true);
        $this->db_urssim = $this->load->database('dburssim',true);
        $this->db_nfs = $this->load->database('dbnfs',true);
    }
    function get_login_info($user,$pass)
    {                                                                                
        $query=$this->db->query("exec get_user_info '{$user}','" . md5($pass) . "'");
        $data=$query->result_array();
        return $data;
    }
    function list_client_by_code($client_code)
    {
        //edit By MK
        //$query=$this->db_jasgir->query("exec mutasi_list_client_by_code '{$client_code}'");
        $query=$this->db_jasgir->query("exec mutasi_list_client_by_code_MK '{$client_code}'");
        $data=$query->result_array();
        return $data;
    }
    function list_client()
    {
        $query=$this->db_jasgir->query("exec list_client");
        $data=$query->result_array();
        return $data;
    }
    function list_client_by_code1($client_code)
    {
        $query=$this->db_itd->query("exec mutasi_list_client_by_code '{$client_code}'");
        $data=$query->result_array();
        return $data;
    }
    function list_coa()
    {
        $query=$this->db_jasgir->query("exec list_coa");
        $data=$query->result_array();
        return $data;
    }
    function list_cli()
    {
        $query=$this->db_jasgir->query("exec get_client_code");
        $data=$query->result_array();
        return $data;
    }
    function get_last_balance_date($client_code='',$acc_no='',$cdt='',$status=0)
    {
        $query=$this->db_jasgir->query("exec [get_last_balance_date] '{$client_code}','{$acc_no}','{$cdt}',{$status}");
        $data=$query->result_array();
        return $data;
    }
    function get_last_date_jasgir_by_user($user_id='')
    {                                                                                    
        $query=$this->db_jasgir->query("exec [get_last_date_jasgir_by_user] '{$user_id}'");
        $data=$query->result_array();
        return $data;
    }
    function list_trx($client_code='',$acc_no='',$dt='1900-01-01')
    { //echo "exec [list_trx] '{$client_code}','{$acc_no}','{$dt}'";
        $query=$this->db_jasgir->query("exec [list_trx] '{$client_code}','{$acc_no}','{$dt}'");
        $data=$query->result_array();
        return $data;
    }
    function get_balance($client_code='',$acc_no='',$dt='1900-01-01')
    { //echo "exec [get_balance] '{$client_code}','{$acc_no}','{$dt}'";
        $query=$this->db_jasgir->query("exec [get_balance] '{$client_code}','{$acc_no}','{$dt}'");
        $data=$query->result_array();
        return $data;
    }
    function add_trx($c_code='',$c_no='',$c_dt='1900-01-01',$c_catcode='',$c_catdesc='',$c_desc='',$c_dc='',$c_nominal=0,$user_id='')
    { //echo "exec [add_trx] '{$c_code}','{$c_no}','{$c_dt}','{$c_catcode}','{$c_catdesc}','{$c_desc}','{$c_dc}',{$c_nominal},'{$user_id}'";
        $query=$this->db_jasgir->query("exec [add_trx] '{$c_code}','{$c_no}','{$c_dt}','{$c_catcode}','{$c_catdesc}','{$c_desc}','{$c_dc}',{$c_nominal},'{$user_id}'");
        $data=$query->result_array();
        return $data;
    }
    function edit_trx($trx_id=0,$c_code='',$c_no='',$c_dt='1900-01-01',$c_catcode='',$c_catdesc='',$c_desc='',$c_dc='',$c_nominal=0,$user_id='')
    { //echo "exec [add_trx] '{$c_code}','{$c_no}','{$c_dt}','{$c_catcode}','{$c_catdesc}','{$c_desc}','{$c_dc}',{$c_nominal},'{$user_id}'";
        $query=$this->db_jasgir->query("exec [edit_trx] {$trx_id},'{$c_code}','{$c_no}','{$c_dt}','{$c_catcode}','{$c_catdesc}','{$c_desc}','{$c_dc}',{$c_nominal},'{$user_id}'");
        $data=$query->result_array();
        return $data;
    }
    function del_trx($trx_id=0,$user_id='')
    { //echo "exec [del_trx] {$trx_id},'{$user_id}'";
        $query=$this->db_jasgir->query("exec [del_trx] {$trx_id},'{$user_id}'");
        $data=$query->result_array();
        return $data;
    }
    function close_day($c_code='',$c_no='',$c_dt='1900-01-01',$gs_bal=0,$c_rem='',$user_id='')
    { //echo "exec [add_trx] '{$c_code}','{$c_no}','{$c_dt}','{$c_catcode}','{$c_catdesc}','{$c_desc}','{$c_dc}',{$c_nominal},'{$user_id}'";
        $query=$this->db_jasgir->query("exec [close_day] '{$c_code}','{$c_no}','{$c_dt}',{$gs_bal},'{$c_rem}','{$user_id}'");
        $data=$query->result_array();
        return $data;
    }
    function cancel_close_day($c_code='',$c_no='',$c_dt='1900-01-01',$user_id='')
    { //echo "exec [add_trx] '{$c_code}','{$c_no}','{$c_dt}','{$c_catcode}','{$c_catdesc}','{$c_desc}','{$c_dc}',{$c_nominal},'{$user_id}'";
        $query=$this->db_jasgir->query("exec [cancel_close_day] '{$c_code}','{$c_no}','{$c_dt}','{$user_id}'");
        $data=$query->result_array();
        return $data;
    }
    function check_last_balance($client_code='',$acc_no='',$dt='1900-01-01')
    { //echo "exec [open_day] '{$client_code}','{$client_name}','{$acc_no}','{$dt}','{$user_id}'";
        $query=$this->db_jasgir->query("exec [check_last_balance] '{$client_code}','{$acc_no}','{$dt}'");
        $data=$query->result_array();
        return $data;
    }
    function open_day($client_code='',$client_name='',$acc_no='',$dt='1900-01-01',$user_id='')
    { //echo "exec [open_day] '{$client_code}','{$client_name}','{$acc_no}','{$dt}','{$user_id}'";
        $query=$this->db_jasgir->query("exec [open_day] '{$client_code}','{$client_name}','{$acc_no}','{$dt}','{$user_id}'");
        $data=$query->result_array();
        return $data;
    }
    function del_client($client_id=0,$user_id='')
    { //echo "exec [add_trx] '{$c_code}','{$c_no}','{$c_dt}','{$c_catcode}','{$c_catdesc}','{$c_desc}','{$c_dc}',{$c_nominal},'{$user_id}'";
        $query=$this->db_jasgir->query("exec [del_client] {$client_id},'{$user_id}'");
        $data=$query->result_array();
        return $data;
    }
    function list_jasgirmon($f=0,$dt1='1900-01-01',$dt2='1900-01-01')
    { //echo "exec [add_trx] '{$c_code}','{$c_no}','{$c_dt}','{$c_catcode}','{$c_catdesc}','{$c_desc}','{$c_dc}',{$c_nominal},'{$user_id}'";
        $query=$this->db_jasgir->query("exec [list_jasgirmon] {$f},'{$dt1}','{$dt2}'");
        $data=$query->result_array();
        return $data;
    }
    function del_jasgirmon($giro_id=0,$user_id)
    { //echo "exec [add_trx] '{$c_code}','{$c_no}','{$c_dt}','{$c_catcode}','{$c_catdesc}','{$c_desc}','{$c_dc}',{$c_nominal},'{$user_id}'";
        $query=$this->db_jasgir->query("exec [del_jasgirmon] {$giro_id},'{$user_id}'");
        $data=$query->result_array();
        return $data;
    }
    function list_balance($dt1='1900-01-01',$dt2='1900-01-01',$proc="ALL",$cclient="All")
    { //echo "exec [add_trx] '{$c_code}','{$c_no}','{$c_dt}','{$c_catcode}','{$c_catdesc}','{$c_desc}','{$c_dc}',{$c_nominal},'{$user_id}'";
        $query=$this->db_jasgir->query("exec [list_balance] '{$dt1}','{$dt2}','{$proc}','{$cclient}'");
        $data=$query->result_array();
        return $data;
    }
    function get_rekening_mon($c_dt='1900-01-01')
    { //echo "exec [add_trx] '{$c_code}','{$c_no}','{$c_dt}','{$c_catcode}','{$c_catdesc}','{$c_desc}','{$c_dc}',{$c_nominal},'{$user_id}'";
        $query=$this->db_jasgir->query("exec [get_rekening_mon] '{$c_dt}'");
        $data=$query->result_array();
        return $data;
    }
    function get_client_id($c_code='',$c_no='')
    { //echo "exec [add_trx] '{$c_code}','{$c_no}','{$c_dt}','{$c_catcode}','{$c_catdesc}','{$c_desc}','{$c_dc}',{$c_nominal},'{$user_id}'";
        $query=$this->db_jasgir->query("exec [get_client_id] '{$c_code}','{$c_no}'");
        $data=$query->result_array();
        return $data;
    }
    function list_mutasi_taxbro($dt1='1900-01-01',$dt2='1900-01-01',$coa='',$cdoc=-1)
    { //echo "exec [add_trx] '{$c_code}','{$c_no}','{$c_dt}','{$c_catcode}','{$c_catdesc}','{$c_desc}','{$c_dc}',{$c_nominal},'{$user_id}'";
        $query=$this->db_jasgir->query("exec [list_mutasi_taxbro] '{$dt1}','{$dt2}','{$coa}',{$cdoc}");
        $data=$query->result_array();
        return $data;
    }
    function compare_balance($dt1='1900-01-01',$dt2='1900-01-01')
    { //echo "exec [add_trx] '{$c_code}','{$c_no}','{$c_dt}','{$c_catcode}','{$c_catdesc}','{$c_desc}','{$c_dc}',{$c_nominal},'{$user_id}'";
        $query=$this->db_jasgir->query("exec [get_selisih_dua_dt] '{$dt1}','{$dt2}'");
        $data=$query->result_array();
        return $data;
    }
    function set_permission($client_code='',$acc_no='',$dt='1900-01-01',$user_id)
    {// echo "exec [permit_open_edit] '{$client_code}','{$acc_no}','{$dt}','{$user_id}'";
        $query=$this->db_jasgir->query("exec [permit_open_edit] '{$client_code}','{$acc_no}','{$dt}','{$user_id}'");        
        //echo "exec [permit_open_edit] '{$client_code}','{$acc_no}','{$dt}','{$user_id}'";
    }
    function get_rekap_status($dt1='1900-01-01')
    {
        $query=$this->db_jasgir->query("exec get_mutasi_client_status '{$dt1}'");
        $data=$query->result_array();
        return $data;
    }
    function get_rekap_status_opened($dt1='1900-01-01')
    {
        $query=$this->db_jasgir->query("exec get_mutasi_client_status_opened '{$dt1}'");
        $data=$query->result_array();
        return $data;
    }
    function open_day_all($client_code='',$client_name,$user_id)
    { //echo "exec [open_day] '{$client_code}','{$client_name}','{$acc_no}','{$dt}','{$user_id}'";
        $query=$this->db_jasgir->query("exec open_day_all '{$client_code}','{$client_name}','{$user_id}'");        
        //echo "exec [permit_open_edit] '{$client_code}','{$acc_no}','{$dt}','{$user_id}'";
        $data=$query->result_array();
        return $data;
    }

    function SubscribeToMutasi($data)
    {
        $client_code = $data['client_code'];
        $date = date('Y-m-d', strtotime($data['date']) );
        $coa_id = $data['coa_id'];
        $acc_no = $data['acc_no'];

        $coa = $this->db_jasgir->query("
            SELECT 
                * 
            FROM 
                coa
            WHERE coa_no = '".$coa_id."'
        ");
        $coa = $coa->result();

        $subsrd = $this->db_jasgir->query("
            SELECT 
                * 
            FROM 
                subsrd
            WHERE client_code = '".$client_code."' and 
            subsrd_date = '".$date."' and 
            acc_no_src = '".$acc_no."'
        ");

        $mutasi_trx = false;

        $check_mutasi = $this->db_jasgir->query("
            SELECT 
                * 
            FROM 
                mutasi_trx
            WHERE client_code = '".$client_code."' and 
            trx_date = '".$date."' and
            coa_no = '".$coa_id."' and 
            acc_no = '".$acc_no."'
        ");
        
        if( count( $check_mutasi->result_array() ) == 0 ){
            foreach ($subsrd->result_array() as $key => $value) {

                $mutasi_trx = $this->db_jasgir->query("
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
                        [trx_status]
                    )VALUES(
                        '".$value['client_code']."',
                        '".$value['acc_no_src']."',
                        '".$value['subsrd_date']->format('Y-m-d H:i:s')."',
                        '".$value['subsrd_kategori']."',
                        '".$value['subsrd_desc']."',
                        '".$value['bank_src']."',
                        '".$coa[0]->coa_dc."',
                        '".$value['subsrd_nominal']."',
                        '".$value['modified_by']."',
                        '".$value['modified_dt']->format('Y-m-d H:i:s')."',
                        '".$value['modified_by']."',
                        '".$value['modified_dt']->format('Y-m-d H:i:s')."',
                        1
                    );
                ");

            }
        }
        return $mutasi_trx;
    }

    function PenempatanToMutasi($data)
    {
        $client_code = $data['client_code'];
        $date = date('Y-m-d', strtotime($data['date']) );
        $coa_id = $data['coa_id'];
        $acc_no = $data['acc_no'];

        $coa = $this->db_jasgir->query("
            SELECT 
                * 
            FROM 
                coa
            WHERE coa_no = '".$coa_id."'
        ");
        $coa = $coa->result();
        
        $subsrd = $this->db_itd->query("
            SELECT 
                *
            FROM 
                itd_trx_approved
            WHERE trx_client_code = '".$client_code."' and 
            trx_date = '".$date."' and
            trx_type = 1 and 
            trx_acc_no = '".$acc_no."'
        ");

        $mutasi_trx = false;
        $check_mutasi = $this->db_jasgir->query("
            SELECT 
                * 
            FROM 
                mutasi_trx
            WHERE client_code = '".$client_code."' and 
            trx_date = '".$date."' and
            coa_no = '".$coa[0]->coa_no."' and 
            acc_no = '".$acc_no."'
        ");
        if( count( $check_mutasi->result_array() ) == 0 ){
            foreach ($subsrd->result_array() as $key => $value) {
                
                $mutasi_trx = $this->db_jasgir->query("
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
                        [trx_status]
                    )VALUES(
                        '".$value['trx_client_code']."',
                        '".$value['trx_acc_no']."',
                        '".$value['trx_date']->format('Y-m-d H:i:s')."',
                        '".$coa[0]->coa_no."',
                        '".$coa[0]->coa_desc."',
                        '".$value['trx_to']."',
                        '".$coa[0]->coa_dc."',
                        '".$value['trx_nominal']."',
                        '".$value['trx_create_by']."',
                        '".$value['trx_create_dt']->format('Y-m-d H:i:s')."',
                        '".$value['trx_progress_by']."',
                        '".$value['trx_modified_dt']->format('Y-m-d H:i:s')."',
                        1
                    );
                ");

            }
        }
        return $mutasi_trx;
    }

    function PencairanToMutasi($data)
    {
        $client_code = $data['client_code'];
        $date = date('Y-m-d', strtotime($data['date']) );
        $coa_id = $data['coa_id'];
        $acc_no = $data['acc_no'];

        $coa = $this->db_jasgir->query("
            SELECT 
                * 
            FROM 
                coa
            WHERE coa_no = '".$coa_id."'
        ");
        $coa = $coa->result();
        
        $subsrd = $this->db_itd->query("
            SELECT 
                *
            FROM 
                itd_trx_approved
            WHERE trx_client_code = '".$client_code."' and 
            trx_date = '".$date."' and
            trx_type = 3 and 
            trx_acc_no = '".$acc_no."'
        ");

        $mutasi_trx = false;
        $check_mutasi = $this->db_jasgir->query("
            SELECT 
                * 
            FROM 
                mutasi_trx
            WHERE client_code = '".$client_code."' and 
            trx_date = '".$date."' and
            coa_no = '".$coa[0]->coa_no."' and 
            acc_no = '".$acc_no."'
        ");
        if( count( $check_mutasi->result_array() ) == 0 ){
            foreach ($subsrd->result_array() as $key => $value) {
                
                $mutasi_trx = $this->db_jasgir->query("
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
                        [trx_status]
                    )VALUES(
                        '".$value['trx_client_code']."',
                        '".$value['trx_acc_no']."',
                        '".$value['trx_date']->format('Y-m-d H:i:s')."',
                        '".$coa[0]->coa_no."',
                        '".$coa[0]->coa_desc."',
                        '".$value['trx_to']."',
                        '".$coa[0]->coa_dc."',
                        '".$value['trx_nominal']."',
                        '".$value['trx_create_by']."',
                        '".$value['trx_create_dt']->format('Y-m-d H:i:s')."',
                        '".$value['trx_progress_by']."',
                        '".$value['trx_modified_dt']->format('Y-m-d H:i:s')."',
                        1
                    );
                ");

            }
        }
        return $mutasi_trx;
    }

    function RedemptionToMutasi($data)
    {
        $client_code = $data['client_code'];
        $date = date('Y-m-d', strtotime($data['date']) );
        $coa_id = $data['coa_id'];
        $acc_no = $data['acc_no'];

        $coa = $this->db_jasgir->query("
            SELECT 
                * 
            FROM 
                coa
            WHERE coa_no = '".$coa_id."'
        ");
        $coa = $coa->result();
        
        $subsrd = $this->db_urssim->query("
            SELECT
                URSSIM.dbo.FUND_ID.CREATION_DATE AS CREATION_DATE,
                URSSIM.dbo.FUND_ID.MODIFICATION_DATE AS MODIFICATION_DATE,
                URSSIM.dbo.FUND_ID.MODIFIER AS MODIFIER,
                URSSIM.dbo.FUND_ID.CODE_BPM AS client_code,
                URSSIM.dbo.FUND_ID.ACC_BANK_OPR AS acc_no,
                URSSIM.dbo.TXN_POSTING.GOOD_FUND_DATE AS subsrd_date,
                URSSIM.dbo.TXN_POSTING.NET_PROCEED AS subsrd_nominal,
                'D001' AS subsrd_kategori,
                'Redemption' AS deskripsi 
            FROM
                URSSIM.dbo.TXN_POSTING
                INNER JOIN URSSIM.dbo.FUND_ID ON URSSIM.dbo.TXN_POSTING.FUND_LEVEL_CODE = URSSIM.dbo.FUND_ID.FUND_LEVEL_CODE 
                AND URSSIM.dbo.TXN_POSTING.FUND_UMBRELLA_CODE = URSSIM.dbo.FUND_ID.FUND_UMBRELLA_CODE 
                AND URSSIM.dbo.TXN_POSTING.FUND_GROUP = URSSIM.dbo.FUND_ID.FUND_GROUP 
                AND URSSIM.dbo.TXN_POSTING.FUND_ID = URSSIM.dbo.FUND_ID.FUND_ID 
            WHERE
                URSSIM.dbo.TXN_POSTING.TXN_TYPE = 'R' and
                URSSIM.dbo.TXN_POSTING.GOOD_FUND_DATE  = '".$date."' and 
                URSSIM.dbo.FUND_ID.ACC_BANK_OPR = '".$acc_no."' and 
                URSSIM.dbo.FUND_ID.CODE_BPM = '".$client_code."'
            ORDER BY
                subsrd_date DESC
        ");

        $mutasi_trx = false;
        $check_mutasi = $this->db_jasgir->query("
            SELECT 
                * 
            FROM 
                mutasi_trx
            WHERE client_code = '".$client_code."' and 
            trx_date = '".$date."' and
            coa_no = '".$coa[0]->coa_no."' and 
            acc_no = '".$acc_no."'
        ");
        if( count( $check_mutasi->result_array() ) == 0 ){
            foreach ($subsrd->result_array() as $key => $value) {
                
                $mutasi_trx = $this->db_jasgir->query("
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
                        [trx_status]
                    )VALUES(
                        '".$value['client_code']."',
                        '".$value['acc_no']."',
                        '".$value['subsrd_date']->format('Y-m-d H:i:s')."',
                        '".$coa[0]->coa_no."',
                        '".$coa[0]->coa_desc."',
                        '".$value['deskripsi']."',
                        '".$coa[0]->coa_dc."',
                        '".$value['subsrd_nominal']."',
                        '".$value['MODIFIER']."',
                        '".$value['CREATION_DATE']->format('Y-m-d H:i:s')."',
                        '".$value['MODIFIER']."',
                        '".$value['MODIFICATION_DATE']->format('Y-m-d H:i:s')."',
                        1
                    );
                ");

            }
        }
        return $mutasi_trx;
    }

    function JualSahamToMutasi($data)
    {
        $client_code = $data['client_code'];
        $date = date('Y-m-d', strtotime($data['date']) );
        $coa_id = $data['coa_id'];
        $acc_no = $data['acc_no'];

        $coa = $this->db_jasgir->query("
            SELECT 
                * 
            FROM 
                coa
            WHERE coa_no = '".$coa_id."'
        ");
        $coa = $coa->result();
        
        $subsrd = $this->db_nfs->query("
        SELECT
            A.HIPORT_CODE AS client_code,
            B.FUND_OPR_ACCT_NO AS acc_no,
            CONVERT ( DATE, A.TRADE_DATE ) AS subsrd_date,
            CONVERT ( DEC, A.NET_SETTLEMENT_AMOUNT ) AS subsrd_nominal,
            A.MODIFIER,
            A.CREATION_DATE,
            A.MODIFICATION_DATE,
            'C006' AS subsrd_kategori,
            'Jual Saham / Obligasi' AS deskripsi
        FROM
            NFS_DB.dbo.NFS_INQ_EQUITY_TEMP A
            INNER JOIN  NFS_DB.dbo.FUND_DETAILS B on B.HIPORT_CODE = A.HIPORT_CODE
        WHERE
            A.BUY_SELL = '2' and
            A.HIPORT_CODE = '".$client_code."' and 
            CONVERT ( DATE, A.TRADE_DATE ) = '".$date."' and
            B.FUND_OPR_ACCT_NO = '".$acc_no."'
        ORDER BY
            subsrd_date DESC
        ");

        $mutasi_trx = false;
        $check_mutasi = $this->db_jasgir->query("
            SELECT 
                * 
            FROM 
                mutasi_trx
            WHERE client_code = '".$client_code."' and 
            trx_date = '".$date."' and
            coa_no = '".$coa[0]->coa_no."' and 
            acc_no = '".$acc_no."'
        ");
        if( count( $check_mutasi->result_array() ) == 0 ){
            foreach ($subsrd->result_array() as $key => $value) {
                
                $mutasi_trx = $this->db_jasgir->query("
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
                        [trx_status]
                    )VALUES(
                        '".$value['client_code']."',
                        '".$value['acc_no']."',
                        '".$value['subsrd_date']->format('Y-m-d H:i:s')."',
                        '".$coa[0]->coa_no."',
                        '".$coa[0]->coa_desc."',
                        '".$value['deskripsi']."',
                        '".$coa[0]->coa_dc."',
                        '".$value['subsrd_nominal']."',
                        '".$value['MODIFIER']."',
                        '".$value['CREATION_DATE']->format('Y-m-d H:i:s')."',
                        '".$value['MODIFIER']."',
                        '".$value['MODIFICATION_DATE']->format('Y-m-d H:i:s')."',
                        1
                    );
                ");

            }
        }
        return $mutasi_trx;
    }
    
    function BeliSahamToMutasi($data)
    {
        $client_code = $data['client_code'];
        $date = date('Y-m-d', strtotime($data['date']) );
        $coa_id = $data['coa_id'];
        $acc_no = $data['acc_no'];

        $coa = $this->db_jasgir->query("
            SELECT 
                * 
            FROM 
                coa
            WHERE coa_no = '".$coa_id."'
        ");
        $coa = $coa->result();
        
        $subsrd = $this->db_nfs->query("
        SELECT
            A.HIPORT_CODE AS client_code,
            B.FUND_OPR_ACCT_NO AS acc_no,
            CONVERT ( DATE, A.TRADE_DATE ) AS subsrd_date,
            CONVERT ( DEC, A.NET_SETTLEMENT_AMOUNT ) AS subsrd_nominal,
            A.MODIFIER,
            A.CREATION_DATE,
            A.MODIFICATION_DATE,
            'C007' AS subsrd_kategori,
            'Beli Saham / Obligasi' AS deskripsi 
        FROM
            NFS_DB.dbo.NFS_INQ_EQUITY_TEMP A
            INNER JOIN NFS_DB.dbo.FUND_DETAILS B ON B.HIPORT_CODE = A.HIPORT_CODE 
        WHERE
            A.BUY_SELL = '1'  and
            A.HIPORT_CODE = '".$client_code."' and 
            CONVERT ( DATE, A.TRADE_DATE ) = '".$date."' and
            B.FUND_OPR_ACCT_NO = '".$acc_no."'
        ORDER BY
            subsrd_date DESC
        ");

        $mutasi_trx = false;
        $check_mutasi = $this->db_jasgir->query("
            SELECT 
                * 
            FROM 
                mutasi_trx
            WHERE client_code = '".$client_code."' and 
            trx_date = '".$date."' and
            coa_no = '".$coa[0]->coa_no."' and 
            acc_no = '".$acc_no."'
        ");
        if( count( $check_mutasi->result_array() ) == 0 ){
            foreach ($subsrd->result_array() as $key => $value) {
                
                $mutasi_trx = $this->db_jasgir->query("
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
                        [trx_status]
                    )VALUES(
                        '".$value['client_code']."',
                        '".$value['acc_no']."',
                        '".$value['subsrd_date']->format('Y-m-d H:i:s')."',
                        '".$coa[0]->coa_no."',
                        '".$coa[0]->coa_desc."',
                        '".$value['deskripsi']."',
                        '".$coa[0]->coa_dc."',
                        '".$value['subsrd_nominal']."',
                        '".$value['MODIFIER']."',
                        '".$value['CREATION_DATE']->format('Y-m-d H:i:s')."',
                        '".$value['MODIFIER']."',
                        '".$value['MODIFICATION_DATE']->format('Y-m-d H:i:s')."',
                        1
                    );
                ");

            }
        }
        return $mutasi_trx;
    }

    function WhtCommisionToMutasi($data)
    {
        $client_code = $data['client_code'];
        $date = date('Y-m-d', strtotime($data['date']) );
        $coa_id = $data['coa_id'];
        $acc_no = $data['acc_no'];

        $coa = $this->db_jasgir->query("
            SELECT 
                * 
            FROM 
                coa
            WHERE coa_no = '".$coa_id."'
        ");
        $coa = $coa->result();
        
        $subsrd = $this->db_nfs->query("
            SELECT 
                A.HIPORT_CODE AS client_code,
                CONVERT ( DATE, A.TRADE_DATE ) AS subsrd_date,
                CONVERT ( DEC, A.WHT_COMMISION ) AS subsrd_nominal,
                A.MODIFIER,
                A.CREATION_DATE,
                A.MODIFICATION_DATE,
                'D016' AS subsrd_kategori,
                'Wht Commision' AS deskripsi,
                B.FUND_OPR_ACCT_NO AS acc_no 
            FROM
                NFS_DB.dbo.NFS_INQ_EQUITY_TEMP A
                INNER JOIN NFS_DB.dbo.FUND_DETAILS B ON B.HIPORT_CODE = A.HIPORT_CODE 
            WHERE
                CONVERT ( DEC, A.WHT_COMMISION ) > 0 
                AND A.HIPORT_CODE = '".$client_code."' 
                AND CONVERT ( DATE, A.TRADE_DATE ) = '".$date."' 
                AND B.FUND_OPR_ACCT_NO = '".$acc_no."' 
            ORDER BY
                subsrd_date DESC
        ");

        $mutasi_trx = false;
        $check_mutasi = $this->db_jasgir->query("
            SELECT 
                * 
            FROM 
                mutasi_trx
            WHERE client_code = '".$client_code."' and 
            trx_date = '".$date."' and
            coa_no = '".$coa[0]->coa_no."' and 
            acc_no = '".$acc_no."'
        ");
        if( count( $check_mutasi->result_array() ) == 0 ){
            foreach ($subsrd->result_array() as $key => $value) {
                
                $mutasi_trx = $this->db_jasgir->query("
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
                        [trx_status]
                    )VALUES(
                        '".$value['client_code']."',
                        '".$value['acc_no']."',
                        '".$value['subsrd_date']->format('Y-m-d H:i:s')."',
                        '".$coa[0]->coa_no."',
                        '".$coa[0]->coa_desc."',
                        '".$value['deskripsi']."',
                        '".$coa[0]->coa_dc."',
                        '".$value['subsrd_nominal']."',
                        '".$value['MODIFIER']."',
                        '".$value['CREATION_DATE']->format('Y-m-d H:i:s')."',
                        '".$value['MODIFIER']."',
                        '".$value['MODIFICATION_DATE']->format('Y-m-d H:i:s')."',
                        1
                    );
                ");

            }
        }
        return $mutasi_trx;
    }

    function TaxObligasiToMutasi($data)
    {
        $client_code = $data['client_code'];
        $date = date('Y-m-d', strtotime($data['date']) );
        $coa_id = $data['coa_id'];
        $acc_no = $data['acc_no'];

        $coa = $this->db_jasgir->query("
            SELECT 
                * 
            FROM 
                coa
            WHERE coa_no = '".$coa_id."'
        ");
        $coa = $coa->result();
        
        $subsrd = $this->db_nfs->query("
            SELECT
                * 
            FROM
            (
            SELECT
                A.HIPORT_CODE AS client_code,
                CONVERT ( DATE, A.TRADE_DATE ) AS subsrd_date,
                CONVERT ( DEC, A.CAPITAL_GAIN_TAX ) AS subsrd_nominal,
                A.MODIFIER,
                A.CREATION_DATE,
                A.MODIFICATION_DATE,
                'D017' AS subsrd_kategori,
                'Capital Gain Tax' AS deskripsi,
                B.FUND_OPR_ACCT_NO AS acc_no 
            FROM
                NFS_DB.dbo.NFS_FI_INS_INQ_TEMP A
                INNER JOIN NFS_DB.dbo.FUND_DETAILS B ON B.HIPORT_CODE = A.HIPORT_CODE 
            WHERE
                CONVERT ( DEC, A.CAPITAL_GAIN_TAX ) > 0 
                AND A.HIPORT_CODE = '".$client_code."' 
                AND CONVERT ( DATE, A.TRADE_DATE ) = '".$date."' 
                AND B.FUND_OPR_ACCT_NO = '".$acc_no."' 
            ) AS CAPITAL_GAIN_TAX

            UNION ALL

            SELECT
                * 
            FROM
            (
                SELECT
                    A.HIPORT_CODE AS client_code,
                    CONVERT ( DATE, A.TRADE_DATE ) AS subsrd_date,
                    CONVERT ( DEC, A.INTEREST_INCOME_TAX ) AS subsrd_nominal,
                    A.MODIFIER,
                    A.CREATION_DATE,
                    A.MODIFICATION_DATE,
                    'D017' AS subsrd_kategori,
                    'Interst Income Tax' AS deskripsi,
                    B.FUND_OPR_ACCT_NO AS acc_no 
                FROM
                    NFS_DB.dbo.NFS_FI_INS_INQ_TEMP A
                    INNER JOIN NFS_DB.dbo.FUND_DETAILS B ON B.HIPORT_CODE = A.HIPORT_CODE 
                WHERE
                    CONVERT ( DEC, A.INTEREST_INCOME_TAX ) > 0 
                    AND A.HIPORT_CODE = '".$client_code."' 
                    AND CONVERT ( DATE, A.TRADE_DATE ) = '".$date."' 
                    AND B.FUND_OPR_ACCT_NO = '".$acc_no."' 
            ) AS INTEREST_INCOME_TAX
            
        ");

        $mutasi_trx = false;
        $check_mutasi = $this->db_jasgir->query("
            SELECT 
                * 
            FROM 
                mutasi_trx
            WHERE client_code = '".$client_code."' and 
            trx_date = '".$date."' and
            coa_no = '".$coa[0]->coa_no."' and 
            acc_no = '".$acc_no."'
        ");
        if( count( $check_mutasi->result_array() ) == 0 ){
            foreach ($subsrd->result_array() as $key => $value) {
                
                $mutasi_trx = $this->db_jasgir->query("
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
                        [trx_status]
                    )VALUES(
                        '".$value['client_code']."',
                        '".$value['acc_no']."',
                        '".$value['subsrd_date']->format('Y-m-d H:i:s')."',
                        '".$coa[0]->coa_no."',
                        '".$coa[0]->coa_desc."',
                        '".$value['deskripsi']."',
                        '".$coa[0]->coa_dc."',
                        '".$value['subsrd_nominal']."',
                        '".$value['MODIFIER']."',
                        '".$value['CREATION_DATE']->format('Y-m-d H:i:s')."',
                        '".$value['MODIFIER']."',
                        '".$value['MODIFICATION_DATE']->format('Y-m-d H:i:s')."',
                        1
                    );
                ");

            }
        }
        return $mutasi_trx;
    }

    function CheckMutasiClient($client_code)
    {
        $query = $this->db_jasgir->query("
            SELECT * FROM mutasi_client WHERE client_code LIKE '%".$client_code."%' and client_enable = 1
        ");

        if ( count( $query->result() ) > 0)
        {
            return true;
        }

        return false;
    }

    function MutasiClientAccNo($client_code)
    {
        $query = $this->db_jasgir->query("
            SELECT acc_no FROM mutasi_client WHERE client_code LIKE '%".$client_code."%' and client_enable = 1
        ");

        $return = '';
        if ( count( $query->result_array() ) > 0)
        {
            foreach ($query->result_array() as $key => $value) {
                $return = $return."'".$value['acc_no']."',";
            }
        }

        return rtrim($return, ", ");
    }

    function MutasiClient($client_code, $accc_no)
    {
        $query = $this->db_jasgir->query("
            SELECT 
                client_name,
                kena_jasgir,
                client_enable,
                bank_name
            FROM mutasi_client 
            WHERE 
                client_code LIKE '%".$client_code."%' 
                and acc_no = '".$accc_no."'
                and client_enable = '1'
        ");

        if ( count( $query->result_array() ) > 0)
        {   
            $data = $query->result_array();
            return $data[0];
        }

        return array(
            'client_name' => null,
            'kena_jasgir' => null,
            'client_enable' => null,
            'bank_name' => null
        );
    }

    function CoaDescription($coa_no)
    {
        $query = $this->db_jasgir->query("
            SELECT coa_desc FROM coa WHERE coa_no = '".$coa_no."'
        ");

        if ( count( $query->result() ) > 0)
        {
            $row = $query->row();
            return $row->coa_desc;
        }

        return NULL;
    }

    function ListClient($client_code)
    {
        $ListSubscribe = $this->ListSubscribe($client_code);
        $ListJasaGiro = $this->ListJasaGiro($client_code);
        $ListPenempatan = $this->ListPenempatan($client_code);
        $ListPencairan = $this->ListPencairan($client_code);
        $ListRedemption = $this->ListRedemption($client_code);
        $ListNfsJual = $this->ListNfsJual($client_code);
        $ListNfsBeli = $this->ListNfsBeli($client_code);
        $ListWhtCommision = $this->ListWhtCommision($client_code);
        $ListIGIncomeTax = $this->ListIGIncomeTax($client_code);

        return array_merge(
            $ListSubscribe, 
            $ListJasaGiro,
            $ListPenempatan,
            $ListPencairan,
            $ListRedemption,
            $ListNfsJual,
            $ListNfsBeli,
            $ListWhtCommision,
            $ListIGIncomeTax
        );

    }

    function ListSubscribe($client_code)
    {
        $return = array();
        if( $this->CheckMutasiClient($client_code) ){
            $query=$this->db_jasgir->query("
                SELECT TOP
                    ( 200 ) 'subsrd' AS src_dt,
                    a.client_code,
                    a.subsrd_date,
                    SUM ( a.subsrd_nominal ) AS subsrd_nominal,
                    a.acc_no_src AS acc_no ,
                    'C002' AS subsrd_kategori,
			        'Subscription' AS deskripsi
                FROM
                    subsrd a 
                WHERE
                    client_code like '%".$client_code."%' 
                    and a.acc_no_src in (".$this->MutasiClientAccNo($client_code).")
                GROUP BY
                    a.client_code,
                    a.subsrd_date,
                    a.acc_no_src 
                ORDER BY
                    a.subsrd_date DESC
            ");
            
            $data = $query->result_array();
            $merge = array();
            foreach ($data as $key => $value) {
                $coa_desc = $this->CoaDescription($value['subsrd_kategori']);
                array_push($merge, 
                    array_merge(
                        $value,
                        array('coa_desc'=>$coa_desc),
                        $this->MutasiClient($client_code, $value['acc_no'])
                    ) 
                );
            }
            $return = $merge;
        }
        
        return $return;
    }

    function ListJasaGiro($client_code)
    {
        $return = array();
        if( $this->CheckMutasiClient($client_code) ){
            $query=$this->db_jasgir->query("
                SELECT TOP
                    ( 200 ) 
                    'subsrd_jasgir' AS src_dt,
                    mutasi_giro.client_code,
                    mutasi_giro.giro_asof_date AS subsrd_date,
                    mutasi_giro.giro_nominal AS subsrd_nominal,
                    'C001' AS subsrd_kategori,
                    'Jasa Giro' AS deskripsi,
                    mutasi_giro.acc_no 
                FROM
                    mutasi_client AS mutasi_client_1
                    INNER JOIN mutasi_giro ON mutasi_giro.client_code = mutasi_client_1.client_code 
                    AND mutasi_client_1.acc_no = mutasi_giro.acc_no 
                WHERE
                    mutasi_client_1.kena_jasgir = '1' and
                    mutasi_client_1.client_enable = '1' and
                    mutasi_giro.client_code like '%".$client_code."%'
                GROUP BY
                    mutasi_giro.giro_nominal,
                    mutasi_giro.client_code,
                    mutasi_giro.giro_asof_date,
                    mutasi_giro.acc_no 
                ORDER BY
                    subsrd_date desc
            ");
            
            $data = $query->result_array();
            $merge = array();
            foreach ($data as $key => $value) {
                $coa_desc = $this->CoaDescription($value['subsrd_kategori']);
                array_push($merge, 
                    array_merge(
                        $value, 
                        array('coa_desc'=>$coa_desc),
                        $this->MutasiClient($client_code, $value['acc_no'])
                    ) 
                );
            }
            $return = $merge;
        }
        
        return $return;
    }

    function ListPenempatan($client_code)
    {
        $return = array();
        if( $this->CheckMutasiClient($client_code) ){
            $query=$this->db_itd->query("
                SELECT TOP
                    ( 200 )
                    'itd_Penempatan' AS src_dt,
                    trx_client_code AS client_code,
                    CONVERT ( DATE, trx_date ) AS subsrd_date,
                    trx_nominal AS subsrd_nominal,
                    'D002' AS subsrd_kategori,
                    trx_to AS deskripsi,
                    trx_acc_no AS acc_no
                FROM
                    itd_trx_approved 
                WHERE
                    trx_type = '1' and
                    trx_client_code like '%".$client_code."%' and 
                    trx_acc_no in (".$this->MutasiClientAccNo($client_code).")
                GROUP BY
                    trx_to,
                    itd_kategori,
                    trx_nominal,
                    trx_client_code,
                    trx_acc_no,
                    CONVERT ( DATE, trx_date )
                ORDER BY
                    subsrd_date DESC
            ");
            
            $data = $query->result_array();
            $merge = array();
            foreach ($data as $key => $value) {
                $coa_desc = $this->CoaDescription($value['subsrd_kategori']);
                array_push($merge, 
                    array_merge(
                        $value, 
                        array('coa_desc'=>$coa_desc),
                        $this->MutasiClient($client_code, $value['acc_no'])
                    ) 
                );
            }
            $return = $merge;
        }
        
        return $return;
    }

    function ListPencairan($client_code)
    {
        $return = array();
        if( $this->CheckMutasiClient($client_code) ){
            $query=$this->db_itd->query("
                SELECT TOP
                    ( 200 ) 'itd_Pencairan ' AS src_dt,
                    trx_client_code AS client_code,
                    CONVERT ( DATE, trx_date ) AS subsrd_date,
                    trx_nominal AS subsrd_nominal,
                    'C003' AS subsrd_kategori,
                    trx_to AS deskripsi,
                    trx_acc_no AS acc_no 
                FROM
                    itd_trx_approved AS itd_trx_approved_1 
                WHERE
                    trx_type = '3' and
                    trx_client_code like '%".$client_code."%' and 
                    trx_acc_no in (".$this->MutasiClientAccNo($client_code).")
                GROUP BY
                    trx_type,
                    trx_to,
                    itd_kategori,
                    trx_nominal,
                    trx_client_code,
                    trx_acc_no,
                    CONVERT ( DATE, trx_date ) 
                ORDER BY
                    subsrd_date DESC
            ");
            
            $data = $query->result_array();
            $merge = array();
            foreach ($data as $key => $value) {
                $coa_desc = $this->CoaDescription($value['subsrd_kategori']);
                array_push($merge, 
                    array_merge(
                        $value, 
                        array('coa_desc'=>$coa_desc),
                        $this->MutasiClient($client_code, $value['acc_no'])
                    ) 
                );
            }
            $return = $merge;
        }
        
        return $return;
    }

    function ListRedemption($client_code)
    {
        $return = array();
        if( $this->CheckMutasiClient($client_code) ){
            $query=$this->db_urssim->query("
                SELECT TOP
                    ( 200 ) 
                    'urssim' AS src_dt,
                    TXN_POSTING.TXN_TYPE,
                    FUND_ID.CODE_BPM AS client_code,
                    FUND_ID.ACC_BANK_OPR AS acc_no,
                    CONVERT ( DATE, TXN_POSTING.GOOD_FUND_DATE ) AS subsrd_date,
                    SUM ( TXN_POSTING.NET_PROCEED ) AS subsrd_nominal,
                    'D001' AS subsrd_kategori,
                    'Redemption' AS deskripsi 
                FROM
                    TXN_POSTING
                    INNER JOIN FUND_ID ON TXN_POSTING.FUND_LEVEL_CODE = FUND_ID.FUND_LEVEL_CODE 
                    AND TXN_POSTING.FUND_UMBRELLA_CODE = FUND_ID.FUND_UMBRELLA_CODE 
                    AND TXN_POSTING.FUND_GROUP = FUND_ID.FUND_GROUP 
                    AND TXN_POSTING.FUND_ID = FUND_ID.FUND_ID 
                WHERE
                    TXN_POSTING.TXN_TYPE = 'R' and
                    FUND_ID.CODE_BPM like '%".$client_code."%' and 
                    FUND_ID.ACC_BANK_OPR in (".$this->MutasiClientAccNo($client_code).")
                GROUP BY
                    TXN_POSTING.TXN_TYPE,
                    FUND_ID.CODE_BPM,
                    FUND_ID.ACC_BANK_OPR,
                    CONVERT ( DATE, TXN_POSTING.GOOD_FUND_DATE ) 
                ORDER BY
                    subsrd_date DESC
            ");
            
            $data = $query->result_array();
            $merge = array();
            foreach ($data as $key => $value) {
                $coa_desc = $this->CoaDescription($value['subsrd_kategori']);
                array_push($merge, 
                    array_merge(
                        $value, 
                        array('coa_desc'=>$coa_desc),
                        $this->MutasiClient($client_code, $value['acc_no'])
                    ) 
                );
            }
            $return = $merge;
        }
        
        return $return;
    }

    function ListNfsJual($client_code)
    {
        $return = array();
        if( $this->CheckMutasiClient($client_code) ){
            $query=$this->db_nfs->query("
                SELECT TOP
                    ( 200 ) 'nfs_jual' AS src_dt,
                    'C006' AS subsrd_kategori,
                    'Jual Saham / Obligasi' AS deskripsi,
                    CONVERT ( DATE, A.TRADE_DATE ) AS subsrd_date,
                    SUM ( CONVERT ( DEC, A.NET_SETTLEMENT_AMOUNT ) ) AS subsrd_nominal,
                    A.HIPORT_CODE AS client_code,
                    B.FUND_OPR_ACCT_NO AS acc_no 
                FROM
                    NFS_INQ_EQUITY_TEMP A
                    INNER JOIN FUND_DETAILS B ON B.HIPORT_CODE = A.HIPORT_CODE 
                    AND B.ACTIVE_STATUS = 1 
                WHERE
                    A.BUY_SELL = '2' 
                    AND A.HIPORT_CODE LIKE '%".$client_code."%'
                    AND B.FUND_OPR_ACCT_NO in (".$this->MutasiClientAccNo($client_code).")
                GROUP BY
                    B.FUND_OPR_ACCT_NO,
                    A.HIPORT_CODE,
                    CONVERT ( DATE, A.TRADE_DATE ) 
                ORDER BY
                    subsrd_date DESC
            ");
            
            $data = $query->result_array();
            $merge = array();
            foreach ($data as $key => $value) {
                $coa_desc = $this->CoaDescription($value['subsrd_kategori']);
                array_push($merge, 
                    array_merge(
                        $value, 
                        array('coa_desc'=>$coa_desc),
                        $this->MutasiClient($client_code, $value['acc_no'])
                    ) 
                );
            }
            $return = $merge;
        }
        
        return $return;
    }

    function ListNfsBeli($client_code)
    {
        $return = array();
        if( $this->CheckMutasiClient($client_code) ){
            $query=$this->db_nfs->query("
                SELECT TOP
                    ( 200 )
                    'nfs_beli' AS src_dt,
                    'C007' AS subsrd_kategori,
                    'Beli Saham / Obligasi' AS deskripsi,
                    CONVERT ( DATE, A.TRADE_DATE ) AS subsrd_date,
                    SUM ( CONVERT ( DEC, A.NET_SETTLEMENT_AMOUNT ) ) AS subsrd_nominal,
                    A.HIPORT_CODE AS client_code,
                    B.FUND_OPR_ACCT_NO AS acc_no  
                FROM
                    NFS_INQ_EQUITY_TEMP A
                    INNER JOIN FUND_DETAILS B ON B.HIPORT_CODE = A.HIPORT_CODE 
                    AND B.ACTIVE_STATUS = 1 
                WHERE
                    A.BUY_SELL = '1'
                    AND A.HIPORT_CODE LIKE '%".$client_code."%'
                    AND B.FUND_OPR_ACCT_NO in (".$this->MutasiClientAccNo($client_code).")
                GROUP BY
                    B.FUND_OPR_ACCT_NO,
                    A.HIPORT_CODE,
                    CONVERT ( DATE, A.TRADE_DATE ) 
                ORDER BY
                    subsrd_date DESC
            ");
            
            $data = $query->result_array();
            $merge = array();
            foreach ($data as $key => $value) {
                $coa_desc = $this->CoaDescription($value['subsrd_kategori']);
                array_push($merge, 
                    array_merge(
                        $value, 
                        array('coa_desc'=>$coa_desc),
                        $this->MutasiClient($client_code, $value['acc_no'])
                    ) 
                );
            }
            $return = $merge;
        }
        
        return $return;
    }

    function ListWhtCommision($client_code)
    {
        $return = array();
        if( $this->CheckMutasiClient($client_code) ){
            $query=$this->db_nfs->query("
                SELECT TOP
                    ( 200 ) 
                    'nfs_Wht_Commision' AS src_dt,
                    'D016' AS subsrd_kategori,
                    'Wht Commision' AS deskripsi,
                    CONVERT ( DATE, A.TRADE_DATE ) AS subsrd_date,
                    sum( CONVERT ( DEC, WHT_COMMISION ) ) AS subsrd_nominal,
                    A.HIPORT_CODE AS client_code,
                    B.FUND_OPR_ACCT_NO AS acc_no 
                FROM
                    NFS_INQ_EQUITY_TEMP A
                    INNER JOIN FUND_DETAILS B ON B.HIPORT_CODE = A.HIPORT_CODE 
                    AND B.ACTIVE_STATUS = 1 
                WHERE
                    CONVERT ( DEC, WHT_COMMISION ) > 0
                    AND A.HIPORT_CODE LIKE '%".$client_code."%'
                    AND B.FUND_OPR_ACCT_NO in (".$this->MutasiClientAccNo($client_code).")
                GROUP BY
                    B.FUND_OPR_ACCT_NO,
                    A.HIPORT_CODE,
                    CONVERT ( DATE, A.TRADE_DATE ) 
                ORDER BY
                    subsrd_date DESC
            ");
            
            $data = $query->result_array();
            $merge = array();
            foreach ($data as $key => $value) {
                $coa_desc = $this->CoaDescription($value['subsrd_kategori']);
                array_push($merge, 
                    array_merge(
                        $value, 
                        array('coa_desc'=>$coa_desc),
                        $this->MutasiClient($client_code, $value['acc_no'])
                    ) 
                );
            }
            $return = $merge;
        }
        
        return $return;
    }

    function ListIGIncomeTax($client_code)
    {
        $return = array();
        if( $this->CheckMutasiClient($client_code) ){
            $query=$this->db_nfs->query("
                SELECT TOP
                    ( 200 ) 
                    'nfs_CAPITAL_INTERS_OR_GIANT_TAX' AS src_dt,
                    'D017' AS subsrd_kategori,
                    'Interst/Gain Income Tax' AS deskripsi,
                    CONVERT ( DATE, A.TRADE_DATE ) AS subsrd_date,
                    SUM ( CONVERT ( DEC, INTEREST_INCOME_TAX ) + CONVERT ( DEC, CAPITAL_GAIN_TAX ) ) AS subsrd_nominal,
                    A.HIPORT_CODE AS client_code,
                    B.FUND_OPR_ACCT_NO AS acc_no 
                FROM
                    NFS_FI_INS_INQ_TEMP A
                    INNER JOIN FUND_DETAILS B ON B.HIPORT_CODE = A.HIPORT_CODE 
                    AND B.ACTIVE_STATUS= 1 
                WHERE
                    ( CONVERT ( DEC, INTEREST_INCOME_TAX ) > 0 or CONVERT ( DEC, CAPITAL_GAIN_TAX ) > 0 )
                    AND A.HIPORT_CODE LIKE '%".$client_code."%'
                    AND B.FUND_OPR_ACCT_NO in (".$this->MutasiClientAccNo($client_code).") 
                GROUP BY
                    B.FUND_OPR_ACCT_NO,
                    A.HIPORT_CODE,
                    CONVERT ( DATE, A.TRADE_DATE ) 
                ORDER BY
                    subsrd_date DESC
            ");
            
            $data = $query->result_array();
            $merge = array();
            foreach ($data as $key => $value) {
                $coa_desc = $this->CoaDescription($value['subsrd_kategori']);
                array_push($merge, 
                    array_merge(
                        $value, 
                        array('coa_desc'=>$coa_desc),
                        $this->MutasiClient($client_code, $value['acc_no'])
                    ) 
                );
            }
            $return = $merge;
        }
        
        return $return;
    }

}
?>