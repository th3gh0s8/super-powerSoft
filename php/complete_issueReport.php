<?php
$title = 'Completed Issue Report';
$pageRights = 'Customer_Care/complete_issueReport';
include('path.php');

include('includeFile.php');
?>
</head>

<style>
    .disIssue {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .dataTables_filter {
        text-align: right !important;
        width: 100% !important;
    }

    .form-group,
    button {
        margin-bottom: 5px !important;
        margin-top: 5px !important;
    }

    .bg-danger {
        background-color: rgb(246, 103, 115) !important;
        color: #fff !important;
    }

    .bg-warning {
        background-color: rgb(251, 153, 100) !important;
        color: #000 !important;
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
                    <div class="col-md-12">
                        <div class="x_panel">
                            <div class="x_title disIssue">
                                <h5><i class="fa fa-align-left"></i> Summary Of Issue Details</h5>
                                <div style="display: flex;align-items:center;justify-content:space-between;gap:5px;">
                                    <div class="form-group" style="display: flex; align-items: center; justify-content: end; gap: 15px;">
                                        <label>From date:</label>
                                        <input type="date" id="dateFilter" name="dateFilter" class="form-control" style="width: 55%;" />
                                    </div>
                                    <div class="form-group" style="display: flex; align-items: center; justify-content: end; gap: 15px;">
                                        <label>To date:</label>
                                        <input type="date" id="dateFilterto" name="dateFilterto" class="form-control" style="width: 60%;" />
                                    </div>
                                    <button type="button" class="btn btn-sm btn-success p-1 btnLoad">Load</button>
                                </div>
                            </div>
                            <div class="x_content">
                                <div class="box_content">
                                    <table id="exampleSummery" class="table table-striped table-bordered bootstrap-datatable responsive" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Responsible Person</th>
                                                <th>Issues Received</th>
                                                <th>Completed Issues</th>
                                                <th>Pending Issues</th>
                                                <th>Completed Issues Incl Prev Issues</th>
                                                <th>Agent Completed</th>
                                                <th>Others Completed</th>
                                            </tr>
                                        </thead>
                                        <tbody class="tdataSummery">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="x_panel">
                            <div class="x_title disIssue">
                                <h5><i class="fa fa-align-left"></i> Complete Issue Details</h5>

                            </div>
                            <div class="x_content">
                                <div class="box_content">
                                    <table id="example" class="table table-striped table-bordered bootstrap-datatable responsive" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Issue No</th>
                                                <th>Issue Date</th>
                                                <th>Complete Date</th>
                                                <th>Age Taken</th>
                                                <th>Customer</th>
                                                <th>Complaint</th>

                                                <th>Agent Comment</th>
                                                
                                                <th>Developer Comment</th>

                                                <th>Responsible By</th>

                                               

                                                <th>Issue Solved By</th>
                                                <th>Developer</th>

                                                

                                                <th>Priority</th>
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
        </div>

        <?php include($path . 'footer.php') ?>
        <script>
            $(document).ready(function() {
                $('.btnLoad').on('click', function() {
                    let fromDate = $('#dateFilter').val();
                    let toDate = $('#dateFilterto').val();

                    loadComplete(fromDate, toDate);
                    
                        
                });
            });

            loadComplete();

            function loadComplete(fromDate, toDate) {
                $('.btnLoad').html('<i class="fa fa-spinner fa-spin"></i> Loading...').prop('disabled', true);
                $.ajax({
                    type: "POST",
                    url: "ajx/completeIssueAjax.php",
                    data: {
                        action: 'loadCompleteIssues',
                        fromDate: fromDate,
                        toDate: toDate,
                    },
                    dataType: "json",
                    success: function(response) {
                        if ($.fn.DataTable.isDataTable('#example')) {
                            $('#example').DataTable().destroy();
                        }
                        $('.tdata').html('');
                        if (response.issueDet && Array.isArray(response.issueDet) && response.issueDet.length > 0) {

                            response.issueDet.forEach(function(issue) {
                                let priorityLevel = "";
                                let plevel = issue.priorityLevel;
                                if (plevel == 'High') {
                                    priorityLevel = "badge bg-danger"
                                } else {
                                    priorityLevel = "badge bg-warning"
                                }

                                // Combine date and time for both start and end
                                let startDateTime = new Date(issue.rDate + ' ' + issue.rTime);
                                let endDateTime = new Date(issue.chk_date + ' ' + issue.chk_time);

                                // Calculate time difference in milliseconds
                                let diffMs = endDateTime - startDateTime;

                                // Convert to days and hours
                                let diffDays = Math.floor(diffMs / (1000 * 60 * 60 * 24));
                                let diffHours = Math.floor((diffMs / (1000 * 60 * 60)) % 24);
                                let timeTaken = `${diffDays} day(s) ${diffHours} hour(s)`;

                                let formattedRTime = formatAMPM(issue.rTime);
                                let formattedChkTime = formatAMPM(issue.chk_time);

                                $('.tdata').append(`
                                    <tr>
                                        <td>${issue.ticketNo}</td>
                                        <td>${issue.rDate} ${formattedRTime}</td>
                                        <td>${issue.chk_date} ${formattedChkTime}</td>
                                        <td>${timeTaken}</td>
                                        <td>${issue.cusName}</td>
                                        <td class="btnEdit" data-id="${issue.ID}" style="cursor:pointor;">${issue.complaint}</td>


                                        <td>${issue.AgentComment || ''}</td>

                                        <td>${issue.DeveloperComment || ''}</td>
                                        
                                        <td>${issue.salesRepName}</td>


                                         

                                        <td>${issue.solvedName}</td>
                                        <td>${issue.DeveloperName}</td>

                                        

                                        <td><span class="${priorityLevel}">${plevel}</span></td>
                                    </tr>
                                `);
                            });
                            $('#example').DataTable({
                                searching: true,
                                paging: true,
                                ordering: true,
                                pageLength: 100
                            });
                            
                            let fromDate = $('#dateFilter').val();
                            let toDate = $('#dateFilterto').val();
                    
                            loadSummeryIssues(fromDate, toDate);
                            $('.btnLoad').html('Load').prop('disabled', false);
                        } else {
                            $('.tdata').append(`
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

            document.addEventListener("DOMContentLoaded", function() {
                const dateFilter = document.getElementById("dateFilter");
                const dateFilterto = document.getElementById("dateFilterto");
                const today = new Date();
                const yyyy = today.getFullYear();
                const mm = String(today.getMonth() + 1).padStart(2, '0');
                const dd = String(today.getDate()).padStart(2, '0');
                const formattedToday = `${yyyy}-${mm}-${dd}`;

                if (dateFilter) dateFilter.value = formattedToday;
                if (dateFilterto) dateFilterto.value = formattedToday;
            });

            loadSummeryIssues();

            function loadSummeryIssues(fromDate, toDate) {
                $.ajax({
                    type: "POST",
                    url: "ajx/completeIssueAjax.php",
                    data: {
                        action: 'loadSummeryIssues',
                        fromDate: fromDate,
                        toDate: toDate,
                    },
                    dataType: "json",
                    success: function(response) {
                        if ($.fn.DataTable.isDataTable('#exampleSummery')) {
                            $('#exampleSummery').DataTable().destroy();
                        }
                        $('.tdataSummery').html('');

                        if (response.issueCntDet && Array.isArray(response.issueCntDet) && response.issueCntDet.length > 0) {

                            // Initialize total counters
                            let totalIssues = 0;
                            let totalSolved = 0;
                            let totalPending = 0;
                            let totalSolvedAll = 0;
                            let totalByResponsible = 0;
                            let totalByOthers = 0;

                            response.issueCntDet.forEach(function(issue) {
                                let solvedIssues = parseInt(issue.solved_issues);
                                let totalIssuesCount = parseInt(issue.total_issues);
                                let totalSolvedAllCount = parseInt(issue.total_solved_all);
                                let completedByResponsible = parseInt(issue.completed_by_responsible);
                                let completedByOthers = parseInt(issue.completed_by_others);
                                let pendingIssues = totalIssuesCount - solvedIssues;

                                totalIssues += totalIssuesCount;
                                totalSolved += solvedIssues;
                                totalPending += pendingIssues;
                                totalSolvedAll += totalSolvedAllCount;
                                totalByResponsible += completedByResponsible;
                                totalByOthers += completedByOthers;

                                $('.tdataSummery').append(`
                        <tr>
                            <td>${issue.solvedName}</td>
                            <td>${totalIssuesCount}</td>
                            <td>${solvedIssues}</td>
                            <td>${pendingIssues}</td>
                            <td>${totalSolvedAllCount}</td>
                            <td>${completedByResponsible}</td>
                            <td>${completedByOthers}</td>
                        </tr>
                    `);
                            });

                            // Append totals row
                            $('.tdataSummery').append(`
                    <tr style="font-weight:bold; background:#f2f2f2;">
                        <td>Total</td>
                        <td>${totalIssues}</td>
                        <td>${totalSolved}</td>
                        <td>${totalPending}</td>
                        <td>${totalSolvedAll}</td>
                        <td>${totalByResponsible}</td>
                        <td>${totalByOthers}</td>
                    </tr>
                `);

                            $('#exampleSummery').DataTable({
                                searching: true,
                                paging: true,
                                ordering: true,
                                pageLength: 100
                            });
                        } else {
                            $('.tdataSummery').append(`
                    <tr>
                        <td colspan="7" style="text-align:center;">No Record Found</td>
                    </tr>
                `);
                        }
                    }
                });
            }
        </script>