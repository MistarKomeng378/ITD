<?php
class M_itd_del extends CI_Model {

    private $q_param = array();

    function __construct()
    {                                     
        parent::__construct();           
        $this->load->database('default');
    }
    function d_client($client_id=0)
    {
        $query=$this->db->query("exec delete_client {$client_id}");
    }
    function d_pic($pic_id=0)
    {
        $query=$this->db->query("exec delete_pic {$pic_id}");
    }
    function d_user($user_id='')
    {
        $query=$this->db->query("exec delete_user {$user_id}");
    }
}
?>