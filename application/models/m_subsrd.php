<?php
class M_subsrd extends CI_Model {
    //model subscript
    private $q_param = array();
    private $db_jasgir;
    function __construct()
    {                                     
        parent::__construct();           
        $this->db_jasgir = $this->load->database('dbjasgir',true);
    }
    
    function list_client_by_code($client_code)
    {                                                     
        $query=$this->db_jasgir->query("exec [subsrd_list_client] '{$client_code}'");
        $data=$query->result_array();
        return $data;
    }
    function open_day($client_code,$client_date,$user_id)
    {
        $query=$this->db_jasgir->query("exec subsrd_open_day '{$client_code}','{$client_date}','{$user_id}'");
        $data=$query->result_array();
        return $data;
    }
    function close_day($client_code,$client_date,$user_id)
    {
        $query=$this->db_jasgir->query("exec subsrd_close_day '{$client_code}','{$client_date}','{$user_id}'");
        $data=$query->result_array();
        return $data;
    }
    function cancel_close_day($client_code,$client_date,$user_id)
    {
        $query=$this->db_jasgir->query("exec subsrd_close_day_cancel '{$client_code}','{$client_date}','{$user_id}'");
        $data=$query->result_array();
        return $data;
    }
    function get_status($client_code,$user_id)
    {
        $query=$this->db_jasgir->query("exec subsrd_get_status '{$client_code}','{$user_id}'");
        $data=$query->result_array();
        return $data;
    }
    function list_data($client_code,$subs_date,$user_id)
    {
        $query=$this->db_jasgir->query("exec subsrd_list_data '{$client_code}','{$subs_date}','{$user_id}'");
        $data=$query->result_array();
        return $data;
    }
    function rekap_data($client_code,$subs_date,$user_id)
    {
        $query=$this->db_jasgir->query("exec [subsrd_rekap_by_sa] '{$client_code}','{$subs_date}','{$user_id}'");
        $data=$query->result_array();
        return $data;
    }
    function list_sa($b_code,$user_id)
    {                                    
        $query=$this->db_jasgir->query("exec [subsrd_list_sa_by_client]  '{$b_code}','{$user_id}'");
        $data=$query->result_array();
        return $data;
    }
    function add_subsrd($client_code,$subsrd_date,$sa_id,$acc_src,$acc_dst,$subsrd_desc,$subsrd_nominal,$user_id)
    { //echo "exec subsrd_add '{$client_code}','{$subsrd_date}',{$sa_id},{$acc_src},{$acc_dst},'{$subsrd_desc}',{$subsrd_nominal},'{$user_id}'";
        $query=$this->db_jasgir->query("exec subsrd_add '{$client_code}','{$subsrd_date}',{$sa_id},{$acc_src},{$acc_dst},'{$subsrd_desc}',{$subsrd_nominal},'{$user_id}'");
        $data=$query->result_array();
        return $data;
    }
    function edit_subsrd($subsrd_id,$sa_id,$acc_src,$acc_dst,$subsrd_desc,$subsrd_nominal,$user_id)
    {
        $query=$this->db_jasgir->query("exec subsrd_edit {$subsrd_id},{$sa_id},{$acc_src},{$acc_dst},'{$subsrd_desc}',{$subsrd_nominal},'{$user_id}'");
        $data=$query->result_array();
        return $data;
    }
    function del_subsrd($subsrd_id,$user_id)
    {
        $query=$this->db_jasgir->query("exec subsrd_del {$subsrd_id},'{$user_id}'");
        $data=$query->result_array();
        return $data;
    }
    function get_balance_status($c_code,$c_dt,$user_id)
    {
        $query=$this->db_jasgir->query("exec [subsrd_get_status_as_date] '{$c_code}','{$c_dt}'");
        $data=$query->result_array();
        return $data;
    }
    function get_instruksi_param($c_par)
    {
        $query=$this->db_jasgir->query("exec [subsrd_param_get] '{$c_par}'");
        $data=$query->result_array();
        return $data;
    }
    function rekap_bal_per_bank($c_code,$c_dt,$c_bank,$get_date,$user_id)
    { //echo "   exec [subsrd_rekap_balance_per_bank] '{$c_code}','{$c_dt}','{$c_bank}','{$get_date}'";
        $query=$this->db_jasgir->query("exec [subsrd_rekap_balance_per_bank] '{$c_code}','{$c_dt}','{$c_bank}','{$get_date}'");
        $data=$query->result_array();
        return $data;
    }
    function get_bank_by_client($c_code,$user_id)
    {
        $query=$this->db_jasgir->query("exec [subsrd_get_bank_by_client] '{$c_code}'");
        $data=$query->result_array();
        return $data;
    }
    /*
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
    */
    function rekon_vs_urs($dt,$t)
    {
        $query=$this->db_jasgir->query("exec dbo.sp_subsrd_rekon_urs  '{$dt}',{$t}");
        $data=$query->result_array();
        return $data;
    }

    function SubscribeToMutasi($data)
    {
        $date           = date('Y-m-d', strtotime($data['date']) );
        $client_code    = $data['client_code'];
        $coa_id         = $data['coa_id'];
        $acc_no         = $data['acc_no'];
        $mutasi_trx     = array();

        $coa = $this->db_jasgir->query(" SELECT * FROM coa WHERE coa_no = '".$coa_id."' ");
        $coa = $coa->result();

        $subsrd = $this->db_jasgir->query("
            SELECT 
                * 
            FROM 
                subsrd
            WHERE 
                client_code = '".$client_code."' and
                subsrd_date = '".$date."'
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
                trx_date = '".$date."'
        ");

        // saat insert ke mutasi trx jika :
        // jumat h+3
        // sabtu h+2
        // senin-kamis dan minggu H+1
        $date = $data['date'];
        $dayOfWeek = date('w', strtotime($date));
        switch ($dayOfWeek) {
            case 5:
                $date = date('Y-m-d', strtotime($date.'+3 day'));
                break;
            case 6:
                $date = date('Y-m-d', strtotime($date.'+2 day'));
                break;
            default:
                $date = date('Y-m-d', strtotime($date.'+1 day'));
                break;
        }

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
                        '".$value['subsrd_date']->format('Y-m-d H:i:s')."',
                        '".$this->session->userdata('itd_uid')."',
                        '".date('Y-m-d H:i:s')."',
                        1,
                        '".$value['subsrd_id']."'
                    );
                ");
            }
            $mutasi_trx = $mutasi_trx ? array('msg' => 'Data berhasil masuk ke mutasi') : array('msg' => 'Data Gagal Masuk ke Mutasi');
        }else{
            $mutasi_trx = array('msg' => 'Data Sudah Ada');
        }
        return $mutasi_trx;
    }
}
?>
