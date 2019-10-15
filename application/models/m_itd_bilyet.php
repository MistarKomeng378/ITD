<?php
class M_itd_bilyet extends CI_Model {


    function __construct()
    {                                     
        parent::__construct();           
        $this->load->database('default');
    }
    function get_bilyet_inst_search($b_no,$b_ccode,$b_to,$b_cname,$b_bname,$val_dt,$due_dt,$b_nominal,$b_type)
    {
        //echo "exec search_trx_by_bilyet '{$b_no}','{$b_ccode}','{$b_to}','{$b_cname}','{$b_bname}','{$val_dt}','{$due_dt}',{$b_nominal}, {$b_type}";
        $query=$this->db->query("exec search_trx_by_bilyet '{$b_no}','{$b_ccode}','{$b_to}','{$b_cname}','{$b_bname}','{$val_dt}','{$due_dt}',{$b_nominal}, {$b_type}");
        $data=$query->result_array();
        return $data;
    }
    function get_bilyet_inst_none($b_trx_id)
    {
        $query=$this->db->query("exec get_trx_by_bilyet_none {$b_trx_id}");
        $data=$query->result_array();
        return $data;
    }
    function get_bilyet_inst_in($b_trx_id)
    {
        $query=$this->db->query("exec get_trx_by_bilyet_in {$b_trx_id}");
        $data=$query->result_array();
        return $data;
    }
    function save_bilyet_inst_in($trx_id,$bil_dt,$bil_no,$bil_desc,$user_id,$bil_oncall=0)
    { 
        $query=$this->db->query("exec [bilyet_in] {$trx_id},'{$bil_dt}','{$bil_no}','{$bil_desc}','{$user_id}',{$bil_oncall}");
        $data=$query->result_array();
        return $data;
    }
    function save_bilyet_inst_out($trx_id,$bil_dt,$bil_desc,$user_id)
    { 
        $query=$this->db->query("exec [bilyet_out] {$trx_id},'{$bil_dt}','{$bil_desc}','{$user_id}'");
        $data=$query->result_array();
        return $data;
    }
    function update_bilyet_inst($trx_id,$bil_no,$bil_desc,$user_id)
    { 
        $query=$this->db->query("exec [bilyet_update] {$trx_id},'{$bil_no}','{$bil_desc}','{$user_id}'");
        $data=$query->result_array();
        return $data;
    }
    function get_list_bilyet_for_print($q)
    {
        $query=$this->db->query("exec [get_trx_bilyet_for_print] '{$q}'");      
        $data=$query->result_array();
        return $data;
    }
    function get_bilyet_status_count()
    { 
        $query=$this->db->query("exec get_bilyet_status_count");      
        $data=$query->result_array();
        return $data;
    }
    function list_pending_bilyet_inst($b_tipe=0,$p_opt=0)
    { 
        $query=$this->db->query("exec [list_trx_by_bilyet_pending]  {$b_tipe},{$p_opt}");
        $data=$query->result_array();
        return $data;
    }
    function do_bilyet_inst_cancel($trx_id=0,$i_cancel=0,$user_id='')
    { 
        $query=$this->db->query("exec [bilyet_cancel] {$trx_id},{$i_cancel},'{$user_id}'");
        $data=$query->result_array();
        return $data;
    }
}
?>