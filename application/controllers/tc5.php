<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tc5 extends CI_Controller { 
    var $isLogin;
    var $data;          
    function __construct()
    {
        parent::__construct();   
        $this->load->helper('url');
        $this->load->library('session');      
        $this->isLogin =   $this->is_login();
        $this->data = array("r_login"=>$this->isLogin,"r_success"=>0, "r_err_desc"=>"", "r_num_rows"=>0, "r_sdata"=>"",
                "url"=>base_url(),"nm"=>$this->session->userdata('itd_nm'),"lvl"=>$this->session->userdata('itd_lvl'),
                "itd_key"=>$this->session->userdata('itd_key'),"itd_user_unit"=>$this->session->userdata('itd_user_unit'),
                "uid"=>$this->session->userdata('itd_uid')); 
    }
    
    function is_login()
    {
        //echo $this->session->userdata('nama');
        if(trim($this->session->userdata('itd_nm'))!='' && $this->session->userdata('itd_nm'))
            return true;
        return false;
    }
    function get_login_lvl()
    {
        //echo $this->session->userdata('nama');
        if(trim($this->session->userdata('itd_nm'))!='' && $this->session->userdata('itd_nm'))
            return $this->session->userdata('itd_lvl');
        return 1000000;
    }
    function v_tc5_dlg()
    {
        if($this->isLogin)
            $this->load->view('tc5_dlg',$this->data);
    }
    function list_tc5()
    {
        $param=$this->input->post();                          //  print_r($param);
        $this->load->model("M_tc5");
        $tday= getdate();
        $cdt =$tday["mon"]."/".$tday["mday"]."/".$tday["year"];
        if(cek_date($param["vdt"]))
            $cdt = change_dt_format($param["vdt"]);
        $data = $this->M_tc5->list_tc5($cdt,$param["vccode"],$param["vbank"],$param["vname"]);
        $fields = array("trx_valuta_date");
        add_data_dt_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
     function get_tc5()
    {
        $param=$this->input->post();
        sql_quot_all($param);
        $this->load->model("M_tc5");
        $data = $this->M_tc5->get_tc5($param["pic_id"],$param["trx_id"],$param["unix_no"]);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function save_tc5()
    {
        $param=$this->input->post();
        sql_quot_all($param);
        $this->load->model("M_tc5");  
        $data = $this->M_tc5->save_tc5($param,$this->session->userdata('itd_uid'));
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        //print_r($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function print_tc5($tc5_id=0)
    {
        $this->load->model("M_tc5");  
        $data = $this->M_tc5->get_tc5($tc5_id,0,1);
        $fields = array("trx_valuta_date");
        add_data_dt_str($data,$fields);
        $this->data["r_sdata"]= $data;
        
        if($this->isLogin)
            if($this->session->userdata('itd_user_unit')==4 )
                $this->load->view('tc5_print',$this->data);
    }
    
}
        
?>