<?php if(5) { ?>
<input type="hidden" id="dlgM11Client_acc_no_h" />
<input type="hidden" id="dlgM11Client_code_h" />
    <table width="100%">
        <tr>
            <td width="25%">User</td>
            <td width="1%">:</td>
            <td><select id="dlgM11Client_user"  name="dlgM11Client_user"></select></td>
        </tr>
        <tr>
            <td>Kode Klien</td>
            <td>:</td>
            <td><input type="text" id="dlgM11Client_code"  name="dlgM11Client_code" style="width:80px;" /></td>
        </tr>
        <tr>
            <td>Nama klien</td>
            <td>:</td>
            <td><input type="text" id="dlgM11Client_name"  name="dlgM11Client_name" style="width:280px;" /></td>
        </tr>
        <tr>
            <td>No Rekening</td>
            <td>:</td>
            <td><input type="text" id="dlgM11Client_acc_no"  name="dlgM11Client_acc_no" style="width:120px;" /></td>
        </tr>
        <tr>
            <td>Nama Bank</td>
            <td>:</td>
            <td><input type="text" id="dlgM11Client_bank"  name="dlgM11Client_bank" style="width:280px;" /></td>
        </tr>
        <tr>
            <td>No. CIF</td>
            <td>:</td>
            <td><input type="text" id="dlgM11Client_cif"  name="dlgM11Client_cif" style="width:80px;" /></td>
        </tr>
        <tr>
            <td>No. CBEST</td>
            <td>:</td>
            <td><input type="text" id="dlgM11Client_cbest"  name="dlgM11Client_cbest" style="width:140px;" /></td>
        </tr>
        <tr>
            <td>Bank Internal</td>
            <td>:</td>
            <td>
            <select id="dlgM11Client_internal"  name="dlgM11Client_internal">
                <option value="1">Internal</option>
                <option value="0">Eksternal</option>
            </select>
            </td>
        </tr>
        <tr>
            <td>Tipe Klien</td>
            <td>:</td>
            <td>
            <select id="dlgM11Client_type"  name="dlgM11Client_type">
                <option value="1">Reksadana</option>
                <option value="2">Unit Link</option>
                <option value="3">Diskree</option>
            </select>
            </td>
        </tr>
        <tr>
            <td>Kena Jasa Giro</td>
            <td>:</td>
            <td>
            <select id="dlgM11Client_jasgir"  name="dlgM11Client_jasgir">
                <option value="1">YA</option>
                <option value="0">TIDAK</option>
            </select>
            </td>
        </tr>
    </table>                 
<?php } ?>