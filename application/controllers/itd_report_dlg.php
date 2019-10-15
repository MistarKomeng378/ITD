<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Itd_report_dlg extends CI_Controller { 
    var $isLogin;
    var $data;
    var $today;
    function __construct()
    {
        parent::__construct();   
        $this->load->helper('url');
        $this->load->library('session');      
        $this->isLogin =   $this->is_login();
        $this->today = getdate();
        $this->data = array("r_login"=>$this->isLogin,"r_success"=>0, "r_err_desc"=>"", "r_num_rows"=>0, "r_sdata"=>array(),
                "url"=>base_url(),"nm"=>$this->session->userdata('itd_nm'),"lvl"=>$this->session->userdata('itd_lvl'),
                "today_s"=>substr('0' . $this->today["mon"],-2) . '/' . substr('0' . $this->today["mday"],-2) . '/' . substr('0' . $this->today["year"],-4)); 
        
    } 
    function is_login()
    {
        //echo $this->session->userdata('nama');
        if(trim($this->session->userdata('itd_nm'))!='' && $this->session->userdata('itd_nm'))
            return true;
        return false;
    }
    function v_dlg_report_search($m1=0,$m2=0)
    {
        if($this->isLogin)
        {                                        
            if (0+$m1!=0 && 0+$m2!=0)
            {
                $alink = 'itd_dlg_report' . (0+$m1) . (0+$m2) .'_search';
                $this->load->view($alink,$this->data);
            }
            /*switch(0+$m1)
            {
                case 1: 
                    switch(0+$m2)
                    {
                        case 1: $this->load->view('itd_report_dlg11',$this->data);
                            break;
                    }             
                    break;
            } */
        }
    }
    
    function report11_search()
    {
        $param=$this->input->post();
        sql_quot_all($param);
        
        if($param["s_dt"]=="")
            $param["s_dt"]='01/01/1900';
        if($param["e_dt"]=="")
            $param["e_dt"]='01/01/1900';
        $this->data['s_dt'] = $param['s_dt'];
        $this->data['e_dt'] = $param['e_dt'];        
        $this->data['tipe'] =0+$param['tipe'];        
        $this->data['th'] =0+$param['th'];        
        $this->data["r_success"]=1;
        $this->load->model("M_itd_report_dlg");     
        $param["s_dt"] = change_dt_format($param["s_dt"]);
        $param["e_dt"] = change_dt_format($param["e_dt"]);
        
        $this->data['r_sdata'] = $this->M_itd_report_dlg->report11_search(0+$param["tipe"],$param["c_code"],$param["s_dt"],$param["e_dt"]);
        $fields = array("trx_valuta_date","trx_due_date");
        add_data_dt_str($this->data['r_sdata'],$fields);
        $this->load->view("itd_report11",$this->data);
        /*$fields = array("trx_valuta_date","trx_due_date");
        add_data_dt_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);*/
    }
    function report11_search_save($c_code='',$th='',$s_dt='1900-01-01',$e_dt='1900-01-01',$tipe=1)
    {
        
        $this->data['s_dt'] = $s_dt==''?'1900-01-01':$s_dt;
        $this->data['e_dt'] = $e_dt==''?'1900-01-01':$e_dt;
        
        $this->data['tipe'] =0+$tipe;        
        $this->data['th'] =0+$th;        
        $this->data["r_success"]=1;
        $this->load->model("M_itd_report_dlg");     
        $param["s_dt"] = change_dt_format($this->data['s_dt']);
        $param["e_dt"] = change_dt_format($this->data['e_dt']);
        
        $this->data['r_sdata'] = $this->M_itd_report_dlg->report11_search(0+$tipe,$c_code,$param["s_dt"],$param["e_dt"]);
        $fields = array("trx_valuta_date","trx_due_date");
        add_data_dt_str($this->data['r_sdata'],$fields);
        $filename="rekap.xls";
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$filename");
        header("Pragma: no-cache");
        header("Expires: 0");
                                     
        $this->load->view("itd_report11_save",$this->data);
        /*$fields = array("trx_valuta_date","trx_due_date");
        add_data_dt_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);*/
    }
}
        
?>