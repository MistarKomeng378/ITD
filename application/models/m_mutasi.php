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
        //$this->db_ereport = $this->load->database('dbereport',true);
        $this->db_niaga = $this->load->database('dbniaga',true);
        $this->db_syailendra = $this->load->database('dbsyailendra',true);
        $this->db_trimegah = $this->load->database('dbtrimegah',true);
        //$this->db_tugu = $this->load->database('dbtugu',true);
        $this->db_custody = $this->load->database('dbcustody',true);
        $this->db_discre = $this->load->database('dbdiscre',true);
        $this->db_mega = $this->load->database('dbmega',true);
        $this->db_niaga2 = $this->load->database('dbniaga2',true);

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
    { 
        // start
        // jika data yang di hapus adalah jasa giro maka hapus data di tabel mutasi_giro
        $query = $this->db_jasgir->query("SELECT * FROM mutasi_trx where trx_id = '".$trx_id."' ");
        $data = $query->result_array();
        if($data[0]['coa_no'] == 'C001'){
            $giro_id = $data[0]['subsrd_id'];
            $query = $this->db_jasgir->query("DELETE FROM mutasi_giro where giro_id = '".$giro_id."' ");
        }
        //end 
        
        //hapus data pada mutasi_trx
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
                trx_id,
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
                        [trx_status],
                        [subsrd_id]
                        
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
                        '".$value['trx_date']->format('Y-m-d H:i:s')."',
                        '".$this->session->userdata('itd_uid')."',
                        '".date('Y-m-d H:i:s')."',
                        1,
                        '".$value['trx_id']."'
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
                trx_id,
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
                        [trx_status],
                        [subsrd_id]
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
                        '".$value['trx_date']->format('Y-m-d H:i:s')."',
                        '".$this->session->userdata('itd_uid')."',
                        '".date('Y-m-d H:i:s')."',
                        1,
                        '".$value['trx_id']."'
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
        
        $subsrd = $this->db_urssim->query("
            SELECT
                db_name() + '_' + '".date('Ymd',strtotime($date))."' +'_'+  dbo.FUND_ID.CODE_BPM+'_'+ dbo.FUND_ID.ACC_BANK_OPR+'_'+dbo.TXN.SELLING_AGENT_CODE AS 'subsrd_id',
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID.ACC_BANK_OPR AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM(dbo.TXN_POSTING.NET_PROCEED) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption NIAGA - ' +
                (SELECT NAME FROM SELLING_AGENT WHERE SELLING_AGENT.SELLING_AGENT_CODE = dbo.TXN.SELLING_AGENT_CODE) AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID 
                
            WHERE 
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                (dbo.TXN.BANK_LETTER_CITY = '' OR dbo.TXN.BANK_LETTER_CITY is null )AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.FUND_ID.ACC_BANK_OPR,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ), 
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.BANK_LETTER_CITY,
                dbo.TXN.SELLING_AGENT_CODE
            HAVING 
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) = '".$date."' AND
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID.ACC_BANK_OPR = '".$acc_no."'

            UNION
            
            SELECT
                db_name() + '_' + '".date('Ymd',strtotime($date))."' +'_'+  dbo.FUND_ID.CODE_BPM+'_'+ dbo.FUND_ID_BANK.ACC_NO+'_'+dbo.TXN.SELLING_AGENT_CODE AS 'subsrd_id',
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID_BANK.ACC_NO AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM ( dbo.TXN_POSTING.NET_PROCEED ) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption Non Niaga- ' +
                (SELECT NAME FROM SELLING_AGENT WHERE SELLING_AGENT.SELLING_AGENT_CODE = dbo.TXN.SELLING_AGENT_CODE) AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID_BANK ON dbo.TXN.BANK_LETTER_CITY = dbo.FUND_ID_BANK.BANK_CODE
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID 
                
            WHERE
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.PAYMENT_DATE,
                dbo.FUND_ID_BANK.BANK_NAME,
                dbo.FUND_ID_BANK.DESCRIPTION,
                dbo.FUND_ID_BANK.ACC_NO,
                dbo.TXN.BANK_LETTER_CITY,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ),
                dbo.TXN.SELLING_AGENT_CODE
            HAVING 
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) = '".$date."' AND
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID_BANK.ACC_NO = '".$acc_no."'
        ");

        foreach ($subsrd->result_array() as $key => $value) {

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
                        '".$value['id']."'
                    );
                ");
                $mutasi_trx = $mutasi_trx ? array('msg' => 'Data berhasil masuk ke mutasi') : array('msg' => 'Data Gagal Masuk ke Mutasi');
            }else{
                $mutasi_trx = array('msg' => 'Data Sudah Ada');
            }
        }

        return $mutasi_trx;
    }  

//==================================================================================//

    function RedemptionToMutasiBatavia($data)
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
        
        $subsrd = $this->db_batavia->query("
            SELECT
                db_name() + '_' + '".date('Ymd',strtotime($date))."' +'_'+  dbo.FUND_ID.CODE_BPM+'_'+ dbo.FUND_ID.ACC_BANK_OPR+'_'+dbo.TXN.SELLING_AGENT_CODE AS 'subsrd_id',
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID.ACC_BANK_OPR AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM(dbo.TXN_POSTING.NET_PROCEED) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption NIAGA - ' +
                (SELECT NAME FROM SELLING_AGENT WHERE SELLING_AGENT.SELLING_AGENT_CODE = dbo.TXN.SELLING_AGENT_CODE) AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID
            WHERE 
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                (dbo.TXN.BANK_LETTER_CITY = '' OR dbo.TXN.BANK_LETTER_CITY is null )AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.FUND_ID.ACC_BANK_OPR,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ), 
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.BANK_LETTER_CITY,
                dbo.TXN.SELLING_AGENT_CODE
            HAVING 
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) = '".$date."' AND
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID.ACC_BANK_OPR = '".$acc_no."'

            UNION
            
            SELECT
                db_name() + '_' + '".date('Ymd',strtotime($date))."' +'_'+  dbo.FUND_ID.CODE_BPM+'_'+ dbo.FUND_ID_BANK.ACC_NO+'_'+dbo.TXN.SELLING_AGENT_CODE AS 'subsrd_id',
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID_BANK.ACC_NO AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM ( dbo.TXN_POSTING.NET_PROCEED ) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption Non Niaga- ' +
                (SELECT NAME FROM SELLING_AGENT WHERE SELLING_AGENT.SELLING_AGENT_CODE = dbo.TXN.SELLING_AGENT_CODE) AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID_BANK ON dbo.TXN.BANK_LETTER_CITY = dbo.FUND_ID_BANK.BANK_CODE
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID 
                INNER JOIN dbo.FUND_SUMMARY ON dbo.TXN.FUND_ID = dbo.FUND_SUMMARY.FUND_ID 
				AND dbo.FUND_SUMMARY.TRADE_DATE = dbo.TXN.PAYMENT_DATE
            WHERE
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.PAYMENT_DATE,
                dbo.FUND_ID_BANK.BANK_NAME,
                dbo.FUND_ID_BANK.DESCRIPTION,
                dbo.FUND_ID_BANK.ACC_NO,
                dbo.TXN.BANK_LETTER_CITY,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ),
                dbo.TXN.SELLING_AGENT_CODE
            HAVING 
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) = '".$date."' AND
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID_BANK.ACC_NO = '".$acc_no."'
        ");
        
        foreach ($subsrd->result_array() as $key => $value) {

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
                        '".$value['id']."'
                    );
                ");
                $mutasi_trx = $mutasi_trx ? array('msg' => 'Data berhasil masuk ke mutasi') : array('msg' => 'Data Gagal Masuk ke Mutasi');
            }else{
                $mutasi_trx = array('msg' => 'Data Sudah Ada');
            }
        }

        return $mutasi_trx;
    }  


    function RedemptionToMutasiBni($data)
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
        
        $subsrd = $this->db_bni->query("
            SELECT
                db_name() + '_' + '".date('Ymd',strtotime($date))."' +'_'+  dbo.FUND_ID.CODE_BPM+'_'+ dbo.FUND_ID.ACC_BANK_OPR+'_'+dbo.TXN.SELLING_AGENT_CODE AS 'subsrd_id',
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID.ACC_BANK_OPR AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM(dbo.TXN_POSTING.NET_PROCEED) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption NIAGA - ' +
                (SELECT NAME FROM SELLING_AGENT WHERE SELLING_AGENT.SELLING_AGENT_CODE = dbo.TXN.SELLING_AGENT_CODE) AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID 
            WHERE 
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                (dbo.TXN.BANK_LETTER_CITY = '' OR dbo.TXN.BANK_LETTER_CITY is null ) AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.FUND_ID.ACC_BANK_OPR,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ), 
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.BANK_LETTER_CITY,
                dbo.TXN.SELLING_AGENT_CODE
            HAVING 
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) = '".$date."' AND
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID.ACC_BANK_OPR = '".$acc_no."'

            UNION
            
            SELECT
                db_name() + '_' + '".date('Ymd',strtotime($date))."' +'_'+  dbo.FUND_ID.CODE_BPM+'_'+ dbo.FUND_ID_BANK.ACC_NO+'_'+dbo.TXN.SELLING_AGENT_CODE AS 'subsrd_id',
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID_BANK.ACC_NO AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM ( dbo.TXN_POSTING.NET_PROCEED ) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption Non Niaga- ' +
                (SELECT NAME FROM SELLING_AGENT WHERE SELLING_AGENT.SELLING_AGENT_CODE = dbo.TXN.SELLING_AGENT_CODE) AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID_BANK ON dbo.TXN.BANK_LETTER_CITY = dbo.FUND_ID_BANK.BANK_CODE
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID 
                
            WHERE
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.PAYMENT_DATE,
                dbo.FUND_ID_BANK.BANK_NAME,
                dbo.FUND_ID_BANK.DESCRIPTION,
                dbo.FUND_ID_BANK.ACC_NO,
                dbo.TXN.BANK_LETTER_CITY,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ),
                dbo.TXN.SELLING_AGENT_CODE
            HAVING 
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) = '".$date."' AND
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID_BANK.ACC_NO = '".$acc_no."' 

        ");
        
        foreach ($subsrd->result_array() as $key => $value) {

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
                        '".$value['id']."'
                    );
                ");
                $mutasi_trx = $mutasi_trx ? array('msg' => 'Data berhasil masuk ke mutasi') : array('msg' => 'Data Gagal Masuk ke Mutasi');
            }else{
                $mutasi_trx = array('msg' => 'Data Sudah Ada');
            }
        }

        return $mutasi_trx;
    }  


    function RedemptionToMutasiCustody($data)
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
        
        $subsrd = $this->db_custody->query("
            SELECT
                db_name() + '_' + '".date('Ymd',strtotime($date))."' +'_'+  dbo.FUND_ID.CODE_BPM+'_'+ dbo.FUND_ID.ACC_BANK_OPR+'_'+dbo.TXN.SELLING_AGENT_CODE AS 'subsrd_id',
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID.ACC_BANK_OPR AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM(dbo.TXN_POSTING.NET_PROCEED) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption NIAGA - ' +
                (SELECT NAME FROM SELLING_AGENT WHERE SELLING_AGENT.SELLING_AGENT_CODE = dbo.TXN.SELLING_AGENT_CODE) AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID 
            WHERE 
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                (dbo.TXN.BANK_LETTER_CITY = '' OR dbo.TXN.BANK_LETTER_CITY is null ) AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.FUND_ID.ACC_BANK_OPR,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ), 
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.BANK_LETTER_CITY,
                dbo.TXN.SELLING_AGENT_CODE
            HAVING 
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) = '".$date."' AND
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID.ACC_BANK_OPR = '".$acc_no."'

            UNION
            
            SELECT
                db_name() + '_' + '".date('Ymd',strtotime($date))."' +'_'+  dbo.FUND_ID.CODE_BPM+'_'+ dbo.FUND_ID_BANK.ACC_NO+'_'+dbo.TXN.SELLING_AGENT_CODE AS 'subsrd_id',
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID_BANK.ACC_NO AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM ( dbo.TXN_POSTING.NET_PROCEED ) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption Non Niaga- ' +
                (SELECT NAME FROM SELLING_AGENT WHERE SELLING_AGENT.SELLING_AGENT_CODE = dbo.TXN.SELLING_AGENT_CODE) AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID_BANK ON dbo.TXN.BANK_LETTER_CITY = dbo.FUND_ID_BANK.BANK_CODE
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID
            WHERE
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.PAYMENT_DATE,
                dbo.FUND_ID_BANK.BANK_NAME,
                dbo.FUND_ID_BANK.DESCRIPTION,
                dbo.FUND_ID_BANK.ACC_NO,
                dbo.TXN.BANK_LETTER_CITY,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ),
                dbo.TXN.SELLING_AGENT_CODE
            HAVING 
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) = '".$date."' AND
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID_BANK.ACC_NO = '".$acc_no."'
        ");
        
        foreach ($subsrd->result_array() as $key => $value) {

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
                        '".$value['id']."'
                    );
                ");
                $mutasi_trx = $mutasi_trx ? array('msg' => 'Data berhasil masuk ke mutasi') : array('msg' => 'Data Gagal Masuk ke Mutasi');
            }else{
                $mutasi_trx = array('msg' => 'Data Sudah Ada');
            }
        }

        return $mutasi_trx;
    }  


    function RedemptionToMutasiDiscre($data)
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
        
        $subsrd = $this->db_discre->query("
            SELECT
                db_name() + '_' + '".date('Ymd',strtotime($date))."' +'_'+  dbo.FUND_ID.CODE_BPM+'_'+ dbo.FUND_ID.ACC_BANK_OPR+'_'+dbo.TXN.SELLING_AGENT_CODE AS 'subsrd_id',
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID.ACC_BANK_OPR AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM(dbo.TXN_POSTING.NET_PROCEED) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption NIAGA - ' +
                (SELECT NAME FROM SELLING_AGENT WHERE SELLING_AGENT.SELLING_AGENT_CODE = dbo.TXN.SELLING_AGENT_CODE) AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID
            WHERE 
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                (dbo.TXN.BANK_LETTER_CITY = '' OR dbo.TXN.BANK_LETTER_CITY is null ) AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.FUND_ID.ACC_BANK_OPR,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ), 
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.BANK_LETTER_CITY,
                dbo.TXN.SELLING_AGENT_CODE
            HAVING 
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) = '".$date."' AND
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID.ACC_BANK_OPR = '".$acc_no."' 

            UNION
            
            SELECT
                db_name() + '_' + '".date('Ymd',strtotime($date))."' +'_'+  dbo.FUND_ID.CODE_BPM+'_'+dbo.FUND_ID_BANK.ACC_NO+'_'+dbo.TXN.SELLING_AGENT_CODE AS 'subsrd_id',
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID_BANK.ACC_NO AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM ( dbo.TXN_POSTING.NET_PROCEED ) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption Non Niaga- ' +
                (SELECT NAME FROM SELLING_AGENT WHERE SELLING_AGENT.SELLING_AGENT_CODE = dbo.TXN.SELLING_AGENT_CODE) AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID_BANK ON dbo.TXN.BANK_LETTER_CITY = dbo.FUND_ID_BANK.BANK_CODE
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID 
            WHERE
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.PAYMENT_DATE,
                dbo.FUND_ID_BANK.BANK_NAME,
                dbo.FUND_ID_BANK.DESCRIPTION,
                dbo.FUND_ID_BANK.ACC_NO,
                dbo.TXN.BANK_LETTER_CITY,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ),
                dbo.TXN.SELLING_AGENT_CODE
            HAVING 
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) = '".$date."' AND
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID_BANK.ACC_NO = '".$acc_no."'
        ");
        
        foreach ($subsrd->result_array() as $key => $value) {

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
                        '".$value['id']."'
                    );
                ");
                $mutasi_trx = $mutasi_trx ? array('msg' => 'Data berhasil masuk ke mutasi') : array('msg' => 'Data Gagal Masuk ke Mutasi');
            }else{
                $mutasi_trx = array('msg' => 'Data Sudah Ada');
            }
        }

        return $mutasi_trx;
    }  



    function RedemptionToMutasiMega($data)
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
        
        $subsrd = $this->db_mega->query("
            SELECT
                db_name() + '_' + '".date('Ymd',strtotime($date))."' +'_'+  dbo.FUND_ID.CODE_BPM+'_'+ dbo.FUND_ID.ACC_BANK_OPR+'_'+dbo.TXN.SELLING_AGENT_CODE AS 'subsrd_id',
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID.ACC_BANK_OPR AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM(dbo.TXN_POSTING.NET_PROCEED) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption NIAGA - ' +
                (SELECT NAME FROM SELLING_AGENT WHERE SELLING_AGENT.SELLING_AGENT_CODE = dbo.TXN.SELLING_AGENT_CODE) AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID 
            WHERE 
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                (dbo.TXN.BANK_LETTER_CITY = '' OR dbo.TXN.BANK_LETTER_CITY is null ) AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.FUND_ID.ACC_BANK_OPR,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ), 
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.BANK_LETTER_CITY,
                dbo.TXN.SELLING_AGENT_CODE
            HAVING 
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) = '".$date."' AND
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID.ACC_BANK_OPR = '".$acc_no."'

            UNION
            
            SELECT
                db_name() + '_' + '".date('Ymd',strtotime($date))."' +'_'+  dbo.FUND_ID.CODE_BPM+'_'+ dbo.FUND_ID_BANK.ACC_NO+'_'+dbo.TXN.SELLING_AGENT_CODE AS 'subsrd_id',
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID_BANK.ACC_NO AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM ( dbo.TXN_POSTING.NET_PROCEED ) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption Non Niaga- ' +
                (SELECT NAME FROM SELLING_AGENT WHERE SELLING_AGENT.SELLING_AGENT_CODE = dbo.TXN.SELLING_AGENT_CODE) AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID_BANK ON dbo.TXN.BANK_LETTER_CITY = dbo.FUND_ID_BANK.BANK_CODE
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID
            WHERE
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.PAYMENT_DATE,
                dbo.FUND_ID_BANK.BANK_NAME,
                dbo.FUND_ID_BANK.DESCRIPTION,
                dbo.FUND_ID_BANK.ACC_NO,
                dbo.TXN.BANK_LETTER_CITY,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ),
                dbo.TXN.SELLING_AGENT_CODE
            HAVING 
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) = '".$date."' AND
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID_BANK.ACC_NO = '".$acc_no."' 
        ");
        
        foreach ($subsrd->result_array() as $key => $value) {

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
                        '".$value['id']."'
                    );
                ");
                $mutasi_trx = $mutasi_trx ? array('msg' => 'Data berhasil masuk ke mutasi') : array('msg' => 'Data Gagal Masuk ke Mutasi');
            }else{
                $mutasi_trx = array('msg' => 'Data Sudah Ada');
            }
        }

        return $mutasi_trx;
    }


    function RedemptionToMutasiNiaga($data)
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
        
        $subsrd = $this->db_niaga->query("
            SELECT
                db_name() + '_' + '".date('Ymd',strtotime($date))."' +'_'+  dbo.FUND_ID.CODE_BPM+'_'+ dbo.FUND_ID.ACC_BANK_OPR+'_'+dbo.TXN.SELLING_AGENT_CODE AS 'subsrd_id',
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID.ACC_BANK_OPR AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM(dbo.TXN_POSTING.NET_PROCEED) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption NIAGA - ' +
                (SELECT NAME FROM SELLING_AGENT WHERE SELLING_AGENT.SELLING_AGENT_CODE = dbo.TXN.SELLING_AGENT_CODE) AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID
            WHERE 
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                (dbo.TXN.BANK_LETTER_CITY = '' OR dbo.TXN.BANK_LETTER_CITY is null ) AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.FUND_ID.ACC_BANK_OPR,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ), 
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.BANK_LETTER_CITY,
                dbo.TXN.SELLING_AGENT_CODE
            HAVING 
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) = '".$date."' AND
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID.ACC_BANK_OPR = '".$acc_no."'

            UNION
            
            SELECT
                db_name() + '_' + '".date('Ymd',strtotime($date))."' +'_'+  dbo.FUND_ID.CODE_BPM+'_'+ dbo.FUND_ID_BANK.ACC_NO+'_'+dbo.TXN.SELLING_AGENT_CODE AS 'subsrd_id',
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID_BANK.ACC_NO AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM ( dbo.TXN_POSTING.NET_PROCEED ) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption Non Niaga- ' +
                (SELECT NAME FROM SELLING_AGENT WHERE SELLING_AGENT.SELLING_AGENT_CODE = dbo.TXN.SELLING_AGENT_CODE) AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID_BANK ON dbo.TXN.BANK_LETTER_CITY = dbo.FUND_ID_BANK.BANK_CODE
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID
            WHERE
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.PAYMENT_DATE,
                dbo.FUND_ID_BANK.BANK_NAME,
                dbo.FUND_ID_BANK.DESCRIPTION,
                dbo.FUND_ID_BANK.ACC_NO,
                dbo.TXN.BANK_LETTER_CITY,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ),
                dbo.TXN.SELLING_AGENT_CODE
            HAVING 
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) = '".$date."' AND
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID_BANK.ACC_NO = '".$acc_no."'
        ");
        
        foreach ($subsrd->result_array() as $key => $value) {

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
                        '".$value['id']."'
                    );
                ");
                $mutasi_trx = $mutasi_trx ? array('msg' => 'Data berhasil masuk ke mutasi') : array('msg' => 'Data Gagal Masuk ke Mutasi');
            }else{
                $mutasi_trx = array('msg' => 'Data Sudah Ada');
            }
        }

        return $mutasi_trx;
    }


    function RedemptionToMutasiNiaga2($data)
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
        
        $subsrd = $this->db_niaga2->query("
            SELECT
                db_name() + '_' + '".date('Ymd',strtotime($date))."' +'_'+  dbo.FUND_ID.CODE_BPM+'_'+ dbo.FUND_ID.ACC_BANK_OPR+'_'+dbo.TXN.SELLING_AGENT_CODE AS 'subsrd_id',
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID.ACC_BANK_OPR AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM(dbo.TXN_POSTING.NET_PROCEED) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption NIAGA - ' +
                (SELECT NAME FROM SELLING_AGENT WHERE SELLING_AGENT.SELLING_AGENT_CODE = dbo.TXN.SELLING_AGENT_CODE) AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID
            WHERE 
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                (dbo.TXN.BANK_LETTER_CITY = '' OR dbo.TXN.BANK_LETTER_CITY is null ) AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.FUND_ID.ACC_BANK_OPR,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ), 
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.BANK_LETTER_CITY,
                dbo.TXN.SELLING_AGENT_CODE
            HAVING 
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) = '".$date."' AND
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID.ACC_BANK_OPR = '".$acc_no."'

            UNION
            
            SELECT
                db_name() + '_' + '".date('Ymd',strtotime($date))."' +'_'+  dbo.FUND_ID.CODE_BPM+'_'+ dbo.FUND_ID_BANK.ACC_NO+'_'+dbo.TXN.SELLING_AGENT_CODE AS 'subsrd_id',
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID_BANK.ACC_NO AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM ( dbo.TXN_POSTING.NET_PROCEED ) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption Non Niaga- ' +
                (SELECT NAME FROM SELLING_AGENT WHERE SELLING_AGENT.SELLING_AGENT_CODE = dbo.TXN.SELLING_AGENT_CODE) AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID_BANK ON dbo.TXN.BANK_LETTER_CITY = dbo.FUND_ID_BANK.BANK_CODE
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID 
            WHERE
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.PAYMENT_DATE,
                dbo.FUND_ID_BANK.BANK_NAME,
                dbo.FUND_ID_BANK.DESCRIPTION,
                dbo.FUND_ID_BANK.ACC_NO,
                dbo.TXN.BANK_LETTER_CITY,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ),
                dbo.TXN.SELLING_AGENT_CODE
            HAVING 
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) = '".$date."' AND
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID_BANK.ACC_NO = '".$acc_no."'
        ");


        foreach ($subsrd->result_array() as $key => $value) {

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
                        '".$value['id']."'
                    );
                ");
                $mutasi_trx = $mutasi_trx ? array('msg' => 'Data berhasil masuk ke mutasi') : array('msg' => 'Data Gagal Masuk ke Mutasi');
            }else{
                $mutasi_trx = array('msg' => 'Data Sudah Ada');
            }
        }

        return $mutasi_trx;
    }


    function RedemptionToMutasiSyailendra($data)
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
        
        $subsrd = $this->db_syailendra->query("
            SELECT
                db_name() + '_' + '".date('Ymd',strtotime($date))."' +'_'+  dbo.FUND_ID.CODE_BPM+'_'+ dbo.FUND_ID.ACC_BANK_OPR+'_'+dbo.TXN.SELLING_AGENT_CODE AS 'subsrd_id',
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID.ACC_BANK_OPR AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM(dbo.TXN_POSTING.NET_PROCEED) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption NIAGA - ' +
                (SELECT NAME FROM SELLING_AGENT WHERE SELLING_AGENT.SELLING_AGENT_CODE = dbo.TXN.SELLING_AGENT_CODE) AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID 
            WHERE 
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                (dbo.TXN.BANK_LETTER_CITY = '' OR dbo.TXN.BANK_LETTER_CITY is null ) AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.FUND_ID.ACC_BANK_OPR,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ), 
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.BANK_LETTER_CITY,
                dbo.TXN.SELLING_AGENT_CODE
            HAVING 
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) = '".$date."' AND
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID.ACC_BANK_OPR = '".$acc_no."'

            UNION
            
            SELECT
                db_name() + '_' + '".date('Ymd',strtotime($date))."' +'_'+  dbo.FUND_ID.CODE_BPM+'_'+ dbo.FUND_ID_BANK.ACC_NO+'_'+dbo.TXN.SELLING_AGENT_CODE AS 'subsrd_id',
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID_BANK.ACC_NO AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM ( dbo.TXN_POSTING.NET_PROCEED ) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption Non Niaga- ' +
                (SELECT NAME FROM SELLING_AGENT WHERE SELLING_AGENT.SELLING_AGENT_CODE = dbo.TXN.SELLING_AGENT_CODE) AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID_BANK ON dbo.TXN.BANK_LETTER_CITY = dbo.FUND_ID_BANK.BANK_CODE
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID 
            WHERE
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.PAYMENT_DATE,
                dbo.FUND_ID_BANK.BANK_NAME,
                dbo.FUND_ID_BANK.DESCRIPTION,
                dbo.FUND_ID_BANK.ACC_NO,
                dbo.TXN.BANK_LETTER_CITY,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ),
                dbo.TXN.SELLING_AGENT_CODE
            HAVING 
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) = '".$date."' AND
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID_BANK.ACC_NO = '".$acc_no."'
        ");

        foreach ($subsrd->result_array() as $key => $value) {

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
                        '".$value['id']."'
                    );
                ");
                $mutasi_trx = $mutasi_trx ? array('msg' => 'Data berhasil masuk ke mutasi') : array('msg' => 'Data Gagal Masuk ke Mutasi');
            }else{
                $mutasi_trx = array('msg' => 'Data Sudah Ada');
            }
        }

        return $mutasi_trx;
    }



    function RedemptionToMutasiTrimegah($data)
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
        
        $subsrd = $this->db_trimegah->query("
             SELECT
                db_name() + '_' + '".date('Ymd',strtotime($date))."' +'_'+  dbo.FUND_ID.CODE_BPM+'_'+ dbo.FUND_ID.ACC_BANK_OPR+'_'+dbo.TXN.SELLING_AGENT_CODE AS 'subsrd_id',
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID.ACC_BANK_OPR AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM(dbo.TXN_POSTING.NET_PROCEED) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption NIAGA - ' +
                (SELECT NAME FROM SELLING_AGENT WHERE SELLING_AGENT.SELLING_AGENT_CODE = dbo.TXN.SELLING_AGENT_CODE) AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID 
            WHERE 
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                (dbo.TXN.BANK_LETTER_CITY = '' OR dbo.TXN.BANK_LETTER_CITY is null ) AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.FUND_ID.ACC_BANK_OPR,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ), 
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.BANK_LETTER_CITY,
                dbo.TXN.SELLING_AGENT_CODE
            HAVING 
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) = '".$date."' AND
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID.ACC_BANK_OPR = '".$acc_no."' 

            UNION
            
            SELECT
                db_name() + '_' + '".date('Ymd',strtotime($date))."' +'_'+  dbo.FUND_ID.CODE_BPM+'_'+ dbo.FUND_ID_BANK.ACC_NO+'_'+dbo.TXN.SELLING_AGENT_CODE AS 'subsrd_id',
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID_BANK.ACC_NO AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM ( dbo.TXN_POSTING.NET_PROCEED ) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption Non Niaga- ' +
                (SELECT NAME FROM SELLING_AGENT WHERE SELLING_AGENT.SELLING_AGENT_CODE = dbo.TXN.SELLING_AGENT_CODE) AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID_BANK ON dbo.TXN.BANK_LETTER_CITY = dbo.FUND_ID_BANK.BANK_CODE
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID
            WHERE
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.PAYMENT_DATE,
                dbo.FUND_ID_BANK.BANK_NAME,
                dbo.FUND_ID_BANK.DESCRIPTION,
                dbo.FUND_ID_BANK.ACC_NO,
                dbo.TXN.BANK_LETTER_CITY,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ),
                dbo.TXN.SELLING_AGENT_CODE
            HAVING 
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) = '".$date."' AND
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID_BANK.ACC_NO = '".$acc_no."'
        ");

        foreach ($subsrd->result_array() as $key => $value) {

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
                        '".$value['id']."'
                    );
                ");
                $mutasi_trx = $mutasi_trx ? array('msg' => 'Data berhasil masuk ke mutasi') : array('msg' => 'Data Gagal Masuk ke Mutasi');
            }else{
                $mutasi_trx = array('msg' => 'Data Sudah Ada');
            }
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
            'Hasil Jual Saham - '+RTRIM(SECURITY_CODE) AS deskripsi
        FROM
            NFS_INQ_EQUITY_TEMP A
            INNER JOIN  FUND_DETAILS B on B.HIPORT_CODE = A.HIPORT_CODE
        WHERE
            A.BUY_SELL = '2'
            AND A.HIPORT_CODE = '".$client_code."'
            AND CONVERT ( DATE, A.SETTLEMENT_DATE ) = '".$date."'
            AND B.FUND_OPR_ACCT_NO = '".$acc_no."' 
            AND A.SI_REFF = '".$id."' 
            AND A.TRANSACTION_STATUS ='NEWM'
            
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
            'Beli Saham - '+RTRIM(SECURITY_CODE) AS deskripsi
        FROM
            NFS_INQ_EQUITY_TEMP A
            INNER JOIN  FUND_DETAILS B on B.HIPORT_CODE = A.HIPORT_CODE
        WHERE
            A.BUY_SELL = '1' and
            A.HIPORT_CODE = '".$client_code."' and 
            CONVERT ( DATE, A.SETTLEMENT_DATE ) = '".$date."' and
            B.FUND_OPR_ACCT_NO = '".$acc_no."' AND
            A.SI_REFF = '".$id."'
            AND A.TRANSACTION_STATUS ='NEWM'
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
            'Hasil Jual Obligasi - '+RTRIM(SECURITY_CODE) AS deskripsi 
        FROM
            NFS_FI_INS_INQ_TEMP A
            INNER JOIN FUND_DETAILS B ON B.HIPORT_CODE = A.HIPORT_CODE 
        WHERE
            A.BUY_SELL = '2'  and
            A.HIPORT_CODE = '".$client_code."' and 
            CONVERT ( DATE, A.SETTLEMENT_DATE ) = '".$date."' and
            B.FUND_OPR_ACCT_NO = '".$acc_no."' and
            A.SI_REFERENCE = '".$id."'
            AND A.TRANSACTION_STATUS ='NEWM'
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
            'Beli Obligasi - '+RTRIM(SECURITY_CODE) AS deskripsi 
        FROM
            NFS_FI_INS_INQ_TEMP A
            INNER JOIN FUND_DETAILS B ON B.HIPORT_CODE = A.HIPORT_CODE 
        WHERE
            A.BUY_SELL = '1'  and
            A.HIPORT_CODE = '".$client_code."' and 
            CONVERT ( DATE, A.SETTLEMENT_DATE ) = '".$date."' and
            B.FUND_OPR_ACCT_NO = '".$acc_no."' and 
            A.SI_REFERENCE = '".$id."'
            AND A.TRANSACTION_STATUS ='NEWM'
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
                'Wht Commision - '+RTRIM(SECURITY_CODE) AS deskripsi,
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
                AND A.TRANSACTION_STATUS ='NEWM'  
                AND A.IM_CODE <> 'KI002' AND A.IM_CODE <> 'DX002'
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
                'Capital Gain Tax - ' + RTRIM(SECURITY_CODE) AS deskripsi,  
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
                AND A.TRANSACTION_STATUS ='NEWM'
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
                    'Interst Income Tax - ' + RTRIM(SECURITY_CODE) AS deskripsi,
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
                    AND A.TRANSACTION_STATUS ='NEWM'
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

