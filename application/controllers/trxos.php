<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trxos extends CI_Controller { 
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
    
    function u()
    {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'txt|csv';
        $config['max_size']    = '0';
        $config['max_width']  = '0';
        $config['max_height']  = '0';
        
        
        $param = $this->input->post(); 
        
        sql_quot_all($param);
        
        $dt1= !isset($param['dt'])?'': change_dt_format($param["dt"]); 
        $this->load->library('upload', $config);
        if ( $this->upload->do_upload('f') )
        { 
            $data=$this->upload->data();
            $separator = ',';    /** separator used to explode each line */
            $enclosure = '"';    /** enclosure used to decorate each field */
            $max_row_size = 4096;    /** maximum row size to be used for decoding */
            
            $handle = fopen($data["full_path"], "r");
            $row_count=0;
            $row_insert=0;    
            
            $this->load->model("M_trxos");
            $this->M_trxos->c($dt1);
            while( ($row = fgetcsv($handle, $max_row_size, $separator, $enclosure)) != false) {            
                if( $row[0] != null ) { // skip empty lines
                    $row_count++;
                    if(count($row)==9)
                    {
                        sql_quot_all($row);
                        if(trim($row[0])!='' && trim($row[0])!='TRADE DATE')
                        {                        
                            
                            $rdt1=explode('/',$row[0]);
                            $rdt2=explode('/',$row[1]);
                            $dt_t=$rdt1[1].'/'.$rdt1[0].'/20'.$rdt1[2];
                            $dt_s=$rdt2[1].'/'.$rdt2[0].'/20'.$rdt2[2];
                            if(date_create($dt_t)==date_create($dt1))
                                $this->M_trxos->u($dt_t,$dt_s,$row[2],$row[3],$row[4],$row[5],$row[6],$row[7],$row[8]);
                        }
                    }
                }
            }
            fclose($handle);
        }
    }
    function l()
    {
        $param=$this->input->post();                          //  print_r($param);
        $this->load->model("M_trxos");
        $tday= getdate();             
        $dt =$tday["mon"]."/".$tday["mday"]."/".$tday["year"];
        if(cek_date($param["dt"]))
            $dt = change_dt_format($param["dt"]);
        $data = $this->M_trxos->l($dt);
        $fields = array("trade_date",'settle_date');
        add_data_dt_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function p($pdt='')
    {
        $tday= getdate();             
        $dt =$tday["mon"]."/".$tday["mday"]."/".$tday["year"];
        if(cek_date($pdt))
            $dt = change_dt_format($pdt);
        $this->load->model("M_trxos");
        $this->data['r_data'] = $this->M_trxos->l($dt);
        $this->load->view('trxos_view',$this->data);     
    }
    
}
        
?>