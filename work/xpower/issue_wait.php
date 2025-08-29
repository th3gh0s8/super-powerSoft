<?php
$title = 'Pending Issues';
$pageRights = 'Customer_Care/issue_wait';
include('path.php');

include('includeFile.php');
?>
</head>
<!-- In your <head> -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet">
<!-- At the end of <body> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>

<style>
    .disIssue {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .disradio {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        gap: 10px;
    }

    .btnComplete {
        padding: 5px 5px !important;
    }

    .btn.btnEdit,
    .btn.btnDelete {
        padding: 0 !important;
        border-radius: 50%;
        color: #000;
    }

    .table>tbody>tr>td {
        padding: 5px 8px !important;
    }

    .dataTables_filter {
        text-align: right !important;
        width: 100% !important;
    }

    .bg-danger {
        background-color: rgb(246, 103, 115) !important;
        color: #fff !important;
    }

    .bg-warning {
        background-color: rgb(251, 153, 100) !important;
        color: #000 !important;
    }

    .bg-success {
        background-color: rgb(156, 253, 156) !important;
        color: #000 !important;
    }

    .bg-critical {
        background-color: rgb(253, 88, 88) !important;
        color: #000 !important;
    }

    .form-group {
        margin-bottom: 5px !important;
        margin-top: 5px !important;
    }

    .bg-primary {
        background-color: #0d6efd;
        color: #ffffff;
    }

    .loadAgentDevChat,
    .loadAgentComments {
        display: flex;
        flex-direction: column;
        max-height: 300px;
        overflow-y: auto;
        padding: 10px;
        background: #f2f2f2;
        border-radius: 8px;
        border: 1px solid #ccc;
    }

    .chat-date-separator {
        text-align: center;
        font-weight: bold;
        font-size: 13px;
        color: #555;
        margin: 10px 0;
        padding: 4px 10px;
        background-color: #e6e6e6;
        border-radius: 12px;
        display: inline-block;
        align-self: center;
    }

    .chat-bubble {
        margin: 4px 0;
        max-width: 70%;
        padding: 10px;
        border-radius: 12px;
        font-size: 14px;
        line-height: 1.4;
        position: relative;
        word-wrap: break-word;
    }

    .chat-agent {
        background-color: #d1e7dd;
        align-self: flex-start;
        border-bottom-left-radius: 0;
    }

    .chat-developer {
        background-color: #cfe2ff;
        align-self: flex-end;
        margin-left: auto;
        border-bottom-right-radius: 0;
    }

    .chat-text {
        margin: 0;
    }

    .chat-time {
        display: block;
        text-align: right;
        font-size: 11px;
        color: #666;
        margin-top: 4px;
    }

    .no-chat {
        text-align: center;
        color: #999;
        font-style: italic;
    }
</style>

<body class="nav-sm">
    <div class="container body">
        <div class="main_container">
            <?php
            include($path . 'side.php');
            include($path . 'mainBar.php');
            ?>

            <div class="right_col" role="main">
                <div class="row">
                    <div class="col-md-9">
                        <div class="x_panel">
                            <div class="x_title disIssue">
                                <h5><i class="fa fa-align-left"></i> Waiting Issue Details</h5>
                                <div class="form-group" style="display: flex; align-items: center; justify-content: flex-end; gap: 15px;">
                                    <label>Search by developer</label>
                                    <Select class="form-control form-select" style="width: 50%;" id="searchDev" name="searchDev">
                                        <?php
                                        $sql_salesrep = $mysqli->query("SELECT ID,Name FROM salesrep");
                                        echo '<option>All</option>';
                                        while ($rowSalRep = $sql_salesrep->fetch_assoc()) {
                                            echo '<option value="' . $rowSalRep['ID'] . '">' . $rowSalRep['Name'] . '</option>';
                                        }
                                        ?>
                                    </Select>
                                </div>
                            </div>
                            <div class="x_content">
                                <div class="" style="display: flex;align-items:center;justify-content:space-between;">
                                    <ul class="nav nav-tabs" id="issueTabs" role="tablist">
                                        <li class="nav-item active">
                                            <a class="nav-link active" id="issue-tab" data-toggle="tab" href="#issue" role="tab" aria-controls="issue" aria-selected="true">Issues <span class="badge bg-primary issueCount">0</span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="printIssue-tab" data-toggle="tab" href="#printIssue" role="tab" aria-controls="printIssue" aria-selected="false">Print Issues <span class="badge bg-primary printCount">0</span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="requirements-tab" data-toggle="tab" href="#requirements" role="tab" aria-controls="requirements" aria-selected="false">Requirements <span class="badge bg-primary requireCount">0</span></a>
                                        </li>
                                    </ul>
                                    <div class="" style="display: flex; align-items: center; justify-content: space-between; gap: 30px;">
                                        <p>ART Monthly: <span class="badge bg-warning artm">2 days 5 hrs</span></p>
                                        <p>ART Weakly: <span class="badge bg-success artw">2 days 5 hrs</span></p>
                                    </div>
                                </div>

                                <div class="tab-content" id="issueTabsContent">
                                    <!-- Issues Tab -->
                                    <div class="x_content tab-pane fade in active" id="issue" role="tabpanel" aria-labelledby="issue-tab">
                                        <div class="box-content mt-3">
                                            <table id="example1" class="table table-striped table-bordered bootstrap-datatable responsive" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Issue No /Br</th>
                                                        <th>Date</th>
                                                        <th>Age</th>
                                                        <th>Cus ID/Name</th>
                                                        <th>Complaint</th>
                                                        <th>Developer</th>
                                                        <th>Priority</th>
                                                        <th>Tel</th>
                                                        <th>Image</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="tdata">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Print Issue Tab -->
                                    <div class="x_content tab-pane fade" id="printIssue" role="tabpanel" aria-labelledby="printIssue-tab">
                                        <div class="box-content mt-3">
                                            <table id="example2" class="table table-striped table-bordered bootstrap-datatable responsive" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Issue No /Br</th>
                                                        <th>Date</th>
                                                        <th>Age</th>
                                                        <th>Cus ID/Name</th>
                                                        <th>Complaint</th>
                                                        <th>Developer</th>
                                                        <th>Priority</th>
                                                        <th>Tel</th>
                                                        <th>Image</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="tdata">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- requirements tab -->
                                    <div class="x_content tab-pane fade" id="requirements" role="tabpanel" aria-labelledby="requirements-tab">
                                        <div class="box-content mt-3">
                                            <table id="example3" class="table table-striped table-bordered bootstrap-datatable responsive" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Issue No /Br</th>
                                                        <th>Date</th>
                                                        <th>Age</th>
                                                        <th>Cus ID/Name</th>
                                                        <th>Complaint</th>
                                                        <th>Developer</th>
                                                        <th>Priority</th>
                                                        <th>Tel</th>
                                                        <th>Image</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="tdata">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <form id="waitIssueForm">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="x_panel">
                                        <div class="x_title disIssue">
                                            <h6><i class="fa fa-align-left"></i> Customer Comments</h6>
                                            <div>
                                                <h6>Customer ID: <span id="cusIDDisplay" class="ms-2" style="color:#000; font-size: 12px; font-weight: 800;">0</span></h6>
                                            </div>
                                        </div>
                                        <div class="x_content">
                                            <div class="box_content">
                                                <div class="form-group" style="display:flex; justify-content:space-between;">
                                                    <div>
                                                        <input type="checkbox" id="newLead" name="newLead" value="1"> <span style="font-size:11px;">Requested for New Lead</span>
                                                        <br /><span style="font-size:11px;color:dimgray;">
                                                            Last Request date:- <span id="lastDate"></span> <span id="agelast" class="badge bg-danger" style="margin-top:-7px;"></span></span>
                                                    </div>
                                                    <button type="button" class="btn btn-sm btn-info btnComplete">Mark As Completed</button>
                                                </div>
                                                <div class="form-group">
                                                    <textarea class="form-control" rows="10" id="cusComnt" name="cusComnt"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="x_panel">
                                        <div class="x_title disIssue">
                                            <h5><i class="fa fa-align-left"></i> Agent Comment</h5>
                                            <button type="button" class="btn btn-sm btn-success btnSaveComment" data-replyby="Agent" id="btnAgentComnt">Save</button>
                                        </div>
                                        <div class="x_content">
                                            <div class="box_content">
                                                <div class="form-group loadAgentComments" style="display: none;">

                                                </div>
                                                <div class="form-group disradio">
                                                    <label>
                                                        <input type="radio" name="option" value="developer"> To Developer</label>
                                                    <label>
                                                        <input type="radio" name="option" value="client" checked> To Client</label>
                                                </div>
                                                <div class="form-group">
                                                    <textarea class="form-control" rows="2" id="agentComnt" name="agentComnt"></textarea>
                                                    <input type="hidden" id="agID" name="agID" />
                                                    <input type="hidden" id="issueID" name="issueID" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="x_panel">
                                        <div class="x_title disIssue">
                                            <h5><i class="fa fa-align-left"></i> Developer Comment</h5>
                                            <button type="button" class="btn btn-sm btn-success btnSaveComment" data-replyby="Developer" id="btnDevComnt">Save</button>
                                        </div>
                                        <div class="x_content">
                                            <div class="box_content">
                                                <div class="form-group loadAgentDevChat" style="display: none;">

                                                </div>
                                                <div class="form-group disradio">
                                                    <label>
                                                        <input type="radio" name="devoption" value="agent" checked> To Agent</label>
                                                    <label>
                                                        <input type="radio" name="devoption" value="client"> To Client</label>
                                                </div>
                                                <div class="form-group">
                                                    <textarea class="form-control" rows="2" id="divComnt" name="divComnt"></textarea>
                                                    <input type="hidden" id="devID" name="devID" />
                                                </div>
                                            </div>
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

    <!-- Start Modal of add issue -->
    <div class="modal" id="issueHistory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" style="width:80%;">
            <div class="modal-content" style="width:100%; max-width:100%;">
                <div class="modal-header" style="background: linear-gradient(-45deg, #23a6d5, #23d5ab);">
                    <button type="button" class="close" data-dismiss="modal" style="color: #000;">×</button>
                    <h3>Customer Issue History</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h6 class="cusNameDis"></h6>
                                </div>
                                <div class="x_content">
                                    <div class="box_content">
                                        <table id="issueHistoryTable" class="table table-striped table-bordered bootstrap-datatable responsive custmTB" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Category</th>
                                                    <th>Issue</th>
                                                    <th>Issue Date</th>
                                                    <th>Priority Level</th>
                                                    <th>Contact Name</th>
                                                    <th>Contact Number</th>
                                                    <th>Status</th>
                                                    <th>Expiry Date</th>
                                                </tr>
                                            </thead>
                                            <tbody class="tdataIssues">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end of Modal of add issue -->

    <div class="modal" id="imageDisplay" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" style="width: 60%;">
            <div class="modal-content" style="width:100%; max-width:100%;">
                <div class="modal-header" style="background: linear-gradient(-45deg, #23a6d5, #23d5ab);">
                    <button type="button" class="close" data-dismiss="modal" style="color: #000;">×</button>
                    <h3>Documents preview</h3>
                </div>
                <div class="modal-body">
                    <div class="row imagePreview" style="display:flex; align-items:center; flex-direction: row; gap:10px;">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include($path . 'footer.php') ?>
    <script>
        $(document).on('change', '#searchDev', function() {
            const getId = $(this).val();
            loadIssues(getId);
            loadPrintIssues(getId);
            loadrequirements(getId);
        });

        $(document).ready(function() {
            loadIssues();
            loadPrintIssues();
            loadrequirements();

            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                const tabId = e.target.id.replace('-tab', '');
                $.fn.dataTable.tables({
                    visible: true,
                    api: true
                }).columns.adjust().responsive.recalc();
                loadArtmw(tabId);
            });
        });

        function loadIssues(getId = '') {
            fetchAndRenderData(getId, '#example1', 'loadIssues', 'issueCount');
        }

        function loadPrintIssues(getId = '') {
            fetchAndRenderData(getId, '#example2', 'loadPrintIssues', 'printCount');
        }

        function loadrequirements(getId = '') {
            fetchAndRenderData(getId, '#example3', 'loadRequirements', 'requireCount');
        }

        function fetchAndRenderData(getId, tableSelector, action, countDiv) {
            $.ajax({
                type: "POST",
                url: "ajx/issueLoadWaitAjax.php",
                data: {
                    action: action,
                    getId: getId
                },
                dataType: "json",
                success: function(response) {
                    if ($.fn.DataTable.isDataTable(tableSelector)) {
                        $(tableSelector).DataTable().destroy();
                    }

                    const tableBody = $(tableSelector).find('tbody');
                    tableBody.empty();

                    if (response.issueDet && Array.isArray(response.issueDet) && response.issueDet.length > 0) {
                        totalCount = response.issueDet.length;
                        $('.' + countDiv).text(totalCount);
                        let today = new Date();

                        response.issueDet.forEach(function(issue) {
                            let rDate = new Date(issue.rDate);
                            let daysDiff = Math.floor((today - rDate) / (1000 * 60 * 60 * 24));

                            let badgeClass = (daysDiff >= 40) ? "badge bg-danger" :
                                (daysDiff >= 30) ? "badge bg-warning" : "";

                            let plevel = issue.priorityLevel;
                            let priorityClass = (plevel === 'Critical') ? "badge bg-danger" :
                                (plevel === 'High') ? "badge bg-critical" :
                                (plevel === 'Medium') ? "badge bg-success" : "badge bg-warning";

                            let imageDisplay = '';
                            if (issue && issue.imgID && issue.imageName) {
                                imageDisplay = `
                                    <div class="card btnImageDisplay" style="height:60px; overflow:hidden; border:1px solid #ddd; border-radius:8px; cursor:pointer;" row-id="${issue.imgID}">
                                        <img src="document/images/Issue/doc_${issue.imgID}/${issue.imageName}" 
                                            style="width:100%; height:100%; object-fit:cover;" 
                                            alt="" 
                                            onerror="this.style.display='none';">
                                    </div>
                                `;
                            } else {
                                // Empty placeholder with no image and no text
                                imageDisplay = '';
                            }



                            const row = `
                                    <tr style="background-color:${issue.rowColor}">
                                        <td>${issue.ticketNo} - ${issue.br_id}</td>
                                        <td>${issue.rDate} ${formatAMPM(issue.rTime)}</td>
                                        <td><span class="${badgeClass}">${daysDiff} Days</span></td>
                                        <td><a href="#" class="btnCusHistory" data-cusid="${issue.cusID}" style="color:blue; cursor:pointer;">${issue.CustomerID} - ${issue.cusName}</a></td>
                                        <td class="btnEdit" data-id="${issue.ID}" data-cus="${issue.cusID}" style="cursor:pointer;">${issue.complaint} <br/> ${issue.contact_person} - ${issue.contact_number}</td>
                                        <td>${issue.salesRepName}</td>
                                        <td><span class="${priorityClass}">${plevel}</span></td>
                                        <td>${issue.TelephoneNo} ${issue.contactName} ${issue.contactNo}</td>
                                        <td>${imageDisplay}</td>
                                        <td class="d-flex justify-content-start gap-2">
                                            <button type="button" class="btn btn-sm p-1 btnSuccess btnEdit" data-id="${issue.ID}" data-cus="${issue.cusID}"><i class="fa fa-edit"></i></button>
                                            <button type="button" class="btn btn-sm p-1 btnDelete" data-id="${issue.ID}"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                `;
                            tableBody.append(row);
                        });

                        $(tableSelector).DataTable({
                            searching: true,
                            paging: true,
                            ordering: true,
                            pageLength: 100,
                            responsive: true
                        });

                    } else {
                        tableBody.append(`
                            <tr>
                                <td colspan="10" style="text-align:center;">No Record Found</td>
                            </tr>
                        `);
                    }
                }
            });
        }

        loadArtmw('issue');

        function loadArtmw(session) {
            $.ajax({
                type: "POST",
                url: "ajx/issueWaitAjax.php",
                data: {
                    action: 'loadDataartmw',
                    session: session
                },
                dataType: "json",
                success: function(response) {
                    $('.artm').html('');
                    $('.artw').html('');
                    if (response.artmDet && Array.isArray(response.artmDet) && response.artmDet.length > 0) {
                        let totalRTMTimeMs = 0;
                        let currentMonthIssueCount = 0;

                        let totalRTMTimeWeekMs = 0;
                        let currentWeekIssueCount = 0;

                        let now = new Date();
                        let thisMonth = now.getMonth();
                        let thisYear = now.getFullYear();

                        // Get current week start (Sunday) and end (Saturday)
                        let startOfWeek = new Date(now);
                        startOfWeek.setDate(now.getDate() - now.getDay());
                        startOfWeek.setHours(0, 0, 0, 0);

                        let endOfWeek = new Date(now);
                        endOfWeek.setDate(now.getDate() + (6 - now.getDay()));
                        endOfWeek.setHours(23, 59, 59, 999);

                        response.artmDet.forEach(function(artm) {
                            if (artm.rDate && artm.rTime && artm.chk_date && artm.chk_time) {
                                let [rY, rM, rD] = artm.rDate.split('-').map(Number);
                                let [rH, rMin] = artm.rTime.split(':').map(Number);
                                let created = new Date(rY, rM - 1, rD, rH, rMin);

                                let [cY, cM, cD] = artm.chk_date.split('-').map(Number);
                                let [cH, cMin] = artm.chk_time.split(':').map(Number);
                                let completed = new Date(cY, cM - 1, cD, cH, cMin);

                                // Monthly check
                                if (created.getMonth() === thisMonth && created.getFullYear() === thisYear) {
                                    let diffMs = completed - created;
                                    if (diffMs > 0) {
                                        totalRTMTimeMs += diffMs;
                                        currentMonthIssueCount++;
                                    }
                                }
                                // Weekly check
                                if (created >= startOfWeek && created <= endOfWeek) {
                                    let diffWeekMs = completed - created;
                                    if (diffWeekMs > 0) {
                                        totalRTMTimeWeekMs += diffWeekMs;
                                        currentWeekIssueCount++;
                                    }
                                }
                            }
                        });
                        let avgRTMDisplay = 'N/A';
                        console.log(currentMonthIssueCount);
                        if (currentMonthIssueCount > 0) {
                            let avgMs = totalRTMTimeMs / currentMonthIssueCount;
                            let avgDays = Math.floor(avgMs / (1000 * 60 * 60 * 24));
                            let avgHours = Math.floor((avgMs % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                            avgRTMDisplay = `${avgDays} Day(s) ${avgHours} Hr(s)`;
                        }

                        // Weekly average
                        let avgWeekRTMDisplay = 'N/A';
                        if (currentWeekIssueCount > 0) {
                            let avgWeekMs = totalRTMTimeWeekMs / currentWeekIssueCount;
                            let avgWeekDays = Math.floor(avgWeekMs / (1000 * 60 * 60 * 24));
                            let avgWeekHours = Math.floor((avgWeekMs % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                            avgWeekRTMDisplay = `${avgWeekDays} Day(s) ${avgWeekHours} Hr(s)`;
                        }

                        // Show on page
                        $('.artm').text(avgRTMDisplay);
                        $('.artw').text(avgWeekRTMDisplay);
                    }
                }
            });
        }

        $(document).on('click', '.btnEdit', function() {
            var getByID = $(this).data('id');
            var cusId = $(this).data('cus');

            $.ajax({
                type: "POST",
                url: "ajx/issueWaitAjax.php",
                data: {
                    action: 'loadDataByID',
                    getByID: getByID,
                    cusId: cusId
                },
                dataType: "json",
                success: function(response) {
                    if (response.cmntDet) {
                        $('#cusIDDisplay').html(response.cmntDet.cusID);

                        if (response.lastRequestedDate && response.lastRequestedDate.trim() !== '') {
                            $('#lastDate').html(response.lastRequestedDate);
                        } else {
                            $('#lastDate').html('Not Yet');
                        }

                        if (response.daysSinceLastRequest !== undefined && response.daysSinceLastRequest !== '') {
                            $('#agelast').html(response.daysSinceLastRequest + ' Days')
                        } else {
                            $('#agelast').html('')
                        }
                        $('#cusComnt').val(response.cmntDet.complaint);

                        $('.loadAgentComments').html(''); // clear previous comments
                        $('.loadAgentComments').show();

                        renderAgentComments(getByID);
                        renderDevComments(getByID);

                        $('#issueID').val(response.cmntDet.ID);
                    } else {
                        $('#cusIDDisplay').html('0');
                        $('#lastDate').html('-');
                        $('#agentComnt').val('');
                        $('#divComnt').val('');
                        $('#cusComnt').val('');
                        $('#issueID').val('');
                        $('#agID').val('');
                    }
                }
            });
        })

        function renderAgentComments(getId) {
            $.ajax({
                type: "POST",
                url: "ajx/issueWaitAjax.php",
                data: {
                    action: 'loadAgentComment',
                    getId: getId
                },
                dataType: "json",
                success: function(response) {
                    $('.loadAgentComments').html(''); // Clear previous comments
                    $('.loadAgentComments').show();

                    if (response.agentComment && Array.isArray(response.agentComment) && response.agentComment.length > 0) {
                        let lastDate = '';
                        response.agentComment.forEach(function(causIssue) {
                            // Add date separator if it's a new date
                            if (causIssue.replyDate !== lastDate) {
                                $('.loadAgentComments').append(`
                                    <div class="chat-date-separator">${causIssue.replyDate}</div>
                                `);
                                lastDate = causIssue.replyDate;
                            }

                            // Determine who replied (Agent or Developer)
                            let senderClass = (causIssue.replyBy === 'Agent') ? 'chat-agent' : 'chat-developer';

                            // Append chat bubble
                            $('.loadAgentComments').append(`
                                <div class="chat-bubble ${senderClass}">
                                    <p class="chat-text">${nl2br(causIssue.reply_comment)}</p>
                                    <span class="chat-time">${causIssue.chatPerson} - ${formatAMPM(causIssue.replyTime)}</span>
                                </div>
                            `);
                        });

                        // Scroll to bottom
                        let chatBox = document.querySelector('.loadAgentComments');
                        chatBox.scrollTop = chatBox.scrollHeight;
                    } else {
                        $('.loadAgentComments').html('<p class="no-chat">No comments yet.</p>');
                    }
                }
            });
        }

        function nl2br(str) {
            if (!str) return '';
            return str.replace(/\n/g, '<br>');
        }

        function renderDevComments(getId) {
            $.ajax({
                type: "POST",
                url: "ajx/issueWaitAjax.php",
                data: {
                    action: 'loadDevComment',
                    getId: getId
                },
                dataType: "json",
                success: function(response) {
                    // loadAgentDevChat  chatDet
                    if (response.chatDet && Array.isArray(response.chatDet) && response.chatDet.length > 0) {
                        $('.loadAgentDevChat').html(''); // clear chat window
                        $('.loadAgentDevChat').show();
                        let lastDate = '';
                        response.chatDet.forEach(function(chatDet) {
                            // Add date separator if it's a new date
                            if (chatDet.replyDate !== lastDate) {
                                $('.loadAgentDevChat').append(`
                                        <div class="chat-date-separator">${chatDet.replyDate}</div>
                                    `);
                                lastDate = chatDet.replyDate;
                            }

                            let senderClass = (chatDet.replyBy === 'Agent') ? 'chat-agent' : 'chat-developer';

                            $('.loadAgentDevChat').append(`
                                    <div class="chat-bubble ${senderClass}">
                                        <p class="chat-text">${nl2br(chatDet.reply_comment)}</p>
                                        <span class="chat-time">${chatDet.chatPerson} - ${formatAMPM(chatDet.replyTime)}</span>
                                    </div>
                                `);
                        });
                        let chatBox = document.querySelector('.loadAgentDevChat');
                        chatBox.scrollTop = chatBox.scrollHeight;
                    } else {
                        $('.loadAgentDevChat').html('<p class="no-chat">No chats yet.</p>');
                    }
                }
            });
        }

        // save agent Comment
        $(document).on('click', '.btnSaveComment', function() {
            var replyBy = $(this).data('replyby'); // 'Agent' or 'Developer'
            var commentField = replyBy === 'Agent' ? 'agentComnt' : 'divComnt';
            var agIdField = replyBy === 'Agent' ? 'agID' : 'devID'; // Use separate hidden field for Developer if needed

            var comment = $('#' + commentField).val();
            var agID = $('#' + agIdField).val(); // Agent/Dev comment ID
            var issueID = $('#issueID').val();
            let agentOption = $('input[name="option"]:checked').val();
            let devOption = $('input[name="devoption"]:checked').val();

            var formData = new FormData();
            formData.append('action', 'saveComment');
            formData.append('comment', comment);
            formData.append('agID', agID);
            formData.append('devID', agID);
            formData.append('issueID', issueID);
            formData.append('replyBy', replyBy);
            formData.append('agentOption', agentOption);
            formData.append('devOption', devOption);

            $.ajax({
                type: "POST",
                url: "ajx/issueWaitAjax.php",
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        if (replyBy === 'Agent') {
                            $('#agentComnt').val('');
                            $('#agID').val('');
                        } else {
                            $('#divComnt').val('');
                            $('#devID').val('');
                        }
                        renderAgentComments(issueID);
                        renderDevComments(issueID);
                        loadIssues();
                        loadPrintIssues();
                        loadrequirements();
                    } else {
                        alert(response.message);
                    }
                }
            });
        });

        $(document).on('click', '.btnComplete', function() {
            var form = $('#waitIssueForm')[0];
            var formData = new FormData(form);
            formData.append('action', 'saveallComent');

            $.ajax({
                type: "POST",
                url: "ajx/issueWaitAjax.php",
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(response) {
                    if (response.success == true) {
                        loadIssues();
                        $('#waitIssueForm')[0].reset();
                    } else {
                        alert(response.message);
                    }
                }
            });
        })

        $(document).on('click', '.btnDelete', function() {
            var getByID = $(this).data('id');

            // Show confirmation dialog
            if (!confirm("Are you sure you want to delete this issue?")) {
                return; // Stop if the user cancels
            }

            // Proceed with AJAX if confirmed
            $.ajax({
                type: "POST",
                url: "ajx/issueWaitAjax.php",
                data: {
                    action: 'deleteIssue',
                    getByID: getByID,
                },
                dataType: "json",
                success: function(response) {
                    if (response.success == true) {
                        loadIssues();
                        loadPrintIssues();
                        loadrequirements();
                    } else {
                        alert(response.showMessage);
                    }
                }
            });
        });

        $(document).on('click', '.btnCusHistory', function() {
            var cusID = $(this).data('cusid');
            $('#issueHistory').modal('show');
            loadIssueHistory(cusID);
        })

        $(document).on('click', '.btnImageDisplay', function() {
            let imgId = $(this).attr("row-id");
            loadImagePriview(imgId);
            $('#imageDisplay').modal('show');
        });

        function loadImagePriview(imgId) {
            $.ajax({
                type: "POST",
                url: "ajx/issueWaitAjax.php",
                data: {
                    action: 'loadImages',
                    imgId: imgId
                },
                dataType: "json",
                success: function(response) {
                    $('.imagePreview').html('');
                    if (response.imgDet && Array.isArray(response.imgDet) && response.imgDet.length > 0) {
                        response.imgDet.forEach(function(image) {
                            $('.imagePreview').append(`
                                <a href="document/images/Issue/doc_${image.imgID}/${image.imgName}" data-lightbox="docGroup" data-title="Document Preview">
                                    <img src="document/images/Issue/doc_${image.imgID}/${image.imgName}" 
                                        class="img-thumbnail" 
                                        style="height:260px; width:260px; object-fit:cover;" 
                                        alt="">
                                </a>
                            `);
                        })
                    }
                }
            });
        }

        function loadIssueHistory(cusID) {
            $.ajax({
                type: "POST",
                url: "ajx/issueWaitAjax.php",
                data: {
                    action: 'loadIssueHistory',
                    cusID: cusID
                },
                dataType: "json",
                success: function(response) {
                    if ($.fn.DataTable.isDataTable('#issueHistoryTable')) {
                        $('#issueHistoryTable').DataTable().destroy();
                    }
                    $('.tdataIssues').html('');
                    if (response.loadIssueDet && Array.isArray(response.loadIssueDet) && response.loadIssueDet.length > 0) {
                        // cusName
                        $('.cusNameDis').html('<i class="fa fa-user"></i> ' + response.cusDet.cusName);
                        response.loadIssueDet.forEach(function(issueHistory) {
                            $('.tdataIssues').append(`
                                <tr>
                                    <td>${issueHistory.category}</td>
                                    <td>${issueHistory.complaint}</td>
                                    <td>${issueHistory.rDate}</td>
                                    <td>${issueHistory.priorityLevel}</td>
                                    <td>${issueHistory.contact_person}</td>
                                    <td>${issueHistory.contact_number}</td>
                                    <td>${issueHistory.issueStatus}</td>
                                    <td>${issueHistory.expDates}</td>
                                </tr>
                            `);
                        });
                        $('#issueHistoryTable').DataTable({
                            searching: true,
                            paging: true,
                            ordering: true,
                            pageLength: 100
                        });
                    } else {
                        $('.tdataIssues').append(`
                            <tr>
                                <td colspan="8" style="text-align:center;">No Record Found</td>
                            </tr>
                        `);
                    }
                }
            });
        }

        function formatAMPM(timeStr) {
            const [hours, minutes, seconds] = timeStr.split(':');
            let hour = parseInt(hours);
            const ampm = hour >= 12 ? 'PM' : 'AM';
            hour = hour % 12 || 12; // Convert 0 -> 12
            return `${hour}:${minutes} ${ampm}`;
        }
    </script>