//=================================== background job start

    function JualSahamToMutasiBackground($date)
    {
        $subsrd = $this->db_nfs->query("
        SELECT
            A.SI_REFF as subsrd_id,
            A.HIPORT_CODE AS client_code,
            B.FUND_OPR_ACCT_NO AS acc_no,
            CONVERT ( DATE, A.SETTLEMENT_DATE ) AS subsrd_date,
            CONVERT ( DECIMAL(16,2), A.NET_SETTLEMENT_AMOUNT ) AS subsrd_nominal,
            A.MODIFIER,
            A.CREATION_DATE,
            A.MODIFICATION_DATE,
            'C006' AS subsrd_kategori,
            'Hasil Jual Saham - '+RTRIM(SECURITY_CODE) AS deskripsi
        FROM
            NFS_INQ_EQUITY_TEMP A
            INNER JOIN  FUND_DETAILS B on B.HIPORT_CODE = A.HIPORT_CODE
        WHERE
            A.BUY_SELL = '2'
            AND CONVERT ( DATE, A.SETTLEMENT_DATE ) = '".$date."'
            AND A.TRANSACTION_STATUS ='NEWM'
        ORDER BY
            subsrd_date DESC
        ");
        
        $sql = '';
        $msg = '';
        if( count($subsrd->result_array()) > 0 ){
            foreach ($subsrd->result_array() as $key => $value) {
                $status_mutasi = $this->status_mutasi($value['client_code'], $value['acc_no'], $value['subsrd_date']->format('Y-m-d'));

                if($status_mutasi == 0){
                    $msg = $msg.' <br> '.$value['subsrd_id'];
                    $sql = $sql. "
                    IF NOT EXISTS ( SELECT*FROM mutasi_trx WHERE client_code='".$value['client_code']."' AND trx_date='".$value['subsrd_date']->format('Y-m-d H:i:s')."' AND coa_no='C006' AND acc_no='".$value['acc_no']."' AND subsrd_id='".$value['subsrd_id']."' )
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
                        ) VALUES ( 
                            '".$value['client_code']."',
                            '".$value['acc_no']."', 
                            '".$value['subsrd_date']->format('Y-m-d H:i:s')."',
                            '".$value['subsrd_kategori']."', 
                            'Hasil Jual Saham',
                            '".$value['deskripsi']."',
                            'C', 
                            '".$value['subsrd_nominal']."',
                            'system', 
                            '".date('Y-m-d H:i:s')."', 
                            'system', 
                            '".date('Y-m-d H:i:s')."', 
                            1, 
                            '".$value['subsrd_id']."'
                        );
                    END;";
                }else{
                    $msg = $msg.' <br> '.$value['client_code'].' - '.$value['acc_no'].' - '.$value['subsrd_date']->format('Y-m-d').' - STATUS BUKAN OPEN';
                }
            }
            return array('sql'=> $sql, 'msg' => $msg);
        }
        return false;
    }

    function BeliSahamToMutasiBackground($date)
    {   
        $subsrd = $this->db_nfs->query("
            SELECT
                A.SI_REFF as subsrd_id,
                A.HIPORT_CODE AS client_code,
                B.FUND_OPR_ACCT_NO AS acc_no,
                CONVERT ( DATE, A.SETTLEMENT_DATE ) AS subsrd_date,
                CONVERT ( DECIMAL(16,2), A.NET_SETTLEMENT_AMOUNT ) AS subsrd_nominal,
                A.MODIFIER,
                A.CREATION_DATE,
                A.MODIFICATION_DATE,
                'D004' AS subsrd_kategori,
                'Beli Saham - '+RTRIM(SECURITY_CODE) AS deskripsi
            FROM
                NFS_INQ_EQUITY_TEMP A
                INNER JOIN  FUND_DETAILS B on B.HIPORT_CODE = A.HIPORT_CODE
            WHERE
                A.BUY_SELL = '1' and
                CONVERT ( DATE, A.SETTLEMENT_DATE ) = '".$date."'
                AND A.TRANSACTION_STATUS ='NEWM'
            ORDER BY
                subsrd_date DESC
        ");

        $sql = '';
        $msg = '';
        if( count($subsrd->result_array()) > 0 ){
            foreach ($subsrd->result_array() as $key => $value) {

                $status_mutasi = $this->status_mutasi($value['client_code'], $value['acc_no'], $value['subsrd_date']->format('Y-m-d'));

                if($status_mutasi == 0){
                $msg = $msg.' <br> '.$value['subsrd_id'];
                $sql = $sql. "
                IF NOT EXISTS ( SELECT*FROM mutasi_trx WHERE client_code='".$value['client_code']."' AND trx_date='".$value['subsrd_date']->format('Y-m-d H:i:s')."' AND coa_no='D004' AND acc_no='".$value['acc_no']."' AND subsrd_id='".$value['subsrd_id']."' )
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
                    ) VALUES ( 
                        '".$value['client_code']."',
                        '".$value['acc_no']."', 
                        '".$value['subsrd_date']->format('Y-m-d H:i:s')."',
                        '".$value['subsrd_kategori']."', 
                        'Beli Saham',
                        '".$value['deskripsi']."',
                        'D', 
                        '".$value['subsrd_nominal']."',
                        'system', 
                        '".date('Y-m-d H:i:s')."', 
                        'system', 
                        '".date('Y-m-d H:i:s')."', 
                        1, 
                        '".$value['subsrd_id']."'
                    );
                END;";
                }else{
                    $msg = $msg.' <br> '.$value['client_code'].' - '.$value['acc_no'].' - '.$value['subsrd_date']->format('Y-m-d').' - STATUS BUKAN OPEN';
                }
            }
            return array('sql'=> $sql, 'msg' => $msg);
        }
        return false;
    }
    
    function JualObligasiToMutasiBackground($date)
    {   
        $subsrd = $this->db_nfs->query("
            SELECT
                A.SI_REFERENCE AS subsrd_id,
                A.HIPORT_CODE AS client_code,
                B.FUND_OPR_ACCT_NO AS acc_no,
                CONVERT ( DATE, A.SETTLEMENT_DATE ) AS subsrd_date,
                CONVERT ( DECIMAL(16,2), A.NET_PROCEEDS ) AS subsrd_nominal,
                A.MODIFIER,
                A.CREATION_DATE,
                A.MODIFICATION_DATE,
                'C007' AS subsrd_kategori,
                'Hasil Jual Obligasi - '+RTRIM(SECURITY_CODE) AS deskripsi 
            FROM
                NFS_FI_INS_INQ_TEMP A
                INNER JOIN FUND_DETAILS B ON B.HIPORT_CODE = A.HIPORT_CODE 
            WHERE
                A.BUY_SELL = '2'  and
                CONVERT ( DATE, A.SETTLEMENT_DATE ) = '".$date."'
                AND A.TRANSACTION_STATUS ='NEWM'
            ORDER BY
                subsrd_date DESC
        ");

        $sql = '';
        $msg = '';
        if( count($subsrd->result_array()) > 0 ){
            foreach ($subsrd->result_array() as $key => $value) {
                $status_mutasi = $this->status_mutasi($value['client_code'], $value['acc_no'], $value['subsrd_date']->format('Y-m-d'));

				if($status_mutasi == 0){
                $msg = $msg.' <br> '.$value['subsrd_id'];
                $sql = $sql. "
                IF NOT EXISTS ( SELECT*FROM mutasi_trx WHERE client_code='".$value['client_code']."' AND trx_date='".$value['subsrd_date']->format('Y-m-d H:i:s')."' AND coa_no='C007' AND acc_no='".$value['acc_no']."' AND subsrd_id='".$value['subsrd_id']."' )
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
                    ) VALUES ( 
                        '".$value['client_code']."',
                        '".$value['acc_no']."', 
                        '".$value['subsrd_date']->format('Y-m-d H:i:s')."',
                        '".$value['subsrd_kategori']."', 
                        'Hasil Jual Obligasi',
                        '".$value['deskripsi']."',
                        'C', 
                        '".$value['subsrd_nominal']."',
                        'system', 
                        '".date('Y-m-d H:i:s')."', 
                        'system', 
                        '".date('Y-m-d H:i:s')."', 
                        1, 
                        '".$value['subsrd_id']."'
                    );
                END;";
                }else{
                    $msg = $msg.' <br> '.$value['client_code'].' - '.$value['acc_no'].' - '.$value['subsrd_date']->format('Y-m-d').' - STATUS BUKAN OPEN';
                }
            }
            return array('sql'=> $sql, 'msg' => $msg);
        }
        return false;
    }

    function BeliObligasiToMutasiBackground($date)
    {        
        $subsrd = $this->db_nfs->query("
            SELECT
                A.SI_REFERENCE AS subsrd_id,
                A.HIPORT_CODE AS client_code,
                B.FUND_OPR_ACCT_NO AS acc_no,
                CONVERT ( DATE, A.SETTLEMENT_DATE ) AS subsrd_date,
                CONVERT ( DECIMAL(16,2), A.NET_PROCEEDS ) AS subsrd_nominal,
                A.MODIFIER,
                A.CREATION_DATE,
                A.MODIFICATION_DATE,
                'D005' AS subsrd_kategori,
                'Beli Obligasi - '+RTRIM(SECURITY_CODE) AS deskripsi 
            FROM
                NFS_FI_INS_INQ_TEMP A
                INNER JOIN FUND_DETAILS B ON B.HIPORT_CODE = A.HIPORT_CODE 
            WHERE
                A.BUY_SELL = '1'  and
                CONVERT ( DATE, A.SETTLEMENT_DATE ) = '".$date."'
                AND A.TRANSACTION_STATUS ='NEWM'
            ORDER BY
                subsrd_date DESC
        ");

        $sql = '';
        $msg = '';
        if( count($subsrd->result_array()) > 0 ){
            foreach ($subsrd->result_array() as $key => $value) {
                $status_mutasi = $this->status_mutasi($value['client_code'], $value['acc_no'], $value['subsrd_date']->format('Y-m-d'));

				if($status_mutasi == 0){
                $msg = $msg.' <br> '.$value['subsrd_id'];
                $sql = $sql. "
                IF NOT EXISTS ( SELECT*FROM mutasi_trx WHERE client_code='".$value['client_code']."' AND trx_date='".$value['subsrd_date']->format('Y-m-d H:i:s')."' AND coa_no='D005' AND acc_no='".$value['acc_no']."' AND subsrd_id='".$value['subsrd_id']."' )
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
                    ) VALUES ( 
                        '".$value['client_code']."',
                        '".$value['acc_no']."', 
                        '".$value['subsrd_date']->format('Y-m-d H:i:s')."',
                        '".$value['subsrd_kategori']."', 
                        'Beli Obligasi',
                        '".$value['deskripsi']."',
                        'D',  
                        '".$value['subsrd_nominal']."',
                        'system', 
                        '".date('Y-m-d H:i:s')."', 
                        'system', 
                        '".date('Y-m-d H:i:s')."', 
                        1, 
                        '".$value['subsrd_id']."'
                    );
                END;";
                }else{
                    $msg = $msg.' <br> '.$value['client_code'].' - '.$value['acc_no'].' - '.$value['subsrd_date']->format('Y-m-d').' - STATUS BUKAN OPEN';
                }
            }
            return array('sql'=> $sql, 'msg' => $msg);
        }
        return false;
    }

    function TaxBrokerToMutasiBackground($date)
    {   
        $subsrd = $this->db_nfs->query("
            SELECT 
                A.SI_REFF as subsrd_id,
                A.HIPORT_CODE AS client_code,
                CONVERT ( DATE, A.SETTLEMENT_DATE ) AS subsrd_date,
                CONVERT ( DECIMAL(16,2), A.WHT_COMMISION ) AS subsrd_nominal,
                A.MODIFIER,
                A.CREATION_DATE,
                A.MODIFICATION_DATE,
                'D016' AS subsrd_kategori,
                'Wht Commision - '+RTRIM(SECURITY_CODE) AS deskripsi,
                B.FUND_OPR_ACCT_NO AS acc_no 
            FROM
                NFS_INQ_EQUITY_TEMP A
                INNER JOIN FUND_DETAILS B ON B.HIPORT_CODE = A.HIPORT_CODE 
            WHERE
                CONVERT ( DECIMAL(16,2), A.WHT_COMMISION ) > 0 AND
                CONVERT ( DATE, A.SETTLEMENT_DATE ) = '".$date."'
                AND A.TRANSACTION_STATUS ='NEWM'
                AND A.IM_CODE <> 'KI002' AND A.IM_CODE <> 'DX002'
            ORDER BY
                subsrd_date DESC
        ");

        $sql = '';
        $msg = '';
        if( count($subsrd->result_array()) > 0 ){
            foreach ($subsrd->result_array() as $key => $value) {
                $status_mutasi = $this->status_mutasi($value['client_code'], $value['acc_no'], $value['subsrd_date']->format('Y-m-d'));

				if($status_mutasi == 0){
                $sql = $sql. "
                IF NOT EXISTS ( SELECT*FROM mutasi_trx WHERE client_code='".$value['client_code']."' AND trx_date='".$value['subsrd_date']->format('Y-m-d H:i:s')."' AND coa_no='D016' AND acc_no='".$value['acc_no']."' AND subsrd_id='".$value['subsrd_id']."' )
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
                    ) VALUES ( 
                        '".$value['client_code']."',
                        '".$value['acc_no']."', 
                        '".$value['subsrd_date']->format('Y-m-d H:i:s')."',
                        '".$value['subsrd_kategori']."', 
                        'Tax Broker',
                        '".$value['deskripsi']."',
                        'D',  
                        '".$value['subsrd_nominal']."',
                        'system', 
                        '".date('Y-m-d H:i:s')."', 
                        'system', 
                        '".date('Y-m-d H:i:s')."', 
                        1, 
                        '".$value['subsrd_id']."'
                    );
                END;";
                }else{
                    $msg = $msg.' <br> '.$value['client_code'].' - '.$value['acc_no'].' - '.$value['subsrd_date']->format('Y-m-d').' - STATUS BUKAN OPEN';
                }
            }
            return array('sql'=> $sql, 'msg' => $msg);
        }
        return false;
    }

    function TaxObligasiToMutasiBackground($date)
    {        
        $subsrd = $this->db_nfs->query("
            SELECT
                * 
            FROM
            (
            SELECT
                A.SI_REFERENCE AS subsrd_id,
                A.HIPORT_CODE AS client_code,
                CONVERT ( DATE, A.SETTLEMENT_DATE ) AS subsrd_date,
                CONVERT ( DECIMAL(16,2), A.CAPITAL_GAIN_TAX ) AS subsrd_nominal,
                A.MODIFIER,
                A.CREATION_DATE,
                A.MODIFICATION_DATE,
                'D017' AS subsrd_kategori,
                'Capital Gain Tax - ' + RTRIM(SECURITY_CODE) AS deskripsi,
                B.FUND_OPR_ACCT_NO AS acc_no 
            FROM
                NFS_FI_INS_INQ_TEMP A
                INNER JOIN FUND_DETAILS B ON B.HIPORT_CODE = A.HIPORT_CODE 
            WHERE
                CONVERT ( DECIMAL(16,2), A.CAPITAL_GAIN_TAX ) > 0
                AND CONVERT ( DATE, A.SETTLEMENT_DATE ) = '".$date."'
                AND BUY_SELL = '1'
                AND A.TRANSACTION_STATUS ='NEWM'
            ) AS CAPITAL_GAIN_TAX

            UNION ALL

            SELECT
                * 
            FROM
            (
                SELECT
                    A.SI_REFERENCE AS subsrd_id,
                    A.HIPORT_CODE AS client_code,
                    CONVERT ( DATE, A.SETTLEMENT_DATE ) AS subsrd_date,
                    CONVERT ( DECIMAL(16,2), A.INTEREST_INCOME_TAX ) AS subsrd_nominal,
                    A.MODIFIER,
                    A.CREATION_DATE,
                    A.MODIFICATION_DATE,
                    'D017' AS subsrd_kategori,
                    'Interst Income Tax - ' + RTRIM(SECURITY_CODE) AS deskripsi,
                    B.FUND_OPR_ACCT_NO AS acc_no 
                FROM
                    NFS_FI_INS_INQ_TEMP A
                    INNER JOIN FUND_DETAILS B ON B.HIPORT_CODE = A.HIPORT_CODE 
                WHERE
                    CONVERT ( DECIMAL(16,2), A.INTEREST_INCOME_TAX ) > 0 
                    AND CONVERT ( DATE, A.SETTLEMENT_DATE ) = '".$date."'
                    AND BUY_SELL = '1' 
                    AND A.TRANSACTION_STATUS ='NEWM'
            ) AS INTEREST_INCOME_TAX
            
        ");

        $sql = '';
        $msg = '';
        if( count($subsrd->result_array()) > 0 ){
            foreach ($subsrd->result_array() as $key => $value) {
                $status_mutasi = $this->status_mutasi($value['client_code'], $value['acc_no'], $value['subsrd_date']->format('Y-m-d'));

				if($status_mutasi == 0){
                $msg = $msg.' <br> '.$value['subsrd_id'];
                $sql = $sql. "
                IF NOT EXISTS ( SELECT*FROM mutasi_trx WHERE client_code='".$value['client_code']."' AND trx_date='".$value['subsrd_date']->format('Y-m-d H:i:s')."' AND coa_no='D017' AND acc_no='".$value['acc_no']."' AND subsrd_id='".$value['subsrd_id']."' )
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
                    ) VALUES ( 
                        '".$value['client_code']."',
                        '".$value['acc_no']."', 
                        '".$value['subsrd_date']->format('Y-m-d H:i:s')."',
                        '".$value['subsrd_kategori']."', 
                        'Tax Obligasi',
                        '".$value['deskripsi']."',
                        'D', 
                        '".$value['subsrd_nominal']."',
                        'system', 
                        '".date('Y-m-d H:i:s')."', 
                        'system', 
                        '".date('Y-m-d H:i:s')."', 
                        1, 
                        '".$value['subsrd_id']."'
                    );
                END;";
                }else{
                    $msg = $msg.' <br> '.$value['client_code'].' - '.$value['acc_no'].' - '.$value['subsrd_date']->format('Y-m-d').' - STATUS BUKAN OPEN';
                }
            }
            return array('sql'=> $sql, 'msg' => $msg);
        }
        return false;
    }

    function RedemptionToMutasiBackground($date)
    {
        $subsrd = $this->db_urssim->query("
            select 
                *
            from (
                SELECT
                    CONVERT ( DATE, '".$date."', 102 ) as 'subsrd_date',
                    db_name() + '_' + '".date('Ymd',strtotime($date))."' +'_'+ a.HIPORT_CODE+'_'+ a.debitacc+'_'+a.SELLING_AGENT_CODE AS 'subsrd_id',
                    a.HIPORT_CODE as 'client_code',
                    SUM ( a.net_proceed ) AS 'subsrd_nominal',
                    a.debitacc as 'acc_no',
                    a.FUND_ID ,
                    a.BANK_NAME ,
                    a.saname ,
                    a.SELLING_AGENT_CODE,
                    'Redemption NIAGA - ' + a.saname AS deskripsi
                FROM
                    (
                    SELECT
                        fd.HIPORT_CODE ,
                        dbo.TXN_POSTING.INVESTOR_NO,
                        dbo.TXN_POSTING.TXN_TYPE,
                        dbo.TXN_POSTING.NET_PROCEED,
                        dbo.TXN.PAYMENT_DATE,
                        dbo.FUND_ID.ACC_BANK_OPR AS 'debitacc',
                        fund_id.DESCRIPTION AS 'bank_name',
                        dbo.TXN.BANK_ID_ADDRESS,
                        dbo.TXN.BANK_ACCT_NO,
                        dbo.TXN_POSTING.GOOD_FUND_DATE,
                        dbo.TXN.FUND_ID,
                        dbo.TXN.BANK_LETTER_CITY,
                        sa.NAME AS 'saname',
                        sa.SELLING_AGENT_CODE
                    FROM
                        dbo.TXN
                        INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                        INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID
                        LEFT JOIN SELLING_AGENT sa ON sa.SELLING_AGENT_CODE = txn.SELLING_AGENT_CODE
                        INNER JOIN NFS_DB.dbo.FUND_DETAILS fd ON fd.URS_CODE = FUND_ID.FUND_ID 
                        INNER JOIN dbo.FUND_SUMMARY ON dbo.FUND_SUMMARY.FUND_ID = dbo.TXN.FUND_ID AND dbo.FUND_SUMMARY.TRADE_DATE = dbo.TXN.PAYMENT_DATE 
                    WHERE ( CONVERT ( DATE, dbo.TXN.PAYMENT_DATE ) = '".$date."' ) 
                        AND ( dbo.TXN_POSTING.TXN_TYPE = 'R' ) 
                        AND ( isnull( dbo.TXN.BANK_LETTER_CITY , '' ) = '' ) 
                    ) a 
                GROUP BY
                    a.HIPORT_CODE ,
                    a.debitacc  ,
                    a.FUND_ID ,
                    a.BANK_NAME ,
                    a.saname ,
                    a.SELLING_AGENT_CODE 
                
                UNION ALL
            
                SELECT
                    CONVERT ( DATE, '".$date."', 102 ) as 'subsrd_date',
                    db_name() + '_' + '".date('Ymd',strtotime($date))."' +'_'+ a.HIPORT_CODE+'_'+ a.debitacc+'_'+a.SELLING_AGENT_CODE AS 'subsrd_id',
                    a.HIPORT_CODE as 'client_code',
                    SUM ( a.net_proceed ) AS 'subsrd_nominal',
                    a.debitacc as 'acc_no',
                    a.FUND_ID ,
                    a.BANK_NAME ,
                    a.saname ,
                    a.SELLING_AGENT_CODE,
                    'Redemption Non Niaga- ' + a.saname AS deskripsi
                FROM
                    (
                    SELECT
                        CONVERT ( DATE, dbo.TXN.PAYMENT_DATE ) as dt,
                        fd.HIPORT_CODE,
                        dbo.TXN_POSTING.INVESTOR_NO,
                        dbo.TXN_POSTING.TXN_TYPE,
                        dbo.TXN_POSTING.NET_PROCEED,
                        dbo.TXN.PAYMENT_DATE,
                        dbo.FUND_ID.ACC_BANK_OPR ,
                        dbo.TXN.BANK_ID_ADDRESS,
                        dbo.TXN.BANK_ACCT_NO,
                        dbo.FUND_ID_BANK.DESCRIPTION AS 'Bank_name',
                        dbo.FUND_ID_BANK.ACC_NO AS 'debitacc',
                        dbo.TXN_POSTING.GOOD_FUND_DATE,
                        dbo.TXN.FUND_ID,
                        dbo.TXN.BANK_LETTER_CITY,
                        sa.NAME AS 'saname',
                        sa.SELLING_AGENT_CODE
                    FROM
                        dbo.TXN
                        INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                        INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID
                        INNER JOIN dbo.FUND_ID_BANK ON dbo.TXN.BANK_LETTER_CITY = dbo.FUND_ID_BANK.BANK_CODE
                        LEFT JOIN SELLING_AGENT sa ON sa.SELLING_AGENT_CODE = txn.SELLING_AGENT_CODE
                        INNER JOIN NFS_DB.dbo.FUND_DETAILS fd ON fd.URS_CODE = FUND_ID.FUND_ID 
                        INNER JOIN dbo.FUND_SUMMARY ON dbo.FUND_SUMMARY.FUND_ID = dbo.TXN.FUND_ID AND dbo.FUND_SUMMARY.TRADE_DATE = dbo.TXN.PAYMENT_DATE
                    WHERE ( CONVERT ( DATE, dbo.TXN.PAYMENT_DATE ) = '".$date."' ) 
                        AND ( dbo.TXN_POSTING.TXN_TYPE = 'R' ) 
                    ) a 
                GROUP BY
                    a.HIPORT_CODE ,
                    a.debitacc  ,
                    a.FUND_ID ,
                    a.BANK_NAME ,
                    a.saname ,
                    a.SELLING_AGENT_CODE
            ) as r
        ");
        
        $sql = '';
        $msg = '';
        if( count($subsrd->result_array()) > 0 ){
            foreach ($subsrd->result_array() as $key => $value) {
                $status_mutasi = $this->status_mutasi($value['client_code'], $value['acc_no'], $value['subsrd_date']->format('Y-m-d'));

				if($status_mutasi == 0){
                $msg = $msg.' <br> '.$value['subsrd_id'];
                $sql = $sql. "
                IF NOT EXISTS (SELECT*FROM mutasi_trx WHERE subsrd_id='".$value['subsrd_id']."')
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
                    ) VALUES ( 
                        '".$value['client_code']."',
                        '".$value['acc_no']."', 
                        '".$value['subsrd_date']->format('Y-m-d H:i:s')."',
                        'D001', 
                        'Bayar Redemption', 
                        '".$value['deskripsi']."',
                        'D', 
                        '".$value['subsrd_nominal']."',
                        'system', 
                        '".date('Y-m-d H:i:s')."', 
                        'system', 
                        '".date('Y-m-d H:i:s')."', 
                        1, 
                        '".$value['subsrd_id']."'
                    );
                END;";
                }else{
                    $msg = $msg.' <br> '.$value['client_code'].' - '.$value['acc_no'].' - '.$value['subsrd_date']->format('Y-m-d').' - STATUS BUKAN OPEN';
                }
            }
            return array('sql'=> $sql, 'msg' => $msg);
        }
        return false;
    }

    function RedemptionToMutasiBackgroundBatavia($date)
    {
        $subsrd = $this->db_batavia->query("
            select 
                *
            from (
                SELECT
                    CONVERT ( DATE, '".$date."', 102 ) as 'subsrd_date',
                    db_name() + '_' + '".date('Ymd',strtotime($date))."' +'_'+ a.HIPORT_CODE+'_'+ a.debitacc+'_'+a.SELLING_AGENT_CODE AS 'subsrd_id',
                    a.HIPORT_CODE as 'client_code',
                    SUM ( a.net_proceed ) AS 'subsrd_nominal',
                    a.debitacc as 'acc_no',
                    a.FUND_ID ,
                    a.BANK_NAME ,
                    a.saname ,
                    a.SELLING_AGENT_CODE,
                    'Redemption NIAGA - ' + a.saname AS deskripsi
                FROM
                    (
                    SELECT
                        fd.HIPORT_CODE ,
                        dbo.TXN_POSTING.INVESTOR_NO,
                        dbo.TXN_POSTING.TXN_TYPE,
                        dbo.TXN_POSTING.NET_PROCEED,
                        dbo.TXN.PAYMENT_DATE,
                        dbo.FUND_ID.ACC_BANK_OPR AS 'debitacc',
                        fund_id.DESCRIPTION AS 'bank_name',
                        dbo.TXN.BANK_ID_ADDRESS,
                        dbo.TXN.BANK_ACCT_NO,
                        dbo.TXN_POSTING.GOOD_FUND_DATE,
                        dbo.TXN.FUND_ID,
                        dbo.TXN.BANK_LETTER_CITY,
                        sa.NAME AS 'saname',
                        sa.SELLING_AGENT_CODE
                    FROM
                        dbo.TXN
                        INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                        INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID
                        LEFT JOIN SELLING_AGENT sa ON sa.SELLING_AGENT_CODE = txn.SELLING_AGENT_CODE
                        INNER JOIN NFS_DB.dbo.FUND_DETAILS fd ON fd.URS_CODE = FUND_ID.FUND_ID 
                        INNER JOIN dbo.FUND_SUMMARY ON dbo.FUND_SUMMARY.FUND_ID = dbo.TXN.FUND_ID AND dbo.FUND_SUMMARY.TRADE_DATE = dbo.TXN.PAYMENT_DATE 
                    WHERE ( CONVERT ( DATE, dbo.TXN.PAYMENT_DATE ) = '".$date."' ) 
                        AND ( dbo.TXN_POSTING.TXN_TYPE = 'R' ) 
                        AND ( isnull( dbo.TXN.BANK_LETTER_CITY , '' ) = '' ) 
                    ) a 
                GROUP BY
                    a.HIPORT_CODE ,
                    a.debitacc  ,
                    a.FUND_ID ,
                    a.BANK_NAME ,
                    a.saname ,
                    a.SELLING_AGENT_CODE 
                
                UNION ALL
            
                SELECT
                    CONVERT ( DATE, '".$date."', 102 ) as 'subsrd_date',
                    db_name() + '_' + '".date('Ymd',strtotime($date))."' +'_'+ a.HIPORT_CODE+'_'+ a.debitacc+'_'+a.SELLING_AGENT_CODE AS 'subsrd_id',
                    a.HIPORT_CODE as 'client_code',
                    SUM ( a.net_proceed ) AS 'subsrd_nominal',
                    a.debitacc as 'acc_no',
                    a.FUND_ID ,
                    a.BANK_NAME ,
                    a.saname ,
                    a.SELLING_AGENT_CODE,
                    'Redemption Non Niaga- ' + a.saname AS deskripsi
                FROM
                    (
                    SELECT
                        CONVERT ( DATE, dbo.TXN.PAYMENT_DATE ) as dt,
                        fd.HIPORT_CODE,
                        dbo.TXN_POSTING.INVESTOR_NO,
                        dbo.TXN_POSTING.TXN_TYPE,
                        dbo.TXN_POSTING.NET_PROCEED,
                        dbo.TXN.PAYMENT_DATE,
                        dbo.FUND_ID.ACC_BANK_OPR ,
                        dbo.TXN.BANK_ID_ADDRESS,
                        dbo.TXN.BANK_ACCT_NO,
                        dbo.FUND_ID_BANK.DESCRIPTION AS 'Bank_name',
                        dbo.FUND_ID_BANK.ACC_NO AS 'debitacc',
                        dbo.TXN_POSTING.GOOD_FUND_DATE,
                        dbo.TXN.FUND_ID,
                        dbo.TXN.BANK_LETTER_CITY,
                        sa.NAME AS 'saname',
                        sa.SELLING_AGENT_CODE
                    FROM
                        dbo.TXN
                        INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                        INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID
                        INNER JOIN dbo.FUND_ID_BANK ON dbo.TXN.BANK_LETTER_CITY = dbo.FUND_ID_BANK.BANK_CODE
                        LEFT JOIN SELLING_AGENT sa ON sa.SELLING_AGENT_CODE = txn.SELLING_AGENT_CODE
                        INNER JOIN NFS_DB.dbo.FUND_DETAILS fd ON fd.URS_CODE = FUND_ID.FUND_ID 
                        INNER JOIN dbo.FUND_SUMMARY ON dbo.FUND_SUMMARY.FUND_ID = dbo.TXN.FUND_ID AND dbo.FUND_SUMMARY.TRADE_DATE = dbo.TXN.PAYMENT_DATE
                    WHERE ( CONVERT ( DATE, dbo.TXN.PAYMENT_DATE ) = '".$date."' ) 
                        AND ( dbo.TXN_POSTING.TXN_TYPE = 'R' ) 
                    ) a 
                GROUP BY
                    a.HIPORT_CODE ,
                    a.debitacc  ,
                    a.FUND_ID ,
                    a.BANK_NAME ,
                    a.saname ,
                    a.SELLING_AGENT_CODE
            ) as r
        ");
        
        $sql = '';
        $msg = '';
        if( count($subsrd->result_array()) > 0 ){
            foreach ($subsrd->result_array() as $key => $value) {
                $status_mutasi = $this->status_mutasi($value['client_code'], $value['acc_no'], $value['subsrd_date']->format('Y-m-d'));

				if($status_mutasi == 0){
                $msg = $msg.' '.$value['subsrd_id'];
                $sql = $sql. "
                IF NOT EXISTS (SELECT*FROM mutasi_trx WHERE subsrd_id='".$value['subsrd_id']."')
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
                    ) VALUES ( 
                        '".$value['client_code']."',
                        '".$value['acc_no']."', 
                        '".$value['subsrd_date']->format('Y-m-d H:i:s')."',
                        'D001', 
                        'Bayar Redemption', 
                        '".$value['deskripsi']."',
                        'D', 
                        '".$value['subsrd_nominal']."',
                        'system', 
                        '".date('Y-m-d H:i:s')."', 
                        'system', 
                        '".date('Y-m-d H:i:s')."', 
                        1, 
                        '".$value['subsrd_id']."'
                    );
                END;";
                }else{
                    $msg = $msg.' <br> '.$value['client_code'].' - '.$value['acc_no'].' - '.$value['subsrd_date']->format('Y-m-d').' - STATUS BUKAN OPEN';
                }
            }
            return array('sql'=> $sql, 'msg' => $msg);
        }
        return false;
    }

    function RedemptionToMutasiBackgroundBni($date)
    {
        $subsrd = $this->db_bni->query("
            select 
                *
            from (
                SELECT
                    CONVERT ( DATE, '".$date."', 102 ) as 'subsrd_date',
                    db_name() + '_' + '".date('Ymd',strtotime($date))."' +'_'+ a.HIPORT_CODE+'_'+ a.debitacc+'_'+a.SELLING_AGENT_CODE AS 'subsrd_id',
                    a.HIPORT_CODE as 'client_code',
                    SUM ( a.net_proceed ) AS 'subsrd_nominal',
                    a.debitacc as 'acc_no',
                    a.FUND_ID ,
                    a.BANK_NAME ,
                    a.saname ,
                    a.SELLING_AGENT_CODE,
                    'Redemption NIAGA - ' + a.saname AS deskripsi
                FROM
                    (
                    SELECT
                        fd.HIPORT_CODE ,
                        dbo.TXN_POSTING.INVESTOR_NO,
                        dbo.TXN_POSTING.TXN_TYPE,
                        dbo.TXN_POSTING.NET_PROCEED,
                        dbo.TXN.PAYMENT_DATE,
                        dbo.FUND_ID.ACC_BANK_OPR AS 'debitacc',
                        fund_id.DESCRIPTION AS 'bank_name',
                        dbo.TXN.BANK_ID_ADDRESS,
                        dbo.TXN.BANK_ACCT_NO,
                        dbo.TXN_POSTING.GOOD_FUND_DATE,
                        dbo.TXN.FUND_ID,
                        dbo.TXN.BANK_LETTER_CITY,
                        sa.NAME AS 'saname',
                        sa.SELLING_AGENT_CODE
                    FROM
                        dbo.TXN
                        INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                        INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID
                        LEFT JOIN SELLING_AGENT sa ON sa.SELLING_AGENT_CODE = txn.SELLING_AGENT_CODE
                        INNER JOIN NFS_DB.dbo.FUND_DETAILS fd ON fd.URS_CODE = FUND_ID.FUND_ID 
                        INNER JOIN dbo.FUND_SUMMARY ON dbo.FUND_SUMMARY.FUND_ID = dbo.TXN.FUND_ID AND dbo.FUND_SUMMARY.TRADE_DATE = dbo.TXN.PAYMENT_DATE 
                    WHERE ( CONVERT ( DATE, dbo.TXN.PAYMENT_DATE ) = '".$date."' ) 
                        AND ( dbo.TXN_POSTING.TXN_TYPE = 'R' ) 
                        AND ( isnull( dbo.TXN.BANK_LETTER_CITY , '' ) = '' ) 
                    ) a 
                GROUP BY
                    a.HIPORT_CODE ,
                    a.debitacc  ,
                    a.FUND_ID ,
                    a.BANK_NAME ,
                    a.saname ,
                    a.SELLING_AGENT_CODE 
                
                UNION ALL
            
                SELECT
                    CONVERT ( DATE, '".$date."', 102 ) as 'subsrd_date',
                    db_name() + '_' + '".date('Ymd',strtotime($date))."' +'_'+ a.HIPORT_CODE+'_'+ a.debitacc+'_'+a.SELLING_AGENT_CODE AS 'subsrd_id',
                    a.HIPORT_CODE as 'client_code',
                    SUM ( a.net_proceed ) AS 'subsrd_nominal',
                    a.debitacc as 'acc_no',
                    a.FUND_ID ,
                    a.BANK_NAME ,
                    a.saname ,
                    a.SELLING_AGENT_CODE,
                    'Redemption Non Niaga- ' + a.saname AS deskripsi
                FROM
                    (
                    SELECT
                        CONVERT ( DATE, dbo.TXN.PAYMENT_DATE ) as dt,
                        fd.HIPORT_CODE,
                        dbo.TXN_POSTING.INVESTOR_NO,
                        dbo.TXN_POSTING.TXN_TYPE,
                        dbo.TXN_POSTING.NET_PROCEED,
                        dbo.TXN.PAYMENT_DATE,
                        dbo.FUND_ID.ACC_BANK_OPR ,
                        dbo.TXN.BANK_ID_ADDRESS,
                        dbo.TXN.BANK_ACCT_NO,
                        dbo.FUND_ID_BANK.DESCRIPTION AS 'Bank_name',
                        dbo.FUND_ID_BANK.ACC_NO AS 'debitacc',
                        dbo.TXN_POSTING.GOOD_FUND_DATE,
                        dbo.TXN.FUND_ID,
                        dbo.TXN.BANK_LETTER_CITY,
                        sa.NAME AS 'saname',
                        sa.SELLING_AGENT_CODE
                    FROM
                        dbo.TXN
                        INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                        INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID
                        INNER JOIN dbo.FUND_ID_BANK ON dbo.TXN.BANK_LETTER_CITY = dbo.FUND_ID_BANK.BANK_CODE
                        LEFT JOIN SELLING_AGENT sa ON sa.SELLING_AGENT_CODE = txn.SELLING_AGENT_CODE
                        INNER JOIN NFS_DB.dbo.FUND_DETAILS fd ON fd.URS_CODE = FUND_ID.FUND_ID 
                        INNER JOIN dbo.FUND_SUMMARY ON dbo.FUND_SUMMARY.FUND_ID = dbo.TXN.FUND_ID AND dbo.FUND_SUMMARY.TRADE_DATE = dbo.TXN.PAYMENT_DATE
                    WHERE ( CONVERT ( DATE, dbo.TXN.PAYMENT_DATE ) = '".$date."' ) 
                        AND ( dbo.TXN_POSTING.TXN_TYPE = 'R' ) 
                    ) a 
                GROUP BY
                    a.HIPORT_CODE ,
                    a.debitacc  ,
                    a.FUND_ID ,
                    a.BANK_NAME ,
                    a.saname ,
                    a.SELLING_AGENT_CODE
            ) as r
        ");
        
        $sql = '';
        $msg = '';
        if( count($subsrd->result_array()) > 0 ){
            foreach ($subsrd->result_array() as $key => $value) {
                $status_mutasi = $this->status_mutasi($value['client_code'], $value['acc_no'], $value['subsrd_date']->format('Y-m-d'));

				if($status_mutasi == 0){
                $msg = $msg.' '.$value['subsrd_id'];
                $sql = $sql. "
                IF NOT EXISTS (SELECT*FROM mutasi_trx WHERE subsrd_id='".$value['subsrd_id']."')
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
                    ) VALUES ( 
                        '".$value['client_code']."',
                        '".$value['acc_no']."', 
                        '".$value['subsrd_date']->format('Y-m-d H:i:s')."',
                        'D001', 
                        'Bayar Redemption', 
                        '".$value['deskripsi']."',
                        'D', 
                        '".$value['subsrd_nominal']."',
                        'system', 
                        '".date('Y-m-d H:i:s')."', 
                        'system', 
                        '".date('Y-m-d H:i:s')."', 
                        1, 
                        '".$value['subsrd_id']."'
                    );
                END;";
                }else{
                    $msg = $msg.' <br> '.$value['client_code'].' - '.$value['acc_no'].' - '.$value['subsrd_date']->format('Y-m-d').' - STATUS BUKAN OPEN';
                }
            }
            return array('sql'=> $sql, 'msg' => $msg);
        }
        return false;
    }

    function RedemptionToMutasiBackgroundNiaga($date)
    {
        $subsrd = $this->db_niaga->query("
            select 
                *
            from (
                SELECT
                    CONVERT ( DATE, '".$date."', 102 ) as 'subsrd_date',
                    db_name() + '_' + '".date('Ymd',strtotime($date))."' +'_'+ a.HIPORT_CODE+'_'+ a.debitacc+'_'+a.SELLING_AGENT_CODE AS 'subsrd_id',
                    a.HIPORT_CODE as 'client_code',
                    SUM ( a.net_proceed ) AS 'subsrd_nominal',
                    a.debitacc as 'acc_no',
                    a.FUND_ID ,
                    a.BANK_NAME ,
                    a.saname ,
                    a.SELLING_AGENT_CODE,
                    'Redemption NIAGA - ' + a.saname AS deskripsi
                FROM
                    (
                    SELECT
                        fd.HIPORT_CODE ,
                        dbo.TXN_POSTING.INVESTOR_NO,
                        dbo.TXN_POSTING.TXN_TYPE,
                        dbo.TXN_POSTING.NET_PROCEED,
                        dbo.TXN.PAYMENT_DATE,
                        dbo.FUND_ID.ACC_BANK_OPR AS 'debitacc',
                        fund_id.DESCRIPTION AS 'bank_name',
                        dbo.TXN.BANK_ID_ADDRESS,
                        dbo.TXN.BANK_ACCT_NO,
                        dbo.TXN_POSTING.GOOD_FUND_DATE,
                        dbo.TXN.FUND_ID,
                        dbo.TXN.BANK_LETTER_CITY,
                        sa.NAME AS 'saname',
                        sa.SELLING_AGENT_CODE
                    FROM
                        dbo.TXN
                        INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                        INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID
                        LEFT JOIN SELLING_AGENT sa ON sa.SELLING_AGENT_CODE = txn.SELLING_AGENT_CODE
                        INNER JOIN NFS_DB.dbo.FUND_DETAILS fd ON fd.URS_CODE = FUND_ID.FUND_ID 
                        INNER JOIN dbo.FUND_SUMMARY ON dbo.FUND_SUMMARY.FUND_ID = dbo.TXN.FUND_ID AND dbo.FUND_SUMMARY.TRADE_DATE = dbo.TXN.PAYMENT_DATE 
                    WHERE ( CONVERT ( DATE, dbo.TXN.PAYMENT_DATE ) = '".$date."' ) 
                        AND ( dbo.TXN_POSTING.TXN_TYPE = 'R' ) 
                        AND ( isnull( dbo.TXN.BANK_LETTER_CITY , '' ) = '' ) 
                    ) a 
                GROUP BY
                    a.HIPORT_CODE ,
                    a.debitacc  ,
                    a.FUND_ID ,
                    a.BANK_NAME ,
                    a.saname ,
                    a.SELLING_AGENT_CODE 
                
                UNION ALL
            
                SELECT
                    CONVERT ( DATE, '".$date."', 102 ) as 'subsrd_date',
                    db_name() + '_' + '".date('Ymd',strtotime($date))."' +'_'+ a.HIPORT_CODE+'_'+ a.debitacc+'_'+a.SELLING_AGENT_CODE AS 'subsrd_id',
                    a.HIPORT_CODE as 'client_code',
                    SUM ( a.net_proceed ) AS 'subsrd_nominal',
                    a.debitacc as 'acc_no',
                    a.FUND_ID ,
                    a.BANK_NAME ,
                    a.saname ,
                    a.SELLING_AGENT_CODE,
                    'Redemption Non Niaga- ' + a.saname AS deskripsi
                FROM
                    (
                    SELECT
                        CONVERT ( DATE, dbo.TXN.PAYMENT_DATE ) as dt,
                        fd.HIPORT_CODE,
                        dbo.TXN_POSTING.INVESTOR_NO,
                        dbo.TXN_POSTING.TXN_TYPE,
                        dbo.TXN_POSTING.NET_PROCEED,
                        dbo.TXN.PAYMENT_DATE,
                        dbo.FUND_ID.ACC_BANK_OPR ,
                        dbo.TXN.BANK_ID_ADDRESS,
                        dbo.TXN.BANK_ACCT_NO,
                        dbo.FUND_ID_BANK.DESCRIPTION AS 'Bank_name',
                        dbo.FUND_ID_BANK.ACC_NO AS 'debitacc',
                        dbo.TXN_POSTING.GOOD_FUND_DATE,
                        dbo.TXN.FUND_ID,
                        dbo.TXN.BANK_LETTER_CITY,
                        sa.NAME AS 'saname',
                        sa.SELLING_AGENT_CODE
                    FROM
                        dbo.TXN
                        INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                        INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID
                        INNER JOIN dbo.FUND_ID_BANK ON dbo.TXN.BANK_LETTER_CITY = dbo.FUND_ID_BANK.BANK_CODE
                        LEFT JOIN SELLING_AGENT sa ON sa.SELLING_AGENT_CODE = txn.SELLING_AGENT_CODE
                        INNER JOIN NFS_DB.dbo.FUND_DETAILS fd ON fd.URS_CODE = FUND_ID.FUND_ID 
                        INNER JOIN dbo.FUND_SUMMARY ON dbo.FUND_SUMMARY.FUND_ID = dbo.TXN.FUND_ID AND dbo.FUND_SUMMARY.TRADE_DATE = dbo.TXN.PAYMENT_DATE
                    WHERE ( CONVERT ( DATE, dbo.TXN.PAYMENT_DATE ) = '".$date."' ) 
                        AND ( dbo.TXN_POSTING.TXN_TYPE = 'R' ) 
                    ) a 
                GROUP BY
                    a.HIPORT_CODE ,
                    a.debitacc  ,
                    a.FUND_ID ,
                    a.BANK_NAME ,
                    a.saname ,
                    a.SELLING_AGENT_CODE
            ) as r
        ");
        
        $sql = '';
        $msg = '';
        if( count($subsrd->result_array()) > 0 ){
            foreach ($subsrd->result_array() as $key => $value) {
                $status_mutasi = $this->status_mutasi($value['client_code'], $value['acc_no'], $value['subsrd_date']->format('Y-m-d'));

				if($status_mutasi == 0){
                $msg = $msg.' '.$value['subsrd_id'];
                $sql = $sql. "
                IF NOT EXISTS (SELECT*FROM mutasi_trx WHERE subsrd_id='".$value['subsrd_id']."')
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
                    ) VALUES ( 
                        '".$value['client_code']."',
                        '".$value['acc_no']."', 
                        '".$value['subsrd_date']->format('Y-m-d H:i:s')."',
                        'D001', 
                        'Bayar Redemption', 
                        '".$value['deskripsi']."',
                        'D', 
                        '".$value['subsrd_nominal']."',
                        'system', 
                        '".date('Y-m-d H:i:s')."', 
                        'system', 
                        '".date('Y-m-d H:i:s')."', 
                        1, 
                        '".$value['subsrd_id']."'
                    );
                END;";
                }else{
                    $msg = $msg.' <br> '.$value['client_code'].' - '.$value['acc_no'].' - '.$value['subsrd_date']->format('Y-m-d').' - STATUS BUKAN OPEN';
                }
            }
            return array('sql'=> $sql, 'msg' => $msg);
        }
        return false;
    }

    function RedemptionToMutasiBackgroundNiaga2($date)
    {
        $subsrd = $this->db_niaga2->query("
            select 
                *
            from (
                SELECT
                    CONVERT ( DATE, '".$date."', 102 ) as 'subsrd_date',
                    db_name() + '_' + '".date('Ymd',strtotime($date))."' +'_'+ a.HIPORT_CODE+'_'+ a.debitacc+'_'+a.SELLING_AGENT_CODE AS 'subsrd_id',
                    a.HIPORT_CODE as 'client_code',
                    SUM ( a.net_proceed ) AS 'subsrd_nominal',
                    a.debitacc as 'acc_no',
                    a.FUND_ID ,
                    a.BANK_NAME ,
                    a.saname ,
                    a.SELLING_AGENT_CODE,
                    'Redemption NIAGA - ' + a.saname AS deskripsi
                FROM
                    (
                    SELECT
                        fd.HIPORT_CODE ,
                        dbo.TXN_POSTING.INVESTOR_NO,
                        dbo.TXN_POSTING.TXN_TYPE,
                        dbo.TXN_POSTING.NET_PROCEED,
                        dbo.TXN.PAYMENT_DATE,
                        dbo.FUND_ID.ACC_BANK_OPR AS 'debitacc',
                        fund_id.DESCRIPTION AS 'bank_name',
                        dbo.TXN.BANK_ID_ADDRESS,
                        dbo.TXN.BANK_ACCT_NO,
                        dbo.TXN_POSTING.GOOD_FUND_DATE,
                        dbo.TXN.FUND_ID,
                        dbo.TXN.BANK_LETTER_CITY,
                        sa.NAME AS 'saname',
                        sa.SELLING_AGENT_CODE
                    FROM
                        dbo.TXN
                        INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                        INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID
                        LEFT JOIN SELLING_AGENT sa ON sa.SELLING_AGENT_CODE = txn.SELLING_AGENT_CODE
                        INNER JOIN NFS_DB.dbo.FUND_DETAILS fd ON fd.URS_CODE = FUND_ID.FUND_ID 
                        INNER JOIN dbo.FUND_SUMMARY ON dbo.FUND_SUMMARY.FUND_ID = dbo.TXN.FUND_ID AND dbo.FUND_SUMMARY.TRADE_DATE = dbo.TXN.PAYMENT_DATE 
                    WHERE ( CONVERT ( DATE, dbo.TXN.PAYMENT_DATE ) = '".$date."' ) 
                        AND ( dbo.TXN_POSTING.TXN_TYPE = 'R' ) 
                        AND ( isnull( dbo.TXN.BANK_LETTER_CITY , '' ) = '' ) 
                    ) a 
                GROUP BY
                    a.HIPORT_CODE ,
                    a.debitacc  ,
                    a.FUND_ID ,
                    a.BANK_NAME ,
                    a.saname ,
                    a.SELLING_AGENT_CODE 
                
                UNION ALL
            
                SELECT
                    CONVERT ( DATE, '".$date."', 102 ) as 'subsrd_date',
                    db_name() + '_' + '".date('Ymd',strtotime($date))."' +'_'+ a.HIPORT_CODE+'_'+ a.debitacc+'_'+a.SELLING_AGENT_CODE AS 'subsrd_id',
                    a.HIPORT_CODE as 'client_code',
                    SUM ( a.net_proceed ) AS 'subsrd_nominal',
                    a.debitacc as 'acc_no',
                    a.FUND_ID ,
                    a.BANK_NAME ,
                    a.saname ,
                    a.SELLING_AGENT_CODE,
                    'Redemption Non Niaga- ' + a.saname AS deskripsi
                FROM
                    (
                    SELECT
                        CONVERT ( DATE, dbo.TXN.PAYMENT_DATE ) as dt,
                        fd.HIPORT_CODE,
                        dbo.TXN_POSTING.INVESTOR_NO,
                        dbo.TXN_POSTING.TXN_TYPE,
                        dbo.TXN_POSTING.NET_PROCEED,
                        dbo.TXN.PAYMENT_DATE,
                        dbo.FUND_ID.ACC_BANK_OPR ,
                        dbo.TXN.BANK_ID_ADDRESS,
                        dbo.TXN.BANK_ACCT_NO,
                        dbo.FUND_ID_BANK.DESCRIPTION AS 'Bank_name',
                        dbo.FUND_ID_BANK.ACC_NO AS 'debitacc',
                        dbo.TXN_POSTING.GOOD_FUND_DATE,
                        dbo.TXN.FUND_ID,
                        dbo.TXN.BANK_LETTER_CITY,
                        sa.NAME AS 'saname',
                        sa.SELLING_AGENT_CODE
                    FROM
                        dbo.TXN
                        INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                        INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID
                        INNER JOIN dbo.FUND_ID_BANK ON dbo.TXN.BANK_LETTER_CITY = dbo.FUND_ID_BANK.BANK_CODE
                        LEFT JOIN SELLING_AGENT sa ON sa.SELLING_AGENT_CODE = txn.SELLING_AGENT_CODE
                        INNER JOIN NFS_DB.dbo.FUND_DETAILS fd ON fd.URS_CODE = FUND_ID.FUND_ID 
                        INNER JOIN dbo.FUND_SUMMARY ON dbo.FUND_SUMMARY.FUND_ID = dbo.TXN.FUND_ID AND dbo.FUND_SUMMARY.TRADE_DATE = dbo.TXN.PAYMENT_DATE
                    WHERE ( CONVERT ( DATE, dbo.TXN.PAYMENT_DATE ) = '".$date."' ) 
                        AND ( dbo.TXN_POSTING.TXN_TYPE = 'R' ) 
                    ) a 
                GROUP BY
                    a.HIPORT_CODE ,
                    a.debitacc  ,
                    a.FUND_ID ,
                    a.BANK_NAME ,
                    a.saname ,
                    a.SELLING_AGENT_CODE
            ) as r
        ");
        
        $sql = '';
        $msg = '';
        if( count($subsrd->result_array()) > 0 ){
            foreach ($subsrd->result_array() as $key => $value) {
                $status_mutasi = $this->status_mutasi($value['client_code'], $value['acc_no'], $value['subsrd_date']->format('Y-m-d'));

				if($status_mutasi == 0){
                $msg = $msg.' '.$value['subsrd_id'];
                $sql = $sql. "
                IF NOT EXISTS (SELECT*FROM mutasi_trx WHERE subsrd_id='".$value['subsrd_id']."')
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
                    ) VALUES ( 
                        '".$value['client_code']."',
                        '".$value['acc_no']."', 
                        '".$value['subsrd_date']->format('Y-m-d H:i:s')."',
                        'D001', 
                        'Bayar Redemption', 
                        '".$value['deskripsi']."',
                        'D', 
                        '".$value['subsrd_nominal']."',
                        'system', 
                        '".date('Y-m-d H:i:s')."', 
                        'system', 
                        '".date('Y-m-d H:i:s')."', 
                        1, 
                        '".$value['subsrd_id']."'
                    );
                END;";
                }else{
                    $msg = $msg.' <br> '.$value['client_code'].' - '.$value['acc_no'].' - '.$value['subsrd_date']->format('Y-m-d').' - STATUS BUKAN OPEN';
                }
            }
            return array('sql'=> $sql, 'msg' => $msg);
        }
        return false;
    }

    function RedemptionToMutasiBackgroundSyalendra($date)
    {
        $subsrd = $this->db_syailendra->query("
            select 
                *
            from (
                SELECT
                    CONVERT ( DATE, '".$date."', 102 ) as 'subsrd_date',
                    db_name() + '_' + '".date('Ymd',strtotime($date))."' +'_'+ a.HIPORT_CODE+'_'+ a.debitacc+'_'+a.SELLING_AGENT_CODE AS 'subsrd_id',
                    a.HIPORT_CODE as 'client_code',
                    SUM ( a.net_proceed ) AS 'subsrd_nominal',
                    a.debitacc as 'acc_no',
                    a.FUND_ID ,
                    a.BANK_NAME ,
                    a.saname ,
                    a.SELLING_AGENT_CODE,
                    'Redemption NIAGA - ' + a.saname AS deskripsi
                FROM
                    (
                    SELECT
                        fd.HIPORT_CODE ,
                        dbo.TXN_POSTING.INVESTOR_NO,
                        dbo.TXN_POSTING.TXN_TYPE,
                        dbo.TXN_POSTING.NET_PROCEED,
                        dbo.TXN.PAYMENT_DATE,
                        dbo.FUND_ID.ACC_BANK_OPR AS 'debitacc',
                        fund_id.DESCRIPTION AS 'bank_name',
                        dbo.TXN.BANK_ID_ADDRESS,
                        dbo.TXN.BANK_ACCT_NO,
                        dbo.TXN_POSTING.GOOD_FUND_DATE,
                        dbo.TXN.FUND_ID,
                        dbo.TXN.BANK_LETTER_CITY,
                        sa.NAME AS 'saname',
                        sa.SELLING_AGENT_CODE
                    FROM
                        dbo.TXN
                        INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                        INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID
                        LEFT JOIN SELLING_AGENT sa ON sa.SELLING_AGENT_CODE = txn.SELLING_AGENT_CODE
                        INNER JOIN NFS_DB.dbo.FUND_DETAILS fd ON fd.URS_CODE = FUND_ID.FUND_ID 
                        INNER JOIN dbo.FUND_SUMMARY ON dbo.FUND_SUMMARY.FUND_ID = dbo.TXN.FUND_ID AND dbo.FUND_SUMMARY.TRADE_DATE = dbo.TXN.PAYMENT_DATE 
                    WHERE ( CONVERT ( DATE, dbo.TXN.PAYMENT_DATE ) = '".$date."' ) 
                        AND ( dbo.TXN_POSTING.TXN_TYPE = 'R' ) 
                        AND ( isnull( dbo.TXN.BANK_LETTER_CITY , '' ) = '' ) 
                    ) a 
                GROUP BY
                    a.HIPORT_CODE ,
                    a.debitacc  ,
                    a.FUND_ID ,
                    a.BANK_NAME ,
                    a.saname ,
                    a.SELLING_AGENT_CODE 
                
                UNION ALL
            
                SELECT
                    CONVERT ( DATE, '".$date."', 102 ) as 'subsrd_date',
                    db_name() + '_' + '".date('Ymd',strtotime($date))."' +'_'+ a.HIPORT_CODE+'_'+ a.debitacc+'_'+a.SELLING_AGENT_CODE AS 'subsrd_id',
                    a.HIPORT_CODE as 'client_code',
                    SUM ( a.net_proceed ) AS 'subsrd_nominal',
                    a.debitacc as 'acc_no',
                    a.FUND_ID ,
                    a.BANK_NAME ,
                    a.saname ,
                    a.SELLING_AGENT_CODE,
                    'Redemption Non Niaga- ' + a.saname AS deskripsi
                FROM
                    (
                    SELECT
                        CONVERT ( DATE, dbo.TXN.PAYMENT_DATE ) as dt,
                        fd.HIPORT_CODE,
                        dbo.TXN_POSTING.INVESTOR_NO,
                        dbo.TXN_POSTING.TXN_TYPE,
                        dbo.TXN_POSTING.NET_PROCEED,
                        dbo.TXN.PAYMENT_DATE,
                        dbo.FUND_ID.ACC_BANK_OPR ,
                        dbo.TXN.BANK_ID_ADDRESS,
                        dbo.TXN.BANK_ACCT_NO,
                        dbo.FUND_ID_BANK.DESCRIPTION AS 'Bank_name',
                        dbo.FUND_ID_BANK.ACC_NO AS 'debitacc',
                        dbo.TXN_POSTING.GOOD_FUND_DATE,
                        dbo.TXN.FUND_ID,
                        dbo.TXN.BANK_LETTER_CITY,
                        sa.NAME AS 'saname',
                        sa.SELLING_AGENT_CODE
                    FROM
                        dbo.TXN
                        INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                        INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID
                        INNER JOIN dbo.FUND_ID_BANK ON dbo.TXN.BANK_LETTER_CITY = dbo.FUND_ID_BANK.BANK_CODE
                        LEFT JOIN SELLING_AGENT sa ON sa.SELLING_AGENT_CODE = txn.SELLING_AGENT_CODE
                        INNER JOIN NFS_DB.dbo.FUND_DETAILS fd ON fd.URS_CODE = FUND_ID.FUND_ID 
                        INNER JOIN dbo.FUND_SUMMARY ON dbo.FUND_SUMMARY.FUND_ID = dbo.TXN.FUND_ID AND dbo.FUND_SUMMARY.TRADE_DATE = dbo.TXN.PAYMENT_DATE
                    WHERE ( CONVERT ( DATE, dbo.TXN.PAYMENT_DATE ) = '".$date."' ) 
                        AND ( dbo.TXN_POSTING.TXN_TYPE = 'R' ) 
                    ) a 
                GROUP BY
                    a.HIPORT_CODE ,
                    a.debitacc  ,
                    a.FUND_ID ,
                    a.BANK_NAME ,
                    a.saname ,
                    a.SELLING_AGENT_CODE
            ) as r
        ");
        
        $sql = '';
        $msg = '';
        if( count($subsrd->result_array()) > 0 ){
            foreach ($subsrd->result_array() as $key => $value) {
                $status_mutasi = $this->status_mutasi($value['client_code'], $value['acc_no'], $value['subsrd_date']->format('Y-m-d'));

				if($status_mutasi == 0){
                $msg = $msg.' '.$value['subsrd_id'];
                $sql = $sql. "
                IF NOT EXISTS (SELECT*FROM mutasi_trx WHERE subsrd_id='".$value['subsrd_id']."')
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
                    ) VALUES ( 
                        '".$value['client_code']."',
                        '".$value['acc_no']."', 
                        '".$value['subsrd_date']->format('Y-m-d H:i:s')."',
                        'D001', 
                        'Bayar Redemption', 
                        '".$value['deskripsi']."',
                        'D', 
                        '".$value['subsrd_nominal']."',
                        'system', 
                        '".date('Y-m-d H:i:s')."', 
                        'system', 
                        '".date('Y-m-d H:i:s')."', 
                        1, 
                        '".$value['subsrd_id']."'
                    );
                END;";
                }else{
                    $msg = $msg.' <br> '.$value['client_code'].' - '.$value['acc_no'].' - '.$value['subsrd_date']->format('Y-m-d').' - STATUS BUKAN OPEN';
                }
            }
            return array('sql'=> $sql, 'msg' => $msg);
        }
        return false;
    }

    function RedemptionToMutasiBackgroundTrimegah($date)
    {
        $subsrd = $this->db_trimegah->query("
            select 
                *
            from (
                SELECT
                    CONVERT ( DATE, '".$date."', 102 ) as 'subsrd_date',
                    db_name() + '_' + '".date('Ymd',strtotime($date))."' +'_'+ a.HIPORT_CODE+'_'+ a.debitacc+'_'+a.SELLING_AGENT_CODE AS 'subsrd_id',
                    a.HIPORT_CODE as 'client_code',
                    SUM ( a.net_proceed ) AS 'subsrd_nominal',
                    a.debitacc as 'acc_no',
                    a.FUND_ID ,
                    a.BANK_NAME ,
                    a.saname ,
                    a.SELLING_AGENT_CODE,
                    'Redemption NIAGA - ' + a.saname AS deskripsi
                FROM
                    (
                    SELECT
                        fd.HIPORT_CODE ,
                        dbo.TXN_POSTING.INVESTOR_NO,
                        dbo.TXN_POSTING.TXN_TYPE,
                        dbo.TXN_POSTING.NET_PROCEED,
                        dbo.TXN.PAYMENT_DATE,
                        dbo.FUND_ID.ACC_BANK_OPR AS 'debitacc',
                        fund_id.DESCRIPTION AS 'bank_name',
                        dbo.TXN.BANK_ID_ADDRESS,
                        dbo.TXN.BANK_ACCT_NO,
                        dbo.TXN_POSTING.GOOD_FUND_DATE,
                        dbo.TXN.FUND_ID,
                        dbo.TXN.BANK_LETTER_CITY,
                        sa.NAME AS 'saname',
                        sa.SELLING_AGENT_CODE
                    FROM
                        dbo.TXN
                        INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                        INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID
                        LEFT JOIN SELLING_AGENT sa ON sa.SELLING_AGENT_CODE = txn.SELLING_AGENT_CODE
                        INNER JOIN NFS_DB.dbo.FUND_DETAILS fd ON fd.URS_CODE = FUND_ID.FUND_ID 
                        INNER JOIN dbo.FUND_SUMMARY ON dbo.FUND_SUMMARY.FUND_ID = dbo.TXN.FUND_ID AND dbo.FUND_SUMMARY.TRADE_DATE = dbo.TXN.PAYMENT_DATE 
                    WHERE ( CONVERT ( DATE, dbo.TXN.PAYMENT_DATE ) = '".$date."' ) 
                        AND ( dbo.TXN_POSTING.TXN_TYPE = 'R' ) 
                        AND ( isnull( dbo.TXN.BANK_LETTER_CITY , '' ) = '' ) 
                    ) a 
                GROUP BY
                    a.HIPORT_CODE ,
                    a.debitacc  ,
                    a.FUND_ID ,
                    a.BANK_NAME ,
                    a.saname ,
                    a.SELLING_AGENT_CODE 
                
                UNION ALL
            
                SELECT
                    CONVERT ( DATE, '".$date."', 102 ) as 'subsrd_date',
                    db_name() + '_' + '".date('Ymd',strtotime($date))."' +'_'+ a.HIPORT_CODE+'_'+ a.debitacc+'_'+a.SELLING_AGENT_CODE AS 'subsrd_id',
                    a.HIPORT_CODE as 'client_code',
                    SUM ( a.net_proceed ) AS 'subsrd_nominal',
                    a.debitacc as 'acc_no',
                    a.FUND_ID ,
                    a.BANK_NAME ,
                    a.saname ,
                    a.SELLING_AGENT_CODE,
                    'Redemption Non Niaga- ' + a.saname AS deskripsi
                FROM
                    (
                    SELECT
                        CONVERT ( DATE, dbo.TXN.PAYMENT_DATE ) as dt,
                        fd.HIPORT_CODE,
                        dbo.TXN_POSTING.INVESTOR_NO,
                        dbo.TXN_POSTING.TXN_TYPE,
                        dbo.TXN_POSTING.NET_PROCEED,
                        dbo.TXN.PAYMENT_DATE,
                        dbo.FUND_ID.ACC_BANK_OPR ,
                        dbo.TXN.BANK_ID_ADDRESS,
                        dbo.TXN.BANK_ACCT_NO,
                        dbo.FUND_ID_BANK.DESCRIPTION AS 'Bank_name',
                        dbo.FUND_ID_BANK.ACC_NO AS 'debitacc',
                        dbo.TXN_POSTING.GOOD_FUND_DATE,
                        dbo.TXN.FUND_ID,
                        dbo.TXN.BANK_LETTER_CITY,
                        sa.NAME AS 'saname',
                        sa.SELLING_AGENT_CODE
                    FROM
                        dbo.TXN
                        INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                        INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID
                        INNER JOIN dbo.FUND_ID_BANK ON dbo.TXN.BANK_LETTER_CITY = dbo.FUND_ID_BANK.BANK_CODE
                        LEFT JOIN SELLING_AGENT sa ON sa.SELLING_AGENT_CODE = txn.SELLING_AGENT_CODE
                        INNER JOIN NFS_DB.dbo.FUND_DETAILS fd ON fd.URS_CODE = FUND_ID.FUND_ID 
                        INNER JOIN dbo.FUND_SUMMARY ON dbo.FUND_SUMMARY.FUND_ID = dbo.TXN.FUND_ID AND dbo.FUND_SUMMARY.TRADE_DATE = dbo.TXN.PAYMENT_DATE
                    WHERE ( CONVERT ( DATE, dbo.TXN.PAYMENT_DATE ) = '".$date."' ) 
                        AND ( dbo.TXN_POSTING.TXN_TYPE = 'R' ) 
                    ) a 
                GROUP BY
                    a.HIPORT_CODE ,
                    a.debitacc  ,
                    a.FUND_ID ,
                    a.BANK_NAME ,
                    a.saname ,
                    a.SELLING_AGENT_CODE
            ) as r
        ");
        
        $sql = '';
        $msg = '';
        if( count($subsrd->result_array()) > 0 ){
            foreach ($subsrd->result_array() as $key => $value) {
                $status_mutasi = $this->status_mutasi($value['client_code'], $value['acc_no'], $value['subsrd_date']->format('Y-m-d'));

				if($status_mutasi == 0){
                $msg = $msg.' '.$value['subsrd_id'];
                $sql = $sql. "
                IF NOT EXISTS (SELECT*FROM mutasi_trx WHERE subsrd_id='".$value['subsrd_id']."')
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
                    ) VALUES ( 
                        '".$value['client_code']."',
                        '".$value['acc_no']."', 
                        '".$value['subsrd_date']->format('Y-m-d H:i:s')."',
                        'D001', 
                        'Bayar Redemption', 
                        '".$value['deskripsi']."',
                        'D', 
                        '".$value['subsrd_nominal']."',
                        'system', 
                        '".date('Y-m-d H:i:s')."', 
                        'system', 
                        '".date('Y-m-d H:i:s')."', 
                        1, 
                        '".$value['subsrd_id']."'
                    );
                END;";
                }else{
                    $msg = $msg.' <br> '.$value['client_code'].' - '.$value['acc_no'].' - '.$value['subsrd_date']->format('Y-m-d').' - STATUS BUKAN OPEN';
                }
            }
            return array('sql'=> $sql, 'msg' => $msg);
        }
        return false;
    }

    function RedemptionToMutasiBackgroundCustody($date)
    {
        $subsrd = $this->db_custody->query("
            select 
                *
            from (
                SELECT
                    CONVERT ( DATE, '".$date."', 102 ) as 'subsrd_date',
                    db_name() + '_' + '".date('Ymd',strtotime($date))."' +'_'+ a.HIPORT_CODE+'_'+ a.debitacc+'_'+a.SELLING_AGENT_CODE AS 'subsrd_id',
                    a.HIPORT_CODE as 'client_code',
                    SUM ( a.net_proceed ) AS 'subsrd_nominal',
                    a.debitacc as 'acc_no',
                    a.FUND_ID ,
                    a.BANK_NAME ,
                    a.saname ,
                    a.SELLING_AGENT_CODE,
                    'Redemption NIAGA - ' + a.saname AS deskripsi
                FROM
                    (
                    SELECT
                        fd.HIPORT_CODE ,
                        dbo.TXN_POSTING.INVESTOR_NO,
                        dbo.TXN_POSTING.TXN_TYPE,
                        dbo.TXN_POSTING.NET_PROCEED,
                        dbo.TXN.PAYMENT_DATE,
                        dbo.FUND_ID.ACC_BANK_OPR AS 'debitacc',
                        fund_id.DESCRIPTION AS 'bank_name',
                        dbo.TXN.BANK_ID_ADDRESS,
                        dbo.TXN.BANK_ACCT_NO,
                        dbo.TXN_POSTING.GOOD_FUND_DATE,
                        dbo.TXN.FUND_ID,
                        dbo.TXN.BANK_LETTER_CITY,
                        sa.NAME AS 'saname',
                        sa.SELLING_AGENT_CODE
                    FROM
                        dbo.TXN
                        INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                        INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID
                        LEFT JOIN SELLING_AGENT sa ON sa.SELLING_AGENT_CODE = txn.SELLING_AGENT_CODE
                        INNER JOIN NFS_DB.dbo.FUND_DETAILS fd ON fd.URS_CODE = FUND_ID.FUND_ID 
                        INNER JOIN dbo.FUND_SUMMARY ON dbo.FUND_SUMMARY.FUND_ID = dbo.TXN.FUND_ID AND dbo.FUND_SUMMARY.TRADE_DATE = dbo.TXN.PAYMENT_DATE 
                    WHERE ( CONVERT ( DATE, dbo.TXN.PAYMENT_DATE ) = '".$date."' ) 
                        AND ( dbo.TXN_POSTING.TXN_TYPE = 'R' ) 
                        AND ( isnull( dbo.TXN.BANK_LETTER_CITY , '' ) = '' ) 
                    ) a 
                GROUP BY
                    a.HIPORT_CODE ,
                    a.debitacc  ,
                    a.FUND_ID ,
                    a.BANK_NAME ,
                    a.saname ,
                    a.SELLING_AGENT_CODE 
                
                UNION ALL
            
                SELECT
                    CONVERT ( DATE, '".$date."', 102 ) as 'subsrd_date',
                    db_name() + '_' + '".date('Ymd',strtotime($date))."' +'_'+ a.HIPORT_CODE+'_'+ a.debitacc+'_'+a.SELLING_AGENT_CODE AS 'subsrd_id',
                    a.HIPORT_CODE as 'client_code',
                    SUM ( a.net_proceed ) AS 'subsrd_nominal',
                    a.debitacc as 'acc_no',
                    a.FUND_ID ,
                    a.BANK_NAME ,
                    a.saname ,
                    a.SELLING_AGENT_CODE,
                    'Redemption Non Niaga- ' + a.saname AS deskripsi
                FROM
                    (
                    SELECT
                        CONVERT ( DATE, dbo.TXN.PAYMENT_DATE ) as dt,
                        fd.HIPORT_CODE,
                        dbo.TXN_POSTING.INVESTOR_NO,
                        dbo.TXN_POSTING.TXN_TYPE,
                        dbo.TXN_POSTING.NET_PROCEED,
                        dbo.TXN.PAYMENT_DATE,
                        dbo.FUND_ID.ACC_BANK_OPR ,
                        dbo.TXN.BANK_ID_ADDRESS,
                        dbo.TXN.BANK_ACCT_NO,
                        dbo.FUND_ID_BANK.DESCRIPTION AS 'Bank_name',
                        dbo.FUND_ID_BANK.ACC_NO AS 'debitacc',
                        dbo.TXN_POSTING.GOOD_FUND_DATE,
                        dbo.TXN.FUND_ID,
                        dbo.TXN.BANK_LETTER_CITY,
                        sa.NAME AS 'saname',
                        sa.SELLING_AGENT_CODE
                    FROM
                        dbo.TXN
                        INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                        INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID
                        INNER JOIN dbo.FUND_ID_BANK ON dbo.TXN.BANK_LETTER_CITY = dbo.FUND_ID_BANK.BANK_CODE
                        LEFT JOIN SELLING_AGENT sa ON sa.SELLING_AGENT_CODE = txn.SELLING_AGENT_CODE
                        INNER JOIN NFS_DB.dbo.FUND_DETAILS fd ON fd.URS_CODE = FUND_ID.FUND_ID 
                        INNER JOIN dbo.FUND_SUMMARY ON dbo.FUND_SUMMARY.FUND_ID = dbo.TXN.FUND_ID AND dbo.FUND_SUMMARY.TRADE_DATE = dbo.TXN.PAYMENT_DATE
                    WHERE ( CONVERT ( DATE, dbo.TXN.PAYMENT_DATE ) = '".$date."' ) 
                        AND ( dbo.TXN_POSTING.TXN_TYPE = 'R' ) 
                    ) a 
                GROUP BY
                    a.HIPORT_CODE ,
                    a.debitacc  ,
                    a.FUND_ID ,
                    a.BANK_NAME ,
                    a.saname ,
                    a.SELLING_AGENT_CODE
            ) as r
        ");
        
        $sql = '';
        $msg = '';
        if( count($subsrd->result_array()) > 0 ){
            foreach ($subsrd->result_array() as $key => $value) {
                $status_mutasi = $this->status_mutasi($value['client_code'], $value['acc_no'], $value['subsrd_date']->format('Y-m-d'));

				if($status_mutasi == 0){
                $msg = $msg.' '.$value['subsrd_id'];
                $sql = $sql. "
                IF NOT EXISTS (SELECT*FROM mutasi_trx WHERE subsrd_id='".$value['subsrd_id']."')
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
                    ) VALUES ( 
                        '".$value['client_code']."',
                        '".$value['acc_no']."', 
                        '".$value['subsrd_date']->format('Y-m-d H:i:s')."',
                        'D001', 
                        'Bayar Redemption', 
                        '".$value['deskripsi']."',
                        'D', 
                        '".$value['subsrd_nominal']."',
                        'system', 
                        '".date('Y-m-d H:i:s')."', 
                        'system', 
                        '".date('Y-m-d H:i:s')."', 
                        1, 
                        '".$value['subsrd_id']."'
                    );
                END;";
                }else{
                    $msg = $msg.' <br> '.$value['client_code'].' - '.$value['acc_no'].' - '.$value['subsrd_date']->format('Y-m-d').' - STATUS BUKAN OPEN';
                }
            }
            return array('sql'=> $sql, 'msg' => $msg);
        }
        return false;
    }

    function RedemptionToMutasiBackgroundDiscre($date)
    {
        $subsrd = $this->db_discre->query("
            select 
                *
            from (
                SELECT
                    CONVERT ( DATE, '".$date."', 102 ) as 'subsrd_date',
                    db_name() + '_' + '".date('Ymd',strtotime($date))."' +'_'+ a.HIPORT_CODE+'_'+ a.debitacc+'_'+a.SELLING_AGENT_CODE AS 'subsrd_id',
                    a.HIPORT_CODE as 'client_code',
                    SUM ( a.net_proceed ) AS 'subsrd_nominal',
                    a.debitacc as 'acc_no',
                    a.FUND_ID ,
                    a.BANK_NAME ,
                    a.saname ,
                    a.SELLING_AGENT_CODE,
                    'Redemption NIAGA - ' + a.saname AS deskripsi
                FROM
                    (
                    SELECT
                        fd.HIPORT_CODE ,
                        dbo.TXN_POSTING.INVESTOR_NO,
                        dbo.TXN_POSTING.TXN_TYPE,
                        dbo.TXN_POSTING.NET_PROCEED,
                        dbo.TXN.PAYMENT_DATE,
                        dbo.FUND_ID.ACC_BANK_OPR AS 'debitacc',
                        fund_id.DESCRIPTION AS 'bank_name',
                        dbo.TXN.BANK_ID_ADDRESS,
                        dbo.TXN.BANK_ACCT_NO,
                        dbo.TXN_POSTING.GOOD_FUND_DATE,
                        dbo.TXN.FUND_ID,
                        dbo.TXN.BANK_LETTER_CITY,
                        sa.NAME AS 'saname',
                        sa.SELLING_AGENT_CODE
                    FROM
                        dbo.TXN
                        INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                        INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID
                        LEFT JOIN SELLING_AGENT sa ON sa.SELLING_AGENT_CODE = txn.SELLING_AGENT_CODE
                        INNER JOIN NFS_DB.dbo.FUND_DETAILS fd ON fd.URS_CODE = FUND_ID.FUND_ID 
                        INNER JOIN dbo.FUND_SUMMARY ON dbo.FUND_SUMMARY.FUND_ID = dbo.TXN.FUND_ID AND dbo.FUND_SUMMARY.TRADE_DATE = dbo.TXN.PAYMENT_DATE 
                    WHERE ( CONVERT ( DATE, dbo.TXN.PAYMENT_DATE ) = '".$date."' ) 
                        AND ( dbo.TXN_POSTING.TXN_TYPE = 'R' ) 
                        AND ( isnull( dbo.TXN.BANK_LETTER_CITY , '' ) = '' ) 
                    ) a 
                GROUP BY
                    a.HIPORT_CODE ,
                    a.debitacc  ,
                    a.FUND_ID ,
                    a.BANK_NAME ,
                    a.saname ,
                    a.SELLING_AGENT_CODE 
                
                UNION ALL
            
                SELECT
                    CONVERT ( DATE, '".$date."', 102 ) as 'subsrd_date',
                    db_name() + '_' + '".date('Ymd',strtotime($date))."' +'_'+ a.HIPORT_CODE+'_'+ a.debitacc+'_'+a.SELLING_AGENT_CODE AS 'subsrd_id',
                    a.HIPORT_CODE as 'client_code',
                    SUM ( a.net_proceed ) AS 'subsrd_nominal',
                    a.debitacc as 'acc_no',
                    a.FUND_ID ,
                    a.BANK_NAME ,
                    a.saname ,
                    a.SELLING_AGENT_CODE,
                    'Redemption Non Niaga- ' + a.saname AS deskripsi
                FROM
                    (
                    SELECT
                        CONVERT ( DATE, dbo.TXN.PAYMENT_DATE ) as dt,
                        fd.HIPORT_CODE,
                        dbo.TXN_POSTING.INVESTOR_NO,
                        dbo.TXN_POSTING.TXN_TYPE,
                        dbo.TXN_POSTING.NET_PROCEED,
                        dbo.TXN.PAYMENT_DATE,
                        dbo.FUND_ID.ACC_BANK_OPR ,
                        dbo.TXN.BANK_ID_ADDRESS,
                        dbo.TXN.BANK_ACCT_NO,
                        dbo.FUND_ID_BANK.DESCRIPTION AS 'Bank_name',
                        dbo.FUND_ID_BANK.ACC_NO AS 'debitacc',
                        dbo.TXN_POSTING.GOOD_FUND_DATE,
                        dbo.TXN.FUND_ID,
                        dbo.TXN.BANK_LETTER_CITY,
                        sa.NAME AS 'saname',
                        sa.SELLING_AGENT_CODE
                    FROM
                        dbo.TXN
                        INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                        INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID
                        INNER JOIN dbo.FUND_ID_BANK ON dbo.TXN.BANK_LETTER_CITY = dbo.FUND_ID_BANK.BANK_CODE
                        LEFT JOIN SELLING_AGENT sa ON sa.SELLING_AGENT_CODE = txn.SELLING_AGENT_CODE
                        INNER JOIN NFS_DB.dbo.FUND_DETAILS fd ON fd.URS_CODE = FUND_ID.FUND_ID 
                        INNER JOIN dbo.FUND_SUMMARY ON dbo.FUND_SUMMARY.FUND_ID = dbo.TXN.FUND_ID AND dbo.FUND_SUMMARY.TRADE_DATE = dbo.TXN.PAYMENT_DATE
                    WHERE ( CONVERT ( DATE, dbo.TXN.PAYMENT_DATE ) = '".$date."' ) 
                        AND ( dbo.TXN_POSTING.TXN_TYPE = 'R' ) 
                    ) a 
                GROUP BY
                    a.HIPORT_CODE ,
                    a.debitacc  ,
                    a.FUND_ID ,
                    a.BANK_NAME ,
                    a.saname ,
                    a.SELLING_AGENT_CODE
            ) as r
        ");
        
        $sql = '';
        $msg = '';
        if( count($subsrd->result_array()) > 0 ){
            foreach ($subsrd->result_array() as $key => $value) {
                $status_mutasi = $this->status_mutasi($value['client_code'], $value['acc_no'], $value['subsrd_date']->format('Y-m-d'));

				if($status_mutasi == 0){
                $msg = $msg.' '.$value['subsrd_id'];
                $sql = $sql. "
                IF NOT EXISTS (SELECT*FROM mutasi_trx WHERE subsrd_id='".$value['subsrd_id']."')
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
                    ) VALUES ( 
                        '".$value['client_code']."',
                        '".$value['acc_no']."', 
                        '".$value['subsrd_date']->format('Y-m-d H:i:s')."',
                        'D001', 
                        'Bayar Redemption', 
                        '".$value['deskripsi']."',
                        'D', 
                        '".$value['subsrd_nominal']."',
                        'system', 
                        '".date('Y-m-d H:i:s')."', 
                        'system', 
                        '".date('Y-m-d H:i:s')."', 
                        1, 
                        '".$value['subsrd_id']."'
                    );
                END;";
                }else{
                    $msg = $msg.' <br> '.$value['client_code'].' - '.$value['acc_no'].' - '.$value['subsrd_date']->format('Y-m-d').' - STATUS BUKAN OPEN';
                }
            }
            return array('sql'=> $sql, 'msg' => $msg);
        }
        return false;
    }

    function RedemptionToMutasiBackgroundMega($date)
    {
        $subsrd = $this->db_mega->query("
            select 
                *
            from (
                SELECT
                    CONVERT ( DATE, '".$date."', 102 ) as 'subsrd_date',
                    db_name() + '_' + '".date('Ymd',strtotime($date))."' +'_'+ a.HIPORT_CODE+'_'+ a.debitacc+'_'+a.SELLING_AGENT_CODE AS 'subsrd_id',
                    a.HIPORT_CODE as 'client_code',
                    SUM ( a.net_proceed ) AS 'subsrd_nominal',
                    a.debitacc as 'acc_no',
                    a.FUND_ID ,
                    a.BANK_NAME ,
                    a.saname ,
                    a.SELLING_AGENT_CODE,
                    'Redemption NIAGA - ' + a.saname AS deskripsi
                FROM
                    (
                    SELECT
                        fd.HIPORT_CODE ,
                        dbo.TXN_POSTING.INVESTOR_NO,
                        dbo.TXN_POSTING.TXN_TYPE,
                        dbo.TXN_POSTING.NET_PROCEED,
                        dbo.TXN.PAYMENT_DATE,
                        dbo.FUND_ID.ACC_BANK_OPR AS 'debitacc',
                        fund_id.DESCRIPTION AS 'bank_name',
                        dbo.TXN.BANK_ID_ADDRESS,
                        dbo.TXN.BANK_ACCT_NO,
                        dbo.TXN_POSTING.GOOD_FUND_DATE,
                        dbo.TXN.FUND_ID,
                        dbo.TXN.BANK_LETTER_CITY,
                        sa.NAME AS 'saname',
                        sa.SELLING_AGENT_CODE
                    FROM
                        dbo.TXN
                        INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                        INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID
                        LEFT JOIN SELLING_AGENT sa ON sa.SELLING_AGENT_CODE = txn.SELLING_AGENT_CODE
                        INNER JOIN NFS_DB.dbo.FUND_DETAILS fd ON fd.URS_CODE = FUND_ID.FUND_ID 
                        INNER JOIN dbo.FUND_SUMMARY ON dbo.FUND_SUMMARY.FUND_ID = dbo.TXN.FUND_ID AND dbo.FUND_SUMMARY.TRADE_DATE = dbo.TXN.PAYMENT_DATE 
                    WHERE ( CONVERT ( DATE, dbo.TXN.PAYMENT_DATE ) = '".$date."' ) 
                        AND ( dbo.TXN_POSTING.TXN_TYPE = 'R' ) 
                        AND ( isnull( dbo.TXN.BANK_LETTER_CITY , '' ) = '' ) 
                    ) a 
                GROUP BY
                    a.HIPORT_CODE ,
                    a.debitacc  ,
                    a.FUND_ID ,
                    a.BANK_NAME ,
                    a.saname ,
                    a.SELLING_AGENT_CODE 
                
                UNION ALL
            
                SELECT
                    CONVERT ( DATE, '".$date."', 102 ) as 'subsrd_date',
                    db_name() + '_' + '".date('Ymd',strtotime($date))."' +'_'+ a.HIPORT_CODE+'_'+ a.debitacc+'_'+a.SELLING_AGENT_CODE AS 'subsrd_id',
                    a.HIPORT_CODE as 'client_code',
                    SUM ( a.net_proceed ) AS 'subsrd_nominal',
                    a.debitacc as 'acc_no',
                    a.FUND_ID ,
                    a.BANK_NAME ,
                    a.saname ,
                    a.SELLING_AGENT_CODE,
                    'Redemption Non Niaga- ' + a.saname AS deskripsi
                FROM
                    (
                    SELECT
                        CONVERT ( DATE, dbo.TXN.PAYMENT_DATE ) as dt,
                        fd.HIPORT_CODE,
                        dbo.TXN_POSTING.INVESTOR_NO,
                        dbo.TXN_POSTING.TXN_TYPE,
                        dbo.TXN_POSTING.NET_PROCEED,
                        dbo.TXN.PAYMENT_DATE,
                        dbo.FUND_ID.ACC_BANK_OPR ,
                        dbo.TXN.BANK_ID_ADDRESS,
                        dbo.TXN.BANK_ACCT_NO,
                        dbo.FUND_ID_BANK.DESCRIPTION AS 'Bank_name',
                        dbo.FUND_ID_BANK.ACC_NO AS 'debitacc',
                        dbo.TXN_POSTING.GOOD_FUND_DATE,
                        dbo.TXN.FUND_ID,
                        dbo.TXN.BANK_LETTER_CITY,
                        sa.NAME AS 'saname',
                        sa.SELLING_AGENT_CODE
                    FROM
                        dbo.TXN
                        INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                        INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID
                        INNER JOIN dbo.FUND_ID_BANK ON dbo.TXN.BANK_LETTER_CITY = dbo.FUND_ID_BANK.BANK_CODE
                        LEFT JOIN SELLING_AGENT sa ON sa.SELLING_AGENT_CODE = txn.SELLING_AGENT_CODE
                        INNER JOIN NFS_DB.dbo.FUND_DETAILS fd ON fd.URS_CODE = FUND_ID.FUND_ID 
                        INNER JOIN dbo.FUND_SUMMARY ON dbo.FUND_SUMMARY.FUND_ID = dbo.TXN.FUND_ID AND dbo.FUND_SUMMARY.TRADE_DATE = dbo.TXN.PAYMENT_DATE
                    WHERE ( CONVERT ( DATE, dbo.TXN.PAYMENT_DATE ) = '".$date."' ) 
                        AND ( dbo.TXN_POSTING.TXN_TYPE = 'R' ) 
                    ) a 
                GROUP BY
                    a.HIPORT_CODE ,
                    a.debitacc  ,
                    a.FUND_ID ,
                    a.BANK_NAME ,
                    a.saname ,
                    a.SELLING_AGENT_CODE
            ) as r
        ");
        
        $sql = '';
        $msg = '';
        if( count($subsrd->result_array()) > 0 ){
            foreach ($subsrd->result_array() as $key => $value) {
                $status_mutasi = $this->status_mutasi($value['client_code'], $value['acc_no'], $value['subsrd_date']->format('Y-m-d'));

				if($status_mutasi == 0){
                $msg = $msg.' '.$value['subsrd_id'];
                $sql = $sql. "
                IF NOT EXISTS (SELECT*FROM mutasi_trx WHERE subsrd_id='".$value['subsrd_id']."')
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
                    ) VALUES ( 
                        '".$value['client_code']."',
                        '".$value['acc_no']."', 
                        '".$value['subsrd_date']->format('Y-m-d H:i:s')."',
                        'D001', 
                        'Bayar Redemption', 
                        '".$value['deskripsi']."',
                        'D', 
                        '".$value['subsrd_nominal']."',
                        'system', 
                        '".date('Y-m-d H:i:s')."', 
                        'system', 
                        '".date('Y-m-d H:i:s')."', 
                        1, 
                        '".$value['subsrd_id']."'
                    );
                END;";
                }else{
                    $msg = $msg.' <br> '.$value['client_code'].' - '.$value['acc_no'].' - '.$value['subsrd_date']->format('Y-m-d').' - STATUS BUKAN OPEN';
                }
            }
            return array('sql'=> $sql, 'msg' => $msg);
        }
        return false;
    }

