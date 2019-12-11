<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Itd_duedate extends CI_Controller { 
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
    function list_data()
    {
        $param=$this->input->post();
        $this->load->model("M_itd_duedate");
        $tday= getdate();
        $cdt =$tday["mon"]."/".$tday["mday"]."/".$tday["year"];
        if(cek_date($param["trx_dt"]))
            $cdt = change_dt_format($param["trx_dt"]);
        $data = $this->M_itd_duedate->list_data($cdt,0);
        $fields = array("trx_valuta_date","trx_due_date","trx_create_dt");
        add_data_dt_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);   
    }

    function filter_data()
    {
        $param=$this->input->post();
        $this->load->model("M_itd_duedate");

        $tday= getdate();
        $cdt =$tday["mon"]."/".$tday["mday"]."/".$tday["year"];

        if(cek_date($param["trx_sdt"]))
            $cdt = change_dt_format($param["trx_sdt"]);

        if(cek_date($param["trx_edt"]))
            $edt = change_dt_format($param["trx_edt"]);

        $data = $this->M_itd_duedate->filter_data($cdt,2,$edt);
        $fields = array("trx_valuta_date","trx_due_date","trx_create_dt");
        add_data_dt_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);   
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

    function save_to_excel($sdt,$edt)
    {
        if(cek_date($sdt))
            $cdt = change_dt_format($sdt);

        if(cek_date($edt))
            $edt = change_dt_format($edt);

        $this->load->model("M_itd_duedate");
        $data = $this->M_itd_duedate->filter_data($cdt,2,$edt);
        
        $fields = array("trx_valuta_date","trx_due_date","trx_create_dt");
        add_data_dt_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        // echo json_encode($this->data);
        
        $filename="deposito_jatuh_tempo ".$cdt." s.d ".$edt.".xls";
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$filename");
        header("Pragma: no-cache");
        header("Expires: 0");
        
        $this->load->view('deposito_jatuh_tempo_excel',$this->data);
    }

    public function debug()
    {
        $this->load->model("M_itd_duedate");
        $tday= getdate();
        $cdt =$tday["mon"]."/".$tday["mday"]."/".$tday["year"];
        $data = $this->M_itd_duedate->list_data($cdt,1);
        echo json_encode($data);
    }
    
}
        
?>