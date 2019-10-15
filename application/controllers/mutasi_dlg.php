<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mutasi_dlg extends CI_Controller { 
    var $isLogin;
    var $data;          
    function __construct()
    {
        parent::__construct();   
        $this->load->helper('url');
        $this->load->library('session');      
        $this->isLogin =   $this->is_login();
        $this->data = array("r_login"=>$this->isLogin,"r_success"=>0, "r_err_desc"=>"", "r_num_rows"=>0, "r_sdata"=>array(),
                "url"=>base_url(),"uid"=>$this->session->userdata('itd_uid'),"lvl"=>$this->session->userdata('itd_lvl')
                ,"unit"=>$this->session->userdata('itd_user_unit')); 
    } 
    function is_login()
    {
        //echo $this->session->userdata('nama');
        if(trim($this->session->userdata('itd_nm'))!='' && $this->session->userdata('itd_nm'))
            return true;
        return false;
    }
    function v_1()
    {
        if($this->isLogin)
            $this->load->view('itd_mutasi11_dlg1',$this->data);
    }
    function act_1()
    {                    
        $this->load->model("M_mutasi_dlg");  
        $param=$this->input->post();   
        sql_quot_all($param);                           
        $data = $this->M_mutasi_dlg->list_mutasi($param['c_code'],$param['acc_no'],0+$param["i_mon"],0+$param["i_year"]); 
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        $filename="mutasi.xls";
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$filename");
        header("Pragma: no-cache");
        header("Expires: 0");
        $this->load->view('itd_mutasi11_list',$this->data);
    }
    function act_1a()
    {                    
        $this->load->model("M_mutasi_dlg");  
        $param=$this->input->post();   
        sql_quot_all($param);                           
        
        $d1=explode('-',$param["dt"]);
        $e1=mktime(0,0,0,$d1[1],$d1[0],$d1[2]);
        $f1 = getdate($e1);
        
        
        $d2=explode('-',$param["dt1"]);
        $e2=mktime(0,0,0,$d2[1],$d2[0],$d2[2]);
        
        $d =($e2-$e1)/(3600*24);
        
        $irow=0;
        for($i=$f1["mday"];$i<=$f1["mday"]+$d;$i++)
        {
            $dt = getdate(mktime(0,0,0,$f1["mon"],$i,$f1["year"]));
            $data1 = $this->M_mutasi_dlg->list_mutasi_by_dt($param['c_code'],$param['acc_no'],$dt["year"].'-'.$dt["mon"].'-'.$dt["mday"]); 
            if(count($data1)>0)
            {
                $data[$irow]["dt"] = $dt["mday"].'-'.$dt["mon"].'-'.$dt["year"];
                $data[$irow++]["data"]=$data1;
            }
        }
        
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        
        $filename="mutasi.xls";
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$filename");
        header("Pragma: no-cache");
        header("Expires: 0");
        $this->load->view('itd_mutasi11_list',$this->data);
    }
    function v_2()
    {
        if($this->isLogin)
        {
            $this->load->view('itd_mutasi11_dlg2',$this->data);
        }
    }
    function get_last_balance()
    {
        $this->load->model("M_mutasi_dlg");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
        //$param["c_dt"]=change_dt_format($param["c_dt"]);
        $data = $this->M_mutasi_dlg->get_last_balance($param["c_code"],$param["c_accno"]); 
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function add_mutasi_giro()
    {
        $this->load->model("M_mutasi_dlg");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
        $param["v_dt"]=change_dt_format($param["v_dt"]);
        $param["a_dt"]=change_dt_format($param["a_dt"]);
        $param["c_nml"]=str_replace(",","",$param["c_nml"]);
        $param["c_int"]=str_replace(",","",$param["c_int"]);
        $param["c_int_tax"]=str_replace(",","",$param["c_int_tax"]);
        $param["c_int_net"]=str_replace(",","",$param["c_int_net"]); 
        //$data = $this->M_mutasi_dlg->add_mutasi_giro($param["v_dt"],$param["a_dt"],0+$param["c_rate"],0+$param["c_tenor"],0+$param["c_year"],$param["c_code"],$param["c_name"],$param["c_accno"],0+$param["c_nml"],0+$param["c_int"],0+$param["c_int_tax"],0+$param["c_int_net"],0+$param["c_add"],$this->data["uid"]); 
        $data = $this->M_mutasi_dlg->add_mutasi_giro($param["v_dt"],$param["a_dt"],$param["c_rate"],$param["c_tenor"],$param["c_year"],$param["c_code"],$param["c_name"],$param["c_accno"],$param["c_nml"],$param["c_int"],$param["c_int_tax"],$param["c_int_net"],$param["c_add"],$this->data["uid"]); 
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function print_1($giro_id=0)
    {
        $this->load->model("M_mutasi_dlg");
        $data = $this->M_mutasi_dlg->get_giro(0+trim($giro_id));  
        $fields = array("giro_val_date","giro_asof_date");
        add_data_dt_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        $this->load->view('itd_mutasi11_dlg2_print',$this->data);
    }
    
    function v_3()
    {
        if($this->isLogin)
            $this->load->view('itd_mutasi11_dlg3',$this->data);
    }
    function act_3()
    {                    
        $this->load->model("M_mutasi_dlg");  
        $param=$this->input->post();   
        sql_quot_all($param);       
        $this->data["dt"]= $param["dt"];                      
        $param["dt"]=change_dt_format($param["dt"]);
        $data = $this->M_mutasi_dlg->list_jasa_giro_by_date($param["dt"]); 
        $this->data["r_success"] = 1;     
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data; 
        $data1 = $this->M_mutasi_dlg->get_last_param("MUTASI_DLG3_HEADER");
        if(count($data1)<=0)
            $data1=array(0=>array(
                "param1"=>'',"param2"=>'',"param3"=>'',"param4"=>'',"param5"=>'',"param6"=>'',"param7"=>'',"param8"=>'',"param9"=>''
            ));
        $this->data["r_success1"] = 1;
        $this->data["r_num_rows1"] = count($data1);
        $this->data["r_sdata1"]= $data1;
        
        $incl = isset($param["no"])?$param["no"]:'';
        $incl_sign = substr($incl,0,1);
        if($incl_sign =='-' || $incl_sign=='a')
            $incl = substr($incl,1,strlen($incl)-1);
        $this->data["incl_sign"] = $incl_sign;
        $this->data["incl"] = explode(",",$incl);
        $this->load->view('itd_mutasi11_dlg3_print',$this->data);
    }
    function save_3($dt='1900-01-01',$s_no='')
    {                    
        $this->load->model("M_mutasi_dlg");  
        $this->data["dt"]= $dt;                      
    
        $data = $this->M_mutasi_dlg->list_jasa_giro_by_date(change_dt_format($dt)); 
        $this->data["r_success"] = 1;     
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data; 
        $incl = $s_no;
        $incl_sign = substr($incl,0,1);
        if($incl_sign =='-' || $incl_sign=='a')
            $incl = substr($incl,1,strlen($incl)-1);
        $this->data["incl_sign"] = $incl_sign;
        $this->data["incl"] = explode(",",$incl);
        
        $filename="rekap_jasa_giro.xls";
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$filename");
        header("Pragma: no-cache");
        header("Expires: 0");                                    
        $this->load->view('itd_mutasi11_dlg3_save',$this->data);
    }
    function save_3b($dt='1900-01-01',$s_no='')
    {                    
        $this->load->model("M_mutasi_dlg");  
        $this->data["dt"]= $dt;                      
    
        $data = $this->M_mutasi_dlg->list_jasa_giro_by_date(change_dt_format($dt)); 
        $this->data["r_success"] = 1;     
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data; 
        
        $incl = $s_no;
        $incl_sign = substr($incl,0,1);
        if($incl_sign =='-' || $incl_sign=='a')
            $incl = substr($incl,1,strlen($incl)-1);
        $this->data["incl_sign"] = $incl_sign;
        $this->data["incl"] = explode(",",$incl);
        $filename="rekap_jasa_giro.csv";
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$filename");
        header("Pragma: no-cache");
        header("Expires: 0");                                    
        $this->load->view('itd_mutasi11_dlg3_save_csv',$this->data);
    }
    function get_giro_val_asof()
    {
        $this->load->model("M_mutasi_dlg");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
        $param["c_dt"]=change_dt_format($param["c_dt"]);
        $param["v_dt"]=change_dt_format($param["v_dt"]);
        $data = $this->M_mutasi_dlg->get_giro_val_asof($param["c_code"],$param["c_accno"],$param["c_dt"],$param["v_dt"]); 
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
            
        echo json_encode($this->data);
    }
    
    function v_4()
    {
        if($this->isLogin)
            $this->load->view('itd_mutasi11_dlg4',$this->data);
    }
    function get_giro_val_asof_by_user()
    {
        if($this->isLogin)
        {
            $this->load->model("M_mutasi_dlg");  
            $param=$this->input->post();
            if (is_array($param))
            {
                sql_quot_all($param); 
                //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
                $param["c_dt"]=change_dt_format($param["c_dt"]);
                $param["v_dt"]=change_dt_format($param["v_dt"]);
            }
            else
            {
                $param["c_dt"]='1900-01-01';
                $param["v_dt"]='1900-01-01';
            }
            $data = $this->M_mutasi_dlg->get_giro_val_asof_by_user($param["c_dt"],$param["v_dt"],$param["u_id"]); 
            $fields = array("giro_val_date","giro_asof_date");
            add_data_dt_str($data,$fields);
            $this->data["r_success"] = 1;
            $this->data["r_num_rows"] = count($data);
            $this->data["r_sdata"]= $data;
            $this->load->view('itd_mutasi11_dlg4_detail',$this->data);
        }
        
    }
    function get_giro_val_asof_by_user1()
    {
        if($this->isLogin)
        {
            $this->load->model("M_mutasi_dlg");  
            $param=$this->input->post();
            if (is_array($param))
            {
                sql_quot_all($param); 
                //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
                //$param["c_dt"]=change_dt_format($param["c_dt"]);
                $param["v_dt"]=change_dt_format($param["v_dt"]);
            }
            else
            {
                //$param["c_dt"]='1900-01-01';
                $param["v_dt"]='1900-01-01';
            }
            $data = $this->M_mutasi_dlg->get_giro_val_asof_by_user1($param["v_dt"],$param["u_id"]); 
            $fields = array("giro_val_date","giro_asof_date");
            add_data_dt_str($data,$fields);
            $this->data["r_success"] = 1;
            $this->data["r_num_rows"] = count($data);
            $this->data["r_sdata"]= $data;
            $this->load->view('itd_mutasi11_dlg4_detail',$this->data);
        }
        
    }
    function print_4($param='')
    {                                                                        
        $arr_par = explode('_',$param);                    
        if(count($arr_par)==3)
        {
            $arr_par[0]=change_dt_format($arr_par[0]);
            $arr_par[1]=change_dt_format($arr_par[1]);
            $this->load->model("M_mutasi_dlg");
            $data = $this->M_mutasi_dlg->get_giro_val_asof_by_user($arr_par[0],$arr_par[1],$arr_par[2]);  
            $fields = array("giro_val_date","giro_asof_date");
            add_data_dt_str($data,$fields);
            $this->data["r_success"] = 1;
            $this->data["r_num_rows"] = count($data);
            $this->data["r_sdata"]= $data;
            $this->load->view('itd_mutasi11_dlg4_print',$this->data);
        }
    }
    function save_4($param='')
    {    
        $arr_par = explode('_',$param);
        $this->data["r_num_rows"] = 0;                    
        if(count($arr_par)==3)
        {
            $arr_par[0]=change_dt_format($arr_par[0]);
            $arr_par[1]=change_dt_format($arr_par[1]);
            $this->load->model("M_mutasi_dlg");
            $data = $this->M_mutasi_dlg->get_giro_val_asof_by_user($arr_par[0],$arr_par[1],$arr_par[2]);  
            $fields = array("giro_val_date","giro_asof_date");
            add_data_dt_str($data,$fields);
            $this->data["r_success"] = 1;
            $this->data["r_num_rows"] = count($data);
            $this->data["r_sdata"]= $data;
            //$this->load->view('itd_mutasi11_dlg4_print',$this->data);
        }
        $filename="jasa_giro.xls";
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$filename");
        header("Pragma: no-cache");
        header("Expires: 0");
        $this->load->view('itd_mutasi11_dlg4_save',$this->data);
        
    }
    function print_41($param='',$tipe=0)
    {                                                                        
        $arr_par = explode('_',$param);                    
        if(count($arr_par)>=2)
        {
            $arr_par[0]=change_dt_format($arr_par[0]);
            $this->load->model("M_mutasi_dlg");
            $data = $this->M_mutasi_dlg->get_giro_val_asof_by_user1($arr_par[0],$arr_par[1],$tipe);  
            $fields = array("giro_val_date","giro_asof_date");
            add_data_dt_str($data,$fields);
            $this->data["r_success"] = 1;
            $this->data["r_num_rows"] = count($data);
            $this->data["r_sdata"]= $data;
            $this->data["r_ctype"]= $tipe;
            $this->load->view('itd_mutasi11_dlg4_print',$this->data);
        }
    }
    function view_41($param='')
    {                                                                        
        $arr_par = explode('_',$param);                    
        if(count($arr_par)>=2)
        {
            $arr_par[0]=change_dt_format($arr_par[0]);
            $this->load->model("M_mutasi_dlg");
            $data = $this->M_mutasi_dlg->get_giro_val_asof_by_user1($arr_par[0],$arr_par[1]);  
            $fields = array("giro_val_date","giro_asof_date");
            add_data_dt_str($data,$fields);
            $this->data["r_success"] = 1;
            $this->data["r_num_rows"] = count($data);
            $this->data["r_sdata"]= $data;
            $this->load->view('itd_mutasi11_dlg4_view',$this->data);
        }
    }
    function save_41($param='')
    {    
        $arr_par = explode('_',$param);
        $this->data["r_num_rows"] = 0;                    
        if(count($arr_par)>=2)
        {
            $arr_par[0]=change_dt_format($arr_par[0]);
            $this->load->model("M_mutasi_dlg");
            $data = $this->M_mutasi_dlg->get_giro_val_asof_by_user1($arr_par[0],$arr_par[1]);  
            $fields = array("giro_val_date","giro_asof_date");
            add_data_dt_str($data,$fields);
            $this->data["r_success"] = 1;
            $this->data["r_num_rows"] = count($data);
            $this->data["r_sdata"]= $data;
            //$this->load->view('itd_mutasi11_dlg4_print',$this->data);
        }
        $filename="jasa_giro.xls";
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$filename");
        header("Pragma: no-cache");
        header("Expires: 0");
        $this->load->view('itd_mutasi11_dlg4_save',$this->data);
        
    }
}
        
?>