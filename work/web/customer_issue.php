<?php
$title = 'Customer Issue';
$pageRights = 'Customer_Care/customer_issue';
include('path.php');

include('includeFile.php');
?>
</head>
<style>
    .table>tbody>tr>td {
        padding: 3px !important;
        vertical-align: middle !important;
    }

    .btn {
        padding: 5px 10px !important;
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

    .disflex {
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
    }

    .disradio {
        display: flex !important;
        align-items: center !important;
        justify-content: flex-start !important;
        gap: 15px;
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
                <div class="">
                    <div class="page-title">
                        <div class="title_left">
                            <h3><?php echo $title; ?></h3>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h5><i class="fa fa-align-left"></i> Customer Details</h5>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div class="box-content">
                                        <table id="example" class="table table-striped table-bordered bootstrap-datatable responsive custmTB" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Code</th>
                                                    <th>Customer name</th>
                                                    <th>Contact No</th>
                                                    <th>Email</th>
                                                    <th>Other numbers</th>
                                                    <th>Date</th>
                                                    <th>SMS</th>
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
            </div>
        </div>
    </div>

    <!-- Start Modal of add issue -->
    <div class="modal" id="addIssue" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" style="width:80%;">
            <div class="modal-content" style="width:100%; max-width:100%;">
                <div class="modal-header" style="background: linear-gradient(-45deg, #23a6d5, #23d5ab);">
                    <button type="button" class="close" data-dismiss="modal" style="color: #000;">×</button>
                    <h3>Add Issue </h3>
                </div>
                <form action="" method="post" id="issueForm">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h6><i class="fa fa-align-left"></i> Issue Details</h6>
                                    </div>
                                    <div class="x_content">
                                        <div class="box_content">
                                            <table id="issueTable" class="table table-striped table-bordered bootstrap-datatable responsive custmTB" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Issue Type</th>
                                                        <th>Issue Date</th>
                                                        <th>Priority Level</th>
                                                        <th>Contact Name</th>
                                                        <th>Contact Number</th>
                                                        <th>Description</th>
                                                        <th>Responsible Agent</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="tdataIssues">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h6><i class="fa fa-align-left"></i>New Issue</h6>
                                    </div>
                                    <div class="x_content">
                                        <?php include('issue_form.php'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="button" name="" id="procBtn">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end of Modal of add issue -->

    <!-- Start Modal of add log -->
    <div class="modal" id="addLog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-lg" style="width:80%;">
            <div class="modal-content" style="width:100%; max-width:100%;">
                <div class="modal-header" style="background: linear-gradient(-45deg, #23a6d5, #23d5ab);">
                    <button type="button" class="close" data-dismiss="modal" style="color: #000;">×</button>
                    <h3>Add Log </h3>
                </div>
                <form action="" method="post" id="logForm" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h5><i class="fa fa-align-left"></i> Log Details</h5>
                                    </div>
                                    <div class="x_content">
                                        <div class="box_content">
                                            <table id="logTable" class="table table-striped table-bordered bootstrap-datatable responsive" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Customer</th>
                                                        <th>Call Date</th>
                                                        <th>Call Time</th>
                                                        <th>Contact Name</th>
                                                        <th>Issue</th>
                                                        <th>Contact No</th>
                                                        <th>Remarks</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="tdataLog">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h5><i class="fa fa-align-left"></i> New Log</h5>
                                    </div>
                                    <div class="x_content">
                                        <div class="box_content">
                                            <div class="form-group">
                                                <label>Log Type</label>
                                                <select class="form-control form-select" id="logType" name="logType">
                                                    <option value="call" selected>Call</option>
                                                    <option value="whatsapp">Whatsapp</option>
                                                    <option value="email">E-mail</option>
                                                    <option value="message">Message</option>
                                                </select>
                                                <input type="hidden" id="CUSID" name="CUSID" />
                                                <input type="hidden" id="logID" name="logID" />
                                            </div>
                                            <div class="form-group">
                                                <label>Branch No</label>
                                                <select id="branchNoLog" name="branchNoLog" class="form-control branchLoad" required>

                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Call Date</label>
                                                <input type="date" name="call_date" id="call_date" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Contact Name</label>
                                                <input type="text" class="form-control" id="cName" name="cName" />
                                            </div>
                                            <div class="form-group">
                                                <label>Contact Number</label>
                                                <input type="text" class="form-control" id="cNumber" name="cNumber" />
                                            </div>
                                            <div class="form-group">
                                                <label>Discussed Information</label>
                                                <textarea class="form-control" id="dInformation" name="dInformation" rows="4"></textarea>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" name="addtoissue" id="addtoissue" />
                                                <label class="form-check-label">Add this to issue</label>
                                            </div>
                                            <div class="disIssue" style="display:none">
                                                <?php include('issue_form.php') ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="button" name="" id="logBtn">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end of Modal of add log -->

    <?php include($path . 'footer.php') ?>
    <script>
        $(document).ready(function() {
            $("#addtoissue").change(function() {
                var cusName = $('#cName').val().trim();
                var contactNumber = $('#cNumber').val().trim();

                console.log("Customer Name:", cusName);
                console.log("Contact Number:", contactNumber);

                if ($(this).is(":checked")) {
                    $(".disIssue").slideDown(2300, function() {
                        // Check for form load by looking for form fields
                        var checkInterval = setInterval(function() {
                            console.log("Checking if form is loaded...");

                            if ($("#contactName").length > 0) {
                                // Form is loaded, set values and focus
                                $('#contactName').val(cusName);
                                $('#contactNumber').val(contactNumber);
                                $('#description').focus();

                                console.log("Values Set and Focused Successfully!");
                                clearInterval(checkInterval); // Clear interval after values are set
                            } else {
                                console.log("Form Not Loaded Yet...");
                            }
                        }, 3200); // Check every 200ms until the form is loaded
                    });
                } else {
                    $(".disIssue").slideUp();
                }
            });
        });

        // Set today's date in yyyy-mm-dd format
        document.getElementById('call_date').value = new Date().toISOString().split('T')[0];


        loadCustomer();

        function loadCustomer() {
            $.ajax({
                type: "POST",
                url: "ajx/cusAjax.php",
                data: {
                    action: 'loadCus'
                },
                dataType: "json",
                success: function(response) {
                    if ($.fn.DataTable.isDataTable('#example')) {
                        $('#example').DataTable().destroy();
                    }
                    $('.tdata').html(''); // Clear existing table data

                    response.cusDet.forEach(function(customer) {
                        $('.tdata').append(
                            `<tr>
                                <td>${customer.CustomerID}</td>
                                <td>${customer.cusName}</td>
                                <td>${customer.TelNo}</td>
                                <td>${customer.EmailNo}</td>
                                <td>${customer.MobNo}</td>
                                <td ${customer.inactiveStyle}>${customer.expDates}</td>
                                <td>13</td>
                                <td style="text-align:right;" class="disflex">
                                    <input type="button" class="btn btn-sm btn-primary add-issue" data-id="${customer.CustomerID}" data-custb="${customer.ID}" value="Add Issue">
                                    <input type="button" class="btn btn-sm btn-success add-log" data-id="${customer.CustomerID}" data-custb="${customer.ID}" value="Add Log">
                                </td>
                            </tr>`
                        );
                    });
                    $('#example').DataTable({
                        searching: true,
                        paging: true,
                        ordering: true,
                        pageLength: 100
                    });
                },
                error: function() {
                    console.error("Error loading customer data.");
                }
            });
        }

        $(document).on('click', '.add-issue', function() {
            var cusID = $(this).data('id');
            var custb = $(this).data('custb');
            $('#cid').val(custb);
            $('#addIssue').modal('show');
            loadTable1(custb);
            loadBranchDropdown(cusID, '0');
        })

        $(document).on('click', '.add-log', function() {
            var cusLogID = $(this).data('id');
            var custb = $(this).data('custb');
            $('#CUSID').val(custb);
            $('#cid').val(custb);
            $('#addLog').modal('show');
            loadLogTable(custb);
            loadBranchDropdown(cusLogID, '0');
            $('#dInformation').focus();
        })

        $(document).ready(function() {
            $(document).on('click', '#procBtn', function(e) {
                e.preventDefault(); // Prevent default form submission)

                var form = $('#issueForm')[0];
                var formData = new FormData(form);
                formData.delete('file[]');

                // ✅ Add all files manually
                allFiles.forEach(file => {
                    formData.append('file[]', file);
                });

                if (voiceBlob) {
                    formData.append('voice_note', voiceBlob, 'voice_note.webm');
                }

                formData.append('action', 'insertData');

                $.ajax({
                    url: 'ajx/cusAjax.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 'success') {
                            $('#addIssue').modal('hide');
                            $('#issueForm')[0].reset();
                            $('#preview').empty();
                            allFiles = [];
                            var currentCusId = $('#cid').val();
                            loadTable1(currentCusId);
                            alert(response.message);
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('An error occurred: ' + textStatus);
                    }
                })
            })
        });

        $(document).ready(function() {
            $(document).on('click', '#logBtn', function(e) {
                e.preventDefault(); // Prevent default form submission)

                var form = $('#logForm')[0];
                var formData = new FormData(form);
                formData.append('action', 'insertLogData');

                $.ajax({
                    url: 'ajx/cusAjax.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 'success') {
                            $('#addLog').modal('hide');
                            $('#logForm')[0].reset();
                            var currentCusId = $('#CUSID').val();
                            loadLogTable(currentCusId);
                            alert(response.message);
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('An error occurred: ' + textStatus);
                    }
                })
            })
        });

        loadTable1();

        function loadTable1(cusId) {
            $.ajax({
                type: "POST",
                url: 'ajx/cusAjax.php',
                data: {
                    action: 'loadTable1',
                    cusValue: cusId
                },
                dataType: "json",
                success: function(response) {
                    if ($.fn.DataTable.isDataTable('#issueTable')) {
                        $('#issueTable').DataTable().destroy();
                    }

                    $(".tdataIssues").html('');
                    if (response.conDet && Array.isArray(response.conDet) && response.conDet.length > 0) {
                        var lastCustomer = response.conDet[response.conDet.length - 1];
                        var lastCusName = lastCustomer.contact_person;
                        var lastContactNumber = lastCustomer.contact_number;

                        if (lastCusName && lastContactNumber) {
                            $('#contactName').val(lastCusName);
                            $('#contactNumber').val(lastContactNumber);
                        }

                        response.conDet.forEach(function(issue) {
                            $(".tdataIssues").append(`
                                <tr class="editTr" data-id="${issue.ID}">
                                    <td>${issue.category}</td>
                                    <td>${issue.rDate}</td>
                                    <td>${issue.priorityLevel}</td>
                                    <td>${issue.contact_person}</td>
                                    <td>${issue.contact_number}</td>
                                    <td>${issue.complaint}</td>
                                    <td>${issue.agent_name}</td>
                                </tr>
                            `);
                        });
                    } else {
                        // If no data available, clear the fields
                        $('#contactName').val('');
                        $('#contactNumber').val('');
                    }
                    $('#issueTable').DataTable({
                        responsive: true,
                        searching: true,
                        paging: true,
                        ordering: true,
                        pageLength: 50
                    });
                }
            });
        }

        loadLogTable();

        function loadLogTable(cusId) {
            $.ajax({
                type: "POST",
                url: "ajx/cusAjax.php",
                data: {
                    action: 'loadLogData',
                    cusId: cusId
                },
                dataType: "json",
                success: function(response) {
                    if ($.fn.DataTable.isDataTable('#logTable')) {
                        $('#logTable').DataTable().destroy();
                    }

                    $(".tdataLog").html('');
                    if (Array.isArray(response.logDet) && response.logDet.length > 0) {
                        var lastCustomerLog = response.logDet[response.logDet.length - 1];
                        var cusName = lastCustomerLog.cus_name;
                        var mobile = lastCustomerLog.mobile;

                        if (cusName && mobile) {
                            $('#cName').val(cusName);
                            $('#cNumber').val(mobile);
                        }

                        response.logDet.forEach(function(logs) {
                            $('.tdataLog').append(
                                `
                                    <tr class="editLogtr" data-id="${logs.ID}">
                                        <td>${logs.customer_name}</td>
                                        <td>${logs.call_date}</td>
                                        <td>${formatAMPM(logs.rtime)}</td>
                                        <td>${logs.cus_name}</td>
                                        <td>${logs.issue}</td>
                                        <td>${logs.mobile}</td>
                                        <td>${logs.remark}</td>
                                    </tr>
                                `
                            );
                        });
                    } else {
                        $('#cName').val('');
                        $('#cNumber').val('');
                    }
                    $('#logTable').DataTable({
                        responsive: true,
                        searching: true,
                        paging: true,
                        ordering: true,
                        pageLength: 50
                    });
                }
            });
        }

        function loadBranchDropdown(comId, brId) {
            $.ajax({
                type: "POST",
                url: "ajx/cusAjax.php",
                data: {
                    action: 'loadBranchDropdown',
                    comIDD: comId,
                    brIDD: brId
                },
                dataType: "json",
                success: function(response) {
                    if (response.branches && Array.isArray(response.branches)) {
                        var branchSelect = $('.branchLoad');
                        branchSelect.empty();
                        response.branches.forEach(function(branch, index) {
                            branchSelect.append('<option value="' + branch.ID + '"' + (index === 0 ? ' selected' : '') + '>' + branch.br_code + ' - ' + branch.name + '</option>');
                        });
                    } else {
                        $('.branchLoad').html('<option value="">No branches found</option>');
                    }
                }
            });
        }

        // When clicking a row in the issue table
        $(document).on('click', '.editTr', function() {
            var issueID = $(this).data('id');
            $.ajax({
                url: 'ajx/cusAjax.php',
                type: 'POST',
                data: {
                    action: 'getIssue',
                    issueID: issueID
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        // Populate form fields
                        $('input[name="issueSection"][value="' + response.data.section + '"]').prop('checked', true);
                        $('#issueType').val(response.data.category);
                        $('#branchNo').val(response.data.br_id);
                        $('#priorityLevel').val(response.data.priorityLevel);
                        $('#contactName').val(response.data.contact_person);
                        $('#contactNumber').val(response.data.contact_number);
                        $('#description').val(response.data.complaint);
                        $('#responsibleAgent').val(response.data.responsible_agent);
                        $('#issueID').val(response.data.ID); // Set the issue ID
                        $('#cid').val(response.data.cusID); // Customer ID

                        // Toggle buttons
                        $('#procBtn').html('Update');
                    } else {
                        alert(response.message);
                    }
                }
            });
        });

        $(document).on('click', '.editLogtr', function() {
            var logID = $(this).data('id');
            $.ajax({
                url: 'ajx/cusAjax.php',
                type: 'POST',
                data: {
                    action: 'getLog',
                    logID: logID
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        $('#logType').val(response.data.remark).trigger('change');
                        $('#branchNoLog').val(response.data.br_id);
                        $('#cName').val(response.data.cus_name);
                        $('#cNumber').val(response.data.mobile);
                        $('#dInformation').val(response.data.issue);
                        $('#call_date').val(response.data.call_date);
                        $('#logID').val(response.data.ID); // Set the issue ID
                        $('#CUSID').val(response.data.cusID);

                        // Toggle buttons
                        $('#logBtn').html('Update');
                    } else {
                        alert(response.message);
                    }
                }
            });
        });

        function formatAMPM(timeStr) {
            const [hours, minutes, seconds] = timeStr.split(':');
            let hour = parseInt(hours);
            const ampm = hour >= 12 ? 'PM' : 'AM';
            hour = hour % 12 || 12; // Convert 0 -> 12
            return `${hour}:${minutes} ${ampm}`;
        }


        let allFiles = [];
        const fileInput = document.getElementById('fileInput');
        const preview = document.getElementById('preview');

        // Handle file selection via input
        fileInput.addEventListener('change', function(event) {
            handleFiles(event.target.files);
        });

        // Handle drop event
        function handleDrop(event) {
            event.preventDefault();
            handleFiles(event.dataTransfer.files);
        }

        // Handle paste event
        function handlePaste(event) {
            const items = event.clipboardData.items;
            for (let item of items) {
                if (item.kind === 'file') {
                    const file = item.getAsFile();
                    handleFiles([file]);
                }
            }
        }

        function handleFiles(files) {
            Array.from(files).forEach((file, index) => {
                const fileIndex = allFiles.push(file) - 1;

                const wrapper = document.createElement('div');
                wrapper.className = 'preview-item';
                wrapper.style.position = 'relative';
                wrapper.style.display = 'inline-block';
                wrapper.style.margin = '10px';

                const closeBtn = document.createElement('span');
                closeBtn.innerHTML = '&times;';
                closeBtn.style.position = 'absolute';
                closeBtn.style.top = '0';
                closeBtn.style.right = '5px';
                closeBtn.style.cursor = 'pointer';
                closeBtn.style.color = 'red';
                closeBtn.style.fontSize = '18px';
                closeBtn.onclick = function() {
                    allFiles[fileIndex] = null; // Mark file for removal
                    preview.removeChild(wrapper); // Remove from DOM
                };

                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.maxWidth = '120px';
                        img.style.border = '1px solid #ccc';
                        wrapper.appendChild(closeBtn);
                        wrapper.appendChild(img);
                        preview.appendChild(wrapper);
                    };
                    reader.readAsDataURL(file);
                } else if (file.type === 'application/pdf') {
                    const pdfBox = document.createElement('div');
                    pdfBox.textContent = `📄 ${file.name}`;
                    pdfBox.style.padding = '10px';
                    pdfBox.style.border = '1px solid #ccc';
                    pdfBox.style.background = '#f9f9f9';
                    pdfBox.style.maxWidth = '120px';
                    wrapper.appendChild(closeBtn);
                    wrapper.appendChild(pdfBox);
                    preview.appendChild(wrapper);
                } else if (file.type.startsWith('video/')) {
                    const video = document.createElement('video');
                    video.src = URL.createObjectURL(file);
                    video.controls = true;
                    video.style.maxWidth = '150px';
                    video.style.border = '1px solid #ccc';
                    wrapper.appendChild(closeBtn);
                    wrapper.appendChild(video);
                    preview.appendChild(wrapper);
                }
            });
        }


        // voice record parseInt
        let mediaRecorder;
        let audioChunks = [];
        let voiceBlob = null;

        $('#startRecord').click(async function() {
            $('#recordingStatus').text('Recording...');
            $('#startRecord').prop('disabled', true);
            $('#stopRecord').prop('disabled', false);

            const stream = await navigator.mediaDevices.getUserMedia({
                audio: true
            });
            mediaRecorder = new MediaRecorder(stream);

            mediaRecorder.start();

            audioChunks = [];
            mediaRecorder.addEventListener('dataavailable', event => {
                audioChunks.push(event.data);
            });

            mediaRecorder.addEventListener('stop', () => {
                voiceBlob = new Blob(audioChunks, {
                    type: 'audio/webm'
                });

                const audioUrl = URL.createObjectURL(voiceBlob);
                $('#audioPreview').attr('src', audioUrl).show();
                $('#recordingStatus').text('Recording complete');
            });
        });

        $('#stopRecord').click(function() {
            $('#stopRecord').prop('disabled', true);
            $('#startRecord').prop('disabled', false);
            mediaRecorder.stop();
        });
    </script>