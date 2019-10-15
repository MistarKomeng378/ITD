<?php
class M_itd_dlg extends CI_Model {

    private $q_param = array();

    function __construct()
    {                                     
        parent::__construct();           
        $this->load->database('default');
    }
    function get_trx_type()
    {
        $query=$this->db->query("select * from itd_trx_type order by type_id");
        $data=$query->result_array();
        return $data;
    }
    function get_trx_deposit_type()
    {
        $query=$this->db->query("select * from itd_deposit_type order by type_id");
        $data=$query->result_array();
        return $data;
    }
    function get_trx_tax_status()
    {
        $query=$this->db->query("select * from itd_tax_status order by status_id");
        $data=$query->result_array();
        return $data;
    }
    function get_trx_rate_payment()
    {
        $query=$this->db->query("select * from itd_rate_payment order by payment_id");
        $data=$query->result_array();
        return $data;
    }
    function get_trx_curr()
    {
        $query=$this->db->query("select * from itd_curr");
        $data=$query->result_array();
        return $data;
    }
    function get_trx_due_dt_status()
    {
        $query=$this->db->query("select * from itd_due_date");
        $data=$query->result_array();
        return $data;
    }
}
?>