<?php
class M_docim extends CI_Model {

    function __construct()
    {                                     
        parent::__construct();
        $this->load->database('dbdocim');
    }
    function get_bilyet_inst_search($b_no,$b_ccode,$b_to,$b_cname,$b_bname,$val_dt,$due_dt,$b_nominal,$b_type)
    {
        //echo "exec search_trx_by_bilyet '{$b_no}','{$b_bname}','{$b_name}','{$val_dt}','{$due_dt}',{$b_nominal}, {$b_type}";
        $query=$this->db->query("exec search_trx_by_bilyet '{$b_no}','{$b_ccode}','{$b_to}','{$b_cname}','{$b_bname}','{$val_dt}','{$due_dt}',{$b_nominal}, {$b_type}");
        $data=$query->result_array();
        return $data;
    }
    function get_docim_search($c_id,$f_id,$b_id,$s_sdt,$s_edt,$i_sdt,$i_edt)
    {     
        
       // $query=$this->db->query("select top 10000 * from doc_list");
        $query=$this->db->query("exec search_document '{$c_id}','{$f_id}','{$b_id}','{$s_sdt}','{$s_edt}','{$i_sdt}','{$i_edt}'");
        $data=$query->result_array();
        return $data;
    }
    function get_docim($doc_id)
    {     
        
       // $query=$this->db->query("select top 10000 * from doc_list");
        $query=$this->db->query("exec get_document {$doc_id}");
        $data=$query->result_array();
        return $data;
    }
    function insert_docim_tmp($c_id,$f_id,$b_id,$s_dt,$i_dt,$l_dt,$p_count,$fname,$u_id)
    {
        $this->db->query("exec insert_document_tmp '{$c_id}','{$f_id}','{$b_id}','{$s_dt}','{$i_dt}','{$l_dt}',{$p_count},'{$fname}','{$u_id}'");
    }
    function create_docim_tmp($s_dt)
    {
        $this->db->query("exec create_document_tmp '{$s_dt}'");
    }
    function copy_docim_tmp($s_dt)
    {
        $this->db->query("exec copy_document_tmp '{$s_dt}'");
    }
}
?>