<?php if(5) { ?>
    <table width="100%">
        <tr>
            <td>Tanggal Balance</td>
            <td width="1%">:</td>
            <td><input type="text" id="i_dlgSubsDlg_dt"  name="i_dlgSubsDlg_dt"  class="dtpick" style="width: 80px; text-align: center;"  /></td>
        </tr>
    </table>          
    <div id="div_dlgSubsDlg_h">
    <form id="frm_dlgSubsDlg_h" action="<?php echo $url . "index.php/subscript/save_subs";?>" method="post" target="_blank">
        <input type="hidden"  id="i_dlgSubsDlg_dt_h"  name="b_dt" />
        <input type="hidden"  id="i_dlgSubsDlg_ccode_h"  name="b_ccode" />
        <input type="hidden"  id="i_dlgSubsDlg_bcode_h"  name="b_code" />
        <input type="hidden"  id="i_dlgSubsDlg_accno_h"  name="b_accno" />
    </form>
    </div>
<?php } ?>