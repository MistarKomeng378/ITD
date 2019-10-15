<?php if(5) { ?>
    <table width="100%">
        <tr>
            <td width="25%">Kode Klien</td>
            <td width="1%">:</td>
            <td><input type="text" id="dlgClientGroup_code"  name="dlgClientGroup_code" style="width:80px;" /></td>
        </tr>
        <tr>
            <td>Nama klien</td>
            <td>:</td>
            <td><input type="text" id="dlgClientGroup_name"  name="dlgClientGroup_name" style="width:280px;" /></td>
        </tr>
        <tr>
            <td>Mail Enable</td>
            <td>:</td>
            <td>
                <select id="dlgClientGroup_enable">
                    <option value="1">Ya</option>
                    <option value="0">Tidak</option>
                </select>
            </td>
        </tr>
        <tr>
            <td valign="top">Mail<br />** Use coma(,) as separator</td>
            <td>:</td>
            <td><textarea id="dlgClientGroup_mail"  name="dlgClientGroup_mail" rows="4" cols="60"></textarea></td>
        </tr>
        <tr>
            <td valign="top">Mail CC<br />** Use coma(,) as separator</td>
            <td>:</td>
            <td><textarea id="dlgClientGroup_mail_cc"  name="dlgClientGroup_mail_cc" rows="4" cols="60"></textarea></td>
        </tr>
    </table>                 
<?php } ?>