//=================================== background job end
    
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
        SELECT * FROM (
            SELECT
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID.ACC_BANK_OPR AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM(dbo.TXN_POSTING.NET_PROCEED) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption NIAGA' AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID 
            WHERE 
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                (dbo.TXN.BANK_LETTER_CITY = '' OR dbo.TXN.BANK_LETTER_CITY is null ) AND 
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.FUND_ID.ACC_BANK_OPR,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ), 
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.BANK_LETTER_CITY
            HAVING 
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID.ACC_BANK_OPR = '".$acc_no."'

            UNION
            
            SELECT
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID_BANK.ACC_NO AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM ( dbo.TXN_POSTING.NET_PROCEED ) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption Non NIAGA'AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID_BANK ON dbo.TXN.BANK_LETTER_CITY = dbo.FUND_ID_BANK.BANK_CODE
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID 
            WHERE
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.PAYMENT_DATE,
                dbo.FUND_ID_BANK.BANK_NAME,
                dbo.FUND_ID_BANK.DESCRIPTION,
                dbo.FUND_ID_BANK.ACC_NO,
                dbo.TXN.BANK_LETTER_CITY,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 )
            HAVING 
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID_BANK.ACC_NO = '".$acc_no."'

        ) AS TABELS 
        ORDER BY subsrd_date DESC
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

