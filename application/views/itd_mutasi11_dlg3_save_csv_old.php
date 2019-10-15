<?php 
if($lvl>-5) { 
    if ($r_num_rows>0) 
    {     
        $str_detail='';                         // echo $incl_sign; print_r($incl);
        $pengurang= count($incl)>1?count($incl):count($incl)==1?$incl[0]==''?0:count($incl):0;
        $cola = $r_num_rows+1;
        if ($incl_sign=='-')
            $cola = $r_num_rows+1-$pengurang;
        else if($incl_sign=='a')
            $cola = $pengurang+1;
        $irow=0;
        $total_giro=0;
        $total_tax=0;
        $total_net=0; 
        $today=getdate();
        $str_today = substr("0".$today["mday"],0,2) . substr("0".$today["mon"],0,2) . substr("0".$today["year"],0,4);
        $field_no=3;
        foreach($r_sdata as $items) 
        { 
            if (trim($items['acc_no'])!='')
            { 
                if( ($incl_sign!='a' && $incl_sign!='-') || ($incl_sign=='a' && in_array($field_no,$incl)) || ($incl_sign=='-' && !in_array($field_no,$incl)))
                {
                    $str_detail.=  $cola. ',A,' . $items['acc_no'] .  ',' . number_format($items['giro_interest_net'],2,'.','') . ',' . substr('000'.$cola,-3)  . $str_today . ',JASA GIRO,JASA GIRO' . "\r\n" ;
                    $irow++;
                    $total_giro+=$items["giro_interest"];
                    $total_tax+=$items["giro_interest_tax"];
                    $total_net+=$items["giro_interest_net"];
                }
                $field_no++;
            } 
        } 
        echo $cola. ',G,079390030000000,' . number_format($total_giro,2,'.','') . ',' . substr('000'.$cola,-3)  . $str_today . ',JASA GIRO,JASA GIRO' . "\r\n" ;
        echo $cola. ',G,079512220000000,' . number_format($total_tax,2,'.','') . ',' . substr('000'.$cola,-3)  . $str_today . ',JASA GIRO,JASA GIRO' . "\r\n" ;
        echo $str_detail;
    }
} 
?>

