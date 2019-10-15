<?php if($lvl>-5) { ?>
<?php if($lvl!=2) { 
$arr_bln = array( 0 => 'Januari',1=>'Februari',2=>'Maret',3=>'April',4=>'Mei',5=>'Juni',6=>'Juni',7=>'Juli',
                8=>'Agustus',9=>'September',10=>'Oktober',11=>'Desember');
$tday= getdate();
?> 
<form action="<?php echo $url ?>index.php/mutasi_dlg/act_1" target="_blank" id="frm_mutasi11_1" method="post">
Bulan : 

<select id="s_mutasi11_dlg1_month" name="i_mon">
<?php
    
    for($imon=0;$imon<=10;$imon++)
        if($imon==$tday["mon"])
            echo "<option value=\"{$imon}\" selected>{$arr_bln[$imon]}</option>\n";
        else
            echo "<option value=\"{$imon}\">{$arr_bln[$imon]}</option>\n";
?>

</select> - <select id="s_mutasi11_dlg1_year" name="i_year">
<?php    
    for($iyear=2012;$iyear<=$tday["year"];$iyear++)
        if($iyear==$tday["year"])
            echo "<option value=\"{$iyear}\" selected>{$iyear}</option>\n";
        else
            echo "<option value=\"{$iyear}\">{$iyear}</option>\n";
?>
</select>

<input type="hidden" id="i_mutasi11_dlg1_c_code" name="c_code" />
<input type="hidden" id="i_mutasi11_dlg1_acc_no" name="acc_no" />
<input type="hidden" id="i_mutasi11_dlg1_c_dt" name="c_dt" />
</form>
<?php } ?>
<?php } ?>