//=========================================================================================//

    function ListRedemptionBatavia($client_code,$acc_no)
    {
        $return = array();
        $query=$this->db_batavia->query("
        SELECT * FROM (
            SELECT
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID.ACC_BANK_OPR AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM(dbo.TXN_POSTING.NET_PROCEED) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption NIAGA' AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID 
            WHERE 
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                (dbo.TXN.BANK_LETTER_CITY = '' OR dbo.TXN.BANK_LETTER_CITY is null ) AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.FUND_ID.ACC_BANK_OPR,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ), 
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.BANK_LETTER_CITY
                
            HAVING 
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID.ACC_BANK_OPR = '".$acc_no."'

            UNION
            
            SELECT
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID_BANK.ACC_NO AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM ( dbo.TXN_POSTING.NET_PROCEED ) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption Non NIAGA' AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID_BANK ON dbo.TXN.BANK_LETTER_CITY = dbo.FUND_ID_BANK.BANK_CODE
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID
            WHERE
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.PAYMENT_DATE,
                dbo.FUND_ID_BANK.BANK_NAME,
                dbo.FUND_ID_BANK.DESCRIPTION,
                dbo.FUND_ID_BANK.ACC_NO,
                dbo.TXN.BANK_LETTER_CITY,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 )
            HAVING 
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID_BANK.ACC_NO = '".$acc_no."'

        ) AS TABELS 
        ORDER BY subsrd_date DESC
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


    function ListRedemptionBni($client_code,$acc_no)
    {
        $return = array();
        $query=$this->db_bni->query("
        SELECT * FROM (
            SELECT
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID.ACC_BANK_OPR AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM(dbo.TXN_POSTING.NET_PROCEED) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption NIAGA' AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID
            WHERE 
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                (dbo.TXN.BANK_LETTER_CITY = '' OR dbo.TXN.BANK_LETTER_CITY is null ) AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.FUND_ID.ACC_BANK_OPR,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ), 
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.BANK_LETTER_CITY
            HAVING 
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID.ACC_BANK_OPR = '".$acc_no."'

            UNION
            
            SELECT
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID_BANK.ACC_NO AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM ( dbo.TXN_POSTING.NET_PROCEED ) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption Non NIAGA' AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID_BANK ON dbo.TXN.BANK_LETTER_CITY = dbo.FUND_ID_BANK.BANK_CODE
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID 
                INNER JOIN dbo.FUND_SUMMARY ON dbo.TXN.FUND_ID = dbo.FUND_SUMMARY.FUND_ID 
				AND dbo.FUND_SUMMARY.TRADE_DATE = dbo.TXN.PAYMENT_DATE
            WHERE
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.PAYMENT_DATE,
                dbo.FUND_ID_BANK.BANK_NAME,
                dbo.FUND_ID_BANK.DESCRIPTION,
                dbo.FUND_ID_BANK.ACC_NO,
                dbo.TXN.BANK_LETTER_CITY,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 )
            HAVING 
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID_BANK.ACC_NO = '".$acc_no."'

        ) AS TABELS 
        ORDER BY subsrd_date DESC
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


    function ListRedemptionCustody($client_code,$acc_no)
    {
        $return = array();
        $query=$this->db_custody->query("
        SELECT * FROM (
            SELECT
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID.ACC_BANK_OPR AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM(dbo.TXN_POSTING.NET_PROCEED) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption NIAGA' AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID 
            WHERE 
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                (dbo.TXN.BANK_LETTER_CITY = '' OR dbo.TXN.BANK_LETTER_CITY is null ) AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.FUND_ID.ACC_BANK_OPR,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ), 
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.BANK_LETTER_CITY
            HAVING 
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID.ACC_BANK_OPR = '".$acc_no."'

            UNION
            
            SELECT
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID_BANK.ACC_NO AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM ( dbo.TXN_POSTING.NET_PROCEED ) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption Non NIAGA' AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID_BANK ON dbo.TXN.BANK_LETTER_CITY = dbo.FUND_ID_BANK.BANK_CODE
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID
            WHERE
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.PAYMENT_DATE,
                dbo.FUND_ID_BANK.BANK_NAME,
                dbo.FUND_ID_BANK.DESCRIPTION,
                dbo.FUND_ID_BANK.ACC_NO,
                dbo.TXN.BANK_LETTER_CITY,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 )
            HAVING 
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID_BANK.ACC_NO = '".$acc_no."'

        ) AS TABELS 
        ORDER BY subsrd_date DESC
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


    function ListRedemptionDiscre($client_code,$acc_no)
    {
        $return = array();
        $query=$this->db_discre->query("
        SELECT * FROM (
            SELECT
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID.ACC_BANK_OPR AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM(dbo.TXN_POSTING.NET_PROCEED) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption NIAGA' AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID 
            WHERE 
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                (dbo.TXN.BANK_LETTER_CITY = '' OR dbo.TXN.BANK_LETTER_CITY is null ) AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.FUND_ID.ACC_BANK_OPR,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ), 
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.BANK_LETTER_CITY
            HAVING 
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID.ACC_BANK_OPR = '".$acc_no."'

            UNION
            
            SELECT
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID_BANK.ACC_NO AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM ( dbo.TXN_POSTING.NET_PROCEED ) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption Non NIAGA' AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID_BANK ON dbo.TXN.BANK_LETTER_CITY = dbo.FUND_ID_BANK.BANK_CODE
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID
            WHERE
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.PAYMENT_DATE,
                dbo.FUND_ID_BANK.BANK_NAME,
                dbo.FUND_ID_BANK.DESCRIPTION,
                dbo.FUND_ID_BANK.ACC_NO,
                dbo.TXN.BANK_LETTER_CITY,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 )
            HAVING 
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID_BANK.ACC_NO = '".$acc_no."'

        ) AS TABELS 
        ORDER BY subsrd_date DESC
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


    function ListRedemptionMega($client_code,$acc_no)
    {
        $return = array();
        $query=$this->db_mega->query("
        SELECT * FROM (
            SELECT
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID.ACC_BANK_OPR AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM(dbo.TXN_POSTING.NET_PROCEED) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption NIAGA' AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID 
            WHERE 
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                (dbo.TXN.BANK_LETTER_CITY = '' OR dbo.TXN.BANK_LETTER_CITY is null ) AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.FUND_ID.ACC_BANK_OPR,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ), 
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.BANK_LETTER_CITY
            HAVING 
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID.ACC_BANK_OPR = '".$acc_no."'

            UNION
            
            SELECT
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID_BANK.ACC_NO AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM ( dbo.TXN_POSTING.NET_PROCEED ) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption Non NIAGA' AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID_BANK ON dbo.TXN.BANK_LETTER_CITY = dbo.FUND_ID_BANK.BANK_CODE
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID 
            WHERE
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.PAYMENT_DATE,
                dbo.FUND_ID_BANK.BANK_NAME,
                dbo.FUND_ID_BANK.DESCRIPTION,
                dbo.FUND_ID_BANK.ACC_NO,
                dbo.TXN.BANK_LETTER_CITY,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 )
            HAVING 
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID_BANK.ACC_NO = '".$acc_no."'

        ) AS TABELS 
        ORDER BY subsrd_date DESC
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


    function ListRedemptionNiaga($client_code,$acc_no)
    {
        $return = array();
        $query=$this->db_niaga->query("
        SELECT * FROM (
            SELECT
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID.ACC_BANK_OPR AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM(dbo.TXN_POSTING.NET_PROCEED) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption NIAGA' AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID 
            WHERE 
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                (dbo.TXN.BANK_LETTER_CITY = '' OR dbo.TXN.BANK_LETTER_CITY is null ) AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.FUND_ID.ACC_BANK_OPR,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ), 
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.BANK_LETTER_CITY
            HAVING 
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID.ACC_BANK_OPR = '".$acc_no."'

            UNION
            
            SELECT
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID_BANK.ACC_NO AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM ( dbo.TXN_POSTING.NET_PROCEED ) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption Non NIAGA' AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID_BANK ON dbo.TXN.BANK_LETTER_CITY = dbo.FUND_ID_BANK.BANK_CODE
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID 
            WHERE
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.PAYMENT_DATE,
                dbo.FUND_ID_BANK.BANK_NAME,
                dbo.FUND_ID_BANK.DESCRIPTION,
                dbo.FUND_ID_BANK.ACC_NO,
                dbo.TXN.BANK_LETTER_CITY,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 )
            HAVING 
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID_BANK.ACC_NO = '".$acc_no."'

        ) AS TABELS 
        ORDER BY subsrd_date DESC
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


    function ListRedemptionNiaga2($client_code,$acc_no)
    {
        $return = array();
        $query=$this->db_niaga2->query("
        SELECT * FROM (
            SELECT
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID.ACC_BANK_OPR AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM(dbo.TXN_POSTING.NET_PROCEED) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption NIAGA' AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID 
            WHERE 
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                (dbo.TXN.BANK_LETTER_CITY = '' OR dbo.TXN.BANK_LETTER_CITY is null ) AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.FUND_ID.ACC_BANK_OPR,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ), 
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.BANK_LETTER_CITY
            HAVING 
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID.ACC_BANK_OPR = '".$acc_no."'

            UNION
            
            SELECT
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID_BANK.ACC_NO AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM ( dbo.TXN_POSTING.NET_PROCEED ) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption Non NIAGA' AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID_BANK ON dbo.TXN.BANK_LETTER_CITY = dbo.FUND_ID_BANK.BANK_CODE
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID 
            WHERE
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.PAYMENT_DATE,
                dbo.FUND_ID_BANK.BANK_NAME,
                dbo.FUND_ID_BANK.DESCRIPTION,
                dbo.FUND_ID_BANK.ACC_NO,
                dbo.TXN.BANK_LETTER_CITY,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 )
            HAVING 
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID_BANK.ACC_NO = '".$acc_no."'

        ) AS TABELS 
        ORDER BY subsrd_date DESC
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
    

    function ListRedemptionSyailendra($client_code,$acc_no)
    {
        $return = array();
        $query=$this->db_syailendra->query("
        SELECT * FROM (
            SELECT
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID.ACC_BANK_OPR AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM(dbo.TXN_POSTING.NET_PROCEED) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption NIAGA' AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID 
            WHERE 
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                (dbo.TXN.BANK_LETTER_CITY = '' OR dbo.TXN.BANK_LETTER_CITY is null ) AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.FUND_ID.ACC_BANK_OPR,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ), 
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.BANK_LETTER_CITY
            HAVING 
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID.ACC_BANK_OPR = '".$acc_no."'

            UNION
            
            SELECT
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID_BANK.ACC_NO AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM ( dbo.TXN_POSTING.NET_PROCEED ) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption Non NIAGA' AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID_BANK ON dbo.TXN.BANK_LETTER_CITY = dbo.FUND_ID_BANK.BANK_CODE
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID 
            WHERE
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.PAYMENT_DATE,
                dbo.FUND_ID_BANK.BANK_NAME,
                dbo.FUND_ID_BANK.DESCRIPTION,
                dbo.FUND_ID_BANK.ACC_NO,
                dbo.TXN.BANK_LETTER_CITY,
                dbo.FUND_ID.CODE_BPM,
                dbo.TXN.SELLING_AGENT_CODE,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 )
            HAVING 
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID_BANK.ACC_NO = '".$acc_no."'

        ) AS TABELS 
        ORDER BY subsrd_date DESC
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


    function ListRedemptionTrimegah($client_code,$acc_no)
    {
        $return = array();
        $query=$this->db_trimegah->query("
        SELECT * FROM (
            SELECT
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID.ACC_BANK_OPR AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM(dbo.TXN_POSTING.NET_PROCEED) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption NIAGA' AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID 
            WHERE 
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                (dbo.TXN.BANK_LETTER_CITY = '' OR dbo.TXN.BANK_LETTER_CITY is null ) AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.FUND_ID.ACC_BANK_OPR,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ), 
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.BANK_LETTER_CITY
            HAVING 
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID.ACC_BANK_OPR = '".$acc_no."'

            UNION
            
            SELECT
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID_BANK.ACC_NO AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM ( dbo.TXN_POSTING.NET_PROCEED ) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption Non NIAGA' AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID_BANK ON dbo.TXN.BANK_LETTER_CITY = dbo.FUND_ID_BANK.BANK_CODE
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID 
            WHERE
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.PAYMENT_DATE,
                dbo.FUND_ID_BANK.BANK_NAME,
                dbo.FUND_ID_BANK.DESCRIPTION,
                dbo.FUND_ID_BANK.ACC_NO,
                dbo.TXN.BANK_LETTER_CITY,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 )
            HAVING 
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID_BANK.ACC_NO = '".$acc_no."'

        ) AS TABELS 
        ORDER BY subsrd_date DESC
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
                AND A.TRANSACTION_STATUS ='NEWM'
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
                AND A.TRANSACTION_STATUS ='NEWM'
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
                AND A.TRANSACTION_STATUS ='NEWM'
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
                AND A.TRANSACTION_STATUS ='NEWM'
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
                AND A.TRANSACTION_STATUS ='NEWM'
                AND A.IM_CODE <> 'KI002' AND A.IM_CODE <> 'DX002'
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
                AND A.TRANSACTION_STATUS ='NEWM'
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
                AND A.TRANSACTION_STATUS ='NEWM'
        ");

        $res_redemption = $this->CoaDescription('D001');
        
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
                AND A.TRANSACTION_STATUS ='NEWM'
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
                AND A.TRANSACTION_STATUS ='NEWM'
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
                AND A.TRANSACTION_STATUS ='NEWM'
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
                AND A.TRANSACTION_STATUS ='NEWM'
                AND A.IM_CODE <> 'KI002' AND A.IM_CODE <> 'DX002'
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
                AND A.TRANSACTION_STATUS ='NEWM'
        ");
        $res_tax_obligasi = array();
        if (count( $tax_obligasi->result_array() ) == 1) {
            $res_tax_obligasi = $this->CoaDescription('D017');
        }
        
        return array(
            $res_subscription,
            $res_penempatan,
            $res_pencairan,
            $res_redemption,
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
                'URSSIM_".date('Ymd', strtotime($date))."_' + dbo.TXN.SELLING_AGENT_CODE as id,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID.ACC_BANK_OPR AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM(dbo.TXN_POSTING.NET_PROCEED) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption NIAGA - ' +
                (SELECT NAME FROM SELLING_AGENT WHERE SELLING_AGENT.SELLING_AGENT_CODE = dbo.TXN.SELLING_AGENT_CODE) AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID
            WHERE 
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                (dbo.TXN.BANK_LETTER_CITY = '' OR dbo.TXN.BANK_LETTER_CITY is null )AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.FUND_ID.ACC_BANK_OPR,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ), 
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.BANK_LETTER_CITY,
                dbo.TXN.SELLING_AGENT_CODE
            HAVING 
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) = '".$date."' AND
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID.ACC_BANK_OPR = '".$acc_no."'

            UNION
            
            SELECT
                'URSSIM_".date('Ymd', strtotime($date))."_' + dbo.TXN.SELLING_AGENT_CODE as id,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID_BANK.ACC_NO AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM ( dbo.TXN_POSTING.NET_PROCEED ) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption Non Niaga- ' +
                (SELECT NAME FROM SELLING_AGENT WHERE SELLING_AGENT.SELLING_AGENT_CODE = dbo.TXN.SELLING_AGENT_CODE) AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID_BANK ON dbo.TXN.BANK_LETTER_CITY = dbo.FUND_ID_BANK.BANK_CODE
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID
            WHERE
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.PAYMENT_DATE,
                dbo.FUND_ID_BANK.BANK_NAME,
                dbo.FUND_ID_BANK.DESCRIPTION,
                dbo.FUND_ID_BANK.ACC_NO,
                dbo.TXN.BANK_LETTER_CITY,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ),
                dbo.TXN.SELLING_AGENT_CODE
            HAVING 
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) = '".$date."' AND
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID_BANK.ACC_NO = '".$acc_no."'
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

