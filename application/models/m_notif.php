<?php
class M_notif extends CI_Model {

    private $q_param = array();
    private $db_itd;
    private $db_jasgir;
    function __construct()
    {                                     
        parent::__construct();           
        $this->db_itd = $this->load->database('default',true);
        $this->db_jasgir = $this->load->database('dbjasgir',true);
    }
    function get_login_info($user,$pass)
    {                                                                                
        $query=$this->db->query("exec get_user_info '{$user}','" . md5($pass) . "'");
        $data=$query->result_array();
        return $data;
    }
    function get_mail_info($notif_type='')
    {
        $query=$this->db_jasgir->query("exec notif_get_mail_info '{$notif_type}'");
        $data=$query->result_array();
        return $data;
    }
    function list_mail()
    {
        $query=$this->db_jasgir->query("exec notif_list_mail");
        $data=$query->result_array();
        return $data;
    }
    function save_mail($mail_no,$mail_host,$mail_port,$mail_user,$mail_password,$mail_from,$mail_fromname,$mail_to,$mail_default)
    {
        $query=$this->db_jasgir->query("exec notif_save_mail '{$mail_no}','{$mail_host}','{$mail_port}','{$mail_user}','{$mail_password}','{$mail_from}','{$mail_fromname}','{$mail_to}','{$mail_default}'");
    }
    function delete_mail($mail_no)
    {
        $query=$this->db_jasgir->query("exec notif_delete_mail '{$mail_no}'");
    }
}
?>