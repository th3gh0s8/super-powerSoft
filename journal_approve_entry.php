<?php
$title = 'Approve Journal Entry';
$pageRights = 'journal_approve_entry';
include('path.php');

include('includeFile.php');

// Function to get the count of entries by status
function getEntryCount($mysqli, $br_id, $status) {
    $query = "SELECT COUNT(*) AS count FROM jentry WHERE `br_id`=? AND jentry_delete = 0 AND approved_status = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ii", $br_id, $status);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    return $row['count'];
}

$pendingCount = getEntryCount($mysqli, $br_id, 0);
$approvedCount = getEntryCount($mysqli, $br_id, 1);
$rejectedCount = getEntryCount($mysqli, $br_id, 2);

// Fetch Journal Entries
$query = "
SELECT
    Date AS transaction_date,
    IFNULL((SELECT AccName FROM jentry AS j2 WHERE j2.VNo = j1.VNo AND j2.Debit != 0 LIMIT 1), 'cash on hand') AS from_journal,
    IFNULL((SELECT AccName FROM jentry AS j3 WHERE j3.VNo = j1.VNo AND j3.Credit != 0 LIMIT 1), 'cash on hand') AS to_journal,
    Description,
    IFNULL(Credit, Debit) AS amount,
    userID,
    recodDate,
    ID, approved_status
FROM jentry AS j1
WHERE `br_id`=? AND jentry_delete = 0
ORDER BY Date DESC
LIMIT 100
";

$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $br_id);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

?>

<input type="text" name="rgt_edit" class="boxb rgt_edit" id="rgt_edit" value="<?php echo $page_rights; ?>" hidden border="0px" />




<style>
.jstBlnkTB {
    margin-top: 100px;
}

.custmTB {
    overflow-y: scroll;
}

.custmTB tr:nth-child(even):hover td,
tbody tr.odd:hover td {
    background: #DFD;
    cursor: pointer;
    color: #009999
}

.custmCretTB tr:nth-child(odd) td {
    background-color: #fbfbfb
}

/*odd*/
.custmCretTB tr:nth-child(even) td {
    background-color: #e8ecee
}

/* even*/

.custmCretTB tr:nth-child(even):hover td,
.custmCretTB tr:nth-child(odd):hover td {
    background: #DFD;
    cursor: pointer;
    color: #009999
}

/* hovering */


#ajax_img_lod,
#ajax_img_lod_cusDetil {
display: none;

}

.ajaxContent {}

/***************   STYLE FOR AUTOCOMPLETE DROPDOWN ***********/
.ui-autocomplete {
    max-height: 150px;
    min-width: 170px;
    background: #CCC;
    overflow-y: auto;
    overflow-x: hidden;
}


.ui-autocomplete::-webkit-scrollbar {
    width: 12px;
}

.ui-autocomplete::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
    border-radius: 10px;
}

.ui-autocomplete::-webkit-scrollbar-thumb {
    border-radius: 10px;
    -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.5);
}

/*************** END OF  STYLE FOR AUTOCOMPLETE DROPDOWN ***********/


input[type='text'],
input[type='number'],
input[type='email'],
input[type='tel'],
select {
    padding: 2px 2px 2px 5px;
    height: 25px;
}

.reqireLbl {
    color: #F00
}

FIELDSET {
    margin: 8px;
    border: 1px solid silver;
    padding: 8px;
    border-radius: 4px;
}

LEGEND {
    padding: 2px;
}

.joinDate {}

.errConfrmHaed {
    //height: 20px;
    margin: 9px;
    border: 1px solid #aaaaaa;
    background: #cccccc;
    border-radius: 4px;
    padding: 4px;
    color: #fff
    /*tomato*/
    ;
    font-size: 14px;
    font-weight: bold;
}

.blockUIClosBtn {
    padding: 2px 10px 2px 10px;
    margin: 14px 0 10px 0
}

.gndlbl {
    font-size: 10px
}

input[type="email"] {
    text-transform: lowercase;
}

#cardDetil {
display: none
}

