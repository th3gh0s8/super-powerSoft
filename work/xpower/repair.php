  <?php
  $title = 'Repair | xPower';
  $pageRights = 'Distributor/xPowerRepair/repair';

  include('path.php');
  include($path . 'header.php');
  include($path . 'connection.php');
  $paths = '../../';
  ?>

  </head>

  <body class="nav-sm">
    <div class="container body">
      <div class="main_container">
        <?php
        include('InvStyle.php');
        include($path . 'side.php');
        include($path . 'mainBar.php');

        $sql_findStorePrint1 = $mysqli->query("SELECT `PrintNm` FROM `all_print_type` WHERE  `Form` = 'Repair Print' AND br_id='$br_id' ");
        if ($sql_findStorePrint1->num_rows > 0) {
          $findStorePrint1 = $sql_findStorePrint1->fetch_array();
          $storePrintNm1 = $findStorePrint1['PrintNm'];
        } else {
          $storePrintNm1 = 'printPage';
        }
        echo '<input type="hidden" id="prntHidden" class="prntHidden" value="' . $storePrintNm1 . '">';

        ?>
        <link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet" />
        <style>
          .chosen-search-input {
            height: 33px !important;
          }

          .chosen-container-multi {
            width: 100% !important;
          }

          .chosen-container-multi .chosen-choices {
            border: 1px solid #d6d6dc !important;
            border-radius: 3px !important;
          }

          .chosen-container-multi .chosen-choices li.search-choice {
            margin: 8px 5px 3px 0 !important;
          }

          .itemmmesnme:hover {
            background-color: yellow;
          }

          .listItemHov-class:hover {
            background-color: yellow;
          }
        </style>

        <script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="container">
            <div class="row">
              <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="x_panel inv_head">
                  <!-- left part -->
                  <h2 class="text-primary" style="margin-bottom: 25px;"><b>Item Report</b></h2>

                  <div class="col-md-6">
                    <p>Device Name : <span id="devicename"></span></p>
                    <p>Sold Date : <span id="soldDate"></span></p>
                    <p>Sold Before : <span id="purchasebefore"></span></p>
                    <p>Sales person : <span id="salesperson"></span></p>
                  </div>

                  <div class="col-md-6">
                    <p>Customer Name : <span id="cusName"></span></p>
                    <p>Mobile : <span id="cusMob"></span></p>
                    <p>Address : <span id="cusAddr"></span></p>
                  </div>

                </div>

                <div class="repairHistory" id="repairHistory"></div>
              </div>


              <form id="myForm">
                <div class="col-md-6 col-sm-12 col-xs-12 ">
                  <div class="x_panel inv_head">
                    <div class="row" style="margin-top:20px;">
                      <div class="col-md-6" style="text-align:left;">
                        <span class="text-primary" style="margin-bottom: 25px; font-size:25px; font-weight:bold; color:#3daae9;"><b>Repair Request</b></span>
                      </div>
                      <div class="col-md-6" style="text-align:right;">
                        <?php
                        $sql_getLatJobNo = $mysqli->query("SELECT jobNo, inv_id FROM `repair_tb` ORDER BY ID DESC limit 1");
                        $getLatJobNo = $sql_getLatJobNo->fetch_array(MYSQLI_ASSOC);
                        if ($getLatJobNo != '') {
                          echo "<span class='text-primary' style='color: #0a2402; font-size:25px; font-weight:bold;'><b>Last Job No: " . $getLatJobNo['jobNo'] . "</b></span>";
                        }
                        // if ($getLatJobNo['inv_id'] == 0) {
                        //   echo "<span class='text-primary' style='color: #0a2402; font-size:25px; font-weight:bold;'><b>Last Inv No: " . $getLatJobNo['inv_id'] . "</b></span>";
                        // }
                        ?>
                      </div>
                    </div>
                    <div class="row mb-4" style="padding:10px;">
                      <div class="col-md-3">
                        <input type="radio" name="JTP" checked="checked" id="serialNo" value="SerialNo">SERIAL-NO<br>
                      </div>
                      <div class="col-md-3">
                        <input type="radio" name="JTP" id="jobNo" value="JOBNO">JOB-NO<br>
                      </div>
                    </div>
                    <div style="position: relative;">
                      <div class="row" style="padding: 0px;margin-bottom:20px;">
                        <div class="col-md-5 col-sm-5 col-xs-5">
                          <label style="margin-bottom: 0px;"> Enter Serial No </label>
                          <input type="text" name="imeiNo" id="imeiNo" class="form-control" placeholder="Serial No">
                        </div>
                        <div class="col-md-5 col-sm-5 col-xs-5">
                          <label style="margin-bottom: 0px;"> Repair Type </label>
                          <div class="custom-select" style="width:100%;">
                            <select name="warrantyType" class="form-control form-control-user" id="warrantyType">
                              <option value="Device Repair">Device Repair</option>
                              <option value="Accessory Repair">Accessory Repair</option>
                            </select>
                          </div>
                        </div>

                        <div class="col-md-2  col-sm-2 col-xs-2">
                          &nbsp;
                          <button class="btn btn-primary btn_load" style="width:100%;padding: 7.5px;" type="button">Load</button>
                        </div>
                      </div>
                    </div>
                    <div style="position: relative; top: 10; display: none;" class="RepairForm">
                      <div class="container">
                        <div class="row">
                          <div class="form-group col-md-6 col-sm-6 col-xs-6" style="margin-bottom: 5px;">
                            <label for="inputEmail4" style="margin-bottom: 0px;">Customer Name</label><label style="color: red;">*</label>
                            <input type="text" name="Cusname" id="Cusname" class="form-control" placeholder="Customer name" />
                            <div style="z-index: 1000; position: absolute; background-color: #c9c9c9; width: 94%;" id="customerList"></div>
                            <input type="hidden" id="customerID" class="customerID" name="customerID" value="" readonly />
                          </div>
                          <div class="form-group col-md-1 col-sm-1 col-xs-1" style="margin-bottom: 15px;">
                            <label for="inputEmail4" style="margin-bottom: 0px;">&nbsp;</label>
                            <button type="button" title="Create new customer" style="margin-0px;width: 100%;line-height:0.9px;font-size: 20px; margin: 0; padding: 0;" name="cusCreate" id="cusCreate" class="btn btn-info form-control"> + </button>
                          </div>

                          <div class="form-group col-md-5 col-sm-5 col-xs-5" style="margin-top: 10px;">
                            <label for="inputEmail4" style="margin-bottom: 0px;">Mobile No</label>
                            <input type="text" class="form-control" name="mobileNo" id="mobileNo" placeholder="Customer mobile no">
                          </div>
                        </div>
                        <div class="row">
                          <div class="form-group col-md-12 col-sm-12 col-xs-12">
                            <label for="inputEmail4" style="margin-bottom: 0px;">Address</label>
                            <input type="text" class="form-control address" name="address" id="address" placeholder="Customer address">
                          </div>
                        </div>


                        <div class="row">
                          <div class="form-group col-md-6 col-sm-6 col-xs-6" style="margin-bottom: 10px;">
                            <label for="inputEmail4" style="margin-bottom: 0px;">Item name</label><label style="color: red;">*</label>
                            <input type="text" name="Itemmsname" id="Itemmsname" class="form-control Itemmsname" placeholder="Item name" />
                            <div style="z-index: 1000; position: absolute; background-color: #c9c9c9; width: 94%;" id="ItemmsList"></div>
                            <input type="hidden" id="itemmsID" class="itemmsID" name="itemmsID" value="" readonly />
                          </div>
                          <div class="form-group col-md-6 col-sm-6 col-xs-6">
                            <label style="margin-bottom: 0px;"> Salesman </label>
                            <div class="custom-select " style="width:100%">
                              <select name="salesmanvalue" class="form-control form-control-user salesmanvalue" id="salesmanvalue">
                                <?php
                                $query = $mysqli->query("SELECT ID, Name FROM salesrep WHERE br_id=$br_id");
                                $i = 0;
                                while ($row = $query->fetch_array()) {
                                ?>
                                  <option value="<?php echo $row["ID"]; ?>"><?php echo $row["Name"]; ?></option>
                                <?php
                                }
                                ?>
                              </select>
                            </div>
                          </div>

                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <label>Brand</label>
                            <input type="text" name="brand" class="form-control brand" id="brand" placeholder="Enter Item Brand">
                            <div style="z-index: 1000; position: absolute; background-color: #c9c9c9; width: 94%;" id="brandList"></div>
                          </div>
                          <div class="col-md-6">
                            <label>Model</label>
                            <input type="text" name="itemModal" class="form-control itemModal" id="itemModal" placeholder="Enter Item Model">
                            <div style="z-index: 1000; position: absolute; background-color: #c9c9c9; width: 94%;" id="modelList"></div>
                          </div>
                          <div class="col-md-6">
                            <label>Color</label>
                            <input type="text" name="color" id="color" class="form-control color" placeholder="Enter Item Color" />
                            <div style="z-index: 1000; position: absolute; background-color: #c9c9c9; width: 94%;" id="colorList"></div>
                          </div>
                          <div class="col-md-6">
                            <label>Passcode</label>
                            <input type="text" name="passcode" class="form-control passcode" id="passcode" placeholder="Enter Passcode">
                          </div>
                        </div>
                        <div class="row">
                          <?php
                          $sql_repairDetails = $mysqli->query("SELECT `repair_accessories`, `repair_faults` FROM com_brnches WHERE ID = $br_id");
                          $repairDetails = $sql_repairDetails->fetch_assoc();

                          $repairFaults = explode(",", $repairDetails['repair_faults']);
                          ?>
                          <div class="form-group col-md-5 col-sm-5 col-xs-5">
                            <label for="inputEmail4" style="margin-bottom: 0px;">Fault<span style="color: red">*</span></label>
                            <select data-placeholder="Select issue type" multiple class="chosen-select form-group form-control form-control-user fault" name="fault[]" id="fault" style="border-radius: 3px;height: 33px;">
                              <?php
                              foreach ($repairFaults as $repairFault) {
                                echo '<option value="' . $repairFault . '">' . $repairFault . '</option>';
                              }
                              ?>
                            </select>
                          </div>
                          <div class="col-md-1 col-sm-1 cos-xs-1">
                            <label>&nbsp;</label>
                            <button type="button" class="btn btn-success btn-sm addFault" data-toggle="modal" data-target="#faultModal"><span style="padding:5px;">+</span></button>
                          </div>
                          <div class="form-group col-md-5 col-sm-5 col-xs-5">
                            <label for="inputAddress" style="margin-bottom: 0px;">Accessory Received<span style="color: red;">*</span></label>
                            <select data-placeholder="Select Accessories Received" multiple class="chosen-select form-group form-control form-control-user accessoriesReceived" name="accessoriesReceived[]" id="accessoriesReceived" style="border-radius: 3px; height: 33px;">
                              <?php
                              $sql_repairDetails = $mysqli->query("SELECT `repair_accessories`, `repair_faults` FROM com_brnches WHERE ID = $br_id");
                              $repairDetails = $sql_repairDetails->fetch_assoc();
                              $repairAccessories = explode(",", $repairDetails['repair_accessories']);
                              foreach ($repairAccessories as $repairAccessorie) {
                                echo '<option value="' . $repairAccessorie . '">' . $repairAccessorie . '</option>';
                              }
                              ?>
                            </select>
                          </div>
                          <div class="col-md-1 col-sm-1 cos-xs-1">
                            <label>&nbsp;</label>
                            <button type="button" class="btn btn-success btn-sm addAcc" data-toggle="modal" data-target="#accModal"><span style="padding:5px;">+</span></button>
                          </div>

                        </div>




                        <div class="row">
                          <div class="form-group col-md-6 col-sm-6 col-xs-6">
                            <input type="hidden" name='caseId' id='caseId' class='caseId'>
                            <label for="inputAddress" style="margin-top: 1px;">Deposit</label>
                            <input type="text" class="form-control" name="depositAmt" id="depositAmt" placeholder="Deposit amount">
                          </div>

                          <div class="form-group col-md-6 col-sm-6 col-xs-6">
                            <label for="inputAddress" style="margin-top: 1px;">Warranty Type</label>
                            <select id="warrantytypeDet" name="warrantytypeDet" class="form-select form-control form-control-user warrantytypeDet" aria-label="Default select example">
                              <option selected value="">Choose warranty type</option>
                              <option value="warranty">Warranty</option>
                              <option value="non-warranty">Non-Warranty</option>
                              <option value="pending">Pending</option>
                            </select>
                          </div>
                        </div>


                        <div class="row">
                          <div class="form-group col-md-6 col-sm-6 col-xs-6">
                            <label for="inputAddress" style="margin-top: 1px;">Established Cost</label>
                            <input type="text" class="form-control" name="eCost" id="eCost" placeholder="Enter Costt">
                          </div>

                          <div class="form-group col-md-6 col-sm-6 col-xs-6">
                            <label for="inputAddress" style="margin-top: 1px;">Estimated Delivery Date</label>
                            <input type="date" class="form-control" name="eDelDate" id="eDelDate">

                          </div>
                        </div>

                        <div class="row">
                          <div class="form-group col-md-6 col-sm-6 col-xs-6">
                            <label for="inputEmail4" style="margin-bottom: 0px;">Remarks</label>
                            <input type="text" class="form-control" name="remarks" id="remarks" placeholder="Remarks">
                          </div>
                          <div class="row">
                          <div class="form-group col-md-6 col-sm-6 col-xs-6">
                            <label for="inputEmail4" style="margin-bottom: 0px;">Assign Service Person</label>
                            <select name="serviceP" id="serviceP" class="serviceP form-control">
                              <option value=""></option>
                              <?php
                              	$sql_salesrepDetail = $mysqli->query("SELECT ID, Name FROM salesrep WHERE Actives = 'YES' AND rep_level='Servicemen'");
                                while ($salesrepDetail = $sql_salesrepDetail->fetch_array()) {
                                  echo '<option value="'.$salesrepDetail['ID'].'">'.$salesrepDetail['Name'].'</option>';
                                }
                              
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <button type="button" class="btn btn-success btn_save" style="float: right; padding: 7.5px; width: 100px;">Save</button>
                            <button type="button" style="display: none; float: right; padding: 7.5px; width: 100px;" class="btn btn-info savenew">Save as New</button>
                          </div>
                        </div>
                      </div>
                    </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!--<div class="modal fade" id="Customer_Create" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="">-->
    <!--  <div class="modal-dialog" style="width:80%;">-->
    <!--    <div class="modal-content modalSeachDialog">-->
    <!--      <div class="modal-header" style="background: #5CB85C;border-top-left-radius: 4px;border-top-right-radius: -->
    <!--                                    4px;border-bottom: 2px solid #4D7579;">-->
    <!--        <button type="button" class="close" data-dismiss="modal">×</button>-->
    <!--        <h3 style="margin:15px 0px 0px 0px;color:rgba(46, 27, 71, 0.72);"> Create Customer </h3>-->
    <!--      </div>-->
    <!--      <div class="modal-body">-->
    <!--        <form id="orderForm">-->

    <!--          ?php-->
    <!--          $sql_cusLast = $mysqli->query("SELECT CustomerID, cusName, TelNo, Address FROM custtable ORDER BY ID DESC LIMIT 01");-->
    <!--          $cusLast = $sql_cusLast->fetch_array();-->

    <!--          $sql_selectRight = $mysqli->query("SELECT `ID` FROM `user_rights` WHERE user_id = '$user_id' AND page_id = '137'");-->
    <!--          $RightCount = $sql_selectRight->num_rows;-->

    <!--          if ($RightCount == true) {-->
    <!--            if (is_numeric($cusLast[0])) {-->
    <!--              $autoID = $cusLast[0] + 1;-->
    <!--              $idDisabe = 'style="pointer-events: none;"';-->
    <!--            } else {-->
    <!--              $autoID = '';-->
    <!--              $idDisabe = '';-->
    <!--            }-->
    <!--          } else {-->
    <!--            $autoID = '';-->
    <!--            $idDisabe = '';-->
    <!--          }-->
    <!--          ?>-->
    <!--          <button class="btn btn-success btn-xs Cus_saveData" type="button">Save</button>-->
    <!--          <table class="table table-striped table-bordered custmCretTB custForm">-->
    <!--            <tbody>-->
    <!--              <tr>-->
    <!--                <td>Customer ID </td>-->
    <!--                <td>-->
    <!--                  <input type="hidden" id="custIDHidn" name="custIDHidn" />-->

    <!--                  <input type="text" class="CussID" name="custID" value="?php echo $autoID ?>" required ?php echo $idDisabe ?> />-->
    <!--                  <label class="reqireLbl"> * [ ?php echo $cusLast[0] ?> ]</label>-->
    <!--                  <img src="../img/ajax-loaders/ajax-loader-1.gif" id="ajax_img_lod" />-->
    <!--                </td>-->
    <!--              </tr>-->

    <!--              <tr>-->
    <!--                <td>Name </td>-->
    <!--                <td>-->
    <!--                  <input type="text" class="customerName" style="width:200px" name="cname" placeholder="" required />-->
    <!--                  <label class="reqireLbl"> * </label>-->
    <!--                  <img src="../img/ajax-loaders/ajax-loader-1.gif" id="ajax_img_lod" />-->
    <!--                </td>-->
    <!--              </tr>-->

    <!--              <tr>-->
    <!--                <td>Address </td>-->
    <!--                <td>-->
    <!--                  <input type="text" class="cusAddress" style="width:300px" name="address" />-->
    <!--                </td>-->
    <!--              </tr>-->

    <!--              <tr>-->

    <!--                <td> Area : </td>-->
    <!--                <td>-->
    <!--                  <input class="input-sm length" type="text" id="area_name" name="area_name" style="width: 100%;" list="area_nam">-->

    <!--                  <datalist id="area_nam">-->

    <!--                    ?php-->

    <!--                    $qry_area = $mysqli->query("SELECT distinct `area` FROM `custtable`");-->

    <!--                    while ($exc_qry = $qry_area->fetch_array()) {-->

    <!--                      echo '<option value="' . $exc_qry[0] . '">' . $exc_qry[0] . '</option>';-->
    <!--                    }-->
    <!--                    ?>-->

    <!--                  </datalist>-->
    <!--                </td>-->
    <!--              </tr>-->

    <!--              <tr>-->
    <!--                <td>Credit Limit </td>-->
    <!--                <td>-->
    <!--                  <input type="number" class="cashTxt" style="text-align:right " name="creditLmt" placeholder="" />-->
    <!--                </td>-->
    <!--              </tr>-->

    <!--              <tr>-->
    <!--                <td>Discount Level </td>-->
    <!--                <td>-->
    <!--                  <select class="" name="disLevl" id="discnLevl">-->
    <!--                    <option> None</option>-->
    <!--                    <option value="Level 1">Level 1</option>-->
    <!--                    <option value="Level 2">Level 2</option>-->
    <!--                    <option value="Level 3">Level 3</option>-->
    <!--                    <option value="Level 4">Level 4</option>-->
    <!--                    <option value="Level 5">Level 5</option>-->
    <!--                  </select>-->
    <!--                  <label style="font-size:9px;padding-left:20px"> Press tab key to move to next field </label>-->
    <!--                </td>-->
    <!--              </tr>-->

    <!--              <tr>-->
    <!--                <td>Telephone </td>-->
    <!--                <td>-->
    <!--                  <input type="tel" class="cusPhone" style="" name="telphone" placeholder="011 243 5467" pattern="[0-9]{3} [0-9]{3} [0-9]{4}" maxlength="12" title="Ten digits code" />-->
    <!--                  <label style="font-size:9px;padding-left:20px"> Eg : 081 222 2224 </label>-->
    <!--                </td>-->
    <!--              </tr>-->

    <!--              <tr>-->
    <!--                <td>Fax </td>-->
    <!--                <td>-->
    <!--                  <input type="tel" class="" style="" name="fax" placeholder="021 243 5467" pattern="[0-9]{3} [0-9]{3} [0-9]{4}" maxlength="12" />-->
    <!--                </td>-->
    <!--              </tr>-->

    <!--              <tr>-->
    <!--                <td>Email </td>-->
    <!--                <td>-->
    <!--                  <input type="email" id="cusEmail" style="" name="cusEmail" placeholder="exsample@alax.lk" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" />-->
    <!--                </td>-->
    <!--              </tr>-->
    <!--              ?php-->


    <!--              $hidde_rep = '';-->


    <!--              echo ' <tr ' . $hidde_rep . '>  -->
    <!--                	<td>Salesman </td>                                                     		-->
    <!--                    <td>                              	-->
    <!--                        <select  name="salRep" id="salRepID" style="padding-top: 4px;"  >-->
    <!--                            <option ></option>';-->

    <!--              $sql_slRep = $mysqli->query("SELECT ID, Name FROM salesrep WHERE `br_id`='$br_id' ");-->
    <!--              while ($slRep = $sql_slRep->fetch_array()) {-->
    <!--                echo '<option value="' . $slRep['ID'] . '">' . $slRep['Name'] . '</option>';-->
    <!--              }-->

    <!--              echo ' </select>-->
    <!--                    </td>  -->
    <!--                 </tr>';-->
    <!--              ?>-->
    <!--              <tr>-->
    <!--                <td>Dealer Code</td>-->
    <!--                <td>-->
    <!--                  <input type="text" name="Dcode" placeholder="00001" title="Type Dealer Code" />-->
    <!--                </td>-->
    <!--              </tr>-->
    <!--              <tr>-->
    <!--                <td>Active</td>-->
    <!--                <td>-->
    <!--                  <input type="CHECKBOX" name="active" id="active" class="active" value="YES" checked />-->
    <!--                </td>-->
    <!--              </tr>-->


    <!--            </tbody>-->
    <!--          </table>-->
    <!--          <fieldset>-->
    <!--            <legend style="width:auto;border-bottom:0px;font-size:12px;font-weight:bold;margin-bottom:0px;">Extra Details</legend>-->

    <!--            <table class="table table-striped table-bordered custmCretTB">-->
    <!--              <tbody>-->
    <!--                <tr>-->
    <!--                  <td>Mobile No</td>-->
    <!--                  <td>-->
    <!--                    <input type="text" class="" style="" name="moblNo" placeholder="077 773 5467" pattern="[0-9]{3} [0-9]{3} [0-9]{4}" maxlength="12" title="Ten digits code" />-->
    <!--                  </td>-->
    <!--                </tr>-->

    <!--                <tr>-->
    <!--                  <td>Customer Type </td>-->
    <!--                  <td>-->
    <!--                    <Select name="cus_deal_typ2" id="cus_deal_typ2" ;>-->
    <!--                      <option value="CUSTOMER">Customer</option>-->
    <!--                      <option value="DEALER">Dealer</option>-->
    <!--                    </Select>-->
    <!--                  </td>-->
    <!--                </tr>-->

    <!--                <tr>-->
    <!--                  <td>Date </td>-->
    <!--                  <td>-->
    <!--                    <div class="controls" style="padding-top:0px;margin-bottom:5px;margin-left:-15px">-->
    <!--                      <div align="left" class="col-sm-10 input-append date datePicker" data-date="" data-date-format="yyyy-mm-dd" data-link-field="bil_date" data-link-format="yyyy-mm-dd">-->
    <!--                        <input size="16" type="text" name="createDate" id="createDate" value="<?php echo date('Y-m-d') ?>" readonly class="form-control" style="width:80px; border-radius: 0px;" />-->
    <!--                        <span class="add-on" style=""><i class="icon-th"></i></span>-->
    <!--                      </div>-->
    <!--                    </div>-->
    <!--                  </td>-->
    <!--                </tr>-->

    <!--                <tr>-->
    <!--                  <td>Other Name </td>-->
    <!--                  <td>-->
    <!--                    <input type="text" class="" style="" name="othrName" placeholder="" />-->
    <!--                  </td>-->
    <!--                </tr>-->
    <!--                <tr>-->
    <!--                  <td>Price </td>-->
    <!--                  <td>-->
    <!--                    <input type="number" class="txt_price" style="" name="txt_price" placeholder="" />-->
    <!--                  </td>-->
    <!--                </tr>-->
    <!--                <tr>-->
    <!--                  <td>Cus.VAT </td>-->
    <!--                  <td>-->
    <!--                    <input type="checkbox" class="chk_vat" style="" name="chk_vat" />-->
    <!--                    <input type="text" class="txt_Vno" style="" name="txt_Vno" placeholder="VAT NO" hidden />-->
    <!--                  </td>-->
    <!--                </tr>-->
    <!--                <tr>-->
    <!--                  <td>Bank Details </td>-->
    <!--                  <td>-->
    <!--                    <input type="text" class="txt_BKdet" style="width:95%;" name="txt_BKdet" placeholder="Bank Details" />-->
    <!--                  </td>-->
    <!--                </tr>-->


    <!--                <tr>-->
    <!--                  <td>Owner Name</td>-->
    <!--                  <td>-->
    <!--                    <input type="text" class="txt_owner" style="width:95%;" name="txt_owner" placeholder="Owner Name" />-->
    <!--                  </td>-->

    <!--                </tr>-->

    <!--                <tr>-->
    <!--                  <td> Owner Date of Birth</td>-->
    <!--                  <td>-->
    <!--                    <input type="DATE" class="txt_owner_bod" style="width:95%;" name="txt_owner_bod" />-->
    <!--                  </td>-->

    <!--                </tr>-->

    <!--                <tr>-->
    <!--                  <td>Pur.Officer Name </td>-->
    <!--                  <td>-->
    <!--                    <input type="text" class="txt_pur_office" style="width:95%;" name="txt_pur_office" placeholder="Purchase Officer Name" />-->
    <!--                  </td>-->
    <!--                </tr>-->
    <!--                <tr>-->
    <!--                  <td><label for="cusSource">Customer Source</label> </td>-->
    <!--                  <td>-->
    <!--                    <input type="text" id="source_from" name="source_from" list="source_from-list" Class="form-control">-->
    <!--                    <datalist id="source_from-list">-->
    <!--                      <option value="Facebook">-->
    <!--                      <option value="Twitter">-->
    <!--                      <option value="Instagram">-->
    <!--                      <option value="LinkedIn">-->
    <!--                      <option value="Snapchat">-->
    <!--                      <option value="TikTok">-->
    <!--                      <option value="YouTube">-->
    <!--                      <option value="Pinterest">-->
    <!--                      <option value="Reddit">-->
    <!--                      <option value="Tumblr">-->
    <!--                      <option value="WhatsApp">-->
    <!--                      <option value="Telegram">-->
    <!--                      <option value="Discord">-->
    <!--                      <option value="Vimeo">-->
    <!--                      <option value="Flickr">-->
    <!--                      <option value="Quora">-->
    <!--                      <option value="WeChat">-->
    <!--                      <option value="Twitch">-->
    <!--                      <option value="Signal">-->
    <!--                      <option value="Line">-->
    <!--                      <option value="Baidu Tieba">-->
    <!--                      <option value="VK (VKontakte)">-->
    <!--                    </datalist>-->
    <!--                  </td>-->
    <!--                </tr>-->

    <!--              </tbody>-->
    <!--            </table>-->
    <!--          </fieldset>-->
    <!--        </form>-->
    <!--      </div>-->
    <!--      <div class="modal-footer">-->
    <!--        <button class="btn btn-danger btn-xs" type="button" data-dismiss="modal">Close</button>-->
    <!--      </div>-->
    <!--    </div>-->
    <!--  </div>-->
    <!--</div>-->

    <div id="creatCusMsg" style="display:none;">
      <div class="errConfrmHaed"> Warning ! </div>
      <span style="color:#F00" id="responseSpanCus"> </span>
      <br />

      <button type="button" class="btn btn-default blockUIClosBtn" style="" />Ok</button>
    </div>

    <div class="modal fade" id="accModal" tabindex="-1" role="dialog" aria-labelledby="accModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="accModalLabel">Add Accessory</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <input type="text" class="form-control accInput" id="accInput" name="accInput" placeholder="Add Accessory">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary modalUpdate">Update</button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="faultModal" tabindex="-1" role="dialog" aria-labelledby="faultModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="faultModalLabel">Add Faults</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <input type="text" class="form-control faultInput" id="faultInput" name="faultInput" placeholder="Add Faults">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary modalUpdate1">Update</button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="Customer_Create" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="">
                            <div class="modal-dialog">
                                <div class="modal-content modalSeachDialog">
                                    <div class="modal-header" style="background: #5CB85C;border-top-left-radius: 4px;border-top-right-radius: 
                                        4px;border-bottom: 2px solid #4D7579;">
                                        <button type="button" class="close" data-dismiss="modal">×</button>
                                        <h3 style="margin:15px 0px 0px 0px;color:rgba(46, 27, 71, 0.72);"> Create Customer </h3>
                                    </div>
                                    <div class="modal-body">
                                    <?php   $ajxPath = '../../'; ?>
                                    <form id="orderForm">
                                        <?php include(''.$paths.'Invoice/customer_create.php'); ?>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-danger btn-xs" type="button" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
    <script>
      /*$(".chosen-select").chosen({
        no_results_text: "Oops, nothing found!"
      });*/

      $(document).on('click', '.btn_save', function(e) {
        e.preventDefault();
        saveData();
      })

      function saveData() {

        var finalRaioBtn = $('input[name="JTP"]:checked').val();

        if ($('.fault').val() != null && $('.accessoriesReceived').val() != null && $("#salesmanvalue").val() != '') {
          var mForm = $('#myForm')[0];
          var formData = new FormData(mForm);
          formData.append("btnMainSave", 'saveRepairs'); 
          formData.append("finalRaioBtn", finalRaioBtn);

          $.ajax({ 
            url: 'ajx/repairAjx.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json', 
            success: function(response) {
              if (response.status == 'DataSavedSuccessfully') {
                var imeiNo = $('#imeiNo').val();
                var warrantyType = $('#warrantyType').val();
                autoLoadOnLoad(imeiNo, warrantyType, finalRaioBtn);
                
                if(response.serviceP != ''){
                    $.ajax({
                        url:'../Repairs/ajxRepair.php',
                        type:'post',
                        dataType:'json',
                        data:{btn:'btnAddStatusAssign', 'repairTb':response.id, 'formNo': '5', 'repTb':response.serviceP, 'accessoryCheck':$('.accessoriesReceived').val()}, 
                        success:function (data) {
                            
                        }
                    });
                }
                window.open(`prints/<?php echo $storePrintNm1; ?>.php?id=${response.id}&repId=${response.repID}&jobNo=${response.jobNo}`);
                
              } else if (response.status == 'DataUpdatedSuccessfully') {
                var imeiNo = $('#imeiNo').val();
                var warrantyType = $('#warrantyType').val();
                autoLoadOnLoad(imeiNo, warrantyType, finalRaioBtn)
              } else {
                alert("Sorry! Something went wrong from our end. Please try again or call Powersoft Pvt Ltd.")
              }
              $('#depositAmt').val('')
              $('#warrantytypeDet').val('')
            }
          })
        } else {
          alert("Mandatory fileds are empty!!")
        }
      }

      $(document).on('click', '.btn_load', function(e) {
        e.preventDefault();
        var RadioButtonVals = $('input[name="JTP"]:checked').val();
        var finalRaioBtn = '';
        if (RadioButtonVals == 'JOBNO') {
          finalRaioBtn = RadioButtonVals;
        } else {
          finalRaioBtn = RadioButtonVals;
        }
        console.log(finalRaioBtn)
        var imeiNo = $('#imeiNo').val();
        var warrantyType = $('#warrantyType').val();
        var jobNo = $('#jobNo').val();
        var serialNo = $('#serialNo').val();
        if (finalRaioBtn != undefined) {
          autoLoadOnLoad(imeiNo, warrantyType, finalRaioBtn)
        } else {
          alert('Please Select your prefered method, Serial No or job No first')
        }

      })

      function autoLoadOnLoad(imeiNo, warrantyType, finalRaioBtn) {
        var prntHidden = $('#prntHidden').val();
        $.ajax({
          url: 'ajx/repairAjx.php',
          type: 'post',
          dataType: 'json',
          data: {
            imeiNo: imeiNo,
            warrantyType: warrantyType,
            'btns': 'searchImei',
            finalRaioBtn: finalRaioBtn,
            'prntHidden': prntHidden
          },
          success: function(data) {
            if (data.status == 'true') {
              $('#salesperson').html(data.salesperson.Name);
              $('.repairHistory').html(data.warrantyTable);
              $('.accessoriesReceived').val('').trigger("chosen:updated");
              $('.fault').val('').trigger("chosen:updated");
              $('#sub').html("Save");

              $('.serviceP').val(data.repairSt)


              $('.RepairForm').show();
              if (data.imeiDet !== null) {
                $('#devicename').html(data.imeiDet.Description);
                $('#soldDate').html(data.imeiDet.Date);

                $('.Itemmsname').val(data.imeiDet.Description);
                $('.itemmsID').val(data.imeiDet.ID);
                $('.itemmNo').val(data.imeiDet.ItemNO)

                var dbDate = data.imeiDet.Date;

                const date1 = new Date(dbDate);

                var today = new Date();
                var dd = String(today.getDate()).padStart(2, '0');
                var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                var yyyy = today.getFullYear();

                today = yyyy + '-' + mm + '-' + dd;

                const date2 = new Date(today);
                const diffTime = Math.abs(date2 - date1);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                $('#purchasebefore').html(diffDays + " Days");
              } else {
                //$('.itemmsID').val(data.imeiDet.itemID);
                //$('.itemmNo').val(data.imeiDet.ItemNo)
              }



              $('#cusName').html(data.cusDet.cusName);
              $('.customerID').val(data.cusDet.ID)
              $('#cusMob').html(data.cusDet.TelNo);
              $('#cusAddr').html(data.cusDet.Address);

              $('#address').val(data.cusDet.Address);
              $('#mobileNo').val(data.cusDet.TelNo)

              $('#Cusname').val(data.cusDet.cusName)
              $('#mobileNo').val(data.cusDet.TelNo)
              // $('.salesmanvalue').val(data.salesperson.Name)
              $("#salesmanvalue").val(data.salesperson.ID);

              $('#remarks').val('')


            } else {
              $('.RepairForm').hide();
              alert('No data found with this serial number. Please try again.');
            }
          }
        })
      }

      $(document).on('click', '.editDataDet', function(e) {
        e.preventDefault();
        var editId = $(this).attr('editId');
        $.ajax({
          url: 'ajx/repairAjx.php',
          type: 'post',
          dataType: 'json',
          data: {
            editId: editId,
            'btnDet': 'editData'
          },
          success: function(data) {
            $('#mobileNo').val(data.imeiDet.cusMobNo)
            $('#Cusname').val(data.imeiDet.cusName)
            $('#address').val(data.imeiDet.cusAddress)

            $('.serviceP').val(data.repairSt)

            $('#brand').val(data.imeiDet.itmBrand)
            $('#itemModal').val(data.imeiDet.itmModal)
            $('#color').val(data.imeiDet.itmColor)
            $('#passcode').val(data.imeiDet.devicePasscode)

            $('#eCost').val(data.imeiDet.estimated_cost)
            $('#eDelDate').val(data.imeiDet.estimated_delivery_date)

            $('#remarks').val(data.imeiDet.remarks)
            $('#accessoriesReceived').val(data.imeiDet.accessoryReceived.split(', ')).trigger("chosen:updated");
            $('#depositAmt').val(data.imeiDet.depositAmount)
            $('#caseId').val(data.imeiDet.ID)
            $('#warrantytypeDet').val(data.imeiDet.warrantyType)
            $('.customerID').val(data.imeiDet.cusTb)

            $('.Itemmsname').val(data.imeiDet.itmName);
            $('.itemmsID').val(data.imeiDet.ItemID);
            $('.itemmNo').val(data.imeiDet.ItemNo)

            var faultArray = data.imeiDet.fault.split(', ');
            $('.fault').val(faultArray).trigger("chosen:updated");
            $("#salesmanvalue").val(data.salesRep.ID);
            $('.btn_save').html("Update");
            $('.savenew').show();
          }
        })
      })

      $('#Cusname').on('keyup focusout', function(event) {
        var query = $(this).val();

        if (event.type === 'keyup' && query != '') {
          $.ajax({
            url: "ajx/repairAjx.php",
            method: "POST",
            data: {
              query: query,
              "btn": "getCustomersNames"
            },
            success: function(data) {
              $('#customerList').fadeIn();
              $('#customerList').html(data);
            }
          });
        } else if (event.type === 'focusout' || query == '') {
          $('#customerList').fadeOut(); // Hide the div when textbox is empty or loses focus
        }
      });


      $(document).on('click', '.cutomnme', function(e) {
        e.preventDefault()
        $('.customerID').val($(this).attr('rvt'))
        $('#Cusname').val($(this).text());
        $('#customerList').fadeOut();
        $('#address').val($(this).attr('cusAddressFixed'));
        $('#mobileNo').val($(this).attr('cusmobileNo'))
      })


      // ITEM NAME
      $(document).ready(function() {
        $('#Itemmsname').keyup(function() {
          var queryz = $(this).val();
          if (queryz != '') {
            $.ajax({
              url: "ajx/repairAjx.php",
              method: "POST",
              data: {
                queryz: queryz,
                "btn": "getItemNames"
              },
              success: function(datas) {
                $('#ItemmsList').fadeIn();
                $('#ItemmsList').html(datas);
              }
            });
          }
        });
      });

      $(document).on('click', '.savenew', function(e) {
        $('#caseId').val('');
        saveData();
      });

      $(document).on('click', '.itemmmesnme', function(e) {
        e.preventDefault()
        $('.itemmsID').val($(this).attr('rvtItem'))
        // $('.itemmNo').val($(this).attr('ItemNOS'))
        $('#Itemmsname').val($(this).text());
        $('#ItemmsList').fadeOut();
      })

      // $(document).on('click', '.cusButton', function() {

      //   $('#Customer_Create').css({
      //     'z-index': '9999999'
      //   });
      //   $('.modalSeachDialog').css({
      //     'width': '80%'
      //   });
      //   $('#Customer_Create').modal('show');
      // });

      // $(document).on('click', '.Cus_saveData', function() {
        
      //   var count = requFiledValidte();

      //   if (count == 0) {
      //     var cusMail = $('#cusEmail').val();
      //     if ($.trim(cusMail) !== '') {

      //       if (ValidateEmail($.trim(cusMail)) == true) {
      //         saveCus();
      //       } else {
      //         emailFail();
      //       }

      //     } else {
      //       saveCus();
      //     }
      //   } else {
      //     alert("Please fill all required fields");
      //   }
      // });

      

      

      
      // $(document).ready(function() {
      //   $(document).on('focusout', '#imeiNo', function() {
      //     var thisVal = $(this).val();
      //     $.ajax({
      //       type: "POST",
      //       url: "ajx/serialCheck.php",
      //       data: {
      //         'btn': 'serialBtn',
      //         'serialcode': thisVal
      //       },
      //       dataType: "json",
      //       success: function(res) {
      //         if (res.status == 201) {
      //           alert('This serial is already in use. Please enter another serial no to continue.')
      //           $('#imeiNo').val('')
      //           $('#imeiNo').focus()
      //         } else {

      //         }

      //       }
      //     });
      //   });
      // });

      // $(document).ready(function() {
      //   $(document).on('keyup', '#imeiNo', function() {
      //     var thisVal = $(this).val();
      //     var thisEle = $(this);
      //     var thisSpan = $('#thisspan'); // Cache the span element

      //     $.ajax({
      //       type: "POST",
      //       url: "ajx/serialCheck.php",
      //       data: {
      //         'btn': 'serialBtn',
      //         'serialcode': thisVal
      //       },
      //       dataType: "json",
      //       success: function(res) {
      //         if (res.status == 201) {
      //           $('.btn_save').prop('disabled', true);
      //           $('.btn_save').css('opacity', '0.4');

      //           // Display the error message
      //           if (thisSpan.length === 0) {
      //             thisEle.after('<span id="thisspan" style="color:red;">Serial No Already Exist!</span>');
      //           }
      //         } else {
      //           $('.btn_save').prop('disabled', false);
      //           $('.btn_save').css('opacity', '1');

      //           // Remove the error message
      //           thisSpan.remove();
      //         }
      //       }
      //     });
      //   });
      // });

      $(document).on('click', '.modalUpdate', function() {
        var accInput = $('.accInput').val();

        $.ajax({
          type: "POST",
          url: "ajx/addMore.php",
          data: {
            'btn': 'updateBtn',
            accInput: accInput
          },
          dataType: "json",
          success: function(res) {
            $('#accModal').modal('hide')
            if (res.status == 200) {
              var newOption = new Option(res.type, res.type, true, true);
              $(".accessoriesReceived").append(newOption).trigger("chosen:updated");
            }
          }
        });


      });
      $(document).on('click', '.modalUpdate1', function() {
        var faultInput = $('.faultInput').val();
        $.ajax({
          type: "POST",
          url: "ajx/addMore.php",
          data: {
            'btn': 'updateBtn1',
            faultInput: faultInput
          },
          dataType: "json",
          success: function(res) {
            $('#faultModal').modal('hide')
            if (res.status == 201) {
              var newOption1 = new Option(res.type, res.type, true, true);
              $(".fault").append(newOption1).trigger("chosen:updated");
            }

          }
        });


      });

      $('#color').on('keyup focusout', function(event) {
        var query = $(this).val();

        if (event.type === 'keyup' && query != '') {
          $.ajax({
            url: "ajx/repairAjx.php",
            method: "POST",
            data: {
              query1: query,
              "btn": "colorBtn"
            },
            success: function(data) {
              $('#colorList').fadeIn();
              $('#colorList').html(data);
            }
          });
        } else if (event.type === 'focusout' || query == '') {
          $('#colorList').fadeOut(); // Hide the div when textbox is empty or loses focus
        }
      });
      $(document).on('click', '.colorVal', function() {
        $('.color').val($(this).text())

      });

      $('#brand').on('keyup focusout', function(event) {
        var query = $(this).val();

        if (event.type === 'keyup' && query != '') {
          $.ajax({
            url: "ajx/repairAjx.php",
            method: "POST",
            data: {
              query2: query,
              "btn": "brandBtn"
            },
            success: function(data) {
              $('#brandList').fadeIn();
              $('#brandList').html(data);
            }
          });
        } else if (event.type === 'focusout' || query == '') {
          $('#brandList').fadeOut(); // Hide the div when textbox is empty or loses focus
        }
      });
      $(document).on('click', '.brandVal', function() {
        $('.brand').val($(this).text())

      });

      $('#itemModal').on('keyup focusout', function(event) {
        var query = $(this).val();

        if (event.type === 'keyup' && query != '') {
          $.ajax({
            url: "ajx/repairAjx.php",
            method: "POST",
            data: {
              query3: query,
              "btn": "modalBtn"
            },
            success: function(data) {
              $('#modelList').fadeIn();
              $('#modelList').html(data);
            }
          });
        } else if (event.type === 'focusout' || query == '') {
          $('#modelList').fadeOut(); // Hide the div when textbox is empty or loses focus
        }
      });
      $(document).on('click', '.modelVal', function() {
        $('.itemModal').val($(this).text())

      });
    </script>

    <?php
    include($path . 'footer.php');
    ?>