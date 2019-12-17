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
        $this->db_batavia = $this->load->database('dbbatavia',true);
        $this->db_bni = $this->load->database('dbbni',true);
        $this->db_ereport = $this->load->database('dbereport',true);
        $this->db_niaga = $this->load->database('dbniaga',true);
        $this->db_syailendra = $this->load->database('dbsyailendra',true);
        $this->db_trimegah = $this->load->database('dbtrimegah',true);
        $this->db_tugu = $this->load->database('dbtugu',true);

    }
    function get_login_info($user,$pass)
    {                                                                                
        $query=$this->db->query("exec get_user_info '{$user}','" . md5($pass) . "'");
        $data=$query->result_array();
        return $data;
    }
    function list_client_by_code($client_code = '')
    {
        //edit By MK
        $query=$this->db_jasgir->query("exec mutasi_list_client_by_code '{$client_code}'");
        // $query=$this->db_jasgir->query("exec mutasi_list_client_by_code_MK '{$client_code}'");
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
        $id = $data['id'];
        $client_code = $data['client_code'];
        $date = date('Y-m-d', strtotime($data['date']) );
        $coa_id = $data['coa_id'];
        $acc_no = $data['acc_no'];
        $mutasi_trx = array();

        $coa = $this->db_jasgir->query(" SELECT * FROM coa WHERE coa_no = '".$coa_id."' ");
        $coa = $coa->result();

        $subsrd = $this->db_jasgir->query("
            SELECT 
                * 
            FROM 
                subsrd
            WHERE 
                client_code = '".$client_code."' and 
                acc_no_dst = '".$acc_no."' and
                subsrd_id = '".$id."'
        ");

        $check_mutasi = $this->db_jasgir->query("
            SELECT 
                * 
            FROM 
                mutasi_trx
            WHERE 
                client_code = '".$client_code."' and 
                coa_no = '".$coa_id."' and 
                acc_no = '".$acc_no."' and
                subsrd_id = '".$id."'
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
                        [trx_status],
                        [subsrd_id]
                    )VALUES(
                        '".trim($value['client_code'])."',
                        '".trim($value['acc_no_dst'])."',
                        '".$date."',
                        '".$value['subsrd_kategori']."',
                        '".$value['subsrd_desc']."',
                        '".$value['bank_src']."',
                        '".$coa[0]->coa_dc."',
                        '".$value['subsrd_nominal']."',
                        '".$this->session->userdata('itd_uid')."',
                        '".date('Y-m-d H:i:s')."',
                        '".$this->session->userdata('itd_uid')."',
                        '".date('Y-m-d H:i:s')."',
                        1,
                        '".$id."'
                    );
                ");
            }
            $mutasi_trx = $mutasi_trx ? array('msg' => 'Data berhasil masuk ke mutasi') : array('msg' => 'Data Gagal Masuk ke Mutasi');
        }else{
            $mutasi_trx = array('msg' => 'Data Sudah Ada');
        }
        return $mutasi_trx;
    }

    function PenempatanToMutasi($data)
    {
        $id = $data['id'];
        $client_code = $data['client_code'];
        $date = date('Y-m-d', strtotime($data['date']) );
        $coa_id = $data['coa_id'];
        $acc_no = $data['acc_no'];
        $mutasi_trx = array();

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
                trx_client_code,
                trx_acc_no,
                CONVERT ( DATE, trx_date ) as trx_date,
                trx_from,
                trx_nominal
            FROM 
                itd_trx_approved
            WHERE trx_client_code = '".$client_code."' and 
            CONVERT ( DATE, trx_date ) = '".$date."' and
            trx_type = 1 and 
            trx_acc_no = '".$acc_no."' and
            trx_id = '".$id."'
        ");

        $check_mutasi = $this->db_jasgir->query("
            SELECT 
                * 
            FROM 
                mutasi_trx
            WHERE client_code = '".$client_code."' and 
            trx_date = '".$date."' and
            coa_no = '".$coa[0]->coa_no."' and 
            acc_no = '".$acc_no."' and 
            subsrd_id = '".$id."'
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
                        '".trim($value['trx_client_code'])."',
                        '".trim($value['trx_acc_no'])."',
                        '".$value['trx_date']->format('Y-m-d H:i:s')."',
                        '".$coa[0]->coa_no."',
                        '".$coa[0]->coa_desc."',
                        '".$value['trx_from']."',
                        '".$coa[0]->coa_dc."',
                        '".$value['trx_nominal']."',
                        '".$this->session->userdata('itd_uid')."',
                        '".date('Y-m-d H:i:s')."',
                        '".$this->session->userdata('itd_uid')."',
                        '".date('Y-m-d H:i:s')."',
                        1
                    );
                ");
            }
            $mutasi_trx = $mutasi_trx ? array('msg' => 'Data berhasil masuk ke mutasi') : array('msg' => 'Data Gagal Masuk ke Mutasi');
        }else{
            $mutasi_trx = array('msg' => 'Data Sudah Ada');
        }
        return $mutasi_trx;
    }

    function PencairanToMutasi($data)
    {
        $id = $data['id'];
        $client_code = $data['client_code'];
        $date = date('Y-m-d', strtotime($data['date']) );
        $coa_id = $data['coa_id'];
        $acc_no = $data['acc_no'];
        $mutasi_trx = array();

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
                trx_client_code,
                trx_acc_no,
                CONVERT ( DATE, trx_date ) as trx_date,
                trx_from,
                trx_nominal
            FROM 
                itd_trx_approved
            WHERE trx_client_code = '".$client_code."' and 
            CONVERT ( DATE, trx_date ) = '".$date."' and
            trx_type = 3 and 
            trx_acc_no = '".$acc_no."' and
            trx_id = '".$id."'
        ");

        $check_mutasi = $this->db_jasgir->query("
            SELECT 
                * 
            FROM 
                mutasi_trx
            WHERE client_code = '".$client_code."' and 
            trx_date = '".$date."' and
            coa_no = '".$coa[0]->coa_no."' and 
            acc_no = '".$acc_no."' and 
            subsrd_id = '".$id."'
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
                        '".trim($value['trx_client_code'])."',
                        '".trim($value['trx_acc_no'])."',
                        '".$value['trx_date']->format('Y-m-d H:i:s')."',
                        '".$coa[0]->coa_no."',
                        '".$coa[0]->coa_desc."',
                        '".$value['trx_from']."',
                        '".$coa[0]->coa_dc."',
                        '".$value['trx_nominal']."',
                        '".$this->session->userdata('itd_uid')."',
                        '".date('Y-m-d H:i:s')."',
                        '".$this->session->userdata('itd_uid')."',
                        '".date('Y-m-d H:i:s')."',
                        1
                    );
                ");
            }
            $mutasi_trx = $mutasi_trx ? array('msg' => 'Data berhasil masuk ke mutasi') : array('msg' => 'Data Gagal Masuk ke Mutasi');
        }else{
            $mutasi_trx = array('msg' => 'Data Sudah Ada');
        }
        return $mutasi_trx;
    }

    function RedemptionToMutasi($data)
    {
        $client_code = $data['client_code'];
        $date = date('Y-m-d', strtotime($data['date']) );
        $coa_id = $data['coa_id'];
        $acc_no = $data['acc_no'];
        $mutasi_trx = array();

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
                FUND_ID.CREATION_DATE AS CREATION_DATE,
                FUND_ID.MODIFICATION_DATE AS MODIFICATION_DATE,
                FUND_ID.MODIFIER AS MODIFIER,
                FUND_ID.CODE_BPM AS client_code,
                FUND_ID.ACC_BANK_OPR AS acc_no,
                CONVERT ( DATE, TXN_POSTING.GOOD_FUND_DATE ) AS subsrd_date,
                TXN_POSTING.NET_PROCEED AS subsrd_nominal,
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
                CONVERT ( DATE, TXN_POSTING.GOOD_FUND_DATE )  = '".$date."' and 
                FUND_ID.ACC_BANK_OPR = '".$acc_no."' and 
                FUND_ID.CODE_BPM = '".$client_code."'
            ORDER BY
                subsrd_date DESC
        ");

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
                        '".trim($value['client_code'])."',
                        '".trim($value['acc_no'])."',
                        '".$value['subsrd_date']->format('Y-m-d H:i:s')."',
                        '".$coa[0]->coa_no."',
                        '".$coa[0]->coa_desc."',
                        '".$value['deskripsi']."',
                        '".$coa[0]->coa_dc."',
                        '".$value['subsrd_nominal']."',
                        '".$this->session->userdata('itd_uid')."',
                        '".date('Y-m-d H:i:s')."',
                        '".$this->session->userdata('itd_uid')."',
                        '".date('Y-m-d H:i:s')."',
                        1
                    );
                ");
                $mutasi_trx = $mutasi_trx ? array('msg' => 'Data berhasil masuk ke mutasi') : array('msg' => 'Data Gagal Masuk ke Mutasi');
            }
        }else{
            $mutasi_trx = array('msg' => 'Data Sudah Ada');
        }
        return $mutasi_trx;
    }

    function JualSahamToMutasi($data)
    {
        $id = $data['id'];
        $client_code = $data['client_code'];
        $date = date('Y-m-d', strtotime($data['date']) );
        $coa_id = $data['coa_id'];
        $acc_no = $data['acc_no'];
        $mutasi_trx = array();

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
            A.SI_REFF,
            A.HIPORT_CODE AS client_code,
            B.FUND_OPR_ACCT_NO AS acc_no,
            CONVERT ( DATE, A.SETTLEMENT_DATE ) AS subsrd_date,
            CONVERT ( DECIMAL(16,2), A.NET_SETTLEMENT_AMOUNT ) AS subsrd_nominal,
            A.MODIFIER,
            A.CREATION_DATE,
            A.MODIFICATION_DATE,
            'C006' AS subsrd_kategori,
            'Hasil Jual Saham' AS deskripsi
        FROM
            NFS_INQ_EQUITY_TEMP A
            INNER JOIN  FUND_DETAILS B on B.HIPORT_CODE = A.HIPORT_CODE
        WHERE
            A.BUY_SELL = '2'
            AND A.HIPORT_CODE = '".$client_code."'
            AND CONVERT ( DATE, A.SETTLEMENT_DATE ) = '".$date."'
            AND B.FUND_OPR_ACCT_NO = '".$acc_no."' 
            AND A.SI_REFF = '".$id."'
        ORDER BY
            subsrd_date DESC
        ");

        $check_mutasi = $this->db_jasgir->query("
            SELECT 
                * 
            FROM 
                mutasi_trx
            WHERE client_code = '".$client_code."' and 
            trx_date = '".$date."' and
            coa_no = '".$coa[0]->coa_no."' and 
            acc_no = '".$acc_no."' and
            subsrd_id = '".$id."'
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
                        [trx_status],
                        [subsrd_id]
                    )VALUES(
                        '".trim($value['client_code'])."',
                        '".trim($value['acc_no'])."',
                        '".$value['subsrd_date']->format('Y-m-d H:i:s')."',
                        '".$coa[0]->coa_no."',
                        '".$coa[0]->coa_desc."',
                        '".$value['deskripsi']."',
                        '".$coa[0]->coa_dc."',
                        '".$value['subsrd_nominal']."',
                        '".$this->session->userdata('itd_uid')."',
                        '".date('Y-m-d H:i:s')."',
                        '".$this->session->userdata('itd_uid')."',
                        '".date('Y-m-d H:i:s')."',
                        1,
                        '".$value['SI_REFF']."'
                    );
                ");
            }
            $mutasi_trx = $mutasi_trx ? array('msg' => 'Data berhasil masuk ke mutasi') : array('msg' => 'Data Gagal Masuk ke Mutasi');
        }else{
            $mutasi_trx = array('msg' => 'Data Sudah Ada');
        }
        
        return $mutasi_trx;
    }

    function BeliSahamToMutasi($data)
    {
        $id = $data['id'];
        $client_code = $data['client_code'];
        $date = date('Y-m-d', strtotime($data['date']) );
        $coa_id = $data['coa_id'];
        $acc_no = $data['acc_no'];
        $mutasi_trx = array();

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
            A.SI_REFF,
            A.HIPORT_CODE AS client_code,
            B.FUND_OPR_ACCT_NO AS acc_no,
            CONVERT ( DATE, A.SETTLEMENT_DATE ) AS subsrd_date,
            CONVERT ( DECIMAL(16,2), A.NET_SETTLEMENT_AMOUNT ) AS subsrd_nominal,
            A.MODIFIER,
            A.CREATION_DATE,
            A.MODIFICATION_DATE,
            'D004' AS subsrd_kategori,
            'Beli Saham' AS deskripsi
        FROM
            NFS_INQ_EQUITY_TEMP A
            INNER JOIN  FUND_DETAILS B on B.HIPORT_CODE = A.HIPORT_CODE
        WHERE
            A.BUY_SELL = '1' and
            A.HIPORT_CODE = '".$client_code."' and 
            CONVERT ( DATE, A.SETTLEMENT_DATE ) = '".$date."' and
            B.FUND_OPR_ACCT_NO = '".$acc_no."' AND
            A.SI_REFF = '".$id."'
        ORDER BY
            subsrd_date DESC
        ");

        $check_mutasi = $this->db_jasgir->query("
            SELECT 
                * 
            FROM 
                mutasi_trx
            WHERE client_code = '".$client_code."' and 
            trx_date = '".$date."' and
            coa_no = '".$coa[0]->coa_no."' and 
            acc_no = '".$acc_no."' and 
            subsrd_id = '".$id."'
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
                        [trx_status],
                        [subsrd_id]
                    )VALUES(
                        '".trim($value['client_code'])."',
                        '".trim($value['acc_no'])."',
                        '".$value['subsrd_date']->format('Y-m-d H:i:s')."',
                        '".$coa[0]->coa_no."',
                        '".$coa[0]->coa_desc."',
                        '".$value['deskripsi']."',
                        '".$coa[0]->coa_dc."',
                        '".$value['subsrd_nominal']."',
                        '".$this->session->userdata('itd_uid')."',
                        '".date('Y-m-d H:i:s')."',
                        '".$this->session->userdata('itd_uid')."',
                        '".date('Y-m-d H:i:s')."',
                        1,
                        '".$value['SI_REFF']."'
                    );
                ");
            }
            $mutasi_trx = $mutasi_trx ? array('msg' => 'Data berhasil masuk ke mutasi') : array('msg' => 'Data Gagal Masuk ke Mutasi');
        }else{
            $mutasi_trx = array('msg' => 'Data Sudah Ada');
        }
        return $mutasi_trx;
    }
    
    function JualObligasiToMutasi($data)
    {
        $id = $data['id'];
        $client_code = $data['client_code'];
        $date = date('Y-m-d', strtotime($data['date']) );
        $coa_id = $data['coa_id'];
        $acc_no = $data['acc_no'];
        $mutasi_trx = array();
        
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
            A.SI_REFERENCE AS SI_REFF,
            A.HIPORT_CODE AS client_code,
            B.FUND_OPR_ACCT_NO AS acc_no,
            CONVERT ( DATE, A.SETTLEMENT_DATE ) AS subsrd_date,
            CONVERT ( DECIMAL(16,2), A.NET_PROCEEDS ) AS subsrd_nominal,
            A.MODIFIER,
            A.CREATION_DATE,
            A.MODIFICATION_DATE,
            'C007' AS subsrd_kategori,
            'Hasil Jual Obligasi' AS deskripsi 
        FROM
            NFS_FI_INS_INQ_TEMP A
            INNER JOIN FUND_DETAILS B ON B.HIPORT_CODE = A.HIPORT_CODE 
        WHERE
            A.BUY_SELL = '2'  and
            A.HIPORT_CODE = '".$client_code."' and 
            CONVERT ( DATE, A.SETTLEMENT_DATE ) = '".$date."' and
            B.FUND_OPR_ACCT_NO = '".$acc_no."' and
            A.SI_REFERENCE = '".$id."'
        ORDER BY
            subsrd_date DESC
        ");

        $check_mutasi = $this->db_jasgir->query("
            SELECT 
                * 
            FROM 
                mutasi_trx
            WHERE client_code = '".$client_code."' and 
            trx_date = '".$date."' and
            coa_no = '".$coa[0]->coa_no."' and 
            acc_no = '".$acc_no."' and 
            subsrd_id = '".$id."'
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
                        [trx_status],
                        [subsrd_id]
                    )VALUES(
                        '".trim($value['client_code'])."',
                        '".trim($value['acc_no'])."',
                        '".$value['subsrd_date']->format('Y-m-d H:i:s')."',
                        '".$coa[0]->coa_no."',
                        '".$coa[0]->coa_desc."',
                        '".$value['deskripsi']."',
                        '".$coa[0]->coa_dc."',
                        '".$value['subsrd_nominal']."',
                        '".$this->session->userdata('itd_uid')."',
                        '".date('Y-m-d H:i:s')."',
                        '".$this->session->userdata('itd_uid')."',
                        '".date('Y-m-d H:i:s')."',
                        1,
                        '".$value['SI_REFF']."'
                    );
                ");    
            }
            $mutasi_trx = $mutasi_trx ? array('msg' => 'Data berhasil masuk ke mutasi') : array('msg' => 'Data Gagal Masuk ke Mutasi');
        }else{
            $mutasi_trx = array('msg' => 'Data Sudah Ada');
        }
        return $mutasi_trx;
    }

    function BeliObligasiToMutasi($data)
    {
        $id = $data['id'];
        $client_code = $data['client_code'];
        $date = date('Y-m-d', strtotime($data['date']) );
        $coa_id = $data['coa_id'];
        $acc_no = $data['acc_no'];
        $mutasi_trx = array();
        
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
            A.SI_REFERENCE AS SI_REFF,
            A.HIPORT_CODE AS client_code,
            B.FUND_OPR_ACCT_NO AS acc_no,
            CONVERT ( DATE, A.SETTLEMENT_DATE ) AS subsrd_date,
            CONVERT ( DECIMAL(16,2), A.NET_PROCEEDS ) AS subsrd_nominal,
            A.MODIFIER,
            A.CREATION_DATE,
            A.MODIFICATION_DATE,
            'D005' AS subsrd_kategori,
            'Beli Obligasi' AS deskripsi 
        FROM
            NFS_FI_INS_INQ_TEMP A
            INNER JOIN FUND_DETAILS B ON B.HIPORT_CODE = A.HIPORT_CODE 
        WHERE
            A.BUY_SELL = '1'  and
            A.HIPORT_CODE = '".$client_code."' and 
            CONVERT ( DATE, A.SETTLEMENT_DATE ) = '".$date."' and
            B.FUND_OPR_ACCT_NO = '".$acc_no."' and 
            A.SI_REFERENCE = '".$id."'
        ORDER BY
            subsrd_date DESC
        ");

        $check_mutasi = $this->db_jasgir->query("
            SELECT 
                * 
            FROM 
                mutasi_trx
            WHERE client_code = '".$client_code."' and 
            trx_date = '".$date."' and
            coa_no = '".$coa[0]->coa_no."' and 
            acc_no = '".$acc_no."' and 
            subsrd_id = '".$id."'
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
                        [trx_status],
                        [subsrd_id]
                    )VALUES(
                        '".trim($value['client_code'])."',
                        '".trim($value['acc_no'])."',
                        '".$value['subsrd_date']->format('Y-m-d H:i:s')."',
                        '".$coa[0]->coa_no."',
                        '".$coa[0]->coa_desc."',
                        '".$value['deskripsi']."',
                        '".$coa[0]->coa_dc."',
                        '".$value['subsrd_nominal']."',
                        '".$this->session->userdata('itd_uid')."',
                        '".date('Y-m-d H:i:s')."',
                        '".$this->session->userdata('itd_uid')."',
                        '".date('Y-m-d H:i:s')."',
                        1,
                        '".$value['SI_REFF']."'
                    );
                ");
            }
            $mutasi_trx = $mutasi_trx ? array('msg' => 'Data berhasil masuk ke mutasi') : array('msg' => 'Data Gagal Masuk ke Mutasi');
        }else{
            $mutasi_trx = array('msg' => 'Data Sudah Ada');
        }
        return $mutasi_trx;
    }

    function TaxBrokerToMutasi($data)
    {
        $id = $data['id'];
        $client_code = $data['client_code'];
        $date = date('Y-m-d', strtotime($data['date']) );
        $coa_id = $data['coa_id'];
        $acc_no = $data['acc_no'];
        $mutasi_trx = array();

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
                A.SI_REFF,
                A.HIPORT_CODE AS client_code,
                CONVERT ( DATE, A.SETTLEMENT_DATE ) AS subsrd_date,
                CONVERT ( DECIMAL(16,2), A.WHT_COMMISION ) AS subsrd_nominal,
                A.MODIFIER,
                A.CREATION_DATE,
                A.MODIFICATION_DATE,
                'D016' AS subsrd_kategori,
                'Wht Commision' AS deskripsi,
                B.FUND_OPR_ACCT_NO AS acc_no 
            FROM
                NFS_INQ_EQUITY_TEMP A
                INNER JOIN FUND_DETAILS B ON B.HIPORT_CODE = A.HIPORT_CODE 
            WHERE
                CONVERT ( DECIMAL(16,2), A.WHT_COMMISION ) > 0 
                AND A.HIPORT_CODE = '".$client_code."' 
                AND CONVERT ( DATE, A.SETTLEMENT_DATE ) = '".$date."' 
                AND B.FUND_OPR_ACCT_NO = '".$acc_no."'
                AND A.SI_REFF = '".$id."'
            ORDER BY
                subsrd_date DESC
        ");

        $check_mutasi = $this->db_jasgir->query("
            SELECT 
                * 
            FROM 
                mutasi_trx
            WHERE client_code = '".$client_code."' and 
            trx_date = '".$date."' and
            coa_no = '".$coa[0]->coa_no."' and 
            acc_no = '".$acc_no."' and
            subsrd_id = '".$id."'
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
                        [trx_status],
                        [subsrd_id]
                    )VALUES(
                        '".trim($value['client_code'])."',
                        '".trim($value['acc_no'])."',
                        '".$value['subsrd_date']->format('Y-m-d H:i:s')."',
                        '".$coa[0]->coa_no."',
                        '".$coa[0]->coa_desc."',
                        '".$value['deskripsi']."',
                        '".$coa[0]->coa_dc."',
                        '".$value['subsrd_nominal']."',
                        '".$this->session->userdata('itd_uid')."',
                        '".date('Y-m-d H:i:s')."',
                        '".$this->session->userdata('itd_uid')."',
                        '".date('Y-m-d H:i:s')."',
                        1,
                        '".$value['SI_REFF']."'
                    );
                ");
            }
            $mutasi_trx = $mutasi_trx ? array('msg' => 'Data berhasil masuk ke mutasi') : array('msg' => 'Data Gagal Masuk ke Mutasi');
        }else{
            $mutasi_trx = array('msg' => 'Data Sudah Ada');
        }
        return $mutasi_trx;
    }

    function TaxObligasiToMutasi($data)
    {
        $id = $data['id'];
        $client_code = $data['client_code'];
        $date = date('Y-m-d', strtotime($data['date']) );
        $coa_id = $data['coa_id'];
        $acc_no = $data['acc_no'];
        $mutasi_trx = array();

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
                A.SI_REFERENCE AS SI_REFF,
                A.HIPORT_CODE AS client_code,
                CONVERT ( DATE, A.SETTLEMENT_DATE ) AS subsrd_date,
                CONVERT ( DECIMAL(16,2), A.CAPITAL_GAIN_TAX ) AS subsrd_nominal,
                A.MODIFIER,
                A.CREATION_DATE,
                A.MODIFICATION_DATE,
                'D017' AS subsrd_kategori,
                'Capital Gain Tax' AS deskripsi,
                B.FUND_OPR_ACCT_NO AS acc_no 
            FROM
                NFS_FI_INS_INQ_TEMP A
                INNER JOIN FUND_DETAILS B ON B.HIPORT_CODE = A.HIPORT_CODE 
            WHERE
                CONVERT ( DECIMAL(16,2), A.CAPITAL_GAIN_TAX ) > 0  
                AND A.HIPORT_CODE = '".$client_code."' 
                AND CONVERT ( DATE, A.SETTLEMENT_DATE ) = '".$date."' 
                AND B.FUND_OPR_ACCT_NO = '".$acc_no."' 
                AND A.SI_REFERENCE = '".$id."'
                AND BUY_SELL = '1'
            ) AS CAPITAL_GAIN_TAX

            UNION ALL

            SELECT
                * 
            FROM
            (
                SELECT
                    A.SI_REFERENCE AS SI_REFF,
                    A.HIPORT_CODE AS client_code,
                    CONVERT ( DATE, A.SETTLEMENT_DATE ) AS subsrd_date,
                    CONVERT ( DECIMAL(16,2), A.INTEREST_INCOME_TAX ) AS subsrd_nominal,
                    A.MODIFIER,
                    A.CREATION_DATE,
                    A.MODIFICATION_DATE,
                    'D017' AS subsrd_kategori,
                    'Interst Income Tax' AS deskripsi,
                    B.FUND_OPR_ACCT_NO AS acc_no 
                FROM
                    NFS_FI_INS_INQ_TEMP A
                    INNER JOIN FUND_DETAILS B ON B.HIPORT_CODE = A.HIPORT_CODE 
                WHERE
                    CONVERT ( DECIMAL(16,2), A.INTEREST_INCOME_TAX ) > 0 
                    AND A.HIPORT_CODE = '".$client_code."' 
                    AND CONVERT ( DATE, A.SETTLEMENT_DATE ) = '".$date."' 
                    AND B.FUND_OPR_ACCT_NO = '".$acc_no."'
                    AND A.SI_REFERENCE = '".$id."'
                    AND BUY_SELL = '1' 
            ) AS INTEREST_INCOME_TAX
            
        ");

        $check_mutasi = $this->db_jasgir->query("
            SELECT 
                * 
            FROM 
                mutasi_trx
            WHERE client_code = '".$client_code."' and 
            trx_date = '".$date."' and
            coa_no = '".$coa[0]->coa_no."' and 
            acc_no = '".$acc_no."' and
            subsrd_id = '".$id."'
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
                        [trx_status],
                        [subsrd_id]
                    )VALUES(
                        '".trim($value['client_code'])."',
                        '".trim($value['acc_no'])."',
                        '".$value['subsrd_date']->format('Y-m-d H:i:s')."',
                        '".$coa[0]->coa_no."',
                        '".$coa[0]->coa_desc."',
                        '".$value['deskripsi']."',
                        '".$coa[0]->coa_dc."',
                        '".$value['subsrd_nominal']."',
                        '".$this->session->userdata('itd_uid')."',
                        '".date('Y-m-d H:i:s')."',
                        '".$this->session->userdata('itd_uid')."',
                        '".date('Y-m-d H:i:s')."',
                        1,
                        '".$value['SI_REFF']."'
                    );
                ");
            }
            $mutasi_trx = $mutasi_trx ? array('msg' => 'Data berhasil masuk ke mutasi') : array('msg' => 'Data Gagal Masuk ke Mutasi');
        }else{
            $mutasi_trx = array('msg' => 'Data Sudah Ada');
        }
        return $mutasi_trx;
    }
    
    // background job start

    function SubscribeToMutasiBackground($data)
    {
        $client_code = $data['client_code'];
        $date = date('Y-m-d', strtotime($data['date']) );
        $coa_id = $data['coa_id'];
        $acc_no = $data['acc_no'];
        $mutasi_trx = array();

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
            acc_no_dst = '".$acc_no."'
        ");
        
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
                        '".trim($value['client_code'])."',
                        '".trim($value['acc_no_dst'])."',
                        '".$value['subsrd_date']->format('Y-m-d H:i:s')."',
                        '".$value['subsrd_kategori']."',
                        '".$value['subsrd_desc']."',
                        '".$value['bank_src']."',
                        '".$coa[0]->coa_dc."',
                        '".$value['subsrd_nominal']."',
                        '".$this->session->userdata('itd_uid')."',
                        '".date('Y-m-d H:i:s')."',
                        '".$this->session->userdata('itd_uid')."',
                        '".date('Y-m-d H:i:s')."',
                        1
                    );
                ");
            }
            $mutasi_trx = $mutasi_trx ? array('msg' => 'Data berhasil masuk ke mutasi') : array('msg' => 'Data Gagal Masuk ke Mutasi');
        }else{
            $mutasi_trx = array('msg' => 'Data Sudah Ada');
        }
        return $mutasi_trx;
    }

    function PenempatanToMutasiBackground($data)
    {
        $client_code = $data['client_code'];
        $date = date('Y-m-d', strtotime($data['date']) );
        $coa_id = $data['coa_id'];
        $acc_no = $data['acc_no'];
        $mutasi_trx = array();

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
                trx_client_code,
                trx_acc_no,
                CONVERT ( DATE, trx_date ) as trx_date,
                trx_from,
                trx_nominal
            FROM 
                itd_trx_approved
            WHERE trx_client_code = '".$client_code."' and 
            CONVERT ( DATE, trx_date ) = '".$date."' and
            trx_type = 1 and 
            trx_acc_no = '".$acc_no."'
        ");

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
                        '".trim($value['trx_client_code'])."',
                        '".trim($value['trx_acc_no'])."',
                        '".$value['trx_date']->format('Y-m-d H:i:s')."',
                        '".$coa[0]->coa_no."',
                        '".$coa[0]->coa_desc."',
                        '".$value['trx_from']."',
                        '".$coa[0]->coa_dc."',
                        '".$value['trx_nominal']."',
                        '".$this->session->userdata('itd_uid')."',
                        '".date('Y-m-d H:i:s')."',
                        '".$this->session->userdata('itd_uid')."',
                        '".date('Y-m-d H:i:s')."',
                        1
                    );
                ");
            }
            $mutasi_trx = $mutasi_trx ? array('msg' => 'Data berhasil masuk ke mutasi') : array('msg' => 'Data Gagal Masuk ke Mutasi');
        }else{
            $mutasi_trx = array('msg' => 'Data Sudah Ada');
        }
        return $mutasi_trx;
    }

    function PencairanToMutasiBackground($data)
    {
        $client_code = $data['client_code'];
        $date = date('Y-m-d', strtotime($data['date']) );
        $coa_id = $data['coa_id'];
        $acc_no = $data['acc_no'];
        $mutasi_trx = array();

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
                trx_client_code,
                trx_acc_no,
                CONVERT ( DATE, trx_date ) as trx_date,
                trx_from,
                trx_nominal
            FROM 
                itd_trx_approved
            WHERE trx_client_code = '".$client_code."' and 
            CONVERT ( DATE, trx_date ) = '".$date."' and
            trx_type = 3 and 
            trx_acc_no = '".$acc_no."'
        ");

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
                        '".trim($value['trx_client_code'])."',
                        '".trim($value['trx_acc_no'])."',
                        '".$value['trx_date']->format('Y-m-d H:i:s')."',
                        '".$coa[0]->coa_no."',
                        '".$coa[0]->coa_desc."',
                        '".$value['trx_from']."',
                        '".$coa[0]->coa_dc."',
                        '".$value['trx_nominal']."',
                        '".$this->session->userdata('itd_uid')."',
                        '".date('Y-m-d H:i:s')."',
                        '".$this->session->userdata('itd_uid')."',
                        '".date('Y-m-d H:i:s')."',
                        1
                    );
                ");
            }
            $mutasi_trx = $mutasi_trx ? array('msg' => 'Data berhasil masuk ke mutasi') : array('msg' => 'Data Gagal Masuk ke Mutasi');
        }else{
            $mutasi_trx = array('msg' => 'Data Sudah Ada');
        }
        return $mutasi_trx;
    }

    function RedemptionToMutasiBackground($data)
    {
        $client_code = $data['client_code'];
        $date = date('Y-m-d', strtotime($data['date']) );
        $coa_id = $data['coa_id'];
        $acc_no = $data['acc_no'];
        $mutasi_trx = array();

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
                FUND_ID.CREATION_DATE AS CREATION_DATE,
                FUND_ID.MODIFICATION_DATE AS MODIFICATION_DATE,
                FUND_ID.MODIFIER AS MODIFIER,
                FUND_ID.CODE_BPM AS client_code,
                FUND_ID.ACC_BANK_OPR AS acc_no,
                CONVERT ( DATE, TXN_POSTING.GOOD_FUND_DATE ) AS subsrd_date,
                TXN_POSTING.NET_PROCEED AS subsrd_nominal,
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
                CONVERT ( DATE, TXN_POSTING.GOOD_FUND_DATE )  = '".$date."' and 
                FUND_ID.ACC_BANK_OPR = '".$acc_no."' and 
                FUND_ID.CODE_BPM = '".$client_code."'
            ORDER BY
                subsrd_date DESC
        ");

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
                        '".trim($value['client_code'])."',
                        '".trim($value['acc_no'])."',
                        '".$value['subsrd_date']->format('Y-m-d H:i:s')."',
                        '".$coa[0]->coa_no."',
                        '".$coa[0]->coa_desc."',
                        '".$value['deskripsi']."',
                        '".$coa[0]->coa_dc."',
                        '".$value['subsrd_nominal']."',
                        '".$this->session->userdata('itd_uid')."',
                        '".date('Y-m-d H:i:s')."',
                        '".$this->session->userdata('itd_uid')."',
                        '".date('Y-m-d H:i:s')."',
                        1
                    );
                ");
                $mutasi_trx = $mutasi_trx ? array('msg' => 'Data berhasil masuk ke mutasi') : array('msg' => 'Data Gagal Masuk ke Mutasi');
            }
        }else{
            $mutasi_trx = array('msg' => 'Data Sudah Ada');
        }
        return $mutasi_trx;
    }

    function JualSahamToMutasiBackground($data)
    {
        $client_code = $data['client_code'];
        $date = date('Y-m-d', strtotime($data['date']) );
        $coa_id = $data['coa_id'];
        $acc_no = $data['acc_no'];
        $mutasi_trx = array();

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
            A.SI_REFF,
            A.HIPORT_CODE AS client_code,
            B.FUND_OPR_ACCT_NO AS acc_no,
            CONVERT ( DATE, A.SETTLEMENT_DATE ) AS subsrd_date,
            CONVERT ( DECIMAL(16,2), A.NET_SETTLEMENT_AMOUNT ) AS subsrd_nominal,
            A.MODIFIER,
            A.CREATION_DATE,
            A.MODIFICATION_DATE,
            'C006' AS subsrd_kategori,
            'Hasil Jual Saham' AS deskripsi
        FROM
            NFS_INQ_EQUITY_TEMP A
            INNER JOIN  FUND_DETAILS B on B.HIPORT_CODE = A.HIPORT_CODE
        WHERE
            A.BUY_SELL = '2'
            AND A.HIPORT_CODE = '".$client_code."'
            AND CONVERT ( DATE, A.SETTLEMENT_DATE ) = '".$date."'
            AND B.FUND_OPR_ACCT_NO = '".$acc_no."'
        ORDER BY
            subsrd_date DESC
        ");

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
                        [trx_status],
                        [subsrd_id]
                    )VALUES(
                        '".trim($value['client_code'])."',
                        '".trim($value['acc_no'])."',
                        '".$value['subsrd_date']->format('Y-m-d H:i:s')."',
                        '".$coa[0]->coa_no."',
                        '".$coa[0]->coa_desc."',
                        '".$value['deskripsi']."',
                        '".$coa[0]->coa_dc."',
                        '".$value['subsrd_nominal']."',
                        '".$this->session->userdata('itd_uid')."',
                        '".date('Y-m-d H:i:s')."',
                        '".$this->session->userdata('itd_uid')."',
                        '".date('Y-m-d H:i:s')."',
                        1,
                        '".$value['SI_REFF']."'
                    );
                ");
            }
            $mutasi_trx = $mutasi_trx ? array('msg' => 'Data berhasil masuk ke mutasi') : array('msg' => 'Data Gagal Masuk ke Mutasi');
        }else{
            $mutasi_trx = array('msg' => 'Data Sudah Ada');
        }
        
        return $mutasi_trx;
    }

    function BeliSahamToMutasiBackground($data)
    {
        $client_code = $data['client_code'];
        $date = date('Y-m-d', strtotime($data['date']) );
        $coa_id = $data['coa_id'];
        $acc_no = $data['acc_no'];
        $mutasi_trx = array();

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
            A.SI_REFF,
            A.HIPORT_CODE AS client_code,
            B.FUND_OPR_ACCT_NO AS acc_no,
            CONVERT ( DATE, A.SETTLEMENT_DATE ) AS subsrd_date,
            CONVERT ( DECIMAL(16,2), A.NET_SETTLEMENT_AMOUNT ) AS subsrd_nominal,
            A.MODIFIER,
            A.CREATION_DATE,
            A.MODIFICATION_DATE,
            'D004' AS subsrd_kategori,
            'Beli Saham' AS deskripsi
        FROM
            NFS_INQ_EQUITY_TEMP A
            INNER JOIN  FUND_DETAILS B on B.HIPORT_CODE = A.HIPORT_CODE
        WHERE
            A.BUY_SELL = '1' and
            A.HIPORT_CODE = '".$client_code."' and 
            CONVERT ( DATE, A.SETTLEMENT_DATE ) = '".$date."' and
            B.FUND_OPR_ACCT_NO = '".$acc_no."'
        ORDER BY
            subsrd_date DESC
        ");

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
                        [trx_status],
                        [subsrd_id]
                    )VALUES(
                        '".trim($value['client_code'])."',
                        '".trim($value['acc_no'])."',
                        '".$value['subsrd_date']->format('Y-m-d H:i:s')."',
                        '".$coa[0]->coa_no."',
                        '".$coa[0]->coa_desc."',
                        '".$value['deskripsi']."',
                        '".$coa[0]->coa_dc."',
                        '".$value['subsrd_nominal']."',
                        '".$this->session->userdata('itd_uid')."',
                        '".date('Y-m-d H:i:s')."',
                        '".$this->session->userdata('itd_uid')."',
                        '".date('Y-m-d H:i:s')."',
                        1,
                        '".$value['SI_REFF']."'
                    );
                ");
            }
            $mutasi_trx = $mutasi_trx ? array('msg' => 'Data berhasil masuk ke mutasi') : array('msg' => 'Data Gagal Masuk ke Mutasi');
        }else{
            $mutasi_trx = array('msg' => 'Data Sudah Ada');
        }
        return $mutasi_trx;
    }
    
    function JualObligasiToMutasiBackground($data)
    {
        $client_code = $data['client_code'];
        $date = date('Y-m-d', strtotime($data['date']) );
        $coa_id = $data['coa_id'];
        $acc_no = $data['acc_no'];
        $mutasi_trx = array();
        
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
            A.SI_REFERENCE AS SI_REFF,
            A.HIPORT_CODE AS client_code,
            B.FUND_OPR_ACCT_NO AS acc_no,
            CONVERT ( DATE, A.SETTLEMENT_DATE ) AS subsrd_date,
            CONVERT ( DECIMAL(16,2), A.NET_PROCEEDS ) AS subsrd_nominal,
            A.MODIFIER,
            A.CREATION_DATE,
            A.MODIFICATION_DATE,
            'C007' AS subsrd_kategori,
            'Hasil Jual Obligasi' AS deskripsi 
        FROM
            NFS_FI_INS_INQ_TEMP A
            INNER JOIN FUND_DETAILS B ON B.HIPORT_CODE = A.HIPORT_CODE 
        WHERE
            A.BUY_SELL = '2'  and
            A.HIPORT_CODE = '".$client_code."' and 
            CONVERT ( DATE, A.SETTLEMENT_DATE ) = '".$date."' and
            B.FUND_OPR_ACCT_NO = '".$acc_no."'
        ORDER BY
            subsrd_date DESC
        ");

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
                        [trx_status],
                        [subsrd_id]
                    )VALUES(
                        '".trim($value['client_code'])."',
                        '".trim($value['acc_no'])."',
                        '".$value['subsrd_date']->format('Y-m-d H:i:s')."',
                        '".$coa[0]->coa_no."',
                        '".$coa[0]->coa_desc."',
                        '".$value['deskripsi']."',
                        '".$coa[0]->coa_dc."',
                        '".$value['subsrd_nominal']."',
                        '".$this->session->userdata('itd_uid')."',
                        '".date('Y-m-d H:i:s')."',
                        '".$this->session->userdata('itd_uid')."',
                        '".date('Y-m-d H:i:s')."',
                        1,
                        '".$value['SI_REFF']."'
                    );
                ");    
            }
            $mutasi_trx = $mutasi_trx ? array('msg' => 'Data berhasil masuk ke mutasi') : array('msg' => 'Data Gagal Masuk ke Mutasi');
        }else{
            $mutasi_trx = array('msg' => 'Data Sudah Ada');
        }
        return $mutasi_trx;
    }

    function BeliObligasiToMutasiBackground($data)
    {
        $client_code = $data['client_code'];
        $date = date('Y-m-d', strtotime($data['date']) );
        $coa_id = $data['coa_id'];
        $acc_no = $data['acc_no'];
        $mutasi_trx = array();
        
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
            A.SI_REFERENCE AS SI_REFF,
            A.HIPORT_CODE AS client_code,
            B.FUND_OPR_ACCT_NO AS acc_no,
            CONVERT ( DATE, A.SETTLEMENT_DATE ) AS subsrd_date,
            CONVERT ( DECIMAL(16,2), A.NET_PROCEEDS ) AS subsrd_nominal,
            A.MODIFIER,
            A.CREATION_DATE,
            A.MODIFICATION_DATE,
            'D005' AS subsrd_kategori,
            'Beli Obligasi' AS deskripsi 
        FROM
            NFS_FI_INS_INQ_TEMP A
            INNER JOIN FUND_DETAILS B ON B.HIPORT_CODE = A.HIPORT_CODE 
        WHERE
            A.BUY_SELL = '1'  and
            A.HIPORT_CODE = '".$client_code."' and 
            CONVERT ( DATE, A.SETTLEMENT_DATE ) = '".$date."' and
            B.FUND_OPR_ACCT_NO = '".$acc_no."'
        ORDER BY
            subsrd_date DESC
        ");

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
                        [trx_status],
                        [subsrd_id]
                    )VALUES(
                        '".trim($value['client_code'])."',
                        '".trim($value['acc_no'])."',
                        '".$value['subsrd_date']->format('Y-m-d H:i:s')."',
                        '".$coa[0]->coa_no."',
                        '".$coa[0]->coa_desc."',
                        '".$value['deskripsi']."',
                        '".$coa[0]->coa_dc."',
                        '".$value['subsrd_nominal']."',
                        '".$this->session->userdata('itd_uid')."',
                        '".date('Y-m-d H:i:s')."',
                        '".$this->session->userdata('itd_uid')."',
                        '".date('Y-m-d H:i:s')."',
                        1,
                        '".$value['SI_REFF']."'
                    );
                ");
            }
            $mutasi_trx = $mutasi_trx ? array('msg' => 'Data berhasil masuk ke mutasi') : array('msg' => 'Data Gagal Masuk ke Mutasi');
        }else{
            $mutasi_trx = array('msg' => 'Data Sudah Ada');
        }
        return $mutasi_trx;
    }

    function TaxBrokerToMutasiBackground($data)
    {
        $client_code = $data['client_code'];
        $date = date('Y-m-d', strtotime($data['date']) );
        $coa_id = $data['coa_id'];
        $acc_no = $data['acc_no'];
        $mutasi_trx = array();

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
                A.SI_REFF,
                A.HIPORT_CODE AS client_code,
                CONVERT ( DATE, A.SETTLEMENT_DATE ) AS subsrd_date,
                CONVERT ( DECIMAL(16,2), A.WHT_COMMISION ) AS subsrd_nominal,
                A.MODIFIER,
                A.CREATION_DATE,
                A.MODIFICATION_DATE,
                'D016' AS subsrd_kategori,
                'Wht Commision' AS deskripsi,
                B.FUND_OPR_ACCT_NO AS acc_no 
            FROM
                NFS_INQ_EQUITY_TEMP A
                INNER JOIN FUND_DETAILS B ON B.HIPORT_CODE = A.HIPORT_CODE 
            WHERE
                CONVERT ( DECIMAL(16,2), A.WHT_COMMISION ) > 0 
                AND A.HIPORT_CODE = '".$client_code."' 
                AND CONVERT ( DATE, A.SETTLEMENT_DATE ) = '".$date."' 
                AND B.FUND_OPR_ACCT_NO = '".$acc_no."'
            ORDER BY
                subsrd_date DESC
        ");

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
                        [trx_status],
                        [subsrd_id]
                    )VALUES(
                        '".trim($value['client_code'])."',
                        '".trim($value['acc_no'])."',
                        '".$value['subsrd_date']->format('Y-m-d H:i:s')."',
                        '".$coa[0]->coa_no."',
                        '".$coa[0]->coa_desc."',
                        '".$value['deskripsi']."',
                        '".$coa[0]->coa_dc."',
                        '".$value['subsrd_nominal']."',
                        '".$this->session->userdata('itd_uid')."',
                        '".date('Y-m-d H:i:s')."',
                        '".$this->session->userdata('itd_uid')."',
                        '".date('Y-m-d H:i:s')."',
                        1,
                        '".$value['SI_REFF']."'
                    );
                ");
            }
            $mutasi_trx = $mutasi_trx ? array('msg' => 'Data berhasil masuk ke mutasi') : array('msg' => 'Data Gagal Masuk ke Mutasi');
        }else{
            $mutasi_trx = array('msg' => 'Data Sudah Ada');
        }
        return $mutasi_trx;
    }

    function TaxObligasiToMutasiBackground($data)
    {
        $client_code = $data['client_code'];
        $date = date('Y-m-d', strtotime($data['date']) );
        $coa_id = $data['coa_id'];
        $acc_no = $data['acc_no'];
        $mutasi_trx = array();

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
                A.SI_REFERENCE AS SI_REFF,
                A.HIPORT_CODE AS client_code,
                CONVERT ( DATE, A.SETTLEMENT_DATE ) AS subsrd_date,
                CONVERT ( DECIMAL(16,2), A.CAPITAL_GAIN_TAX ) AS subsrd_nominal,
                A.MODIFIER,
                A.CREATION_DATE,
                A.MODIFICATION_DATE,
                'D017' AS subsrd_kategori,
                'Capital Gain Tax' AS deskripsi,
                B.FUND_OPR_ACCT_NO AS acc_no 
            FROM
                NFS_FI_INS_INQ_TEMP A
                INNER JOIN FUND_DETAILS B ON B.HIPORT_CODE = A.HIPORT_CODE 
            WHERE
                CONVERT ( DECIMAL(16,2), A.CAPITAL_GAIN_TAX ) > 0  
                AND A.HIPORT_CODE = '".$client_code."' 
                AND CONVERT ( DATE, A.SETTLEMENT_DATE ) = '".$date."' 
                AND B.FUND_OPR_ACCT_NO = '".$acc_no."'
                AND BUY_SELL = '1'
            ) AS CAPITAL_GAIN_TAX

            UNION ALL

            SELECT
                * 
            FROM
            (
                SELECT
                    A.SI_REFERENCE AS SI_REFF,
                    A.HIPORT_CODE AS client_code,
                    CONVERT ( DATE, A.SETTLEMENT_DATE ) AS subsrd_date,
                    CONVERT ( DECIMAL(16,2), A.INTEREST_INCOME_TAX ) AS subsrd_nominal,
                    A.MODIFIER,
                    A.CREATION_DATE,
                    A.MODIFICATION_DATE,
                    'D017' AS subsrd_kategori,
                    'Interst Income Tax' AS deskripsi,
                    B.FUND_OPR_ACCT_NO AS acc_no 
                FROM
                    NFS_FI_INS_INQ_TEMP A
                    INNER JOIN FUND_DETAILS B ON B.HIPORT_CODE = A.HIPORT_CODE 
                WHERE
                    CONVERT ( DECIMAL(16,2), A.INTEREST_INCOME_TAX ) > 0 
                    AND A.HIPORT_CODE = '".$client_code."' 
                    AND CONVERT ( DATE, A.SETTLEMENT_DATE ) = '".$date."' 
                    AND B.FUND_OPR_ACCT_NO = '".$acc_no."'
                    AND BUY_SELL = '1' 
            ) AS INTEREST_INCOME_TAX
            
        ");

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
                        [trx_status],
                        [subsrd_id]
                    )VALUES(
                        '".trim($value['client_code'])."',
                        '".trim($value['acc_no'])."',
                        '".$value['subsrd_date']->format('Y-m-d H:i:s')."',
                        '".$coa[0]->coa_no."',
                        '".$coa[0]->coa_desc."',
                        '".$value['deskripsi']."',
                        '".$coa[0]->coa_dc."',
                        '".$value['subsrd_nominal']."',
                        '".$this->session->userdata('itd_uid')."',
                        '".date('Y-m-d H:i:s')."',
                        '".$this->session->userdata('itd_uid')."',
                        '".date('Y-m-d H:i:s')."',
                        1,
                        '".$value['SI_REFF']."'
                    );
                ");
            }
            $mutasi_trx = $mutasi_trx ? array('msg' => 'Data berhasil masuk ke mutasi') : array('msg' => 'Data Gagal Masuk ke Mutasi');
        }else{
            $mutasi_trx = array('msg' => 'Data Sudah Ada');
        }
        return $mutasi_trx;
    }

    // background job end
    
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
            SELECT TOP (1) 
                coa_no,
                coa_desc,
                coa_dc,
                coa_order,
                coa_enable
            FROM coa WHERE coa_no = '".$coa_no."'
        ");

        if ( count( $query->result_array() ) > 0)
        {
            $data = $query->result_array();
            return $data[0];
        }

        return array();
    }

    function ListSubscribe($client_code,$acc_no)
    {
        $query=$this->db_jasgir->query("
            SELECT 
                'subsrd' AS src_dt,
                a.client_code,
                a.subsrd_date,
                SUM ( a.subsrd_nominal ) AS subsrd_nominal,
                a.acc_no_dst AS acc_no ,
                'C002' AS subsrd_kategori,
                'Subscription' AS deskripsi
            FROM
                subsrd a 
            WHERE
                client_code = '".$client_code."' 
                and a.acc_no_dst = '".$acc_no."'
            GROUP BY
                a.client_code,
                a.subsrd_date,
                a.acc_no_dst 
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
                    $coa_desc,
                    $this->MutasiClient($client_code, $value['acc_no'])
                ) 
            );
        }
        return $merge;
    }

    function ListJasaGiro($client_code,$acc_no)
    {
        $return = array();
        $query=$this->db_jasgir->query("
            SELECT
                'subsrd_jasgir' AS src_dt,
                mutasi_giro.client_code,
                mutasi_giro.giro_asof_date AS subsrd_date,
                sum(mutasi_giro.giro_nominal) AS subsrd_nominal,
                'C001' AS subsrd_kategori,
                'Jasa Giro' AS deskripsi,
                mutasi_giro.acc_no 
            FROM
                mutasi_giro
            WHERE
                mutasi_giro.client_code = '".$client_code."' and
                mutasi_giro.acc_no = '".$acc_no."'
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
                    $coa_desc,
                    $this->MutasiClient($client_code, $value['acc_no'])
                ) 
            );
        }
        $return = $merge;
        
        return $return;
    }

    function ListPenempatan($client_code,$acc_no)
    {
        $return = array();
        $query=$this->db_itd->query("
            SELECT
                'itd_Penempatan' AS src_dt,
                trx_client_code AS client_code,
                CONVERT ( DATE, trx_date ) AS subsrd_date,
                SUM(trx_nominal) AS subsrd_nominal,
                'D002' AS subsrd_kategori,
                'Penempatan TD di Bank' AS deskripsi,
                trx_acc_no AS acc_no
            FROM
                itd_trx_approved 
            WHERE
                trx_type = '1' and
                trx_client_code = '".$client_code."' and 
                trx_acc_no = '".$acc_no."'
            GROUP BY
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
                    $coa_desc,
                    $this->MutasiClient($client_code, $value['acc_no'])
                ) 
            );
        }
        $return = $merge;
        
        return $return;
    }

    function ListPencairan($client_code,$acc_no)
    {
        $return = array();
        $query=$this->db_itd->query("
            SELECT 
                'itd_Pencairan ' AS src_dt,
                trx_client_code AS client_code,
                CONVERT ( DATE, trx_date ) AS subsrd_date,
                sum(trx_nominal) AS subsrd_nominal,
                'C003' AS subsrd_kategori,
                trx_acc_no AS acc_no,
                'Pencairan TD dari Bank' AS deskripsi
            FROM
                itd_trx_approved 
            WHERE
                trx_type = '3' and
                trx_client_code = '".$client_code."' and 
                trx_acc_no = '".$acc_no."'
            GROUP BY
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
                    $coa_desc,
                    $this->MutasiClient($client_code, $value['acc_no'])
                ) 
            );
        }
        $return = $merge;
        
        return $return;
    }

    function ListRedemption($client_code,$acc_no)
    {
        $return = array();
        $query=$this->db_urssim->query("
            SELECT 
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
                FUND_ID.CODE_BPM = '".$client_code."' and 
                FUND_ID.ACC_BANK_OPR = '".$acc_no."'
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
                    $coa_desc,
                    $this->MutasiClient($client_code, $value['acc_no'])
                ) 
            );
        }
        $return = $merge;
        
        return $return;
    }

    function ListJualSaham($client_code,$acc_no)
    {
        $return = array();
        $query=$this->db_nfs->query("
            SELECT 
                'nfs_jual' AS src_dt,
                'C006' AS subsrd_kategori,
                'Hasil Jual Saham' AS deskripsi,
                CONVERT ( DATE, A.SETTLEMENT_DATE ) AS subsrd_date,
                SUM ( CONVERT ( DECIMAL(16,2), A.NET_SETTLEMENT_AMOUNT ) ) AS subsrd_nominal,
                A.HIPORT_CODE AS client_code,
                B.FUND_OPR_ACCT_NO AS acc_no 
            FROM
                NFS_INQ_EQUITY_TEMP A
                INNER JOIN FUND_DETAILS B ON B.HIPORT_CODE = A.HIPORT_CODE 
                AND B.ACTIVE_STATUS = 1 
            WHERE
                A.BUY_SELL = '2' 
                AND A.HIPORT_CODE = '".$client_code."'
                AND B.FUND_OPR_ACCT_NO = '".$acc_no."'
            GROUP BY
                B.FUND_OPR_ACCT_NO,
                A.HIPORT_CODE,
                CONVERT ( DATE, A.SETTLEMENT_DATE ) 
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
                    $coa_desc,
                    $this->MutasiClient($client_code, $value['acc_no'])
                ) 
            );
        }
        $return = $merge;
        
        return $return;
    }

    function ListBeliSaham($client_code,$acc_no)
    {
        // EQUITY = saham
        // buy sell = 2 jual 1 beli
        
        $return = array();
        $query=$this->db_nfs->query("
            SELECT 
                'nfs_jual' AS src_dt,
                'D004' AS subsrd_kategori,
                'Beli Saham' AS deskripsi,
                CONVERT ( DATE, A.SETTLEMENT_DATE ) AS subsrd_date,
                SUM ( CONVERT ( DECIMAL(16,2), A.NET_SETTLEMENT_AMOUNT ) ) AS subsrd_nominal,
                A.HIPORT_CODE AS client_code,
                B.FUND_OPR_ACCT_NO AS acc_no 
            FROM
                NFS_INQ_EQUITY_TEMP A
                INNER JOIN FUND_DETAILS B ON B.HIPORT_CODE = A.HIPORT_CODE 
                AND B.ACTIVE_STATUS = 1 
            WHERE
                A.BUY_SELL = '1' 
                AND A.HIPORT_CODE = '".$client_code."'
                AND B.FUND_OPR_ACCT_NO = '".$acc_no."'
            GROUP BY
                B.FUND_OPR_ACCT_NO,
                A.HIPORT_CODE,
                CONVERT ( DATE, A.SETTLEMENT_DATE ) 
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
                    $coa_desc,
                    $this->MutasiClient($client_code, $value['acc_no'])
                ) 
            );
        }
        $return = $merge;
        
        return $return;
    }

    function ListJualObligasi($client_code,$acc_no)
    {
        $return = array();
        $query=$this->db_nfs->query("
            SELECT 
                'nfs_jual' AS src_dt,
                'C007' AS subsrd_kategori,
                'Hasil Jual Obligasi' AS deskripsi,
                CONVERT ( DATE, A.SETTLEMENT_DATE ) AS subsrd_date,
                SUM ( CONVERT ( DECIMAL(16,2), A.NET_PROCEEDS ) ) AS subsrd_nominal,
                A.HIPORT_CODE AS client_code,
                B.FUND_OPR_ACCT_NO AS acc_no 
            FROM
                NFS_FI_INS_INQ_TEMP A
                INNER JOIN FUND_DETAILS B ON B.HIPORT_CODE = A.HIPORT_CODE 
                AND B.ACTIVE_STATUS = 1 
            WHERE
                A.BUY_SELL = '2' 
                AND A.HIPORT_CODE = '".$client_code."'
                AND B.FUND_OPR_ACCT_NO = '".$acc_no."'
            GROUP BY
                B.FUND_OPR_ACCT_NO,
                A.HIPORT_CODE,
                CONVERT ( DATE, A.SETTLEMENT_DATE ) 
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
                    $coa_desc,
                    $this->MutasiClient($client_code, $value['acc_no'])
                ) 
            );
        }
        $return = $merge;
        
        return $return;
    }

    function ListBeliObligasi($client_code,$acc_no)
    {
        // NFS_FI_INS_INQ_TEMP = obligasi
        // buy sell = 1 beli 2 jual
        
        $return = array();
        $query=$this->db_nfs->query("
            SELECT 
                'nfs_jual' AS src_dt,
                'D005' AS subsrd_kategori,
                'Beli Obligasi' AS deskripsi,
                CONVERT ( DATE, A.SETTLEMENT_DATE ) AS subsrd_date,
                SUM ( CONVERT ( DECIMAL(16,2), A.NET_PROCEEDS ) ) AS subsrd_nominal,
                A.HIPORT_CODE AS client_code,
                B.FUND_OPR_ACCT_NO AS acc_no 
            FROM
                NFS_FI_INS_INQ_TEMP A
                INNER JOIN FUND_DETAILS B ON B.HIPORT_CODE = A.HIPORT_CODE 
                AND B.ACTIVE_STATUS = 1 
            WHERE
                A.BUY_SELL = '1' 
                AND A.HIPORT_CODE = '".$client_code."'
                AND B.FUND_OPR_ACCT_NO = '".$acc_no."'
            GROUP BY
                B.FUND_OPR_ACCT_NO,
                A.HIPORT_CODE,
                CONVERT ( DATE, A.SETTLEMENT_DATE ) 
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
                    $coa_desc,
                    $this->MutasiClient($client_code, $value['acc_no'])
                ) 
            );
        }
        $return = $merge;
        
        return $return;
    }

    function ListTaxBroker($client_code,$acc_no)
    {
        // EQUITY = saham
        // buy sell = 1 jual 2 beli

        $return = array();
        $query=$this->db_nfs->query("
            SELECT
                'nfs_Wht_Commision' AS src_dt,
                'D016' AS subsrd_kategori,
                'Wht Commision' AS deskripsi,
                CONVERT ( DATE, A.SETTLEMENT_DATE ) AS subsrd_date,
                sum( CONVERT ( DECIMAL(16,2), WHT_COMMISION ) ) AS subsrd_nominal,
                A.HIPORT_CODE AS client_code,
                B.FUND_OPR_ACCT_NO AS acc_no 
            FROM
                NFS_INQ_EQUITY_TEMP A
                INNER JOIN FUND_DETAILS B ON B.HIPORT_CODE = A.HIPORT_CODE 
                AND B.ACTIVE_STATUS = 1 
            WHERE
                CONVERT ( DECIMAL(16,2), WHT_COMMISION ) > 0
                AND A.HIPORT_CODE = '".$client_code."'
                AND B.FUND_OPR_ACCT_NO = '".$acc_no."'
            GROUP BY
                B.FUND_OPR_ACCT_NO,
                A.HIPORT_CODE,
                CONVERT ( DATE, A.SETTLEMENT_DATE ) 
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
                    $coa_desc,
                    $this->MutasiClient($client_code, $value['acc_no'])
                ) 
            );
        }
        $return = $merge;
        
        return $return;
    }

    function ListTaxObligasi($client_code,$acc_no)
    {
        $return = array();
        $query=$this->db_nfs->query("
            SELECT  
                'nfs_CAPITAL_INTERS_OR_GIANT_TAX' AS src_dt,
                'D017' AS subsrd_kategori,
                'Interst/Gain Income Tax' AS deskripsi,
                CONVERT ( DATE, A.SETTLEMENT_DATE ) AS subsrd_date,
                SUM (
                    CONVERT ( DECIMAL ( 16, 2 ), ISNULL(INTEREST_INCOME_TAX, 0) ) + 
                    CONVERT ( DECIMAL ( 16, 2 ), ISNULL(CAPITAL_GAIN_TAX, 0) )
                ) AS subsrd_nominal,
                A.HIPORT_CODE AS client_code,
                B.FUND_OPR_ACCT_NO AS acc_no 
            FROM
                NFS_FI_INS_INQ_TEMP A
                INNER JOIN FUND_DETAILS B ON B.HIPORT_CODE = A.HIPORT_CODE 
                AND B.ACTIVE_STATUS= 1 
            WHERE
                A.BUY_SELL = '1'
                AND ( 
                    CONVERT ( DECIMAL ( 16, 2 ), ISNULL(INTEREST_INCOME_TAX, 0) ) > 0 or 
                    CONVERT ( DECIMAL ( 16, 2 ), ISNULL(CAPITAL_GAIN_TAX, 0) ) > 0 
                )
                AND A.HIPORT_CODE = '".$client_code."'
                AND B.FUND_OPR_ACCT_NO = '".$acc_no."' 
            GROUP BY
                B.FUND_OPR_ACCT_NO,
                A.HIPORT_CODE,
                CONVERT ( DATE, A.SETTLEMENT_DATE )
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
                    $coa_desc,
                    $this->MutasiClient($client_code, $value['acc_no'])
                ) 
            );
        }
        $return = $merge;
        
        return $return;
    }

    function check_kategori($param)
    {
        $subscription = $this->db_jasgir->query("
            SELECT TOP ( 1 ) a.client_code, a.acc_no_dst AS acc_no
            FROM subsrd a 
            WHERE client_code = '".$param['client_code']."' and a.acc_no_dst = '".$param['acc_no']."'
        ");
        $res_subscription = array();
        if (count( $subscription->result_array() ) == 1) {
            $res_subscription = $this->CoaDescription('C002');
        }

        // $jasa_giro = $this->db_jasgir->query("
        //     SELECT TOP ( 1 ) client_code, acc_no
        //     FROM mutasi_giro
        //     WHERE client_code = '".$param['client_code']."' and acc_no = '".$param['acc_no']."'
        // ");
        // $res_jasa_giro = array();
        // if (count( $jasa_giro->result_array() ) == 1) {
        //     $res_jasa_giro = $this->CoaDescription('C001');
        // }

        $penempatan = $this->db_itd->query("
            SELECT TOP ( 1 ) trx_client_code AS client_code, trx_acc_no AS acc_no
            FROM itd_trx_approved 
            WHERE trx_type = '1' and trx_client_code = '".$param['client_code']."' and trx_acc_no = '".$param['acc_no']."'
        ");
        $res_penempatan = array();
        if (count( $penempatan->result_array() ) == 1) {
            $res_penempatan = $this->CoaDescription('D002');
        }

        $pencairan = $this->db_itd->query("
            SELECT TOP ( 1 ) trx_client_code AS client_code, trx_acc_no AS acc_no
            FROM itd_trx_approved 
            WHERE trx_type = '3' and trx_client_code = '".$param['client_code']."' and trx_acc_no = '".$param['acc_no']."'
        ");
        $res_pencairan = array();
        if (count( $pencairan->result_array() ) == 1) {
            $res_pencairan = $this->CoaDescription('C003');
        }
        
        // $redemption = $this->db_urssim->query("
        //     SELECT TOP ( 1 ) FUND_ID.CODE_BPM AS client_code, FUND_ID.ACC_BANK_OPR AS acc_no 
        //     FROM
        //         TXN_POSTING
        //         INNER JOIN FUND_ID ON TXN_POSTING.FUND_LEVEL_CODE = FUND_ID.FUND_LEVEL_CODE 
        //         AND TXN_POSTING.FUND_UMBRELLA_CODE = FUND_ID.FUND_UMBRELLA_CODE 
        //         AND TXN_POSTING.FUND_GROUP = FUND_ID.FUND_GROUP 
        //         AND TXN_POSTING.FUND_ID = FUND_ID.FUND_ID 
        //     WHERE
        //         TXN_POSTING.TXN_TYPE = 'R' and
        //         FUND_ID.CODE_BPM = '".$param['client_code']."' and 
        //         FUND_ID.ACC_BANK_OPR = '".$param['acc_no']."'
        // ");
        // $res_redemption = array();
        // if (count( $redemption->result_array() ) == 1) {
        //     $res_redemption = $this->CoaDescription('D001');
        // }

        $jual_saham = $this->db_nfs->query("
            SELECT TOP ( 1 ) A.HIPORT_CODE AS client_code, B.FUND_OPR_ACCT_NO AS acc_no 
            FROM
                NFS_INQ_EQUITY_TEMP A
                INNER JOIN FUND_DETAILS B ON B.HIPORT_CODE = A.HIPORT_CODE 
                AND B.ACTIVE_STATUS = 1 
            WHERE
                A.BUY_SELL = '2' 
                AND A.HIPORT_CODE = '".$param['client_code']."'
                AND B.FUND_OPR_ACCT_NO = '".$param['acc_no']."'
        ");
        $res_jual_saham = array();
        if (count( $jual_saham->result_array() ) == 1) {
            $res_jual_saham = $this->CoaDescription('C006');
        }

        $beli_saham = $this->db_nfs->query("
            SELECT TOP ( 1 ) A.HIPORT_CODE AS client_code, B.FUND_OPR_ACCT_NO AS acc_no  
            FROM
                NFS_INQ_EQUITY_TEMP A
                INNER JOIN FUND_DETAILS B ON B.HIPORT_CODE = A.HIPORT_CODE 
                AND B.ACTIVE_STATUS = 1 
            WHERE
                A.BUY_SELL = '1'
                AND A.HIPORT_CODE = '".$param['client_code']."'
                AND B.FUND_OPR_ACCT_NO = '".$param['acc_no']."'
        ");
        $res_beli_saham = array();
        if (count( $beli_saham->result_array() ) == 1) {
            $res_beli_saham = $this->CoaDescription('D004');
        }

        $jual_obligasi = $this->db_nfs->query("
            SELECT TOP ( 1 ) A.HIPORT_CODE AS client_code, B.FUND_OPR_ACCT_NO AS acc_no 
            FROM
                NFS_FI_INS_INQ_TEMP A
                INNER JOIN FUND_DETAILS B ON B.HIPORT_CODE = A.HIPORT_CODE 
                AND B.ACTIVE_STATUS = 1 
            WHERE
                A.BUY_SELL = '2' 
                AND A.HIPORT_CODE = '".$param['client_code']."'
                AND B.FUND_OPR_ACCT_NO = '".$param['acc_no']."'
        ");
        $res_jual_obligasi = array();
        if (count( $jual_obligasi->result_array() ) == 1) {
            $res_jual_obligasi = $this->CoaDescription('C007');
        }

        $beli_obligasi = $this->db_nfs->query("
            SELECT TOP ( 1 ) A.HIPORT_CODE AS client_code, B.FUND_OPR_ACCT_NO AS acc_no  
            FROM
                NFS_FI_INS_INQ_TEMP A
                INNER JOIN FUND_DETAILS B ON B.HIPORT_CODE = A.HIPORT_CODE 
                AND B.ACTIVE_STATUS = 1 
            WHERE
                A.BUY_SELL = '1'
                AND A.HIPORT_CODE = '".$param['client_code']."'
                AND B.FUND_OPR_ACCT_NO = '".$param['acc_no']."'
        ");
        $res_beli_obligasi = array();
        if (count( $beli_obligasi->result_array() ) == 1) {
            $res_beli_obligasi = $this->CoaDescription('D005');
        }

        $tax_broker = $this->db_nfs->query("
            SELECT TOP
                ( 1 )
                A.HIPORT_CODE AS client_code,
                B.FUND_OPR_ACCT_NO AS acc_no 
            FROM
                NFS_INQ_EQUITY_TEMP A
                INNER JOIN FUND_DETAILS B ON B.HIPORT_CODE = A.HIPORT_CODE 
                AND B.ACTIVE_STATUS = 1 
            WHERE
                CONVERT ( DECIMAL ( 16, 2 ), WHT_COMMISION ) > 0
                AND A.HIPORT_CODE = '".$param['client_code']."'
                AND B.FUND_OPR_ACCT_NO = '".$param['acc_no']."'
        ");
        $res_tax_broker = array();
        if (count( $tax_broker->result_array() ) == 1) {
            $res_tax_broker = $this->CoaDescription('D016');
        }

        $tax_obligasi = $this->db_nfs->query("
            SELECT TOP
                ( 1 ) 
                A.HIPORT_CODE AS client_code,
                B.FUND_OPR_ACCT_NO AS acc_no 
            FROM
                NFS_FI_INS_INQ_TEMP A
                INNER JOIN FUND_DETAILS B ON B.HIPORT_CODE = A.HIPORT_CODE 
                AND B.ACTIVE_STATUS= 1 
            WHERE
                A.BUY_SELL = '1'
                AND ( 
                    CONVERT ( DECIMAL ( 16, 2 ), ISNULL(INTEREST_INCOME_TAX, 0) ) > 0 or 
                    CONVERT ( DECIMAL ( 16, 2 ), ISNULL(CAPITAL_GAIN_TAX, 0) ) > 0 
                )
                AND A.HIPORT_CODE = '".$param['client_code']."'
                AND B.FUND_OPR_ACCT_NO = '".$param['acc_no']."'
        ");
        $res_tax_obligasi = array();
        if (count( $tax_obligasi->result_array() ) == 1) {
            $res_tax_obligasi = $this->CoaDescription('D017');
        }
        
        return array(
            $res_subscription,
            // $res_jasa_giro,
            $res_penempatan,
            $res_pencairan,
            // $res_redemption,
            $res_jual_saham,
            $res_jual_obligasi,
            $res_beli_saham,
            $res_beli_obligasi,
            $res_tax_broker,
            $res_tax_obligasi,
        );
    }
    
    function ListSubscribeDetail($client_code,$acc_no,$date)
    {
        $query=$this->db_jasgir->query("
            SELECT 
                a.subsrd_id as id,
                'subsrd' AS src_dt,
                a.client_code,
                a.subsrd_date,
                a.subsrd_nominal,
                a.acc_no_dst AS acc_no,
                'C002' AS subsrd_kategori,
                'Subscription' AS deskripsi
            FROM
                subsrd a 
            WHERE
                client_code = '".$client_code."'
                and a.acc_no_dst = '".$acc_no."'
                and a.subsrd_date = '".$date."'
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
                    $coa_desc,
                    $this->MutasiClient($client_code, $value['acc_no'])
                ) 
            );
        }
        return $merge;
    }

    function ListPenempatanDetail($client_code,$acc_no,$date)
    {
        $query=$this->db_itd->query("
            SELECT
                trx_id as id,
                'itd_Penempatan' AS src_dt,
                trx_client_code AS client_code,
                CONVERT ( DATE, trx_date ) AS subsrd_date,
                trx_nominal AS subsrd_nominal,
                trx_acc_no AS acc_no,
                'D002' AS subsrd_kategori,
                'Penempatan TD di Bank' AS deskripsi
            FROM
                itd_trx_approved
            WHERE
                trx_type = '1' and
                trx_client_code = '".$client_code."' and
                trx_acc_no = '".$acc_no."' and
                CONVERT ( DATE, trx_date ) = '".$date."'
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
                    $coa_desc,
                    $this->MutasiClient($client_code, $value['acc_no'])
                ) 
            );
        }
        return $merge;
    }

    function ListPencairanDetail($client_code,$acc_no,$date)
    {
        $return = array();
        $query=$this->db_itd->query("
            SELECT 
                trx_id as id,
                'itd_Pencairan ' AS src_dt,
                trx_client_code AS client_code,
                CONVERT ( DATE, trx_date ) AS subsrd_date,
                trx_nominal AS subsrd_nominal,
                trx_acc_no AS acc_no,
                'C003' AS subsrd_kategori,
                'Pencairan TD dari Bank' AS deskripsi
            FROM
                itd_trx_approved 
            WHERE
                trx_type = '3' and
                trx_client_code = '".$client_code."' and 
                trx_acc_no = '".$acc_no."' and
                CONVERT ( DATE, trx_date ) = '".$date."'
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
                    $coa_desc,
                    $this->MutasiClient($client_code, $value['acc_no'])
                ) 
            );
        }
        $return = $merge;
        
        return $return;
    }

    function ListRedemptionDetail($client_code,$acc_no,$date)
    {
        $return = array();
        $query=$this->db_urssim->query("
            SELECT 
                'urssim' AS src_dt,
                TXN_POSTING.TXN_TYPE,
                FUND_ID.CODE_BPM AS client_code,
                FUND_ID.ACC_BANK_OPR AS acc_no,
                CONVERT ( DATE, TXN_POSTING.GOOD_FUND_DATE ) AS subsrd_date,
                TXN_POSTING.NET_PROCEED AS subsrd_nominal,
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
                FUND_ID.CODE_BPM = '".$client_code."' and 
                FUND_ID.ACC_BANK_OPR = '".$acc_no."' and
                CONVERT ( DATE, TXN_POSTING.GOOD_FUND_DATE ) = '".$date."'
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
                    $coa_desc,
                    $this->MutasiClient($client_code, $value['acc_no'])
                ) 
            );
        }
        $return = $merge;
        
        return $return;
    }

    function ListJualSahamDetail($client_code,$acc_no,$date)
    {
        $return = array();
        $query=$this->db_nfs->query("
            SELECT 
                A.SI_REFF AS id,
                'nfs_jual' AS src_dt,
                'C006' AS subsrd_kategori,
                'Hasil Jual Saham' AS deskripsi,
                CONVERT ( DATE, A.SETTLEMENT_DATE ) AS subsrd_date,
                CONVERT ( DECIMAL ( 16, 2 ), A.NET_SETTLEMENT_AMOUNT ) AS subsrd_nominal,
                A.HIPORT_CODE AS client_code,
                B.FUND_OPR_ACCT_NO AS acc_no
            FROM
                NFS_INQ_EQUITY_TEMP A
                INNER JOIN FUND_DETAILS B ON B.HIPORT_CODE = A.HIPORT_CODE 
                AND B.ACTIVE_STATUS = 1 
            WHERE
                A.BUY_SELL = '2' 
                AND A.HIPORT_CODE = '".$client_code."'
                AND B.FUND_OPR_ACCT_NO = '".$acc_no."'
                AND CONVERT ( DATE, A.SETTLEMENT_DATE ) = '".$date."'
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
                    $coa_desc,
                    $this->MutasiClient($client_code, $value['acc_no'])
                ) 
            );
        }
        $return = $merge;
        
        return $return;
    }

    function ListJualObligasiDetail($client_code,$acc_no,$date)
    {
        $return = array();
        $query=$this->db_nfs->query("
            SELECT 
                A.SI_REFERENCE AS id,
                'nfs_jual' AS src_dt,
                'C007' AS subsrd_kategori,
                'Hasil Jual Obligasi' AS deskripsi,
                CONVERT ( DATE, A.SETTLEMENT_DATE ) AS subsrd_date,
                CONVERT ( DECIMAL ( 16, 2 ), A.NET_PROCEEDS ) AS subsrd_nominal,
                A.HIPORT_CODE AS client_code,
                B.FUND_OPR_ACCT_NO AS acc_no 
            FROM
                NFS_FI_INS_INQ_TEMP A
                INNER JOIN FUND_DETAILS B ON B.HIPORT_CODE = A.HIPORT_CODE 
                AND B.ACTIVE_STATUS = 1 
            WHERE
                A.BUY_SELL = '2' 
                AND A.HIPORT_CODE = '".$client_code."'
                AND B.FUND_OPR_ACCT_NO = '".$acc_no."'
                AND CONVERT ( DATE, A.SETTLEMENT_DATE )  = '".$date."'
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
                    $coa_desc,
                    $this->MutasiClient($client_code, $value['acc_no'])
                ) 
            );
        }
        $return = $merge;
        
        return $return;
    }

    function ListBeliSahamDetail($client_code,$acc_no,$date)
    {
        // EQUITY = saham
        // buy sell = 1 jual 2 beli
        
        $return = array();
        $query=$this->db_nfs->query("
            SELECT 
                A.SI_REFF AS id,
                'nfs_jual' AS src_dt,
                'D004' AS subsrd_kategori,
                'Beli Saham' AS deskripsi,
                CONVERT ( DATE, A.SETTLEMENT_DATE ) AS subsrd_date,
                CONVERT ( DECIMAL ( 16, 2 ), A.NET_SETTLEMENT_AMOUNT ) AS subsrd_nominal,
                A.HIPORT_CODE AS client_code,
                B.FUND_OPR_ACCT_NO AS acc_no 
            FROM
                NFS_INQ_EQUITY_TEMP A
                INNER JOIN FUND_DETAILS B ON B.HIPORT_CODE = A.HIPORT_CODE 
                AND B.ACTIVE_STATUS = 1 
            WHERE
                A.BUY_SELL = '1' 
                AND A.HIPORT_CODE = '".$client_code."'
                AND B.FUND_OPR_ACCT_NO = '".$acc_no."'
                AND CONVERT ( DATE, A.SETTLEMENT_DATE ) = '".$date."'
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
                    $coa_desc,
                    $this->MutasiClient($client_code, $value['acc_no'])
                ) 
            );
        }
        $return = $merge;
        
        return $return;
    }

    function ListBeliObligasiDetail($client_code,$acc_no,$date)
    {
        // NFS_FI_INS_INQ_TEMP = obligasi
        // buy sell = 1 jual 2 beli
        
        $return = array();
        $query=$this->db_nfs->query("
            SELECT 
                A.SI_REFERENCE AS id,
                'nfs_jual' AS src_dt,
                'D005' AS subsrd_kategori,
                'Beli Obligasi' AS deskripsi,
                CONVERT ( DATE, A.SETTLEMENT_DATE ) AS subsrd_date,
                CONVERT ( DECIMAL ( 16, 2 ), A.NET_PROCEEDS ) AS subsrd_nominal,
                A.HIPORT_CODE AS client_code,
                B.FUND_OPR_ACCT_NO AS acc_no 
            FROM
                NFS_FI_INS_INQ_TEMP A
                INNER JOIN FUND_DETAILS B ON B.HIPORT_CODE = A.HIPORT_CODE 
                AND B.ACTIVE_STATUS = 1 
            WHERE
                A.BUY_SELL = '1' 
                AND A.HIPORT_CODE = '".$client_code."'
                AND B.FUND_OPR_ACCT_NO = '".$acc_no."'
                AND CONVERT ( DATE, A.SETTLEMENT_DATE )  = '".$date."'
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
                    $coa_desc,
                    $this->MutasiClient($client_code, $value['acc_no'])
                ) 
            );
        }
        $return = $merge;
        
        return $return;
    }

    function ListTaxBrokerDetail($client_code,$acc_no,$date)
    {
        // EQUITY = saham
        // buy sell = 1 jual 2 beli

        $return = array();
        $query=$this->db_nfs->query("
            SELECT
                A.SI_REFF AS id,
                'nfs_Wht_Commision' AS src_dt,
                'D016' AS subsrd_kategori,
                'Wht Commision' AS deskripsi,
                CONVERT ( DATE, A.SETTLEMENT_DATE ) AS subsrd_date,
                CONVERT ( DECIMAL ( 16, 2 ), WHT_COMMISION ) AS subsrd_nominal,
                A.HIPORT_CODE AS client_code,
                B.FUND_OPR_ACCT_NO AS acc_no 
            FROM
                NFS_INQ_EQUITY_TEMP A
                INNER JOIN FUND_DETAILS B ON B.HIPORT_CODE = A.HIPORT_CODE 
                AND B.ACTIVE_STATUS = 1 
            WHERE
                CONVERT ( DEC, WHT_COMMISION ) > 0
                AND A.HIPORT_CODE = '".$client_code."'
                AND B.FUND_OPR_ACCT_NO = '".$acc_no."'
                AND CONVERT ( DATE, A.SETTLEMENT_DATE )  = '".$date."'
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
                    $coa_desc,
                    $this->MutasiClient($client_code, $value['acc_no'])
                ) 
            );
        }
        $return = $merge;
        
        return $return;
    }

    function ListTaxObligasiDetail($client_code,$acc_no,$date)
    {
        $return = array();
        $query=$this->db_nfs->query("
            SELECT
                * 
            FROM
            (
            SELECT
                A.SI_REFERENCE AS id,
                A.HIPORT_CODE AS client_code,
                CONVERT ( DATE, A.SETTLEMENT_DATE ) AS subsrd_date,
                CONVERT ( DECIMAL ( 16, 2 ), ISNULL(A.CAPITAL_GAIN_TAX, 0) ) AS subsrd_nominal,
                'D017' AS subsrd_kategori,
                'Capital Gain Tax' AS deskripsi,
                B.FUND_OPR_ACCT_NO AS acc_no 
            FROM
                NFS_FI_INS_INQ_TEMP A
                INNER JOIN FUND_DETAILS B ON B.HIPORT_CODE = A.HIPORT_CODE 
                AND B.ACTIVE_STATUS= 1 
            WHERE
                A.BUY_SELL = '1'
                AND CONVERT ( DECIMAL ( 16, 2 ), ISNULL(A.CAPITAL_GAIN_TAX, 0) ) > 0 
                AND A.HIPORT_CODE = '".$client_code."' 
                AND CONVERT ( DATE, A.SETTLEMENT_DATE ) = '".$date."' 
                AND B.FUND_OPR_ACCT_NO = '".$acc_no."' 
            ) AS CAPITAL_GAIN_TAX

            UNION ALL

            SELECT
                * 
            FROM
            (
                SELECT
                    A.SI_REFERENCE AS id,
                    A.HIPORT_CODE AS client_code,
                    CONVERT ( DATE, A.SETTLEMENT_DATE ) AS subsrd_date,
                    CONVERT ( DECIMAL ( 16, 2 ), ISNULL(A.INTEREST_INCOME_TAX, 0) ) AS subsrd_nominal,
                    'D017' AS subsrd_kategori,
                    'Interst Income Tax' AS deskripsi,
                    B.FUND_OPR_ACCT_NO AS acc_no 
                FROM
                    NFS_FI_INS_INQ_TEMP A
                    INNER JOIN FUND_DETAILS B ON B.HIPORT_CODE = A.HIPORT_CODE 
                    AND B.ACTIVE_STATUS= 1 
                WHERE
                    A.BUY_SELL = '1'
                    AND CONVERT ( DECIMAL ( 16, 2 ), ISNULL(A.INTEREST_INCOME_TAX, 0) ) > 0 
                    AND A.HIPORT_CODE = '".$client_code."' 
                    AND CONVERT ( DATE, A.SETTLEMENT_DATE ) = '".$date."' 
                    AND B.FUND_OPR_ACCT_NO = '".$acc_no."' 
            ) AS INTEREST_INCOME_TAX
        ");
        
        $data = $query->result_array();
        $merge = array();
        foreach ($data as $key => $value) {
            $coa_desc = $this->CoaDescription($value['subsrd_kategori']);
            array_push($merge, 
                array_merge(
                    $value, 
                    $coa_desc,
                    $this->MutasiClient($client_code, $value['acc_no'])
                ) 
            );
        }
        $return = $merge;
        
        return $return;
    }

    function coaXmutasiClient($date)
    {
        $query=$this->db_jasgir->query("
            SELECT
                a.coa_no as coa_id,
                b.client_code,
                b.acc_no,
                '".$date."' as date
            FROM
                coa a
                CROSS JOIN mutasi_client b
            WHERE
                a.coa_enable = 1 AND
                b.client_enable = 1 AND
                a.coa_no in ('C006','C007','D004','D005','D016','D017')
        ");
        $data=$query->result_array();
        return $data;
    }

    function backgroudLog($coa_id,$client_code,$acc_no, $date, $desc, $start_date, $end_date)
    {
        $query=$this->db_jasgir->query("
            INSERT INTO [dbo].[backgroud_log]([coa_id], [client_code], [acc_no], [trx_date], [desc], [start_date], [end_date]) 
            VALUES ( '".$coa_id."','".$client_code."','".$acc_no."','".$date."','".$desc."', '".$start_date."', '".$end_date."' );
        ");
        return $query;
    }
    // function RedemptionToMutasiBatavia($data)
    // {
    //     $client_code = $data['client_code'];
    //     $date = date('Y-m-d', strtotime($data['date']) );
    //     $coa_id = $data['coa_id'];
    //     $acc_no = $data['acc_no'];

    //     $coa = $this->db_jasgir->query("
    //         SELECT 
    //             * 
    //         FROM 
    //             coa
    //         WHERE coa_no = '".$coa_id."'
    //     ");
    //     $coa = $coa->result();
        
    //     $subsrd = $this->db_batavia->query("
    //         SELECT
    //             BATAVIA.dbo.FUND_ID.CREATION_DATE AS CREATION_DATE,
    //             BATAVIA.dbo.FUND_ID.MODIFICATION_DATE AS MODIFICATION_DATE,
    //             BATAVIA.dbo.FUND_ID.MODIFIER AS MODIFIER,
    //             BATAVIA.dbo.FUND_ID.CODE_BPM AS client_code,
    //             BATAVIA.dbo.FUND_ID.ACC_BANK_OPR AS acc_no,
    //             BATAVIA.dbo.TXN_POSTING.GOOD_FUND_DATE AS subsrd_date,
    //             BATAVIA.dbo.TXN_POSTING.NET_PROCEED AS subsrd_nominal,
    //             'D001' AS subsrd_kategori,
    //             'Redemption' AS deskripsi 
    //         FROM
    //             BATAVIA.dbo.TXN_POSTING
    //             INNER JOIN BATAVIA.dbo.FUND_ID ON BATAVIA.dbo.TXN_POSTING.FUND_LEVEL_CODE = BATAVIA.dbo.FUND_ID.FUND_LEVEL_CODE 
    //             AND BATAVIA.dbo.TXN_POSTING.FUND_UMBRELLA_CODE = BATAVIA.dbo.FUND_ID.FUND_UMBRELLA_CODE 
    //             AND BATAVIA.dbo.TXN_POSTING.FUND_GROUP = BATAVIA.dbo.FUND_ID.FUND_GROUP 
    //             AND BATAVIA.dbo.TXN_POSTING.FUND_ID = BATAVIA.dbo.FUND_ID.FUND_ID 
    //         WHERE
    //             BATAVIA.dbo.TXN_POSTING.TXN_TYPE = 'R' and
    //             BATAVIA.dbo.TXN_POSTING.GOOD_FUND_DATE  = '".$date."' and 
    //             BATAVIA.dbo.FUND_ID.ACC_BANK_OPR = '".$acc_no."' and 
    //             BATAVIA.dbo.FUND_ID.CODE_BPM = '".$client_code."'
    //         ORDER BY
    //             subsrd_date DESC
    //     ");

    //  
    //     $check_mutasi = $this->db_jasgir->query("
    //         SELECT 
    //             * 
    //         FROM 
    //             mutasi_trx
    //         WHERE client_code = '".$client_code."' and 
    //         trx_date = '".$date."' and
    //         coa_no = '".$coa[0]->coa_no."' and 
    //         acc_no = '".$acc_no."'
    //     ");
    //     if( count( $check_mutasi->result_array() ) == 0 ){
    //         foreach ($subsrd->result_array() as $key => $value) {
                
    //             $mutasi_trx = $this->db_jasgir->query("
    //                 INSERT INTO [dbo].[mutasi_trx] (
    //                     [client_code],
    //                     [acc_no],
    //                     [trx_date],
    //                     [coa_no],
    //                     [coa_desc],
    //                     [trx_desc],
    //                     [trx_dc],
    //                     [trx_nominal],
    //                     [created_by],
    //                     [created_dt],
    //                     [modified_by],
    //                     [modified_dt],
    //                     [trx_status]
    //                 )VALUES(
    //                     '".trim($value['client_code'])."',
    //                     '".$value['acc_no']."',
    //                     '".$value['subsrd_date']->format('Y-m-d H:i:s')."',
    //                     '".$coa[0]->coa_no."',
    //                     '".$coa[0]->coa_desc."',
    //                     '".$value['deskripsi']."',
    //                     '".$coa[0]->coa_dc."',
    //                     '".$value['subsrd_nominal']."',
    //                     '".$value['MODIFIER']."',
    //                     '".$value['CREATION_DATE']->format('Y-m-d H:i:s')."',
    //                     '".$value['MODIFIER']."',
    //                     '".$value['MODIFICATION_DATE']->format('Y-m-d H:i:s')."',
    //                     1
    //                 );
    //             ");

    //         }
    //     }
    //     return $mutasi_trx;
    // }

    // function RedemptionToMutasiBni($data)
    // {
    //     $client_code = $data['client_code'];
    //     $date = date('Y-m-d', strtotime($data['date']) );
    //     $coa_id = $data['coa_id'];
    //     $acc_no = $data['acc_no'];

    //     $coa = $this->db_jasgir->query("
    //         SELECT 
    //             * 
    //         FROM 
    //             coa
    //         WHERE coa_no = '".$coa_id."'
    //     ");
    //     $coa = $coa->result();
        
    //     $subsrd = $this->db_bni->query("
    //         SELECT
    //             BNI.dbo.FUND_ID.CREATION_DATE AS CREATION_DATE,
    //             BNI.dbo.FUND_ID.MODIFICATION_DATE AS MODIFICATION_DATE,
    //             BNI.dbo.FUND_ID.MODIFIER AS MODIFIER,
    //             BNI.dbo.FUND_ID.CODE_BPM AS client_code,
    //             BNI.dbo.FUND_ID.ACC_BANK_OPR AS acc_no,
    //             BNI.dbo.TXN_POSTING.GOOD_FUND_DATE AS subsrd_date,
    //             BNI.dbo.TXN_POSTING.NET_PROCEED AS subsrd_nominal,
    //             'D001' AS subsrd_kategori,
    //             'Redemption' AS deskripsi 
    //         FROM
    //             BNI.dbo.TXN_POSTING
    //             INNER JOIN BNI.dbo.FUND_ID ON BNI.dbo.TXN_POSTING.FUND_LEVEL_CODE = BNI.dbo.FUND_ID.FUND_LEVEL_CODE 
    //             AND BNI.dbo.TXN_POSTING.FUND_UMBRELLA_CODE = BNI.dbo.FUND_ID.FUND_UMBRELLA_CODE 
    //             AND BNI.dbo.TXN_POSTING.FUND_GROUP = BNI.dbo.FUND_ID.FUND_GROUP 
    //             AND BNI.dbo.TXN_POSTING.FUND_ID = BNI.dbo.FUND_ID.FUND_ID 
    //         WHERE
    //             BNI.dbo.TXN_POSTING.TXN_TYPE = 'R' and
    //             BNI.dbo.TXN_POSTING.GOOD_FUND_DATE  = '".$date."' and 
    //             BNI.dbo.FUND_ID.ACC_BANK_OPR = '".$acc_no."' and 
    //             BNI.dbo.FUND_ID.CODE_BPM = '".$client_code."'
    //         ORDER BY
    //             subsrd_date DESC
    //     ");

    //  
    //     $check_mutasi = $this->db_jasgir->query("
    //         SELECT 
    //             * 
    //         FROM 
    //             mutasi_trx
    //         WHERE client_code = '".$client_code."' and 
    //         trx_date = '".$date."' and
    //         coa_no = '".$coa[0]->coa_no."' and 
    //         acc_no = '".$acc_no."'
    //     ");
    //     if( count( $check_mutasi->result_array() ) == 0 ){
    //         foreach ($subsrd->result_array() as $key => $value) {
                
    //             $mutasi_trx = $this->db_jasgir->query("
    //                 INSERT INTO [dbo].[mutasi_trx] (
    //                     [client_code],
    //                     [acc_no],
    //                     [trx_date],
    //                     [coa_no],
    //                     [coa_desc],
    //                     [trx_desc],
    //                     [trx_dc],
    //                     [trx_nominal],
    //                     [created_by],
    //                     [created_dt],
    //                     [modified_by],
    //                     [modified_dt],
    //                     [trx_status]
    //                 )VALUES(
    //                     '".trim($value['client_code'])."',
    //                     '".$value['acc_no']."',
    //                     '".$value['subsrd_date']->format('Y-m-d H:i:s')."',
    //                     '".$coa[0]->coa_no."',
    //                     '".$coa[0]->coa_desc."',
    //                     '".$value['deskripsi']."',
    //                     '".$coa[0]->coa_dc."',
    //                     '".$value['subsrd_nominal']."',
    //                     '".$value['MODIFIER']."',
    //                     '".$value['CREATION_DATE']->format('Y-m-d H:i:s')."',
    //                     '".$value['MODIFIER']."',
    //                     '".$value['MODIFICATION_DATE']->format('Y-m-d H:i:s')."',
    //                     1
    //                 );
    //             ");

    //         }
    //     }
    //     return $mutasi_trx;
    // }


    /*
    function RedemptionToMutasiEreport($data)
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
        
        $subsrd = $this->db_ereport->query("
            SELECT
                E_REPORT.dbo.FUND_ID.CREATION_DATE AS CREATION_DATE,
                E_REPORT.dbo.FUND_ID.MODIFICATION_DATE AS MODIFICATION_DATE,
                E_REPORT.dbo.FUND_ID.MODIFIER AS MODIFIER,
                E_REPORT.dbo.FUND_ID.CODE_BPM AS client_code,
                E_REPORT.dbo.FUND_ID.ACC_BANK_OPR AS acc_no,
                E_REPORT.dbo.TXN_POSTING.GOOD_FUND_DATE AS subsrd_date,
                E_REPORT.dbo.TXN_POSTING.NET_PROCEED AS subsrd_nominal,
                'D001' AS subsrd_kategori,
                'Redemption' AS deskripsi 
            FROM
                E_REPORT.dbo.TXN_POSTING
                INNER JOIN E_REPORT.dbo.FUND_ID ON E_REPORT.dbo.TXN_POSTING.FUND_LEVEL_CODE = E_REPORT.dbo.FUND_ID.FUND_LEVEL_CODE 
                AND E_REPORT.dbo.TXN_POSTING.FUND_UMBRELLA_CODE = E_REPORT.dbo.FUND_ID.FUND_UMBRELLA_CODE 
                AND E_REPORT.dbo.TXN_POSTING.FUND_GROUP = E_REPORT.dbo.FUND_ID.FUND_GROUP 
                AND E_REPORT.dbo.TXN_POSTING.FUND_ID = E_REPORT.dbo.FUND_ID.FUND_ID 
            WHERE
                E_REPORT.dbo.TXN_POSTING.TXN_TYPE = 'R' and
                E_REPORT.dbo.TXN_POSTING.GOOD_FUND_DATE  = '".$date."' and 
                E_REPORT.dbo.FUND_ID.ACC_BANK_OPR = '".$acc_no."' and 
                E_REPORT.dbo.FUND_ID.CODE_BPM = '".$client_code."'
            ORDER BY
                subsrd_date DESC
        ");

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
                        '".trim($value['client_code'])."',
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
    */
    // function RedemptionToMutasiNiaga($data)
    // {
    //     $client_code = $data['client_code'];
    //     $date = date('Y-m-d', strtotime($data['date']) );
    //     $coa_id = $data['coa_id'];
    //     $acc_no = $data['acc_no'];

    //     $coa = $this->db_jasgir->query("
    //         SELECT 
    //             * 
    //         FROM 
    //             coa
    //         WHERE coa_no = '".$coa_id."'
    //     ");
    //     $coa = $coa->result();
        
    //     $subsrd = $this->db_niaga->query("
    //         SELECT
    //             NIAGA.dbo.FUND_ID.CREATION_DATE AS CREATION_DATE,
    //             NIAGA.dbo.FUND_ID.MODIFICATION_DATE AS MODIFICATION_DATE,
    //             NIAGA.dbo.FUND_ID.MODIFIER AS MODIFIER,
    //             NIAGA.dbo.FUND_ID.CODE_BPM AS client_code,
    //             NIAGA.dbo.FUND_ID.ACC_BANK_OPR AS acc_no,
    //             NIAGA.dbo.TXN_POSTING.GOOD_FUND_DATE AS subsrd_date,
    //             NIAGA.dbo.TXN_POSTING.NET_PROCEED AS subsrd_nominal,
    //             'D001' AS subsrd_kategori,
    //             'Redemption' AS deskripsi 
    //         FROM
    //             NIAGA.dbo.TXN_POSTING
    //             INNER JOIN NIAGA.dbo.FUND_ID ON NIAGA.dbo.TXN_POSTING.FUND_LEVEL_CODE = NIAGA.dbo.FUND_ID.FUND_LEVEL_CODE 
    //             AND NIAGA.dbo.TXN_POSTING.FUND_UMBRELLA_CODE = NIAGA.dbo.FUND_ID.FUND_UMBRELLA_CODE 
    //             AND NIAGA.dbo.TXN_POSTING.FUND_GROUP = NIAGA.dbo.FUND_ID.FUND_GROUP 
    //             AND NIAGA.dbo.TXN_POSTING.FUND_ID = NIAGA.dbo.FUND_ID.FUND_ID 
    //         WHERE
    //             NIAGA.dbo.TXN_POSTING.TXN_TYPE = 'R' and
    //             NIAGA.dbo.TXN_POSTING.GOOD_FUND_DATE  = '".$date."' and 
    //             NIAGA.dbo.FUND_ID.ACC_BANK_OPR = '".$acc_no."' and 
    //             NIAGA.dbo.FUND_ID.CODE_BPM = '".$client_code."'
    //         ORDER BY
    //             subsrd_date DESC
    //     ");

    //  
    //     $check_mutasi = $this->db_jasgir->query("
    //         SELECT 
    //             * 
    //         FROM 
    //             mutasi_trx
    //         WHERE client_code = '".$client_code."' and 
    //         trx_date = '".$date."' and
    //         coa_no = '".$coa[0]->coa_no."' and 
    //         acc_no = '".$acc_no."'
    //     ");
    //     if( count( $check_mutasi->result_array() ) == 0 ){
    //         foreach ($subsrd->result_array() as $key => $value) {
                
    //             $mutasi_trx = $this->db_jasgir->query("
    //                 INSERT INTO [dbo].[mutasi_trx] (
    //                     [client_code],
    //                     [acc_no],
    //                     [trx_date],
    //                     [coa_no],
    //                     [coa_desc],
    //                     [trx_desc],
    //                     [trx_dc],
    //                     [trx_nominal],
    //                     [created_by],
    //                     [created_dt],
    //                     [modified_by],
    //                     [modified_dt],
    //                     [trx_status]
    //                 )VALUES(
    //                     '".trim($value['client_code'])."',
    //                     '".$value['acc_no']."',
    //                     '".$value['subsrd_date']->format('Y-m-d H:i:s')."',
    //                     '".$coa[0]->coa_no."',
    //                     '".$coa[0]->coa_desc."',
    //                     '".$value['deskripsi']."',
    //                     '".$coa[0]->coa_dc."',
    //                     '".$value['subsrd_nominal']."',
    //                     '".$value['MODIFIER']."',
    //                     '".$value['CREATION_DATE']->format('Y-m-d H:i:s')."',
    //                     '".$value['MODIFIER']."',
    //                     '".$value['MODIFICATION_DATE']->format('Y-m-d H:i:s')."',
    //                     1
    //                 );
    //             ");

    //         }
    //     }
    //     return $mutasi_trx;
    // }

    // function RedemptionToMutasiSyailendra($data)
    // {
    //     $client_code = $data['client_code'];
    //     $date = date('Y-m-d', strtotime($data['date']) );
    //     $coa_id = $data['coa_id'];
    //     $acc_no = $data['acc_no'];

    //     $coa = $this->db_jasgir->query("
    //         SELECT 
    //             * 
    //         FROM 
    //             coa
    //         WHERE coa_no = '".$coa_id."'
    //     ");
    //     $coa = $coa->result();
        
    //     $subsrd = $this->db_syailendra->query("
    //         SELECT
    //             SYAILENDRA.dbo.FUND_ID.CREATION_DATE AS CREATION_DATE,
    //             SYAILENDRA.dbo.FUND_ID.MODIFICATION_DATE AS MODIFICATION_DATE,
    //             SYAILENDRA.dbo.FUND_ID.MODIFIER AS MODIFIER,
    //             SYAILENDRA.dbo.FUND_ID.CODE_BPM AS client_code,
    //             SYAILENDRA.dbo.FUND_ID.ACC_BANK_OPR AS acc_no,
    //             SYAILENDRA.dbo.TXN_POSTING.GOOD_FUND_DATE AS subsrd_date,
    //             SYAILENDRA.dbo.TXN_POSTING.NET_PROCEED AS subsrd_nominal,
    //             'D001' AS subsrd_kategori,
    //             'Redemption' AS deskripsi 
    //         FROM
    //             SYAILENDRA.dbo.TXN_POSTING
    //             INNER JOIN SYAILENDRA.dbo.FUND_ID ON SYAILENDRA.dbo.TXN_POSTING.FUND_LEVEL_CODE = SYAILENDRA.dbo.FUND_ID.FUND_LEVEL_CODE 
    //             AND SYAILENDRA.dbo.TXN_POSTING.FUND_UMBRELLA_CODE = SYAILENDRA.dbo.FUND_ID.FUND_UMBRELLA_CODE 
    //             AND SYAILENDRA.dbo.TXN_POSTING.FUND_GROUP = SYAILENDRA.dbo.FUND_ID.FUND_GROUP 
    //             AND SYAILENDRA.dbo.TXN_POSTING.FUND_ID = SYAILENDRA.dbo.FUND_ID.FUND_ID 
    //         WHERE
    //             SYAILENDRA.dbo.TXN_POSTING.TXN_TYPE = 'R' and
    //             SYAILENDRA.dbo.TXN_POSTING.GOOD_FUND_DATE  = '".$date."' and 
    //             SYAILENDRA.dbo.FUND_ID.ACC_BANK_OPR = '".$acc_no."' and 
    //             SYAILENDRA.dbo.FUND_ID.CODE_BPM = '".$client_code."'
    //         ORDER BY
    //             subsrd_date DESC
    //     ");

    //  
    //     $check_mutasi = $this->db_jasgir->query("
    //         SELECT 
    //             * 
    //         FROM 
    //             mutasi_trx
    //         WHERE client_code = '".$client_code."' and 
    //         trx_date = '".$date."' and
    //         coa_no = '".$coa[0]->coa_no."' and 
    //         acc_no = '".$acc_no."'
    //     ");
    //     if( count( $check_mutasi->result_array() ) == 0 ){
    //         foreach ($subsrd->result_array() as $key => $value) {
                
    //             $mutasi_trx = $this->db_jasgir->query("
    //                 INSERT INTO [dbo].[mutasi_trx] (
    //                     [client_code],
    //                     [acc_no],
    //                     [trx_date],
    //                     [coa_no],
    //                     [coa_desc],
    //                     [trx_desc],
    //                     [trx_dc],
    //                     [trx_nominal],
    //                     [created_by],
    //                     [created_dt],
    //                     [modified_by],
    //                     [modified_dt],
    //                     [trx_status]
    //                 )VALUES(
    //                     '".trim($value['client_code'])."',
    //                     '".$value['acc_no']."',
    //                     '".$value['subsrd_date']->format('Y-m-d H:i:s')."',
    //                     '".$coa[0]->coa_no."',
    //                     '".$coa[0]->coa_desc."',
    //                     '".$value['deskripsi']."',
    //                     '".$coa[0]->coa_dc."',
    //                     '".$value['subsrd_nominal']."',
    //                     '".$value['MODIFIER']."',
    //                     '".$value['CREATION_DATE']->format('Y-m-d H:i:s')."',
    //                     '".$value['MODIFIER']."',
    //                     '".$value['MODIFICATION_DATE']->format('Y-m-d H:i:s')."',
    //                     1
    //                 );
    //             ");

    //         }
    //     }
    //     return $mutasi_trx;
    // }

    // function RedemptionToMutasiTrimegah($data)
    // {
    //     $client_code = $data['client_code'];
    //     $date = date('Y-m-d', strtotime($data['date']) );
    //     $coa_id = $data['coa_id'];
    //     $acc_no = $data['acc_no'];

    //     $coa = $this->db_jasgir->query("
    //         SELECT 
    //             * 
    //         FROM 
    //             coa
    //         WHERE coa_no = '".$coa_id."'
    //     ");
    //     $coa = $coa->result();
        
    //     $subsrd = $this->db_trimegah->query("
    //         SELECT
    //             TRIMEGAH.dbo.FUND_ID.CREATION_DATE AS CREATION_DATE,
    //             TRIMEGAH.dbo.FUND_ID.MODIFICATION_DATE AS MODIFICATION_DATE,
    //             TRIMEGAH.dbo.FUND_ID.MODIFIER AS MODIFIER,
    //             TRIMEGAH.dbo.FUND_ID.CODE_BPM AS client_code,
    //             TRIMEGAH.dbo.FUND_ID.ACC_BANK_OPR AS acc_no,
    //             TRIMEGAH.dbo.TXN_POSTING.GOOD_FUND_DATE AS subsrd_date,
    //             TRIMEGAH.dbo.TXN_POSTING.NET_PROCEED AS subsrd_nominal,
    //             'D001' AS subsrd_kategori,
    //             'Redemption' AS deskripsi 
    //         FROM
    //             TRIMEGAH.dbo.TXN_POSTING
    //             INNER JOIN TRIMEGAH.dbo.FUND_ID ON TRIMEGAH.dbo.TXN_POSTING.FUND_LEVEL_CODE = TRIMEGAH.dbo.FUND_ID.FUND_LEVEL_CODE 
    //             AND TRIMEGAH.dbo.TXN_POSTING.FUND_UMBRELLA_CODE = TRIMEGAH.dbo.FUND_ID.FUND_UMBRELLA_CODE 
    //             AND TRIMEGAH.dbo.TXN_POSTING.FUND_GROUP = TRIMEGAH.dbo.FUND_ID.FUND_GROUP 
    //             AND TRIMEGAH.dbo.TXN_POSTING.FUND_ID = TRIMEGAH.dbo.FUND_ID.FUND_ID 
    //         WHERE
    //             TRIMEGAH.dbo.TXN_POSTING.TXN_TYPE = 'R' and
    //             TRIMEGAH.dbo.TXN_POSTING.GOOD_FUND_DATE  = '".$date."' and 
    //             TRIMEGAH.dbo.FUND_ID.ACC_BANK_OPR = '".$acc_no."' and 
    //             TRIMEGAH.dbo.FUND_ID.CODE_BPM = '".$client_code."'
    //         ORDER BY
    //             subsrd_date DESC
    //     ");

    //  
    //     $check_mutasi = $this->db_jasgir->query("
    //         SELECT 
    //             * 
    //         FROM 
    //             mutasi_trx
    //         WHERE client_code = '".$client_code."' and 
    //         trx_date = '".$date."' and
    //         coa_no = '".$coa[0]->coa_no."' and 
    //         acc_no = '".$acc_no."'
    //     ");
    //     if( count( $check_mutasi->result_array() ) == 0 ){
    //         foreach ($subsrd->result_array() as $key => $value) {
                
    //             $mutasi_trx = $this->db_jasgir->query("
    //                 INSERT INTO [dbo].[mutasi_trx] (
    //                     [client_code],
    //                     [acc_no],
    //                     [trx_date],
    //                     [coa_no],
    //                     [coa_desc],
    //                     [trx_desc],
    //                     [trx_dc],
    //                     [trx_nominal],
    //                     [created_by],
    //                     [created_dt],
    //                     [modified_by],
    //                     [modified_dt],
    //                     [trx_status]
    //                 )VALUES(
    //                     '".trim($value['client_code'])."',
    //                     '".$value['acc_no']."',
    //                     '".$value['subsrd_date']->format('Y-m-d H:i:s')."',
    //                     '".$coa[0]->coa_no."',
    //                     '".$coa[0]->coa_desc."',
    //                     '".$value['deskripsi']."',
    //                     '".$coa[0]->coa_dc."',
    //                     '".$value['subsrd_nominal']."',
    //                     '".$value['MODIFIER']."',
    //                     '".$value['CREATION_DATE']->format('Y-m-d H:i:s')."',
    //                     '".$value['MODIFIER']."',
    //                     '".$value['MODIFICATION_DATE']->format('Y-m-d H:i:s')."',
    //                     1
    //                 );
    //             ");

    //         }
    //     }
    //     return $mutasi_trx;
    // }

    // function RedemptionToMutasiTugu($data)
    // {
    //     $client_code = $data['client_code'];
    //     $date = date('Y-m-d', strtotime($data['date']) );
    //     $coa_id = $data['coa_id'];
    //     $acc_no = $data['acc_no'];

    //     $coa = $this->db_jasgir->query("
    //         SELECT 
    //             * 
    //         FROM 
    //             coa
    //         WHERE coa_no = '".$coa_id."'
    //     ");
    //     $coa = $coa->result();
        
    //     $subsrd = $this->db_tugu->query("
    //         SELECT
    //             TUGU_MANDIRI.dbo.FUND_ID.CREATION_DATE AS CREATION_DATE,
    //             TUGU_MANDIRI.dbo.FUND_ID.MODIFICATION_DATE AS MODIFICATION_DATE,
    //             TUGU_MANDIRI.dbo.FUND_ID.MODIFIER AS MODIFIER,
    //             TUGU_MANDIRI.dbo.FUND_ID.CODE_BPM AS client_code,
    //             TUGU_MANDIRI.dbo.FUND_ID.ACC_BANK_OPR AS acc_no,
    //             TUGU_MANDIRI.dbo.TXN_POSTING.GOOD_FUND_DATE AS subsrd_date,
    //             TUGU_MANDIRI.dbo.TXN_POSTING.NET_PROCEED AS subsrd_nominal,
    //             'D001' AS subsrd_kategori,
    //             'Redemption' AS deskripsi 
    //         FROM
    //             TUGU_MANDIRI.dbo.TXN_POSTING
    //             INNER JOIN TUGU_MANDIRI.dbo.FUND_ID ON TUGU_MANDIRI.dbo.TXN_POSTING.FUND_LEVEL_CODE = TUGU_MANDIRI.dbo.FUND_ID.FUND_LEVEL_CODE 
    //             AND TUGU_MANDIRI.dbo.TXN_POSTING.FUND_UMBRELLA_CODE = TUGU_MANDIRI.dbo.FUND_ID.FUND_UMBRELLA_CODE 
    //             AND TUGU_MANDIRI.dbo.TXN_POSTING.FUND_GROUP = TUGU_MANDIRI.dbo.FUND_ID.FUND_GROUP 
    //             AND TUGU_MANDIRI.dbo.TXN_POSTING.FUND_ID = TUGU_MANDIRI.dbo.FUND_ID.FUND_ID 
    //         WHERE
    //             TUGU_MANDIRI.dbo.TXN_POSTING.TXN_TYPE = 'R' and
    //             TUGU_MANDIRI.dbo.TXN_POSTING.GOOD_FUND_DATE  = '".$date."' and 
    //             TUGU_MANDIRI.dbo.FUND_ID.ACC_BANK_OPR = '".$acc_no."' and 
    //             TUGU_MANDIRI.dbo.FUND_ID.CODE_BPM = '".$client_code."'
    //         ORDER BY
    //             subsrd_date DESC
    //     ");

    //  
    //     $check_mutasi = $this->db_jasgir->query("
    //         SELECT 
    //             * 
    //         FROM 
    //             mutasi_trx
    //         WHERE client_code = '".$client_code."' and 
    //         trx_date = '".$date."' and
    //         coa_no = '".$coa[0]->coa_no."' and 
    //         acc_no = '".$acc_no."'
    //     ");
    //     if( count( $check_mutasi->result_array() ) == 0 ){
    //         foreach ($subsrd->result_array() as $key => $value) {
                
    //             $mutasi_trx = $this->db_jasgir->query("
    //                 INSERT INTO [dbo].[mutasi_trx] (
    //                     [client_code],
    //                     [acc_no],
    //                     [trx_date],
    //                     [coa_no],
    //                     [coa_desc],
    //                     [trx_desc],
    //                     [trx_dc],
    //                     [trx_nominal],
    //                     [created_by],
    //                     [created_dt],
    //                     [modified_by],
    //                     [modified_dt],
    //                     [trx_status]
    //                 )VALUES(
    //                     '".trim($value['client_code'])."',
    //                     '".$value['acc_no']."',
    //                     '".$value['subsrd_date']->format('Y-m-d H:i:s')."',
    //                     '".$coa[0]->coa_no."',
    //                     '".$coa[0]->coa_desc."',
    //                     '".$value['deskripsi']."',
    //                     '".$coa[0]->coa_dc."',
    //                     '".$value['subsrd_nominal']."',
    //                     '".$value['MODIFIER']."',
    //                     '".$value['CREATION_DATE']->format('Y-m-d H:i:s')."',
    //                     '".$value['MODIFIER']."',
    //                     '".$value['MODIFICATION_DATE']->format('Y-m-d H:i:s')."',
    //                     1
    //                 );
    //             ");

    //         }
    //     }
    //     return $mutasi_trx;
    // }


    // function ListRedemptionBatavia($client_code)
    // {
    //     $return = array();
    //     if( $this->CheckMutasiClient($client_code) ){
    //         $query=$this->db_batavia->query("
    //             SELECT TOP
    //                 ( 200 ) 
    //                 'Batavia' AS src_dt,
    //                 TXN_POSTING.TXN_TYPE,
    //                 FUND_ID.CODE_BPM AS client_code,
    //                 FUND_ID.ACC_BANK_OPR AS acc_no,
    //                 CONVERT ( DATE, TXN_POSTING.GOOD_FUND_DATE ) AS subsrd_date,
    //                 SUM ( TXN_POSTING.NET_PROCEED ) AS subsrd_nominal,
    //                 'D001' AS subsrd_kategori,
    //                 'Redemption' AS deskripsi 
    //             FROM
    //                 TXN_POSTING
    //                 INNER JOIN FUND_ID ON TXN_POSTING.FUND_LEVEL_CODE = FUND_ID.FUND_LEVEL_CODE 
    //                 AND TXN_POSTING.FUND_UMBRELLA_CODE = FUND_ID.FUND_UMBRELLA_CODE 
    //                 AND TXN_POSTING.FUND_GROUP = FUND_ID.FUND_GROUP 
    //                 AND TXN_POSTING.FUND_ID = FUND_ID.FUND_ID 
    //             WHERE
    //                 TXN_POSTING.TXN_TYPE = 'R' and
    //                 FUND_ID.CODE_BPM like '%".$client_code."%' and 
    //                 FUND_ID.ACC_BANK_OPR in (".$this->MutasiClientAccNo($client_code).")
    //             GROUP BY
    //                 TXN_POSTING.TXN_TYPE,
    //                 FUND_ID.CODE_BPM,
    //                 FUND_ID.ACC_BANK_OPR,
    //                 CONVERT ( DATE, TXN_POSTING.GOOD_FUND_DATE ) 
    //             ORDER BY
    //                 subsrd_date DESC
    //         ");
            
    //         $data = $query->result_array();
    //         $merge = array();
    //         foreach ($data as $key => $value) {
    //             $coa_desc = $this->CoaDescription($value['subsrd_kategori']);
    //             array_push($merge, 
    //                 array_merge(
    //                     $value, 
    //                     array('coa_desc'=>$coa_desc),
    //                     $this->MutasiClient($client_code, $value['acc_no'])
    //                 ) 
    //             );
    //         }
    //         $return = $merge;
    //     }
        
    //     return $return;
    // }

    // function ListRedemptionBni($client_code)
    // {
    //     $return = array();
    //     if( $this->CheckMutasiClient($client_code) ){
    //         $query=$this->db_bni->query("
    //             SELECT TOP
    //                 ( 200 ) 
    //                 'Bni' AS src_dt,
    //                 TXN_POSTING.TXN_TYPE,
    //                 FUND_ID.CODE_BPM AS client_code,
    //                 FUND_ID.ACC_BANK_OPR AS acc_no,
    //                 CONVERT ( DATE, TXN_POSTING.GOOD_FUND_DATE ) AS subsrd_date,
    //                 SUM ( TXN_POSTING.NET_PROCEED ) AS subsrd_nominal,
    //                 'D001' AS subsrd_kategori,
    //                 'Redemption' AS deskripsi 
    //             FROM
    //                 TXN_POSTING
    //                 INNER JOIN FUND_ID ON TXN_POSTING.FUND_LEVEL_CODE = FUND_ID.FUND_LEVEL_CODE 
    //                 AND TXN_POSTING.FUND_UMBRELLA_CODE = FUND_ID.FUND_UMBRELLA_CODE 
    //                 AND TXN_POSTING.FUND_GROUP = FUND_ID.FUND_GROUP 
    //                 AND TXN_POSTING.FUND_ID = FUND_ID.FUND_ID 
    //             WHERE
    //                 TXN_POSTING.TXN_TYPE = 'R' and
    //                 FUND_ID.CODE_BPM like '%".$client_code."%' and 
    //                 FUND_ID.ACC_BANK_OPR in (".$this->MutasiClientAccNo($client_code).")
    //             GROUP BY
    //                 TXN_POSTING.TXN_TYPE,
    //                 FUND_ID.CODE_BPM,
    //                 FUND_ID.ACC_BANK_OPR,
    //                 CONVERT ( DATE, TXN_POSTING.GOOD_FUND_DATE ) 
    //             ORDER BY
    //                 subsrd_date DESC
    //         ");
            
    //         $data = $query->result_array();
    //         $merge = array();
    //         foreach ($data as $key => $value) {
    //             $coa_desc = $this->CoaDescription($value['subsrd_kategori']);
    //             array_push($merge, 
    //                 array_merge(
    //                     $value, 
    //                     array('coa_desc'=>$coa_desc),
    //                     $this->MutasiClient($client_code, $value['acc_no'])
    //                 ) 
    //             );
    //         }
    //         $return = $merge;
    //     }
        
    //     return $return;
    // }


    // /*
    // function ListRedemptionEreport($client_code)
    // {
    //     $return = array();
    //     if( $this->CheckMutasiClient($client_code) ){
    //         $query=$this->db_ereport->query("
    //             SELECT TOP
    //                 ( 200 ) 
    //                 'E_report' AS src_dt,
    //                 TXN_POSTING.TXN_TYPE,
    //                 FUND_ID.CODE_BPM AS client_code,
    //                 FUND_ID.ACC_BANK_OPR AS acc_no,
    //                 CONVERT ( DATE, TXN_POSTING.GOOD_FUND_DATE ) AS subsrd_date,
    //                 SUM ( TXN_POSTING.NET_PROCEED ) AS subsrd_nominal,
    //                 'D001' AS subsrd_kategori,
    //                 'Redemption' AS deskripsi 
    //             FROM
    //                 TXN_POSTING
    //                 INNER JOIN FUND_ID ON TXN_POSTING.FUND_LEVEL_CODE = FUND_ID.FUND_LEVEL_CODE 
    //                 AND TXN_POSTING.FUND_UMBRELLA_CODE = FUND_ID.FUND_UMBRELLA_CODE 
    //                 AND TXN_POSTING.FUND_GROUP = FUND_ID.FUND_GROUP 
    //                 AND TXN_POSTING.FUND_ID = FUND_ID.FUND_ID 
    //             WHERE
    //                 TXN_POSTING.TXN_TYPE = 'R' and
    //                 FUND_ID.CODE_BPM like '%".$client_code."%' and 
    //                 FUND_ID.ACC_BANK_OPR in (".$this->MutasiClientAccNo($client_code).")
    //             GROUP BY
    //                 TXN_POSTING.TXN_TYPE,
    //                 FUND_ID.CODE_BPM,
    //                 FUND_ID.ACC_BANK_OPR,
    //                 CONVERT ( DATE, TXN_POSTING.GOOD_FUND_DATE ) 
    //             ORDER BY
    //                 subsrd_date DESC
    //         ");
            
    //         $data = $query->result_array();
    //         $merge = array();
    //         foreach ($data as $key => $value) {
    //             $coa_desc = $this->CoaDescription($value['subsrd_kategori']);
    //             array_push($merge, 
    //                 array_merge(
    //                     $value, 
    //                     array('coa_desc'=>$coa_desc),
    //                     $this->MutasiClient($client_code, $value['acc_no'])
    //                 ) 
    //             );
    //         }
    //         $return = $merge;
    //     }
        
    //     return $return;
    // }
    // */
    // function ListRedemptionNiaga($client_code)
    // {
    //     $return = array();
    //     if( $this->CheckMutasiClient($client_code) ){
    //         $query=$this->db_niaga->query("
    //             SELECT TOP
    //                 ( 200 ) 
    //                 'Niaga' AS src_dt,
    //                 TXN_POSTING.TXN_TYPE,
    //                 FUND_ID.CODE_BPM AS client_code,
    //                 FUND_ID.ACC_BANK_OPR AS acc_no,
    //                 CONVERT ( DATE, TXN_POSTING.GOOD_FUND_DATE ) AS subsrd_date,
    //                 SUM ( TXN_POSTING.NET_PROCEED ) AS subsrd_nominal,
    //                 'D001' AS subsrd_kategori,
    //                 'Redemption' AS deskripsi 
    //             FROM
    //                 TXN_POSTING
    //                 INNER JOIN FUND_ID ON TXN_POSTING.FUND_LEVEL_CODE = FUND_ID.FUND_LEVEL_CODE 
    //                 AND TXN_POSTING.FUND_UMBRELLA_CODE = FUND_ID.FUND_UMBRELLA_CODE 
    //                 AND TXN_POSTING.FUND_GROUP = FUND_ID.FUND_GROUP 
    //                 AND TXN_POSTING.FUND_ID = FUND_ID.FUND_ID 
    //             WHERE
    //                 TXN_POSTING.TXN_TYPE = 'R' and
    //                 FUND_ID.CODE_BPM like '%".$client_code."%' and 
    //                 FUND_ID.ACC_BANK_OPR in (".$this->MutasiClientAccNo($client_code).")
    //             GROUP BY
    //                 TXN_POSTING.TXN_TYPE,
    //                 FUND_ID.CODE_BPM,
    //                 FUND_ID.ACC_BANK_OPR,
    //                 CONVERT ( DATE, TXN_POSTING.GOOD_FUND_DATE ) 
    //             ORDER BY
    //                 subsrd_date DESC
    //         ");
            
    //         $data = $query->result_array();
    //         $merge = array();
    //         foreach ($data as $key => $value) {
    //             $coa_desc = $this->CoaDescription($value['subsrd_kategori']);
    //             array_push($merge, 
    //                 array_merge(
    //                     $value, 
    //                     array('coa_desc'=>$coa_desc),
    //                     $this->MutasiClient($client_code, $value['acc_no'])
    //                 ) 
    //             );
    //         }
    //         $return = $merge;
    //     }
        
    //     return $return;
    // }

    
    // function ListRedemptionSyailendra($client_code)
    // {
    //     $return = array();
    //     if( $this->CheckMutasiClient($client_code) ){
    //         $query=$this->db_syailendra->query("
    //             SELECT TOP
    //                 ( 200 ) 
    //                 'Syailendra' AS src_dt,
    //                 TXN_POSTING.TXN_TYPE,
    //                 FUND_ID.CODE_BPM AS client_code,
    //                 FUND_ID.ACC_BANK_OPR AS acc_no,
    //                 CONVERT ( DATE, TXN_POSTING.GOOD_FUND_DATE ) AS subsrd_date,
    //                 SUM ( TXN_POSTING.NET_PROCEED ) AS subsrd_nominal,
    //                 'D001' AS subsrd_kategori,
    //                 'Redemption' AS deskripsi 
    //             FROM
    //                 TXN_POSTING
    //                 INNER JOIN FUND_ID ON TXN_POSTING.FUND_LEVEL_CODE = FUND_ID.FUND_LEVEL_CODE 
    //                 AND TXN_POSTING.FUND_UMBRELLA_CODE = FUND_ID.FUND_UMBRELLA_CODE 
    //                 AND TXN_POSTING.FUND_GROUP = FUND_ID.FUND_GROUP 
    //                 AND TXN_POSTING.FUND_ID = FUND_ID.FUND_ID 
    //             WHERE
    //                 TXN_POSTING.TXN_TYPE = 'R' and
    //                 FUND_ID.CODE_BPM like '%".$client_code."%' and 
    //                 FUND_ID.ACC_BANK_OPR in (".$this->MutasiClientAccNo($client_code).")
    //             GROUP BY
    //                 TXN_POSTING.TXN_TYPE,
    //                 FUND_ID.CODE_BPM,
    //                 FUND_ID.ACC_BANK_OPR,
    //                 CONVERT ( DATE, TXN_POSTING.GOOD_FUND_DATE ) 
    //             ORDER BY
    //                 subsrd_date DESC
    //         ");
            
    //         $data = $query->result_array();
    //         $merge = array();
    //         foreach ($data as $key => $value) {
    //             $coa_desc = $this->CoaDescription($value['subsrd_kategori']);
    //             array_push($merge, 
    //                 array_merge(
    //                     $value, 
    //                     array('coa_desc'=>$coa_desc),
    //                     $this->MutasiClient($client_code, $value['acc_no'])
    //                 ) 
    //             );
    //         }
    //         $return = $merge;
    //     }
        
    //     return $return;
    // }
    

    // function ListRedemptionTrimegah($client_code)
    // {
    //     $return = array();
    //     if( $this->CheckMutasiClient($client_code) ){
    //         $query=$this->db_trimegah->query("
    //             SELECT TOP
    //                 ( 200 ) 
    //                 'Trimegah' AS src_dt,
    //                 TXN_POSTING.TXN_TYPE,
    //                 FUND_ID.CODE_BPM AS client_code,
    //                 FUND_ID.ACC_BANK_OPR AS acc_no,
    //                 CONVERT ( DATE, TXN_POSTING.GOOD_FUND_DATE ) AS subsrd_date,
    //                 SUM ( TXN_POSTING.NET_PROCEED ) AS subsrd_nominal,
    //                 'D001' AS subsrd_kategori,
    //                 'Redemption' AS deskripsi 
    //             FROM
    //                 TXN_POSTING
    //                 INNER JOIN FUND_ID ON TXN_POSTING.FUND_LEVEL_CODE = FUND_ID.FUND_LEVEL_CODE 
    //                 AND TXN_POSTING.FUND_UMBRELLA_CODE = FUND_ID.FUND_UMBRELLA_CODE 
    //                 AND TXN_POSTING.FUND_GROUP = FUND_ID.FUND_GROUP 
    //                 AND TXN_POSTING.FUND_ID = FUND_ID.FUND_ID 
    //             WHERE
    //                 TXN_POSTING.TXN_TYPE = 'R' and
    //                 FUND_ID.CODE_BPM like '%".$client_code."%' and 
    //                 FUND_ID.ACC_BANK_OPR in (".$this->MutasiClientAccNo($client_code).")
    //             GROUP BY
    //                 TXN_POSTING.TXN_TYPE,
    //                 FUND_ID.CODE_BPM,
    //                 FUND_ID.ACC_BANK_OPR,
    //                 CONVERT ( DATE, TXN_POSTING.GOOD_FUND_DATE ) 
    //             ORDER BY
    //                 subsrd_date DESC
    //         ");
            
    //         $data = $query->result_array();
    //         $merge = array();
    //         foreach ($data as $key => $value) {
    //             $coa_desc = $this->CoaDescription($value['subsrd_kategori']);
    //             array_push($merge, 
    //                 array_merge(
    //                     $value, 
    //                     array('coa_desc'=>$coa_desc),
    //                     $this->MutasiClient($client_code, $value['acc_no'])
    //                 ) 
    //             );
    //         }
    //         $return = $merge;
    //     }
        
    //     return $return;
    // }

    // function ListRedemptionTugu($client_code)
    // {
    //     $return = array();
    //     if( $this->CheckMutasiClient($client_code) ){
    //         $query=$this->db_tugu->query("
    //             SELECT TOP
    //                 ( 200 ) 
    //                 'Tugu' AS src_dt,
    //                 TXN_POSTING.TXN_TYPE,
    //                 FUND_ID.CODE_BPM AS client_code,
    //                 FUND_ID.ACC_BANK_OPR AS acc_no,
    //                 CONVERT ( DATE, TXN_POSTING.GOOD_FUND_DATE ) AS subsrd_date,
    //                 SUM ( TXN_POSTING.NET_PROCEED ) AS subsrd_nominal,
    //                 'D001' AS subsrd_kategori,
    //                 'Redemption' AS deskripsi 
    //             FROM
    //                 TXN_POSTING
    //                 INNER JOIN FUND_ID ON TXN_POSTING.FUND_LEVEL_CODE = FUND_ID.FUND_LEVEL_CODE 
    //                 AND TXN_POSTING.FUND_UMBRELLA_CODE = FUND_ID.FUND_UMBRELLA_CODE 
    //                 AND TXN_POSTING.FUND_GROUP = FUND_ID.FUND_GROUP 
    //                 AND TXN_POSTING.FUND_ID = FUND_ID.FUND_ID 
    //             WHERE
    //                 TXN_POSTING.TXN_TYPE = 'R' and
    //                 FUND_ID.CODE_BPM like '%".$client_code."%' and 
    //                 FUND_ID.ACC_BANK_OPR in (".$this->MutasiClientAccNo($client_code).")
    //             GROUP BY
    //                 TXN_POSTING.TXN_TYPE,
    //                 FUND_ID.CODE_BPM,
    //                 FUND_ID.ACC_BANK_OPR,
    //                 CONVERT ( DATE, TXN_POSTING.GOOD_FUND_DATE ) 
    //             ORDER BY
    //                 subsrd_date DESC
    //         ");
            
    //         $data = $query->result_array();
    //         $merge = array();
    //         foreach ($data as $key => $value) {
    //             $coa_desc = $this->CoaDescription($value['subsrd_kategori']);
    //             array_push($merge, 
    //                 array_merge(
    //                     $value, 
    //                     array('coa_desc'=>$coa_desc),
    //                     $this->MutasiClient($client_code, $value['acc_no'])
    //                 ) 
    //             );
    //         }
    //         $return = $merge;
    //     }
        
    //     return $return;
    // }
}
?>