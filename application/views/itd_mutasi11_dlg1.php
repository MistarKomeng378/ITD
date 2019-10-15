<?php if($lvl>-5) { ?>
<?php if($unit!=2) { ?> 
<form action="<?php echo $url ?>index.php/mutasi_dlg/act_1a" target="_blank" id="frm_mutasi11_1" method="post">
Tanggal : <input type="text" id="i_mutasi11_dlg1_dt"  name="dt" style="width:80px;" />
s/d <input type="text" id="i_mutasi11_dlg1_dt1"  name="dt1" style="width:80px;" />
<input type="hidden" id="i_mutasi11_dlg1_c_code" name="c_code" />
<input type="hidden" id="i_mutasi11_dlg1_acc_no" name="acc_no" />
</form>
<?php } ?>
<?php } ?>