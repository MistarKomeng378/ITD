<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Itd_report extends CI_Controller { 
    var $isLogin;
    var $data;          
    function __construct()
    {
        parent::__construct();   
        $this->load->helper('url');
        $this->load->library('session');      
        $this->isLogin =   $this->is_login();
        $this->data = array("r_login"=>$this->isLogin,"r_success"=>0, "r_err_desc"=>"", "r_num_rows"=>0, "r_sdata"=>array(),
                "url"=>base_url(),"nm"=>$this->session->userdata('itd_nm'),"lvl"=>$this->session->userdata('itd_lvl')); 
    } 
    function is_login()
    {
        //echo $this->session->userdata('nama');
        if(trim($this->session->userdata('itd_nm'))!='' && $this->session->userdata('itd_nm'))
            return true;
        return false;
    }
    function v_report($m1=0,$m2=0)
    {
        if($this->isLogin)
        {
            if (0+$m1!=0 && 0+$m2!=0)
            {
                $alink = 'itd_report' . (0+$m1) . (0+$m2);
                $this->load->view($alink,$this->data);
            }
            /*switch(0+$m1)
            {
                case 1: 
                    switch(0+$m2)
                    {
                        case 1: $this->load->view('itd_report11',$this->data);
                            break;
                    }             
                    break;
            } */
        }
    }
}
        
?>