<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subsrd_pay extends CI_Controller { 
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
                ,"itd_user_unit"=>$this->session->userdata('itd_user_unit')); 
    } 
    function is_login()
    {
        if(trim($this->session->userdata('itd_nm'))!='' && $this->session->userdata('itd_nm'))
            return true;
        return false;
    }
    function v_dlg_internal()
    {
        if($this->isLogin)
        {                             
            if($this->data["itd_user_unit"] ==3 || $this->data["itd_user_unit"] == 4) 
                $this->load->view("subsrd_inquery_dlg_internal",$this->data);           
        }
    }
    function v_dlg_eksternal()
    {
        if($this->isLogin)
        {                             
            if($this->data["itd_user_unit"] ==3 || $this->data["itd_user_unit"] == 4) 
                $this->load->view("subsrd_inquery_dlg_eksternal",$this->data);           
        }
    }
    
    function list_data()
    {            
        $this->load->model("M_subsrd_pay");  
        $param=$this->input->post();
        
        if(!isset($param["vdt"]))
            $param["vdt"]='01-01-1900';
        if(!isset($param["vccode"]))
            $param["vccode"]='';
        sql_quot_all($param);      
        
        $param["vdt"]=change_dt_format($param["vdt"]); 
        
        $data = $this->M_subsrd_pay->list_data($param["vdt"],$param["vccode"],$this->data["uid"]); 
        $fields = array("subsrd_date","inst_date","printed_date");
        add_data_dt_str($data,$fields);
        for($i=0;$i<count($data);$i++)
        {
            if($data[$i]["src"]==0)
                $data[$i]["printed_date_s"]='';
        }
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo @json_encode($this->data);
    }
    function get_data()
    {            
        $this->load->model("M_subsrd_pay");  
        $param=$this->input->post();
        
        if(!isset($param["s_dt"]))
            $param["s_dt"]='01-01-1900';
        if(!isset($param["s_code"]))
            $param["s_code"]='';
        if(!isset($param["s_src"]))
            $param["s_src"]='';
        if(!isset($param["s_dst"]))
            $param["s_dst"]='';
        sql_quot_all($param);      
        
        $param["s_dt"]=change_dt_format($param["s_dt"]); 
        $data =  $this->M_subsrd_pay->get_printed_status($param["s_dt"],$param["s_code"],$param["s_src"],$param["s_dst"],$this->data["uid"]); 
        $printed_status=$data[0]["printed_status"]; //print_r($data);
        $data=array(); 
        if ($printed_status>0)
        {
            if($this->data['lvl']>5 && $this->data["itd_user_unit"]==4)
                $data = $this->M_subsrd_pay->get_data_cso($param["s_dt"],$param["s_code"],$param["s_src"],$param["s_dst"],$this->data["uid"]); 
            else if($this->data["itd_user_unit"]==4)
                $data = $this->M_subsrd_pay->get_data_closed($param["s_dt"],$param["s_code"],$param["s_src"],$param["s_dst"],$this->data["uid"]); 
        }
        else if($this->data["itd_user_unit"]==4)
            $data = $this->M_subsrd_pay->get_data_closed($param["s_dt"],$param["s_code"],$param["s_src"],$param["s_dst"],$this->data["uid"]); 
            
        $fields = array("subsrd_date","inst_date","printed_date",'txn_date');
        add_data_dt_str($data,$fields);
        $arr_bln=array(1=>"Januari",2=>"Februari",3=>"Maret",4=>"April",5=>"Mei",6=>"Juni",7=>"Juli",
            8=>"Agustus",9=>"September",10=>"Oktober",11=>"November",12=>"Desember");
        $arr_romawi=array('0','1','2','3','4','5','6','7','8','9','X','XI','XII');
        if(count($data)>0)
        {
            $today=getdate();
            //$data[0]["subsrd_date_s1"]=date_format($data[0]["subsrd_date"],"d")." ".$arr_bln[date_format($data[0]["subsrd_date"],"m")]." ".date_format($data[0]["subsrd_date"],"Y");
            $data[0]["subsrd_date_s1"]=$today["mday"]." ".$arr_bln[$today["mon"]]." ".$today["year"];
            $data[0]["ref_no"]='XXX'.$data[0]["ref_par2"].$arr_romawi[$today["mon"]].'/'.$today['year'];
        }
        
        
        
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo @json_encode($this->data);
    }
    function create_get_cso()
    {
        $this->load->model("M_subsrd_pay");  
        $param=$this->input->post();
        //print_r($param);
        if(!isset($param["s_dt"]))
            $param["s_dt"]='01-01-1900';
        if(!isset($param["s_inst_dt"]))
            $param["s_inst_dt"]='01-01-1900';
        if(!isset($param["s_txn_date"]))
            $param["s_txn_date"]='01-01-1900';
        $param["s_dt"]=change_dt_format($param["s_dt"]); 
        $param["s_inst_dt"]=change_dt_format($param["s_inst_dt"]); 
        $param["s_txn_date"]=change_dt_format($param["s_txn_date"]); 
        sql_quot_all($param);
        
        $data =  $this->M_subsrd_pay->get_printed_status($param["s_dt"],$param["s_code"],$param["s_src"],$param["s_dst"],$this->data["uid"]); 
        if($data[0]["printed_status"]==1 && $this->data["lvl"]>5)
        {
            echo @json_encode(array("err"=>1,"cso_id"=>0));
        }
        $data =  $this->M_subsrd_pay->create_get_cso($param,$this->data["uid"]); 
        if(count($data)>0)
            echo @json_encode(array("err"=>0,"cso_id"=>$data[0]["cso_id"]));
    }
    function print_instruksi($cso_id=0)
    {
        $this->load->model("M_subsrd_pay");
        $data =  $this->M_subsrd_pay->get_cso($cso_id,$this->data["uid"]);      
        if(count($data)>0)
        {
            if($data[0]["printed_status"]==2 && $this->data["lvl"]>5)
            {
                echo "You have no right to reprint!";
                return 0;
            }
            $this->data["r_sdata"]=$data;
            if($data[0]["acc_src_internal"]==0)
                $this->load->view("subsrd_inst_eksternal",$this->data);
            else
                $this->load->view("subsrd_inst_internal",$this->data);
        }
    }
    function create_get_cso_bca()
    {
        $this->load->model("M_subsrd_pay");  
        $param=$this->input->post();
        //print_r($param);
        if(!isset($param["s_dt"]))
            $param["s_dt"]='01-01-1900';
        if(!isset($param["s_inst_dt"]))
            $param["s_inst_dt"]='01-01-1900';
        if(!isset($param["s_txn_date"]))
            $param["s_txn_date"]='01-01-1900';
        $param["s_dt"]=change_dt_format($param["s_dt"]); 
        $param["s_inst_dt"]=change_dt_format($param["s_inst_dt"]); 
        $param["s_txn_date"]=change_dt_format($param["s_txn_date"]); 
        sql_quot_all($param);
        
        $data =  $this->M_subsrd_pay->get_printed_status($param["s_dt"],$param["s_code"],$param["s_src"],$param["s_dst"],$this->data["uid"]); 
        if($data[0]["printed_status"]==1 && $this->data["lvl"]>5)
        {
            echo @json_encode(array("err"=>1,"cso_id"=>0));
        }
        $data =  $this->M_subsrd_pay->create_get_cso($param,$this->data["uid"],0); 
        if(count($data)>0)
            echo @json_encode(array("err"=>0,"cso_id"=>$data[0]["cso_id"]));
    }
    function print_instruksi_bca($cso_id=0)
    {
        $this->load->model("M_subsrd_pay");
        $data =  $this->M_subsrd_pay->get_cso($cso_id,$this->data["uid"]);      
        if(count($data)>0)
        {
            if($data[0]["printed_status"]==2 && $this->data["lvl"]>5)
            {
                echo "You have no right to reprint!";
                return 0;
            }
            $this->data["r_sdata"]=$data;
            if($data[0]["acc_src_internal"]==0)
                $this->load->view("subsrd_inst_eksternal_bca",$this->data);
            
        }
    }
}
        
?>