//=============================================================================================//

    function ListRedemptionBataviaDetail($client_code,$acc_no,$date)
    {
        $return = array();
        $query=$this->db_batavia->query("
             SELECT
                'BATAVIA_".date('Ymd', strtotime($date))."_' + dbo.TXN.SELLING_AGENT_CODE as id,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID.ACC_BANK_OPR AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM(dbo.TXN_POSTING.NET_PROCEED) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption NIAGA - ' +
                (SELECT NAME FROM SELLING_AGENT WHERE SELLING_AGENT.SELLING_AGENT_CODE = dbo.TXN.SELLING_AGENT_CODE) AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID 
            WHERE 
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                (dbo.TXN.BANK_LETTER_CITY = '' OR dbo.TXN.BANK_LETTER_CITY is null ) AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.FUND_ID.ACC_BANK_OPR,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ), 
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.BANK_LETTER_CITY,
                dbo.TXN.SELLING_AGENT_CODE
            HAVING 
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) = '".$date."' AND
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID.ACC_BANK_OPR = '".$acc_no."'

            UNION
            
            SELECT
                'BATAVIA_".date('Ymd', strtotime($date))."_' + dbo.TXN.SELLING_AGENT_CODE as id,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID_BANK.ACC_NO AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM ( dbo.TXN_POSTING.NET_PROCEED ) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption Non Niaga- ' +
                (SELECT NAME FROM SELLING_AGENT WHERE SELLING_AGENT.SELLING_AGENT_CODE = dbo.TXN.SELLING_AGENT_CODE) AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID_BANK ON dbo.TXN.BANK_LETTER_CITY = dbo.FUND_ID_BANK.BANK_CODE
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID 
            WHERE
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.PAYMENT_DATE,
                dbo.FUND_ID_BANK.BANK_NAME,
                dbo.FUND_ID_BANK.DESCRIPTION,
                dbo.FUND_ID_BANK.ACC_NO,
                dbo.TXN.BANK_LETTER_CITY,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ),
                dbo.TXN.SELLING_AGENT_CODE
            HAVING 
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) = '".$date."' AND
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID_BANK.ACC_NO = '".$acc_no."'
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


    
    function ListRedemptionBniDetail($client_code,$acc_no,$date)
    {
        $return = array();
        $query=$this->db_bni->query("
            SELECT
                'BNI_".date('Ymd', strtotime($date))."_' + dbo.TXN.SELLING_AGENT_CODE as id,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID.ACC_BANK_OPR AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM(dbo.TXN_POSTING.NET_PROCEED) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption NIAGA - ' +
                (SELECT NAME FROM SELLING_AGENT WHERE SELLING_AGENT.SELLING_AGENT_CODE = dbo.TXN.SELLING_AGENT_CODE) AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID 
            WHERE 
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                (dbo.TXN.BANK_LETTER_CITY = '' OR dbo.TXN.BANK_LETTER_CITY is null ) AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.FUND_ID.ACC_BANK_OPR,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ), 
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.BANK_LETTER_CITY,
                dbo.TXN.SELLING_AGENT_CODE
            HAVING 
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) = '".$date."' AND
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID.ACC_BANK_OPR = '".$acc_no."'

            UNION
            
            SELECT
                'BNI_".date('Ymd', strtotime($date))."_' + dbo.TXN.SELLING_AGENT_CODE as id,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID_BANK.ACC_NO AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM ( dbo.TXN_POSTING.NET_PROCEED ) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption Non Niaga- ' +
                (SELECT NAME FROM SELLING_AGENT WHERE SELLING_AGENT.SELLING_AGENT_CODE = dbo.TXN.SELLING_AGENT_CODE) AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID_BANK ON dbo.TXN.BANK_LETTER_CITY = dbo.FUND_ID_BANK.BANK_CODE
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID 
            WHERE
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.PAYMENT_DATE,
                dbo.FUND_ID_BANK.BANK_NAME,
                dbo.FUND_ID_BANK.DESCRIPTION,
                dbo.FUND_ID_BANK.ACC_NO,
                dbo.TXN.BANK_LETTER_CITY,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ),
                dbo.TXN.SELLING_AGENT_CODE
            HAVING 
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) = '".$date."' AND
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID_BANK.ACC_NO = '".$acc_no."'
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

    
    function ListRedemptionCustodyDetail($client_code,$acc_no,$date)
    {
        $return = array();
        $query=$this->db_custody->query("
            SELECT
                'CUSTODY_".date('Ymd', strtotime($date))."_' + dbo.TXN.SELLING_AGENT_CODE as id,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID.ACC_BANK_OPR AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM(dbo.TXN_POSTING.NET_PROCEED) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption NIAGA - ' +
                (SELECT NAME FROM SELLING_AGENT WHERE SELLING_AGENT.SELLING_AGENT_CODE = dbo.TXN.SELLING_AGENT_CODE) AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID 
            WHERE 
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                (dbo.TXN.BANK_LETTER_CITY = '' OR dbo.TXN.BANK_LETTER_CITY is null ) AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.FUND_ID.ACC_BANK_OPR,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ), 
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.BANK_LETTER_CITY,
                dbo.TXN.SELLING_AGENT_CODE
            HAVING 
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) = '".$date."' AND
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID.ACC_BANK_OPR = '".$acc_no."'

            UNION
            
            SELECT
                'CUSTODY_".date('Ymd', strtotime($date))."_' + dbo.TXN.SELLING_AGENT_CODE as id,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID_BANK.ACC_NO AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM ( dbo.TXN_POSTING.NET_PROCEED ) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption Non Niaga- ' +
                (SELECT NAME FROM SELLING_AGENT WHERE SELLING_AGENT.SELLING_AGENT_CODE = dbo.TXN.SELLING_AGENT_CODE) AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID_BANK ON dbo.TXN.BANK_LETTER_CITY = dbo.FUND_ID_BANK.BANK_CODE
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID 
            WHERE
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.PAYMENT_DATE,
                dbo.FUND_ID_BANK.BANK_NAME,
                dbo.FUND_ID_BANK.DESCRIPTION,
                dbo.FUND_ID_BANK.ACC_NO,
                dbo.TXN.BANK_LETTER_CITY,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ),
                dbo.TXN.SELLING_AGENT_CODE
            HAVING 
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) = '".$date."' AND
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID_BANK.ACC_NO = '".$acc_no."'
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


    function ListRedemptionDiscreDetail($client_code,$acc_no,$date)
    {
        $return = array();
        $query=$this->db_discre->query("
            SELECT
                'DISCRE_".date('Ymd', strtotime($date))."_' + dbo.TXN.SELLING_AGENT_CODE as id,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID.ACC_BANK_OPR AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM(dbo.TXN_POSTING.NET_PROCEED) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption NIAGA - ' +
                (SELECT NAME FROM SELLING_AGENT WHERE SELLING_AGENT.SELLING_AGENT_CODE = dbo.TXN.SELLING_AGENT_CODE) AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID 
            WHERE 
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                (dbo.TXN.BANK_LETTER_CITY = '' OR dbo.TXN.BANK_LETTER_CITY is null ) AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.FUND_ID.ACC_BANK_OPR,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ), 
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.BANK_LETTER_CITY,
                dbo.TXN.SELLING_AGENT_CODE
            HAVING 
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) = '".$date."' AND
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID.ACC_BANK_OPR = '".$acc_no."'

            UNION
            
            SELECT
                'DISCRE_".date('Ymd', strtotime($date))."_' + dbo.TXN.SELLING_AGENT_CODE as id,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID_BANK.ACC_NO AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM ( dbo.TXN_POSTING.NET_PROCEED ) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption Non Niaga- ' +
                (SELECT NAME FROM SELLING_AGENT WHERE SELLING_AGENT.SELLING_AGENT_CODE = dbo.TXN.SELLING_AGENT_CODE) AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID_BANK ON dbo.TXN.BANK_LETTER_CITY = dbo.FUND_ID_BANK.BANK_CODE
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID 
            WHERE
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.PAYMENT_DATE,
                dbo.FUND_ID_BANK.BANK_NAME,
                dbo.FUND_ID_BANK.DESCRIPTION,
                dbo.FUND_ID_BANK.ACC_NO,
                dbo.TXN.BANK_LETTER_CITY,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ),
                dbo.TXN.SELLING_AGENT_CODE
            HAVING 
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) = '".$date."' AND
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID_BANK.ACC_NO = '".$acc_no."'
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


    function ListRedemptionMegaDetail($client_code,$acc_no,$date)
    {
        $return = array();
        $query=$this->db_mega->query("
             SELECT
                'MEGA_".date('Ymd', strtotime($date))."_' + dbo.TXN.SELLING_AGENT_CODE as id,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID.ACC_BANK_OPR AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM(dbo.TXN_POSTING.NET_PROCEED) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption NIAGA - ' +
                (SELECT NAME FROM SELLING_AGENT WHERE SELLING_AGENT.SELLING_AGENT_CODE = dbo.TXN.SELLING_AGENT_CODE) AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID 
            WHERE 
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                (dbo.TXN.BANK_LETTER_CITY = '' OR dbo.TXN.BANK_LETTER_CITY is null ) AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.FUND_ID.ACC_BANK_OPR,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ), 
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.BANK_LETTER_CITY,
                dbo.TXN.SELLING_AGENT_CODE
            HAVING 
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) = '".$date."' AND
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID.ACC_BANK_OPR = '".$acc_no."'

            UNION
            
            SELECT
                'MEGA_".date('Ymd', strtotime($date))."_' + dbo.TXN.SELLING_AGENT_CODE as id,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID_BANK.ACC_NO AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM ( dbo.TXN_POSTING.NET_PROCEED ) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption Non Niaga- ' +
                (SELECT NAME FROM SELLING_AGENT WHERE SELLING_AGENT.SELLING_AGENT_CODE = dbo.TXN.SELLING_AGENT_CODE) AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID_BANK ON dbo.TXN.BANK_LETTER_CITY = dbo.FUND_ID_BANK.BANK_CODE
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID 
            WHERE
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.PAYMENT_DATE,
                dbo.FUND_ID_BANK.BANK_NAME,
                dbo.FUND_ID_BANK.DESCRIPTION,
                dbo.FUND_ID_BANK.ACC_NO,
                dbo.TXN.BANK_LETTER_CITY,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ),
                dbo.TXN.SELLING_AGENT_CODE
            HAVING 
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) = '".$date."' AND
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID_BANK.ACC_NO = '".$acc_no."'
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



    function ListRedemptionNiagaDetail($client_code,$acc_no,$date)
    {
        $return = array();
        $query=$this->db_niaga->query("
            SELECT
                'NIAGA_".date('Ymd', strtotime($date))."_' + dbo.TXN.SELLING_AGENT_CODE as id,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID.ACC_BANK_OPR AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM(dbo.TXN_POSTING.NET_PROCEED) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption NIAGA - ' +
                (SELECT NAME FROM SELLING_AGENT WHERE SELLING_AGENT.SELLING_AGENT_CODE = dbo.TXN.SELLING_AGENT_CODE) AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID 
            WHERE 
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                (dbo.TXN.BANK_LETTER_CITY = '' OR dbo.TXN.BANK_LETTER_CITY is null ) AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.FUND_ID.ACC_BANK_OPR,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ), 
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.BANK_LETTER_CITY,
                dbo.TXN.SELLING_AGENT_CODE
            HAVING 
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) = '".$date."' AND
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID.ACC_BANK_OPR = '".$acc_no."'

            UNION
            
            SELECT
                'NIAGA_".date('Ymd', strtotime($date))."_' + dbo.TXN.SELLING_AGENT_CODE as id,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID_BANK.ACC_NO AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM ( dbo.TXN_POSTING.NET_PROCEED ) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption Non Niaga- ' +
                (SELECT NAME FROM SELLING_AGENT WHERE SELLING_AGENT.SELLING_AGENT_CODE = dbo.TXN.SELLING_AGENT_CODE) AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID_BANK ON dbo.TXN.BANK_LETTER_CITY = dbo.FUND_ID_BANK.BANK_CODE
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID 
            WHERE
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.PAYMENT_DATE,
                dbo.FUND_ID_BANK.BANK_NAME,
                dbo.FUND_ID_BANK.DESCRIPTION,
                dbo.FUND_ID_BANK.ACC_NO,
                dbo.TXN.BANK_LETTER_CITY,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ),
                dbo.TXN.SELLING_AGENT_CODE
            HAVING 
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) = '".$date."' AND
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID_BANK.ACC_NO = '".$acc_no."'
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


    function ListRedemptionNiaga2Detail($client_code,$acc_no,$date)
    {
        $return = array();
        $query=$this->db_niaga2->query("
            SELECT
                'NIAGA2_".date('Ymd', strtotime($date))."_' + dbo.TXN.SELLING_AGENT_CODE as id,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID.ACC_BANK_OPR AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM(dbo.TXN_POSTING.NET_PROCEED) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption NIAGA - ' +
                (SELECT NAME FROM SELLING_AGENT WHERE SELLING_AGENT.SELLING_AGENT_CODE = dbo.TXN.SELLING_AGENT_CODE) AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID 
            WHERE 
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                (dbo.TXN.BANK_LETTER_CITY = '' OR dbo.TXN.BANK_LETTER_CITY is null ) AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.FUND_ID.ACC_BANK_OPR,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ), 
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.BANK_LETTER_CITY,
                dbo.TXN.SELLING_AGENT_CODE
            HAVING 
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) = '".$date."' AND
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID.ACC_BANK_OPR = '".$acc_no."'

            UNION
            
            SELECT
                'NIAGA2_".date('Ymd', strtotime($date))."_' + dbo.TXN.SELLING_AGENT_CODE as id,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID_BANK.ACC_NO AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM ( dbo.TXN_POSTING.NET_PROCEED ) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption Non Niaga- ' +
                (SELECT NAME FROM SELLING_AGENT WHERE SELLING_AGENT.SELLING_AGENT_CODE = dbo.TXN.SELLING_AGENT_CODE) AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID_BANK ON dbo.TXN.BANK_LETTER_CITY = dbo.FUND_ID_BANK.BANK_CODE
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID 
            WHERE
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.PAYMENT_DATE,
                dbo.FUND_ID_BANK.BANK_NAME,
                dbo.FUND_ID_BANK.DESCRIPTION,
                dbo.FUND_ID_BANK.ACC_NO,
                dbo.TXN.BANK_LETTER_CITY,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ),
                dbo.TXN.SELLING_AGENT_CODE
            HAVING 
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) = '".$date."' AND
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID_BANK.ACC_NO = '".$acc_no."'
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


    function ListRedemptionSyailendraDetail($client_code,$acc_no,$date)
    {
        $return = array();
        $query=$this->db_syailendra->query("
            SELECT
                'SYAILENDRA_".date('Ymd', strtotime($date))."_' + dbo.TXN.SELLING_AGENT_CODE as id,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID.ACC_BANK_OPR AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM(dbo.TXN_POSTING.NET_PROCEED) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption NIAGA - ' +
                (SELECT NAME FROM SELLING_AGENT WHERE SELLING_AGENT.SELLING_AGENT_CODE = dbo.TXN.SELLING_AGENT_CODE) AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID 
            WHERE 
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                (dbo.TXN.BANK_LETTER_CITY = '' OR dbo.TXN.BANK_LETTER_CITY is null ) AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.FUND_ID.ACC_BANK_OPR,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ), 
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.BANK_LETTER_CITY,
                dbo.TXN.SELLING_AGENT_CODE
            HAVING 
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) = '".$date."' AND
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID.ACC_BANK_OPR = '".$acc_no."'

            UNION
            
            SELECT
                'SYAILENDRA_".date('Ymd', strtotime($date))."_' + dbo.TXN.SELLING_AGENT_CODE as id,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID_BANK.ACC_NO AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM ( dbo.TXN_POSTING.NET_PROCEED ) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption Non Niaga- ' +
                (SELECT NAME FROM SELLING_AGENT WHERE SELLING_AGENT.SELLING_AGENT_CODE = dbo.TXN.SELLING_AGENT_CODE) AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID_BANK ON dbo.TXN.BANK_LETTER_CITY = dbo.FUND_ID_BANK.BANK_CODE
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID 
            WHERE
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.PAYMENT_DATE,
                dbo.FUND_ID_BANK.BANK_NAME,
                dbo.FUND_ID_BANK.DESCRIPTION,
                dbo.FUND_ID_BANK.ACC_NO,
                dbo.TXN.BANK_LETTER_CITY,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ),
                dbo.TXN.SELLING_AGENT_CODE
            HAVING 
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) = '".$date."' AND
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID_BANK.ACC_NO = '".$acc_no."'
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


    function ListRedemptionTrimegahDetail($client_code,$acc_no,$date)
    {
        $return = array();
        $query=$this->db_trimegah->query("
            SELECT
                'TRIMEGAH_".date('Ymd', strtotime($date))."_' + dbo.TXN.SELLING_AGENT_CODE as id,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID.ACC_BANK_OPR AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM(dbo.TXN_POSTING.NET_PROCEED) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption NIAGA - ' +
                (SELECT NAME FROM SELLING_AGENT WHERE SELLING_AGENT.SELLING_AGENT_CODE = dbo.TXN.SELLING_AGENT_CODE) AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID 
            WHERE 
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                (dbo.TXN.BANK_LETTER_CITY = '' OR dbo.TXN.BANK_LETTER_CITY is null ) AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.FUND_ID.ACC_BANK_OPR,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ), 
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.BANK_LETTER_CITY,
                dbo.TXN.SELLING_AGENT_CODE
            HAVING 
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) = '".$date."' AND
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID.ACC_BANK_OPR = '".$acc_no."'

            UNION
            
            SELECT
                'TRIMEGAH_".date('Ymd', strtotime($date))."_' + dbo.TXN.SELLING_AGENT_CODE as id,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) AS subsrd_date,
                dbo.FUND_ID.CODE_BPM AS client_code,
                dbo.FUND_ID_BANK.ACC_NO AS acc_no,
                dbo.TXN_POSTING.TXN_TYPE,
                SUM ( dbo.TXN_POSTING.NET_PROCEED ) AS subsrd_nominal,
                dbo.TXN.BANK_LETTER_CITY,
                'D001' AS subsrd_kategori,
                'Redemption Non Niaga- ' +
                (SELECT NAME FROM SELLING_AGENT WHERE SELLING_AGENT.SELLING_AGENT_CODE = dbo.TXN.SELLING_AGENT_CODE) AS deskripsi 
            FROM
                dbo.TXN
                INNER JOIN dbo.TXN_POSTING ON dbo.TXN.TXN_REF = dbo.TXN_POSTING.TXN_REF 
                AND dbo.TXN.TXN_NO = dbo.TXN_POSTING.TXN_NO
                INNER JOIN dbo.FUND_ID_BANK ON dbo.TXN.BANK_LETTER_CITY = dbo.FUND_ID_BANK.BANK_CODE
                INNER JOIN dbo.FUND_ID ON dbo.TXN.FUND_ID = dbo.FUND_ID.FUND_ID 
            WHERE
                dbo.TXN_POSTING.TXN_TYPE = 'R' AND
                ( 
                    dbo.TXN.FUND_ID IN (SELECT dbo.FUND_SUMMARY.FUND_ID  FROM dbo.FUND_SUMMARY) AND 
                    dbo.TXN.PAYMENT_DATE IN (SELECT dbo.FUND_SUMMARY.TRADE_DATE  FROM dbo.FUND_SUMMARY)
                )
            GROUP BY
                dbo.TXN_POSTING.TXN_TYPE,
                dbo.TXN.PAYMENT_DATE,
                dbo.FUND_ID_BANK.BANK_NAME,
                dbo.FUND_ID_BANK.DESCRIPTION,
                dbo.FUND_ID_BANK.ACC_NO,
                dbo.TXN.BANK_LETTER_CITY,
                dbo.FUND_ID.CODE_BPM,
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ),
                dbo.TXN.SELLING_AGENT_CODE
            HAVING 
                CONVERT ( DATE, dbo.TXN.PAYMENT_DATE, 102 ) = '".$date."' AND
                dbo.FUND_ID.CODE_BPM = '".$client_code."' AND
                dbo.FUND_ID_BANK.ACC_NO = '".$acc_no."'
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
                'Hasil Jual Saham - '+RTRIM(SECURITY_CODE) AS deskripsi,
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
                AND A.TRANSACTION_STATUS ='NEWM'
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
                'Hasil Jual Obligasi - '+RTRIM(SECURITY_CODE) AS deskripsi,
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
                AND A.TRANSACTION_STATUS ='NEWM'
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
                'Beli Saham - '+RTRIM(SECURITY_CODE) AS deskripsi,
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
                AND A.TRANSACTION_STATUS ='NEWM'
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
                'Beli Obligasi - '+RTRIM(SECURITY_CODE) AS deskripsi,
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
                AND A.TRANSACTION_STATUS ='NEWM'
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
                'Wht Commision - '+RTRIM(SECURITY_CODE) AS deskripsi,
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
                AND A.TRANSACTION_STATUS ='NEWM'
                AND A.IM_CODE <> 'KI002' AND A.IM_CODE <> 'DX002'
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
                'Capital Gain Tax - ' + RTRIM(SECURITY_CODE) AS deskripsi,
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
                AND A.TRANSACTION_STATUS ='NEWM'
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
                    'Interst Income Tax - ' + RTRIM(SECURITY_CODE) AS deskripsi,
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
                    AND A.TRANSACTION_STATUS ='NEWM'
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

    public function check_jasgir($client_code, $acc_no)
    {
        $query=$this->db_jasgir->query("
            SELECT
                *
            FROM
                mutasi_client
            where
                client_code = '".$client_code."' and
                acc_no = '".$acc_no."'
        ");
        $data = $query->result_array();
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

    public function SetMutasiGiro($data)
    {
        $this->db_jasgir->query("
            INSERT INTO [dbo].[mutasi_giro] (
                [giro_val_date],
                [giro_asof_date],
                [giro_rate],
                [giro_tenor],
                [giro_year],
                [client_code],
                [client_name],
                [acc_no],
                [giro_nominal],
                [giro_interest],
                [giro_interest_tax],
                [giro_interest_net],
                [created_by],
                [created_dt]
            )
            VALUES
            (
                '".$data['giro_val_date']."',
                '".$data['giro_asof_date']."',
                ".$data['giro_rate'].",
                '".$data['giro_tenor']."',
                '".$data['giro_year']."',
                '".$data['client_code']."',
                '".$data['client_name']."',
                '".$data['acc_no']."',
                '".$data['giro_nominal']."',
                '".$data['giro_interest']."',
                '".$data['giro_interest_tax']."',
                '".$data['giro_interest_net']."',
                '".$data['created_by']."',
                '".$data['created_dt']."'
            );
        ");
    }
    public function JasgirToMutasi()
    {
        $query = $this->db_jasgir->query("
            SELECT TOP (1) * FROM mutasi_giro ORDER BY giro_id DESC; 
        ");
        $data = $query->result_array();
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
                '".$data[0]['client_code']."',
                '".$data[0]['acc_no']."',
                '".$data[0]['giro_asof_date']->format('Y-m-d H:i:s')."',
                'C001',
                'Jasa Giro',
                '".$data[0]['client_name']."',
                'C',
                '".$data[0]['giro_interest_net']."',
                '".$this->session->userdata('itd_uid')."',
                '".$data[0]['giro_val_date']->format('Y-m-d H:i:s')."',
                '".$this->session->userdata('itd_uid')."',
                '".date('Y-m-d H:i:s')."',
                1,
                '".$data[0]['giro_id']."'
            );
        ");
    }

    public function status_mutasi($client_code='',$acc_no='',$cdt='',$status=0)
    {
        $query=$this->db_jasgir->query("exec [get_last_balance_date] '{$client_code}','{$acc_no}','{$cdt}',{$status}");
        $data=$query->result_array();

        if( count($data) > 0 ){
            return $data[0]['curr_status'];
        }
        return count($data);
    }

} // of end class
?>