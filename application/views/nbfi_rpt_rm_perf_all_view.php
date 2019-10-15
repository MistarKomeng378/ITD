<?php 
if(count($r_rdata_finance)<=0)
{
    echo "No data for this period!";
    exit(0);
}
$arr_month = array('','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Okt','Nov','Dec');    
$arr_month_s=array("","January","February","March","April","May","June","July","August","September","October","November","December");
$arr_finance=array(0=>array('GIRO AVERAGE','giro_average_balance'),
                   1=>array('SA AVERAGE','saving_average_balance'),
                   2=>array('NII GIRO','nii_giro'),
                   3=>array('NII SAVING','nii_saving'),
                   4=>array('NII TD','nii_td'));
foreach($arr_finance as $ritem1)
{
?>
<div align="center" style="font-weight: bolder;"><?php echo $ritem1[0];?> FINANCIAL REPORT as of <?php echo strtoupper($arr_month_s[$par['c_month']]) . " {$par['c_year']}"; ?></div>
<table border="0" bgcolor="#800080" width="100%" style="font-size: 80%;">
<?php
echo "<tr bgcolor=\"#ACACAC\"><td>&nbsp; </td>";
$col_tot=array();
foreach($r_rdata_bt as $xitem1)
{
    echo "<td align=\"right\"><b>{$xitem1['bt_name']}</b></td>";
    $col_tot[$xitem1['bt_name']]=0;
}
echo "<td align=\"right\"><b>Total</b></td>";
echo "</tr>";
$cbt= count($r_rdata_bt)+1;
$sgroup='';
$srm='0000000000000000000000';
$sbt='';
$str='';
$bt_no = 0;
$new_row=false;
$row_tot = 0 ;

foreach($r_rdata_finance as $xitem1)
{
    if( ($sgroup!=$xitem1['group'] || $srm!=$xitem1['rm_desc'])&& $sgroup!='')
    {
        while($bt_no<$cbt-1)
        {
            $str.= "<td></td>";
            $bt_no++;
        }
        $str .= "<td align=\"right\"><b>" . number_format($row_tot,2,'.',',') . "</b></td>";
        $str.="</tr>";
    }
            
    if($srm!=$xitem1['rm_desc'])
    {
        if($srm!='0000000000000000000000')
        {
            $str .= "<tr bgcolor=\"#F0F0F0\"><td>&nbsp;</td>";
            $tot=0;
            foreach($r_rdata_bt as $xitem2)
                if($col_tot[$xitem2['bt_name']]!=0)
                {
                    $str .= "<td align=\"right\"><b>" . number_format($col_tot[$xitem2['bt_name']],2,'.',',') . "</b></td>";
                    $tot += $col_tot[$xitem2['bt_name']];
                }
                else
                    $str .= "<td>&nbsp;</td>";
            
            $str .= "<td align=\"right\"><b>" . ($tot!=0?number_format($tot,2,'.',','):'') . "</b></td></tr>";
        }
        $srm=$xitem1['rm_desc'];
        $str.= "<tr bgcolor=\"#C0C0FF\"><td  colspan=\"". ($cbt+1) ."\"><b>{$srm}&nbsp;</b></td></tr>";
        foreach($r_rdata_bt as $xitem2)
            $col_tot[$xitem2['bt_name']]=0;
    }
    if($sgroup!=$xitem1['group'] || $srm!=$xitem1['rm_desc'])
    {
        $str.="<tr bgcolor=\"#FFFFFF\"><td>{$xitem1['group']}</td>";
        
        $sgroup=$xitem1['group'];
        $bt_no=0;
        $row_tot=0;
    }
    while($r_rdata_bt[$bt_no]['bt_name']!=$xitem1['bt_name'] && $bt_no<$cbt)
    {
        $str .= "<td></td>";
        $bt_no++;
        
    }
    if($bt_no<$cbt)
    {
        $str .="<td align=\"right\">" . ($xitem1[$ritem1[1]]!=0?number_format($xitem1[$ritem1[1]],2,'.',','):'')  . "</td>";
        $col_tot[$xitem1['bt_name']] += $xitem1[$ritem1[1]];
        $row_tot += $xitem1[$ritem1[1]];
        $bt_no++;
    }
}
if($sgroup!='')
{
    while($bt_no<$cbt-1)
    {
        $str.= "<td></td>";
        $bt_no++;
    }
    $str .= "<td align=\"right\"><b>" . ($row_tot!=0?number_format($row_tot,2,'.',','):'') . "</b></td>";
    $str.="</tr>";
}
if($srm!='0000000000000000000000')
{
    $str .= "<tr bgcolor=\"#F0F0F0\"><td>&nbsp;</td>";
    $tot=0;
    foreach($r_rdata_bt as $xitem2)
        if($col_tot[$xitem2['bt_name']]!=0)
        {
            $str .= "<td align=\"right\"><b>" . ($col_tot[$xitem2['bt_name']]!=0?number_format($col_tot[$xitem2['bt_name']],2,'.',','):'') . "</b></td>";
            $tot += $col_tot[$xitem2['bt_name']];
        }
        else
            $str .= "<td>&nbsp;</td>";
    
    $str .= "<td align=\"right\"><b>" . ($tot!=0?number_format($tot,2,'.',','):'') . "</b></td></tr>";
}
echo $str; 

?>
</table>
<br /> <br />
<?php }?>