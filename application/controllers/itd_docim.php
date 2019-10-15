<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Itd_docim extends CI_Controller { 
    var $isLogin;
    var $data;          
    function __construct()
    {
        parent::__construct();   
        $this->load->helper('url');
        $this->load->library('session');      
        $this->isLogin =   $this->is_login();
        $this->data = array("r_login"=>$this->isLogin,"r_success"=>0, "r_err_desc"=>"", "r_num_rows"=>0, "r_sdata"=>"",
                "url"=>base_url(),"nm"=>$this->session->userdata('itd_nm'),"uid"=>$this->session->userdata('itd_uid'),"lvl"=>$this->session->userdata('itd_lvl'),
                "itd_key"=>$this->session->userdata('itd_key')); 
    }
    function index()
    {
        if($this->isLogin)
            $this->load->view('itd_main',$this->data);    
        else 
            $this->load->view('itd_login',$this->data); 
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
    function get_bilyet_inst_search()
    {
       $param=$this->input->post();
        sql_quot_all($param);
        $this->load->model("M_itd_bilyet");    
        $param["b_val_dt"]=change_dt_format($param["b_val_dt"]);
        $param["b_due_dt"]=change_dt_format($param["b_due_dt"]);
        $data = $this->M_itd_bilyet->get_bilyet_inst_search(trim($param["b_no"]),trim($param["b_ccode"]),trim($param["b_to"]),trim($param["b_cname"]),trim($param["b_bname"]),trim($param["b_val_dt"])==''?'1900-01-01':trim($param["b_val_dt"]),trim($param["b_due_dt"])==''?'1900-01-01':trim($param["b_due_dt"]),trim($param["b_nominal"])==''?-1:trim($param["b_nominal"]),trim($param["b_type"])==''?0:trim($param["b_type"]));
        $fields = array("trx_valuta_date","trx_due_date","dt_in","dt_in1","dt_out");
        add_data_dt_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    } 
    function list_pending_bilyet_inst()
    {
       $param=$this->input->post();
        sql_quot_all($param);
        $this->load->model("M_itd_bilyet");
        $data = $this->M_itd_bilyet->list_pending_bilyet_inst($param["b_tipe"],$param["p_opt"]);
        $fields = array("trx_valuta_date","trx_due_date","dt_in","dt_in1","dt_out");
        add_data_dt_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function get_bilyet_inst_none()
    {
        $param=$this->input->post();
        $this->load->model("M_itd_bilyet");    
        $data = $this->M_itd_bilyet->get_bilyet_inst_none(trim($param["trx_id"]));
        $fields = array("trx_valuta_date","trx_due_date");
        add_data_dt_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function get_bilyet_inst_in()
    {
        $param=$this->input->post();                        
        $this->load->model("M_itd_bilyet");    
        $data = $this->M_itd_bilyet->get_bilyet_inst_in(trim($param["trx_id"]));
        $fields = array("trx_valuta_date","trx_due_date","bilyet_dt_in");
        add_data_dt_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function save_bilyet_inst_in()
    {
        $param=$this->input->post();
        sql_quot_all($param);
        $param["bil_dt"]=change_dt_format($param["bil_dt"]);
        $this->load->model("M_itd_bilyet");    
        $data = $this->M_itd_bilyet->save_bilyet_inst_in(trim($param["trx_id"]),trim($param["bil_dt"]),trim($param["bil_no"]),trim($param["bil_desc"]),$this->data["uid"],(0+trim($param["bil_oncall"])));
        $this->data["r_success"] = 1;
        echo json_encode($this->data);
    } 
    function save_bilyet_inst_out()
    {
        $param=$this->input->post();
        sql_quot_all($param);
        $param["bil_dt"]=change_dt_format($param["bil_dt"]);
        $this->load->model("M_itd_bilyet");    
        $data = $this->M_itd_bilyet->save_bilyet_inst_out(trim($param["trx_id"]),trim($param["bil_dt"]),trim($param["bil_desc"]),$this->data["uid"]);
        $this->data["r_success"] = 1;
        echo json_encode($this->data);
    } 
    function get_list_bilyet_for_print($q)
    {
        $this->load->model("M_itd_bilyet");    
        $data = $this->M_itd_bilyet->get_list_bilyet_for_print(trim($q));
        $fields = array("trx_valuta_date","trx_due_date","dt_in","dt_in1","dt_out");
        add_data_dt_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        $this->load->view('itd_trx_bilyet_print',$this->data);     
    }
    function get_list_bilyet_for_save($q)
    {
        $this->load->model("M_itd_bilyet");    
        $data = $this->M_itd_bilyet->get_list_bilyet_for_print(trim($q));
        $fields = array("trx_valuta_date","trx_due_date","dt_in","dt_in1","dt_out");
        add_data_dt_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        $filename="bilyet_list.xls";
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$filename");
        header("Pragma: no-cache");
        header("Expires: 0");
        $this->load->view('itd_trx_bilyet_print',$this->data);     
    }
    function get_bilyet_status_count()
    {
        $param=$this->input->post();                        
        $this->load->model("M_itd_bilyet");    
        $data = $this->M_itd_bilyet->get_bilyet_status_count();
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
}
        
?>