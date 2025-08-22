<?php
$sql_cusBranch = $mysqli->query("SELECT `ID`, `br_id`, `opertionName`, `optionPath`, `report_name`, `order`, `backup`  
FROM `optiontb`  
WHERE `opertionName` = 'All Branch Report' AND `optionPath` = 'YES'");  

$br_qry = ($sql_cusBranch->num_rows > 0) ? "" : "WHERE br_id = '$br_id'";  

$sql_cusLast = $mysqli->query("SELECT CustomerID, cusName, TelNo, Address FROM custtable $br_qry ORDER BY ID DESC LIMIT 1");  
$cusLast = $sql_cusLast->fetch_array();

$sql_selectRight = $mysqli->query("SELECT `ID` FROM `user_rights` WHERE user_id = '$user_id' AND page_id = '137'");
$RightCount = $sql_selectRight->num_rows;

if ($RightCount == true) {
    if (is_numeric($cusLast[0])) {
        $autoID = $cusLast[0] + 1;
        $idDisabe = 'style="pointer-events: none;"';
    } else {
        $autoID = '';
        $idDisabe = '';
    }
} else {
    $autoID = '';
    $idDisabe = '';
}
echo '<button class="btn btn-success btn-xs Cus_saveData pull-right" type="button">Save</button>';
$sql_cusName = $mysqli->query("SELECT CustomerID FROM custtable ORDER BY CustomerID DESC LIMIT 1");


if ($sql_cusName && $customer = $sql_cusName->fetch_array()) {
    echo '<p style="font-weight:bold; color:red;">Last Created Customer ID In Full Company: ' . $customer[0] . '</p>';
}
?>

<table class="table table-striped table-bordered custmCretTB custForm">
    <tbody>
        <tr>
            <td>Customer ID </td>
            <td>
                <input type="hidden" id="custIDHidn" name="custIDHidn" />

                <input type="text" class="customerID" name="custID" value="<?php echo $autoID ?>" required <?php echo $idDisabe ?> />
                <label class="reqireLbl"> * [ <?php echo $cusLast[0] ?> ]</label>
                <img src="../img/ajax-loaders/ajax-loader-1.gif" id="ajax_img_lod" />
            </td>
        </tr>

        <tr>
            <td>Name </td>
            <td>
                <input type="text" class="customerName" style="width:200px" name="cname" placeholder=""
                    required />
                <label class="reqireLbl"> * </label>
                <img src="../img/ajax-loaders/ajax-loader-1.gif" id="ajax_img_lod" />
            </td>
        </tr>

        <tr>
            <td>Address </td>
            <td>
                <input type="text" class="" style="width:300px" name="address" />
            </td>
        </tr>

        <tr>

            <td> Area : </td>
            <td>
                <input class="input-sm length" type="text" id="area_name" name="area_name"
                    style="width: 100%;" list="area_nam">

                <datalist id="area_nam">

                    <?php

                    $qry_area = $mysqli->query("SELECT distinct `area` FROM `custtable`");

                    while ($exc_qry = $qry_area->fetch_array()) {

                        echo '<option value="' . $exc_qry[0] . '">' . $exc_qry[0] . '</option>';
                    }
                    ?>

                </datalist>
            </td>
        </tr>

        <tr>
            <td>Credit Limit </td>
            <td>
                <input type="number" class="cashTxt" style="text-align:right " name="creditLmt" placeholder="" />
            </td>
        </tr>
        <tr>
            <td>Due Days </td>
            <td>
                <input type="number" class="form-control dueDays" style="text-align:right " name="dueDays" />
            </td>
        </tr>

        <tr>
            <td>Discount Level </td>
            <td>
                <select class="" name="disLevl" id="discnLevl">
                    <option> None</option>
                    <option value="Level 1">Level 1</option>
                    <option value="Level 2">Level 2</option>
                    <option value="Level 3">Level 3</option>
                    <option value="Level 4">Level 4</option>
                    <option value="Level 5">Level 5</option>
                </select>
                <label style="font-size:9px;padding-left:20px"> Press tab key to move to next field </label>
            </td>
        </tr>

        <tr>
            <td>Telephone </td>
            <td>
                <input type="tel" class="" style="" name="telphone" placeholder="011 243 5467" pattern="[0-9]{3} [0-9]{3} [0-9]{4}"
                    maxlength="12" title="Ten digits code" />
                <label style="font-size:9px;padding-left:20px"> Eg : 081 222 2224 </label>
            </td>
        </tr>

        <tr>
            <td>Fax </td>
            <td>
                <input type="tel" class="" style="" name="fax" placeholder="021 243 5467" pattern="[0-9]{3} [0-9]{3} [0-9]{4}"
                    maxlength="12" />
            </td>
        </tr>

        <tr>
            <td>Email </td>
            <td>
                <input type="email" id="cusEmail" style="" name="cusEmail" placeholder="exsample@alax.lk"
                    pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" />
            </td>
        </tr>
        <?php


        $hidde_rep = '';


        echo ' <tr ' . $hidde_rep . '>  
                    	<td>Salesman </td>                                                     		
                        <td>                              	
                            <select  name="salRep" id="salRepID" style="padding-top: 4px;"  >
                                <option ></option>';

        $sql_slRep = $mysqli->query("SELECT ID, Name FROM salesrep WHERE `br_id`='$br_id' ");
        while ($slRep = $sql_slRep->fetch_array()) {
            echo '<option value="' . $slRep['ID'] . '">' . $slRep['Name'] . '</option>';
        }

        echo ' </select>
                        </td>  
                     </tr>';
        ?>
        <tr>
            <td>Dealer Code</td>
            <td>
                <input type="text" name="Dcode" placeholder="00001" title="Type Dealer Code" />
            </td>
        </tr>
        <tr>
            <td>Active</td>
            <td>
                <input type="CHECKBOX" name="active" id="active" class="active" value="YES" checked />
            </td>
        </tr>


    </tbody>
</table>
<fieldset>
    <legend style="width:auto;border-bottom:0px;font-size:12px;font-weight:bold;margin-bottom:0px;">Extra Details</legend>

    <table class="table table-striped table-bordered custmCretTB">
        <tbody>
            <tr>
                <td>Mobile No</td>
                <td>
                    <input type="text" class="" style="" name="moblNo" placeholder="077 773 5467" pattern="[0-9]{3} [0-9]{3} [0-9]{4}"
                        maxlength="12" title="Ten digits code" />
                </td>
            </tr>

            <tr>
                <td>Customer Type </td>
                <td>
                    <Select name="cus_deal_typ2" id="cus_deal_typ2" ;>
                        <option value="CUSTOMER">Customer</option>
                        <option value="DEALER">Dealer</option>
                    </Select>
                </td>
            </tr>

            <tr>
                <td>Date </td>
                <td>
                    <div class="controls" style="padding-top:0px;margin-bottom:5px;margin-left:-15px">
                        <div align="left" class="col-sm-10 input-append date datePicker"
                            data-date="" data-date-format="yyyy-mm-dd"
                            data-link-field="bil_date" data-link-format="yyyy-mm-dd">
                            <input size="16" type="text" name="createDate" id="createDate" value="<?php echo date('Y-m-d') ?>"
                                readonly class="form-control" style="width:80px; border-radius: 0px;" />
                            <span class="add-on" style=""><i class="icon-th"></i></span>
                        </div>
                    </div>
                </td>
            </tr>

            <tr>
                <td>Other Name </td>
                <td>
                    <input type="text" class="" style="" name="othrName" placeholder="" />
                </td>
            </tr>
            <tr>
                <td>Price </td>
                <td>
                    <input type="number" class="txt_price" style="" name="txt_price" placeholder="" />
                </td>
            </tr>
            <tr>
                <td>Cus.VAT </td>
                <td>
                    <input type="checkbox" class="chk_vat" style="" name="chk_vat" />
                    <input type="text" class="txt_Vno" style="" name="txt_Vno" placeholder="VAT NO" hidden />
                </td>
            </tr>
            <tr>
                <td>Bank Details </td>
                <td>
                    <input type="text" class="txt_BKdet" style="width:95%;" name="txt_BKdet" placeholder="Bank Details" />
                </td>
            </tr>


            <tr>
                <td>Owner Name</td>
                <td>
                    <input type="text" class="txt_owner" style="width:95%;" name="txt_owner" placeholder="Owner Name" />
                </td>

            </tr>

            <tr>
                <td> Owner Date of Birth</td>
                <td>
                    <input type="DATE" class="txt_owner_bod" style="width:95%;" name="txt_owner_bod" />
                </td>

            </tr>

            <tr>
                <td>Pur.Officer Name </td>
                <td>
                    <input type="text" class="txt_pur_office" style="width:95%;" name="txt_pur_office"
                        placeholder="Purchase Officer Name" />
                </td>
            </tr>
            <tr>
                <td>Customer Source</label> </td>
                <td>
                    <input type="text" id="source_from" name="source_from" list="source_from-list" Class="form-control">
                    <datalist id="source_from-list">
                                                                <?php
                                                                    $sql_src = $mysqli->query("SELECT source_from FROM custtable WHERE br_id = '$br_id' GROUP BY source_from");
                                                                    while($sorc = $sql_src->Fetch_assoc()){
                                                                        echo '<option value="'.$sorc['source_from'].'">';
                                                                    }
                                                                ?>
                                                                
                                                            </datalist>
                </td>
            </tr>

        </tbody>
    </table>
</fieldset>
<script>
    $(document).on('click', '#cusCreate', function() {

        $('#Customer_Create').css({
            'z-index': '9999999'
        });
        $('.modalSeachDialog').css({
            'width': '80%'
        });
        $('#Customer_Create').modal('show');
    });

    $(document).on('click', '.Cus_saveData', function() {
        var count = requFiledValidte();

        if (count == 0) {
            var cusMail = $('#cusEmail').val();
            if ($.trim(cusMail) !== '') {

                if (ValidateEmail($.trim(cusMail)) == true) {
                    saveCus();
                } else {
                    emailFail();
                }

            } else {
                saveCus();
            }
        } else {
            alert("Please fill all required fields");
        }
    });

    function emailFail() {
        alert('Email address does not valid');

    }

    function saveCus() {
        var pathss = '<?php echo $ajxPath ?>'

        $.blockUI({
            css: {
                border: 'none',
                padding: '15px',
                backgroundColor: '#000',
                '-webkit-border-radius': '10px',
                '-moz-border-radius': '10px',
                opacity: .5,
                color: '#fff'
            }
        });

        $.ajax({
            url: pathss+'new/ajx/custmerSave.php',
            data: $('#orderForm').serialize(),
            type: 'POST',
            success: function(data) {
                $('#Customer_Create').modal('hide');
                if (data.trim() == 'Ok') {
                    //window.location = 'create_Customer.php';
                    $('#responseSpanCus').html('Successfully Saved..');
                    $.blockUI({
                        message: $('#creatCusMsg')
                    });
                    $('.blockMsg').css({
                        'background': '#fff',
                        'border-radius': '10px',
                        'border': '#fff 3px',
                        'box-shadow': '0 3px 7px rgba(0, 0, 0, 0.3)',
                        'background-clip': 'padding-box'
                    });

                    var CusID = $('.customerID').val();

                    QR_CUSTOMER(CusID);
                    $('#cus_all').prop('checked', true);

                    $('#itemNo_1').focus();

                } else {
                    $('#responseSpanCus').html(data.trim());
                    $.blockUI({
                        message: $('#creatCusMsg')
                    });
                    $('.blockMsg').css({
                        'background': '#fff',
                        'border-radius': '10px',
                        'border': '#fff 3px',
                        'box-shadow': '0 3px 7px rgba(0, 0, 0, 0.3)',
                        'background-clip': 'padding-box'
                    });
                }
                
            }
        });
    }

    function ValidateEmail(email) {
        var expr =
            /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        return expr.test(email);
    }

    function requFiledValidte() {
        var countValid = 0;
        $('.custForm :input[required]').each(function() {
            if ($(this).val().trim() == '') {
                countValid++;
                $(this).focus();
            }
        });
        return countValid;
    }
</script>