.boxx {
    width: 100%;
}

.boxd {
    width: 100%;
}

.boxh {
    width: 100px;
}

.boxb {
    width: 100%;
    border: none;
}

.btns {
    color: #825D19;
    background-color: #825D19;
    /* height:30px; */
    padding-left: 10px;
    padding-right: 10px;

}

.lod_img {
    margin-top: 0px;
}
</style>



</head>

<body class="nav-sm">
    <div class="container body">
        <div class="main_container">
            <?php include($path . 'side.php'); ?>
            <?php include($path . 'mainBar.php'); ?>

            <!-- page content -->
            <div class="right_col" role="main">
                <div class="">
                    <div class="page-title">
                        <div class="title_left">
                            <h3><?php echo $title; ?></h3>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2><i class="fa fa-align-left"></i> Journal<small></small></h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div class="box-content">
                                        <div class="box-content lod_img" align="center">
                                            <ul class="ajax-loaders" style="display:none">
                                                <li><img src="../img/ajax-loaders/ajax-loader-8.gif" /></li>
                                            </ul>
                                        </div>


     <!-- Start Modal of warning -->
                                        <div class="modal" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">×</button>
                                                        <h3 style="margin:0">
                                                            <div id="ermsgHead"></div>
                                                        </h3>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div id="chqMsgContent"></div>
                                                    </div>
                                                    <div class="modal-footer myModlModal"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end of Modal of warning -->


                                        <form action="#" method="Post" name="jentry_form" id="jentry_form" class="jentry_form" autocomplete="off">
                                            <?php
                                            $qry_vno = $mysqli->query("SELECT MAX(VNo) FROM `jentry` WHERE br_id= '$br_id' AND VNo != '0' ORDER BY VNo DESC LIMIT 1");
                                            $ecu_vno = $qry_vno->fetch_array();
                                            $vur_no = $ecu_vno[0];
                                            if ($vur_no < 10) {
                                                $vur_no = 9;
                                            }
                                            $var_no = $vur_no + 1;
                                            ?>

                                            <div class="col-sm-12">
                                                <div class="col-sm-7">
                                                    <input type="text" name="ent_key" id="ent_key" class="ent_key hiddnCls" style="height:30px;" hidden />
                                                </div>
                                                <div class="col-sm-3">
                                                    <!-- Voucher No input field -->
                                                </div>
                                                <div class="col-sm-2">
                                                    <label>Date</label>
                                                    <?php
                                                    if ($user_type == 'Admin' || $user_type == 'SuperAdmin') {
                                                        echo '<div class="controls" style="padding-top:0px;margin-bottom:5px;margin-left:-15px;">
                                                                <div align="left" class="col-sm-10 input-append date dpk_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="bil_date" data-link-format="yyyy-mm-dd">
                                                                    <input size="16" type="text" name="bil_date" id="bil_date" value="' . date("Y-m-d") . '" required readonly class="form-control dpk_date456" style="width:100px;height:30px"/>
                                                                    <span class="add-on" style=""><i class="icon-th"></i></span>
                                                                </div>
                                                            </div>';
                                                    } else {
                                                        $rht_date = $mysqli->query("SELECT * FROM `user_rights` JOIN pages ON `user_rights`.`page_id`= pages.ID WHERE `user_id` ='$user_id' AND `page_title` ='control_Control Invoice Date' AND `user_rights`.`br_id`='$br_id'");
                                                        $count_rht = $rht_date->num_rows;
                                                        if ($count_rht <= 0) {
                                                            $rqst_date = $_SESSION['CRT_DATE'];
                                                            $bill_date = $rqst_date != '' ? $rqst_date : date('Y-m-d');
                                                            echo '<div class="controls" style="padding-top:0px;margin-bottom:5px;margin-left:-15px;">
                                                                    <div align="left" class="col-sm-10 input-append date dpk_date2" data-date="" data-date-format="yyyy-mm-dd" data-link-field="bil_date" data-link-format="yyyy-mm-dd">
                                                                        <input size="16" type="text" name="bil_date" id="bil_date" value="' . $bill_date . '" required readonly title="You can not change date" class="form-control dpk_date456" style="width:100px;height:30px"/>
                                                                        <span class="add-on" style=""><i class="icon-th"></i></span>
                                                                    </div>
                                                                </div>';
                                                        } else {
                                                            echo '<div class="controls" style="padding-top:0px;margin-bottom:5px;margin-left:-15px;">
                                                                    <div align="left" class="col-sm-10 input-append date dpk_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="bil_date" data-link-format="yyyy-mm-dd">
                                                                        <input size="16" type="text" name="bil_date" id="bil_date" value="' . date("Y-m-d") . '" required readonly class="form-control dpk_date456" style="width:100px;height:30px"/>
                                                                        <span class="add-on" style=""><i class="icon-th"></i></span>
                                                                    </div>
                                                                </div>';
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <br />
                                            </div>

                                            <!-- jentry details-->
                                            <div class="jdet">
                                                <div class="jdet2">
                                                    <?php if (!empty($_SESSION['flash'])): ?>
                                                        <div class="alert alert-success flash-message">
                                                            <?php echo htmlspecialchars($_SESSION['flash']); unset($_SESSION['flash']); ?>
                                                        </div>
                                                    <?php endif; ?>


                                                        <div class="container">
                                                            <ul class="nav nav-tabs">
                                                                <li class="active">
                                                                    <a data-toggle="tab" href="#pending">
                                                                        Pending <span class="badge"><?php echo $pendingCount; ?></span>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a data-toggle="tab" href="#approved">
                                                                        Approved <span class="badge"><?php echo $approvedCount; ?></span>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a data-toggle="tab" href="#rejected">
                                                                        Rejected <span class="badge"><?php echo $rejectedCount; ?></span>
                                                                    </a>
                                                                </li>
                                                            </ul>

                                                            <div class="tab-content">
                                                                <div id="pending" class="tab-pane fade in active">
                                                                    <!-- Pending entries will be displayed here -->
                                                                    <table class="table table-bordered bootstrap-datatable responsive table-hover custmTB2">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Date</th>
                                                                                <th>From Journal</th>
                                                                                <th>To Journal</th>
                                                                                <th>Description</th>
                                                                                <th style="text-align:right;">Amount</th>
                                                                                <th>User</th>
                                                                                <th>Recorded Date</th>
                                                                                <th>Action</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="pending-entries">
                                                                            <!-- Pending entries will be loaded here via JavaScript -->
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div id="approved" class="tab-pane fade">
                                                                    <!-- Approved entries will be displayed here -->
                                                                    <table class="table table-bordered bootstrap-datatable responsive table-hover custmTB2">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Date</th>
                                                                                <th>From Journal</th>
                                                                                <th>To Journal</th>
                                                                                <th>Description</th>
                                                                                <th style="text-align:right;">Amount</th>
                                                                                <th>User</th>
                                                                                <th>Recorded Date</th>
                                                                                <th>Status</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="approved-entries">
                                                                            <!-- Approved entries will be loaded here via JavaScript -->
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div id="rejected" class="tab-pane fade">
                                                                    <!-- Rejected entries will be displayed here -->
                                                                    <table class="table table-bordered bootstrap-datatable responsive table-hover custmTB2">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Date</th>
                                                                                <th>From Journal</th>
                                                                                <th>To Journal</th>
                                                                                <th>Description</th>
                                                                                <th style="text-align:right;">Amount</th>
                                                                                <th>User</th>
                                                                                <th>Recorded Date</th>
                                                                                <th>Status</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="rejected-entries">
                                                                            <!-- Rejected entries will be loaded here via JavaScript -->
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    
                                                    

                                                </div>
                                            </div>
                                            <!-- jentry details-->

                                            <!-- footer body -->
                                            <div class="col-sm-12 previousDetails" style="margin-left:15px; display:none;">
                                                <div class="col-sm-3" style="text-align:right;">
                                                    <label style="margin-top:5px;">Total Expenditure</label>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label>Last Month</label>
                                                    <input type="text" name="lst_mon" class="lst_mon hiddnCls" id="lst_mon" readonly />
                                                </div>
                                                <div class="col-sm-3">
                                                    <label>Current Month</label>
                                                    <input type="text" name="cur_mon" class="cur_mon hiddnCls" id="cur_mon" readonly />
                                                </div>
                                                <div class="col-sm-3">
                                                    <label>Budget Amount</label>
                                                    <input type="text" name="bug_amount" class="bug_amount hiddnCls" id="bug_amount" readonly />
                                                </div>
                                            </div>
                                            <!-- footer body -->
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /page content -->

            <!-- Start of warning -->
            <div id="creatCusMsg" style="display:none;">
                <div class="errConfrmHaed">Warning!</div>
                <span style="color:#F00" id="responseSpan"></span>
                <br />
                <button type="button" class="btn btn-default blockUIClosBtn" style="" />Ok</button>
            </div>
            <!--end of warning -->

            <?php include($path . 'footer.php') ?>

            <script type="text/javascript">
                $('.dpk_date').datetimepicker({
                    language: 'fr',
                    weekStart: 1,
                    todayBtn: 1,
                    autoclose: 1,
                    todayHighlight: 1,
                    minView: 2,
                    forceParse: 0,
                    format: "yyyy-mm-dd",
                    viewMode: "months",
                    minViewMode: "months"
                });
            </script>


<script>

                $(document).on('click', '.ajax-approve-btn', function(event) {
    event.preventDefault();
    var jentry_id = $(this).data('id');
    var action = $(this).data('action');
    var buttons = $(this);

    // Show confirmation dialog
    var confirmationMessage = action === 'approve' ? 'Are you sure you want to approve this entry?' : 'Are you sure you want to reject this entry?';
    if (confirm(confirmationMessage)) {
        // Disable buttons to prevent multiple clicks
        buttons.prop('disabled', true);

        $.ajax({
            url: 'ajx/journal_approve_entry.php',
            method: 'POST',
            data: {
                jentry_id: jentry_id,
                action: action,
                btn: "ApproveBtn"
            },
            dataType: 'json',
            success: function(data) {
                if (data.status === 'ok') {
                    var td = buttons.closest('td');
                    if (data.new_status === 'Approved') {
                        td.html('<span class="label label-success">Approved</span>');
                    } else if (data.new_status === 'Rejected') {
                        td.html('<span class="label label-danger">Rejected</span>');
                    }
                } else {
                    alert('Error: ' + (data.msg || 'Unknown error'));
                    buttons.prop('disabled', false);
                }
            },
            error: function() {
                alert('An error occurred while processing your request.');
                buttons.prop('disabled', false);
            }
        });
    }
});
   
</script>

<script>
$(document).ready(function() {
    // Function to load pending entries
    function loadPendingEntries() {
        $.ajax({
            url: 'ajx/fetch_entries.php',
            method: 'GET',
            data: { status: 'pending' },
            success: function(data) {
                $('#pending-entries').html(data);
            }
        });
    }

    // Function to load approved entries
    function loadApprovedEntries() {
        $.ajax({
            url: 'ajx/fetch_entries.php',
            method: 'GET',
            data: { status: 'approved' },
            success: function(data) {
                $('#approved-entries').html(data);
            }
        });
    }

    // Function to load rejected entries
    function loadRejectedEntries() {
        $.ajax({
            url: 'ajx/fetch_entries.php',
            method: 'GET',
            data: { status: 'rejected' },
            success: function(data) {
                $('#rejected-entries').html(data);
            }
        });
    }

    // Load pending entries by default
    loadPendingEntries();

    // Load data when tabs are clicked
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var target = $(e.target).attr("href");
        if (target === "#pending") {
            loadPendingEntries();
        } else if (target === "#approved") {
            loadApprovedEntries();
        } else if (target === "#rejected") {
            loadRejectedEntries();
        }
    });
});
</script>