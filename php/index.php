<?php
$title = 'myXpower';
include('path.php');
include($path . 'header.php');
include('../connection_log.php');
$domainNm = $_SERVER['HTTP_HOST'];

$sql_userDet = $mysqli->query("SELECT `id`, view_type, repID FROM `sys_users` WHERE id ='$user_id'");
$userDet = $sql_userDet->fetch_array();
if ($user_type == 'Admin' && $userDet['view_type'] == 'Hide') {
    $showChart = 1;
} else {
    $showChart = 0;
}
$sql_dob = $mysqli->query("SELECT birth_date FROM staff_infor WHERE repID = '$userDet[repID]'");
if ($sql_dob->num_rows > 0) {
    $dob = $sql_dob->fetch_array();
    echo '<input type="hidden" name="dateOf" id="dateOf" class="dateOf" value="' . $dob['birth_date'] . '">';
}

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

//echo $_SESSION['u_id'].' xPower4';
?>
<style type="text/css">
    .count_box {
        height: 81px;
    }

    .count_bottom {
        font-size: 10px;
        color: white;
    }

    .count_top {
        color: white;
    }

    .count {
        font-size: 23px;
        color: white;
        text-align: center;
        font-weight: bold;
    }

    .boxSahd {
        background-color: #BA55D3;
        box-shadow: 5px 5px;
        color: gray;
    }

    .boxSahdz {
        background: white;
        width: 12%;
        height: 50px;
        border-radius: 10px;
        justify-content: center;
        align-items: center;
        display: flex;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        cursor: pointer;
        padding: 10px;
        min-width: 175px;
        margin-bottom: 6px;
    }

    .tbsChecker {
        width: 170px;
        display: inline-table;
    }

    .boxSahdz:hover {
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);

        .cardDtsText {
            font-weight: bold;
            animation: changeColor 5s linear infinite;
        }
    }



    .notice {
        transition: color 200ms ease;
        text-align: center;
        color: #F00;
        font-size: 25px;
        font-weight: 1000;
    }

    /* The class "Blink" is set to be transparent*/
    .notice.blink {
        color: transparent;
    }


    .card {
        display: block;
        position: relative;
        color: #ffffff;
        padding: 1em 2em 2em;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        text-align: center;
        background-image: url(https://i1.wp.com/businessingambia.com/wp-content/uploads/2017/09/money-saving.jpg?resize=678%2C381&ssl=1);
        background-blend-mode: soft-light;
        font-size: 15px;
    }

    .card2 {
        display: block;
        position: relative;
        color: #ffffff;
        padding: 1em 2em 2em;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        text-align: center;
        background-image: url(https://xpowersplus.net/Home/img/logo.png);
        background-repeat: no-repeat;
        background-blend-mode: soft-light;
        font-size: 15px;
        height: 95px;
    }

    .card h1 {
        font-family: 'Dosis', sans-serif;
        font-weight: bold;
        font-size: 4rem;
    }


    .bg-gradient1 span,
    .bg-gradient1:before {
        background: #fa7e29;
        background: linear-gradient(180deg, #fdab33 0%, #F6682F 80%, #F6682F 100%);
    }

    /* fancy Button */
    .fancy-button {
        display: inline-block;
        margin: 20px;
        font-family: 'Heebo', Helvetica, Arial, sans-serif;
        font-weight: 500;
        font-size: 16px;
        letter-spacing: 0.07em;
        text-transform: uppercase;
        line-height: 24px;
        color: #ffffff;
        position: relative;
    }

    .fancy-button.bg-gradient1 {
        text-shadow: 0px 0px 1px #BF4C28;
    }

    .fancy-button:before {
        content: '';
        display: inline-block;
        height: 40px;
        position: absolute;
        bottom: -1px;
        left: 10px;
        right: 10px;
        z-index: -1;
        border-radius: 2em;
        -webkit-filter: blur(14px) brightness(0.9);
        filter: blur(14px) brightness(0.9);
        -webkit-transform-style: preserve-3d;
        transform-style: preserve-3d;
        transition: all 0.3s ease-out;
    }

    .fancy-button i {
        margin-top: -2px;
        font-size: 1.265em;
        vertical-align: middle;
    }

    .fancy-button span {
        display: inline-block;
        padding: 16px 20px;
        border-radius: 50em;
        position: relative;
        z-index: 2;
        will-change: transform, filter;
        -webkit-transform-style: preserve-3d;
        transform-style: preserve-3d;
        transition: all 0.3s ease-out;
    }

    .fancy-button:focus {
        color: #ffffff;
    }

    .fancy-button:hover {
        color: #ffffff;
    }

    .fancy-button:hover span {
        -webkit-filter: brightness(0.9) contrast(1.2);
        filter: brightness(0.9) contrast(1.2);
        -webkit-transform: scale(0.96);
        transform: scale(0.96);
    }

    .fancy-button:hover:before {
        bottom: 3px;
        -webkit-filter: blur(6px) brightness(0.8);
        filter: blur(6px) brightness(0.8);
    }

    .fancy-button:active span {
        -webkit-filter: brightness(0.75) contrast(1.7);
        filter: brightness(0.75) contrast(1.7);
    }

    .client {
        vertical-align: middle;
        position: relative;
        margin: 5px;
        max-width: calc(34% - 20px);
        height: 100%;
        width: 100%;
        list-style-type: none;
        display: inline-block;
        text-align: center;
        transition: .2s ease all;
    }

    .client-meta {
        width: 100%;
        position: relative;
        display: block;
        text-align: center;
        border-radius: 4px;
        background-color: rgb(255, 255, 255);
        text-align: left;
        border: 1px solid rgb(228, 228, 228);
        box-shadow: 0 0 10px 0 rgba(0, 0, 0, .1);
        -webkit-transition: .2s ease all;
        -moz-transition: .2s ease all;
        -ms-transition: .2s ease all;
        -o-transition: .2s ease all;
        transition: .2s ease all;
    }


    .client-logo {
        z-index: 1;
        position: relative;
        transform: translateY(75%) translateX(-50%);
        left: 50%;
        top: 50%;
        width: 80%;
        height: auto;
        transition: .2s ease all;
        -webkit-animation: fadein .8s;
        -moz-animation: fadein .8s;
        -ms-animation: fadein .8s;
        -o-animation: fadein .8s;
        animation: fadein .8s;
    }

    .white-bg {
        background-color: rgb(255, 255, 255);
    }

    .project-list {
        overflow: hidden;
        max-height: 230px;
        margin-top: calc(100% - 100px);
        padding: 0;
        margin-bottom: 0;
        line-height: 1;
        padding-top: 0;
        padding-bottom: 20px;
        text-align: center;
        border-bottom: 4px solid rgb(189, 189, 255);
        transition: .2s ease all;
    }

    .bar {
        margin: 0 auto;
        border: 0;
        border-top: 4px solid rgb(232, 232, 232);
        max-width: calc(100% - 30px);
        transition: .2s ease all;
    }

    .project-list li {
        cursor: pointer;
        display: block;
        text-align: center;
        padding: 8px 10px;
        font-size: .9rem;
    }

    .startMnth {
        font-size: 20px;
        float: right;
    }


    body {
        zoom: 100% !important;

    }

    @import url("https://fonts.googleapis.com/css2?family=PT+Sans&display=swap");

    .rightbox {
        padding: 0;
        height: 100%;
    }

    .rb-container {
        font-family: "PT Sans", sans-serif;
        width: 100%;
        display: block;
        position: relative;
    }

    .rb-container ul.rb {
        margin: 2.5em 0;
        padding: 0;
        display: inline-block;
    }

    .rb-container ul.rb li {
        list-style: none;
        min-height: 50px;
        border-left: 1px dotted #1d9ce5;
        padding: 0 0 50px 30px;
        position: relative;
    }

    .rb-container ul.rb li:last-child {
        border-left: 0;
    }

    .rb-container ul.rb li::before {
        position: absolute;
        left: -7px;
        top: 0px;
        content: " ";
        border: 5px solid #1d9ce5;
        border-radius: 500%;
        background: #fefefe;
        height: 15px;
        width: 15px;
    }


    ul.rb li .timestamp {
        color: #1d9ce5;
        position: relative;
        font-size: 20px;
        font-weight: bold;
    }

    .item-title {
        color: #777;
    }

    input::placeholder {
        padding: 5em 5em 1em 1em;
        color: #1d9ce5;
    }

    @media only screen and (min-width: 700px) {
        .bs-example {
            margin-left: 70px;
            padding-left: 20px;
        }
    }

    .quckTd {
        background-color: white;
        height: 110px;
        transition: background-color 0.5s ease;
        padding-top: 20px;
        padding-bottom: 20px;
        text-align: center;
    }

    .quckTd:hover {
        background-color: #f1e8e8;
    }

    .quckTd:hover .titleSpan {
        color: black !important;
        font-weight: bold;
    }

    .quickImage:hover {
        cursor: pointer;
    }

    .my-custom-div {
        margin: 0;
        padding: 0;
        background-color: #f0f0f0;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* Your existing CSS for .happy-birthday, .message, .balloon-container, and .balloon can remain the same */

    /* happybirthday style */

    .happy-birthday {
        text-align: center;
        position: relative;
    }

    .message {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
        background: linear-gradient(45deg, #FF69B4, #FFD700, #00BFFF, #32CD32);
        -webkit-background-clip: text;
        color: transparent;
        animation: changeColor 5s linear infinite;
    }

    .balloon-container {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        text-align: center;
    }

    .balloon {
        width: 45px;
        height: 75px;
        background-color: rgba(255, 105, 180, 0.7);
        /* Use rgba to set transparency */
        border-radius: 50% 50% 50% 50% / 60% 60% 40% 40%;
        margin: 0 10px;
        display: inline-block;
        position: relative;
        animation: float 3s ease-in-out infinite;
        font-size: 36px;
        font-family: italic;
        font-weight: bold;
    }

    .balloon:hover {
        opacity: 0;
        /* Set opacity to 0 on hover to make it disappear */
    }

    .balloon span {
        display: inline-flex;
        align-items: center;
        height: 100%;
    }


    @keyframes float {
        0% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-20px);
        }

        100% {
            transform: translateY(0);
        }
    }

    @keyframes changeColor {
        0% {
            background-position: 0% 50%;
        }

        100% {
            background-position: 100% 50%;
        }
    }

    .dash-widget {
        background: #fff;
        margin-bottom: 25px;
        border-radius: 6px;
        padding: 15px;
        border: 1px solid #E8EBED;
        display: flex;
    }

    .dash-widget.dash1 .dash-widgetimg span {
        background: rgba(40, 199, 111, 0.12);
    }

    .dash-widget.dash2 .dash-widgetimg span {
        background: rgba(0, 207, 232, 0.12);
    }

    .dash-widget.dash3 .dash-widgetimg span {
        background: rgba(234, 84, 85, 0.12);
    }

    .dash-widget .dash-widgetcontent {
        margin-left: 20px;
    }

    .dash-widget .dash-widgetcontent h5 {
        color: #212B36;
        font-weight: 700;
        font-size: 18px;
        margin-bottom: 5px;
    }

    .dash-widget .dash-widgetcontent h6 {
        font-weight: 400;
        font-size: 14px;
        color: #212B36;
    }

    .dash-widget .dash-widgetimg span {
        width: 48px;
        height: 48px;
        background: rgba(249, 110, 111, 0.12);
        border-radius: 50px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    @media screen and (max-width: 600px) {
        .dash-widget .dash-widgetcontent {
            width: 85px;
        }
    }

    .dash-count {
        background: #bfd1ff;
        color: #000;
        min-height: 98px;
        width: 100%;
        border-radius: 6px;
        margin: 0 0 25px;
        padding: 15px;
    }

    .dash-count.das1 {
        background: #bfd1ff;
    }

    .dash-count.das2 {
        background: #bfd1ff;
    }

    .dash-count.das3 {
        background: #bfd1ff;
    }

    .dash-count h4 {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 0;
    }

    .dash-count h5 {
        font-size: 14px;
    }

    .dash-imgs {
        justify-content: end;
        align-items: end;
        display: flex;
    }

    @media screen and (max-width: 600px) {
        .dash-count {
            width: 393px;
        }
    }

    .circular-progress {
        position: relative;
        height: 70px;
        width: 70px;
        border-radius: 50%;
        background: conic-gradient(#7d2ae8 3.6deg, #ededed 0deg);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .circular-progress::before {
        content: "";
        position: absolute;
        height: 50px;
        width: 50px;
        border-radius: 50%;
        background-color: #bfd1ff;
    }

    .progress-value {
        position: relative;
        font-size: 16px;
        font-weight: 600;
        color: #000;
    }

    .circular-progress1 {
        position: relative;
        height: 70px;
        width: 70px;
        border-radius: 50%;
        background: conic-gradient(#7d2ae8 3.6deg, #ededed 0deg);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .circular-progress1::before {
        content: "";
        position: absolute;
        height: 50px;
        width: 50px;
        border-radius: 50%;
        background-color: #bfd1ff;
    }

    .progress-value1 {
        position: relative;
        font-size: 16px;
        font-weight: 600;
        color: #000;
    }

    .circular-progress2 {
        position: relative;
        height: 70px;
        width: 70px;
        border-radius: 50%;
        background: conic-gradient(#7d2ae8 3.6deg, #ededed 0deg);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* .circular-progress2::before{
    content: "";
    position: absolute;
    height: 50px;
    width: 50px;
    border-radius: 50%;
    background-color: #bfd1ff;
} */
    .progress-value2 {
        position: relative;
        font-size: 16px;
        font-weight: 600;
        color: #000;
    }

    .circular-progress3 {
        position: relative;
        height: 70px;
        width: 70px;
        border-radius: 50%;
        background: conic-gradient(#7d2ae8 3.6deg, #ededed 0deg);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* .circular-progress3::before{
    content: "";
    position: absolute;
    height: 50px;
    width: 50px;
    border-radius: 50%;
    background-color: #bfd1ff;
} */
    .progress-value3 {
        position: relative;
        font-size: 16px;
        font-weight: 600;
        color: #000;
    }

    .circular-progress-products {
        position: relative;
        height: 70px;
        width: 70px;
        border-radius: 50%;
        background: conic-gradient(#7d2ae8 3.6deg, #ededed 0deg);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .circular-progress-products::before {
        content: "";
        position: absolute;
        height: 50px;
        width: 50px;
        border-radius: 50%;
        background-color: #bfd1ff;
    }

    .progress-value-products {
        position: relative;
        font-size: 16px;
        font-weight: 600;
        color: #000;
    }

    .circular-progress-clients {
        position: relative;
        height: 70px;
        width: 70px;
        border-radius: 50%;
        background: conic-gradient(#7d2ae8 3.6deg, #ededed 0deg);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .circular-progress-clients::before {
        content: "";
        position: absolute;
        height: 50px;
        width: 50px;
        border-radius: 50%;
        background-color: #bfd1ff;
    }

    .progress-value-clients {
        position: relative;
        font-size: 16px;
        font-weight: 600;
        color: #000;
    }

    a:focus,
    a:hover {
        color: #dbdbdb !important;
    }
</style>

<style>
  /* Button Styling */
  .feedback-btn {
    display: inline-block;
    padding: 6px 25px;
    background-color: #4CAF50;
    color: #fff;
    font-size: 16px;
    font-weight: bold;
    text-align: center;
    text-decoration: none;
    border-radius: 30px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    transition: all 0.3s ease;
    cursor: pointer;
  }

  /* Animation on Hover */
  .feedback-btn:hover {
    background-color: #45a049;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
    transform: scale(1.05);
  }

  /* Button Text */
  .feedback-btn:after {
    content: "Share us your feedback";
    display: inline-block;
    animation: pulse 1.5s infinite;
  }

  /* Pulse Animation */
  @keyframes pulse {
    0% {
      transform: scale(1);
    }
    50% {
      transform: scale(1.1);
    }
    100% {
      transform: scale(1);
    }
  }
  
        .register-box {
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
        	animation: gradient 15s ease infinite;
        	background-size: 400% 400%; 
            color: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            padding: 20px;
            text-align: center;
        }

        .register-box h2 {
            font-size: 24px;
            margin-bottom: 15px;
            color: white;
        }

        .register-box p {
            font-size: 16px;
            margin-bottom: 20px;
        }

        .register-box a {
            background-color: #ff6f61;
            color: #fff;
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .register-box a:hover {
            background-color: #e55a50;
        }
        
        @keyframes gradient {
        	0% {
        		background-position: 0% 50%;
        	}
        	50% {
        		background-position: 100% 50%;
        	}
        	100% {
        		background-position: 0% 50%;
        	}
        }


 
  
  

</style>

</head>


<body class="nav-sm">
    <div class="container body" id="mainBody">
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9558967657995335" crossorigin="anonymous"></script>
        <div class="main_container">
 
            <?php
            include($path . 'side.php');
            include($path . 'mainBar.php');
            
            // if($com_id == '485'){
            //     syncShopifyItems();
            // } 
            ?>

            <div class="bs-example bs-example-tabs" data-example-id="togglable-tabs" style="background-color: #f7f6f6;">
                <ul id="myTabs" class="nav nav-tabs" role="tablist">

                    <li class="active"><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Dashboard</a></li>
                    <li><a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">What's new? &nbsp;</a></li>
                    <div style="width: 40%; float: left;">
                        <?php
                            $db_id = $_SESSION['db_id'];
                            $sql_checkFeedback = $xAccounts->query("SELECT ID FROM feedback_responses WHERE db_det = '$db_id'");
                            if($sql_checkFeedback->num_rows == true){
                                
                            }else{
                                if($com_id != '006' && $com_id != '501' && $com_id != '508' && $user_type == 'Admin'){
                                    echo '<a href="https://go2xpower.com/Home/feedback" class="feedback-btn" target="_BLANK"></a>';
                                }
                            }
                        ?>
                    </div>
                    <div style="text-align: end;margin-right: 7px;">
                        <?php
                        $qry_sms_one = $mysqli->query("SELECT `balance` FROM `sms_provider` WHERE `active`='YES' AND br_id='$br_id' ");
                        $smsBal_one = $qry_sms_one->fetch_array();

                        $dateAc = date('Y-m-d');
                        $sql_branchDet = $mysqli->query("SELECT `name`, `tel`, sms_no, sms_no2, br_code, expire_date, `recordDate` FROM com_brnches  WHERE ID = '$br_id'");
                        $branchDet = $sql_branchDet->fetch_array();

                        $NOTICActice = $branchDet['expire_date'];
                        $date2 = date_create($NOTICActice);
                        $date1 = date_create($dateAc);
                        $diff = date_diff($date1, $date2);
                        $dateDiff = $diff->format("%R%a");

                        $isExpired = false;
                        $isExpiredText = '';
                        $isExpiredTextTwo = '';
                        if ($dateDiff == 802) {
                            $isExpired = true;
                            $isExpiredText = 'SYSTEM EXPIRING IN ' . $dateDiff . ' DAYS ';
                            $isExpiredTextTwo = 'activate';
                        } else {
                            $isExpired = false;
                            $isExpiredText = '';
                            $isExpiredTextTwo = '';
                        }

                        $isSMSCount = false;
                        $isSMSCountText = '';
                        $isSMSCountTextTwo = '';
                        if ($qry_sms_one->num_rows == true) {
                            $isSMSCount = true;
                            $isSMSCountText = 'REMAINING SMS ' . $smsBal_one[0] . ' ';
                            $isSMSCountTextTwo = 'reload';
                        } else {
                            $isSMSCount = false;
                            $isSMSCountText = '';
                            $isSMSCountTextTwo = '';
                        }

                        $isBothExpired = '';
                        $isBothExpiredTwo = '';
                        if ($isExpired && $isSMSCount) {
                            $isBothExpired = $isExpiredText . '& ' . $isSMSCountText;
                            $isBothExpiredTwo = 'Click here to ' . $isExpiredTextTwo . ' or ' . $isSMSCountTextTwo;
                        } else if ($isExpired) {
                            $isBothExpired = $isExpiredText;
                            $isBothExpiredTwo = 'Click here to ' . $isExpiredTextTwo;
                        } else if ($isSMSCount) {
                            $isBothExpired = $isSMSCountText;
                            $isBothExpiredTwo = 'Click here to ' . $isSMSCountTextTwo;
                        } else if (!$isExpired && !$isSMSCount) {
                            $isBothExpired = '';
                            $isBothExpiredTwo = '';
                        }

                        echo '<span style="color: red;font-weight: 700;">' . $isBothExpired . ' </span></br>
                                <span><a href="https://' . $domainNm . '/monthlyPay.php">' . $isBothExpiredTwo . '</a></span>';


                        ?>

                    </div>
                </ul>
                <div id="myTabContent" class="tab-content">

                    <div role="tabpanel" class="tab-pane fade" id="home" aria-labelledby="home-tab" style="height: max-content; margin-left:25px">
                        <div class="container" style="margin-top: 20px;">
                            <div id="timeline-1" class="">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-10 col-sm-offset-1 " style="margin-left:0">

                                        <div class="rightbox">
                                            <div class="rb-container">
                                                <ul class="rb">
                                                    <?php
                                                    $sql_invoiceDet = $xdatalogin->query("SELECT `ID`, `upd_title`, `upd_text`,`rDateTime` FROM `xpower_updates` ORDER BY  `rDateTime` DESC LIMIT 0,25");

                                                    $sql_lastUpdateID = $xdatalogin->query("SELECT `ID` FROM `xpower_updates` ORDER BY  `rDateTime` DESC LIMIT 0,1");
                                                    $lastUpdateID = $sql_lastUpdateID->fetch_assoc();
                                                    ?>

                                                    <input type="hidden" id="updateID" value="<?php echo $lastUpdateID['ID'] ?>">

                                                    <?php
                                                    while ($invoiceDet = $sql_invoiceDet->fetch_array()) {
                                                        echo '<li class="rb-item" ng-repeat="itembx">
                                                                    <p style="color:#19191985; margin: 0;">' . date("dS F,Y h:ia", strtotime($invoiceDet['rDateTime'])) . '</p>  
                                                                    <div class="timestamp">
                                                                        ' . $invoiceDet['upd_title'] . ' 
                                                                    </div>
                                                                    <div class="item-title">
                                                                        ' . $invoiceDet['upd_text'] . '<br>
                                                                        
                                                                    </div>
                                                                </li>';
                                                    }
                                                    ?>

                                                </ul>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 dashBoardM" style="margin-bottom: 20px;">
                        <div id="cusBirthDiv"></div>
                        <div id="cusBirthDiv1"></div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade active in" id="profile" aria-labelledby="profile-tab">
                        <!-- page content -->
                        <div class="right_col" role="main" style="background-color: rgb(247, 247, 247);margin-left:0">

                            <div class="row">
                                <div class="col-md-12" style="display:none;">
                                    
                                    <div class="register-box col-md-12">
                                        <h2 style="font-weight:bold;">Join Our ReferX Program!</h2>
                                        <p style="margin-bottom: 0px;">Become an agent and start promoting xPower accounting software today. Earn rewards for every referral!</p>
                                        <p>Online session will be hosted by next week explaining all the details and informations for our registered users.</p>
                                        
                                       
                                        <a href="https://go2xpower.com/ReferX" target="_BLANK">Register Now </a>
                                    </div>
                                    
                                    <div id="google_translate_element"></div>
                                </div>

                                <?php

                                $date = date('Y-m-d');
                                $time = date('h:i:s');
                                $rdate = date('Y-m-d');

                                $qry_card = $mysqli->query("SELECT `ID`,`AccID`,`Commise`,`machinNo`,`machinName`,`BankCODE`,`BranchCODE` FROM journal  
                                WHERE journal.br_id = '$br_id' AND `machinNo` != '' AND `backup` != '1' ");
                                while ($card = $qry_card->fetch_array()) {
                                    $save_cd = $mysqli->query("INSERT INTO `card_tb`( `jID`, `jTB`, `br_id`, `serialNO`, `name`, `commis`, `bkCode`,
                                `brCode`, `rdae`, `rtime`,user_id,cloud) VALUES ('$card[AccID]','$card[ID]','$br_id','$card[machinNo]',
                                '$card[machinName]','$card[Commise]','$card[BankCODE]','$card[BranchCODE]','$date','$time','$user_id','OLD')");

                                    $up_cd = $mysqli->query("UPDATE `journal` SET `backup`='1' WHERE `ID`='$card[ID]' ");
                                }

                                $dateAc = date('Y-m-d');

                                $sql_branchDet = $mysqli->query("SELECT `name`, `tel`, sms_no, sms_no2, br_code, expire_date, `recordDate` FROM com_brnches  WHERE ID = '$br_id'");
                                $branchDet = $sql_branchDet->fetch_array();

                                $NOTICActice = $branchDet['expire_date'];
                                $date2 = date_create($NOTICActice);
                                $date1 = date_create($dateAc);
                                $diff = date_diff($date1, $date2);
                                $dateDiff = $diff->format("%R%a");

                                if ($dateDiff  < 7) {
                                    echo '
                                        <div class="notice">
                                            <p style="font-weight:1000;">YOUR SYSTEM WILL BE EXPIRED WITHIN ' . $dateDiff . ' DAYS </p>
                                        </div>
                                        <p style="text-align:center">Please contact to Powersoft Pvt Ltd To update your system - +94 722 693 693 </p>
                                    ';
                                }

                                $qry_sms = $mysqli->query("SELECT `balance` FROM `sms_provider` WHERE `active`='YES' AND br_id='$br_id' ");
                                $smsBal = $qry_sms->fetch_array();
                                $smsBalz = !empty($smsBal['balance']) ? $smsBal['balance'] : 0;
                                // $smsBalz = $smsBal['balance'];
                                if ($qry_sms->num_rows == true) {
                                    $comNm = $branchDet['name'];

                                    $com_mob = substr(str_replace(' ', '', trim($branchDet['tel'])), 0, 10);
                                    $mNo = $branchDet['sms_no'] . ',' . $branchDet['sms_no2'];
                                    $smsNo = $branchDet['sms_no'];
                                    $smsNo2 = $branchDet['sms_no2'];

                                    if ($smsBal['balance'] <= 10) {
                                        // echo '
                                        //     <div class="notice">
                                        //         <p style="font-weight:1000; ">REMAINING SMS IS ' . $smsBal[0] . '. </p>
                                        //     </div>
                                        //     <p style="text-align:center">Please contact to Powersoft Pvt Ltd To increase SMS count - +94 722 693 693 </p>
                                        // ';


                                        //sms balance alert ############################### start #####################

                                        $sms_type2 = 'SMS-Balance Alert';
                                        $qry_sms = $mysqli->query("SELECT * FROM `sms_rights` WHERE `type`='$sms_type2' AND `user_right`='YES' AND `br_id`='$br_id'");
                                        if ($qry_sms->num_rows == true) {
                                            $qry_chkSMSAL = $mysqli->query("SELECT TIMESTAMPDIFF(DAY, `rdate`, CURDATE()) AS age FROM `sms_sendcount` 
                                                WHERE `type`='SMS-Balance Alert' order by `rdate` desc limit 1");
                                            $chkSMSAL = $qry_chkSMSAL->fetch_array();

                                            if ($qry_chkSMSAL->num_rows == 0 || $chkSMSAL[0] > 5) {
                                                if ($smsNo != '') {
                                                    $sms_alrt = "Dear " . $comNm . ",\n %0a Your remaining SMS Balance is " . $smsBal['balance'] . ". Please top-up your SMS to enjoy uninterrupted service. \n\nThanks\nCall 0722 693 693";

                                                    $sms_alrt2 = $comNm . "\nCom code:" . $_SESSION['COM_ID'] . "\n SMS Balance is " . $smsBal['balance'] . ".\nMobile no " . $smsNo;

                                                    $smsRst2 = messege($sms_alrt, $sms_type2, $sms_alrt, $cusId, $br_id, $smsNo, 'RETURN');
                                                    $smsRst3 = messege($sms_alrt2, $sms_type2, $sms_alrt2, $cusId, $br_id, "775656798", 'RETURN');
                                                    //echo $smsRst2;
                                                }
                                            }
                                        }
                                    }

                                    // SMS day summerry  start
                                    $sms_msg = '';
                                    if ($smsBal['balance'] > 0) {
                                        $qry_dueDate = $mysqli->query("SELECT `l_date` FROM `login_det` WHERE `br_id`='$br_id' AND `l_date` < '$rdate' ORDER by `log_det_id` Desc limit 1");
                                        $dueDate = $qry_dueDate->fetch_array();
                                        $lstDate = $dueDate['l_date'];

                                        $sms_type2 = 'SMS-Day Sales Summary';
                                        $qry_sms = $mysqli->query("SELECT * FROM `sms_rights` WHERE `type`='$sms_type2' AND `user_right`='YES' AND `br_id`='$br_id'");
                                        if ($qry_sms->num_rows == true) {
                                            $qry_chkSMS2 = $mysqli->query("SELECT * FROM `sms_sendcount` WHERE `type`='$sms_type2' 
                                            AND `br_id`='$br_id' AND `rdate`='$rdate'  ");
                                            $no_chkSMS2 = $qry_chkSMS2->num_rows;

                                            if ($no_chkSMS2 == 0) {
                                                $i = 0;
                                                $msgSal = "";
                                                $qry_salesSum = $mysqli->query("SELECT sum(`DiscValue`),XWord FROM `invitem` join itemtable on
                                                 `invitem`.`itemID`=itemtable.ID WHERE `invitem`.`Date`='$lstDate' and `invitem`.`br_id`='$br_id' 
                                                 group by XWord order by sum(`DiscValue` ) desc");
                                                while ($slSum = $qry_salesSum->fetch_array()) {
                                                    $i++;
                                                    $val = $slSum[0];
                                                    $cat = ($slSum[1] == '') ? 'None' : $slSum[1];

                                                    if ($val != 0) {
                                                        $msgSal .= $cat . ": " . $val . "\n";
                                                    }
                                                }

                                                if ($i > 0) {
                                                    $msgSal = substr($msgSal, 0, -1);
                                                    $msgSal2 = $lstDate . "\nSales summary\n\n" . $msgSal;

                                                    $mNo22 = explode(",", $mNo);

                                                    foreach ($mNo22 as $mNo33) {
                                                        $smsRst2 = messege($msgSal2, $sms_type2, $msgSal2, $c, $br_id, $mNo33, 'RETURN');
                                                    }
                                                }
                                            }
                                        }
                                        //sales summerry ################ END #########################

                                        //purchase summerry ################ Start #########################
                                        $sms_type2 = 'Sales detail to vendor';

                                        $qry_sms = $mysqli->query("SELECT * FROM `sms_rights` WHERE `type`='$sms_type2' AND `user_right`='YES' AND `br_id`='$br_id'");
                                        if ($qry_sms->num_rows == true) {
                                            $qry_chkSMS2 = $mysqli->query("SELECT * FROM `sms_sendcount` WHERE `type`='$sms_type2' 
                                            AND `br_id`='$br_id' AND `rdate`='$rdate'  ");
                                            $no_chkSMS2 = $qry_chkSMS2->num_rows;

                                            if ($no_chkSMS2 == 0) {
                                                $i = 0;
                                                $msgSal = '';
                                                $qry_purSum = $mysqli->query("SELECT  Sum(`Quantity`) as qty, sum(`Quantity` * `CostPrice`),Vendor 
                                                                                FROM `invitem` join itemtable on
                                                                                `invitem`.`itemID`=itemtable.ID WHERE `invitem`.`Date`='$lstDate' and `invitem`.`br_id`='$br_id' 
                                                                                group by Vendor  ");
                                                while ($prSum = $qry_purSum->fetch_array()) {
                                                    $i++;
                                                    $venID = $prSum['Vendor'];

                                                    $qry_ven = $mysqli->query("SELECT `CompanyName`,`sms1`,`sms2` FROM `vendor` WHERE `ID`='$venID' ");
                                                    $rst_ven = $qry_ven->fetch_array();
                                                    $venMob = ($rst_ven['sms2'] != '') ? $rst_ven['sms2'] . ',' . $rst_ven['sms1'] : $rst_ven['sms1'];
                                                    if ($venMob != '') {
                                                        $msgSal2 = "Good news!\n\n" . $rst_ven['CompanyName'] . ", We have sold " . $prSum[0] . " products on " . $lstDate . " worth of Rs " . number_format($prSum[1], 2) . " (approximately)\n\n Tel:" . $branchDet['tel'];
                                                        $mNo22 = explode(",", $venMob);

                                                        foreach ($mNo22 as $mNo33) {
                                                            $smsRst2 = messege($msgSal2, $sms_type2, $msgSal2, $c, $br_id, $mNo33, 'RETURN');
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        //purchase summerry summerry ################ END #########################



                                        $sms_type = 'SMS-Day Summary';
                                        $qry_sms = $mysqli->query("SELECT * FROM `sms_rights` WHERE `type`='$sms_type' AND `user_right`='YES' AND `br_id`='$br_id'");
                                        if ($qry_sms->num_rows == true) {
                                            $qry_chkSMS = $mysqli->query("SELECT * FROM `sms_sendcount` WHERE `type`='$sms_type' 
                                            AND `br_id`='$br_id' AND `rdate`='$rdate' ");
                                            $no_chkSMS = $qry_chkSMS->num_rows;

                                            if ($no_chkSMS == 0) {
                                                

                                                $qry_sales = $mysqli->query("SELECT SUM(`InvTot`),SUM(`Balance`) FROM `invoice` WHERE  `Stype` != 'Balance' 
                                            AND `br_id`='$br_id' AND `Date`='$lstDate' AND InvNO NOT LIKE 'Rtn%'");
                                                $tot_sales = $qry_sales->fetch_array();

                                                // $qry_Csales = $mysqli->query("SELECT SUM(cusstatement.Paid) FROM `invoice` JOIN cusstatement 
                                                //     ON `invoice`.ID=cusstatement.invID  and `invoice`.`Date`=cusstatement.Date
                                                //     WHERE `invoice`.`Stype` != 'Balance' 
                                                //     AND `invoice`.`br_id`='$br_id' AND `invoice`.`Date`='$lstDate' AND cusstatement.RepID='' ");
                                                    
                                                    $qry_Csales = $mysqli->query("SELECT SUM(cusstatement.Paid) FROM `cusstatement` WHERE Date = '$lstDate' AND br_id = '$br_id' 
											            AND FromDue != 'Due' AND RepID != 'Card' AND RepID!='CJournal' AND RepID != 'Cheque'   and order_id = ''");
                                                $tot_Csales = $qry_Csales->fetch_array();

                                                $qry_chqSale = $mysqli->query("SELECT SUM(cusstatement.Paid) FROM `invoice` JOIN cusstatement ON `invoice`.ID=cusstatement.invID  and `invoice`.`Date`=cusstatement.Date
                                                    WHERE `invoice`.`Stype` != 'Balance' 
                                                    AND `invoice`.`br_id`='$br_id' AND `invoice`.`Date`='$lstDate' AND cusstatement.RepID='Cheque' 
                                                    ");
                                                $tot_chqSale = $qry_chqSale->fetch_array();

                                                $qry_cardSale = $mysqli->query("SELECT SUM(cusstatement.Paid) FROM `invoice` JOIN cusstatement ON `invoice`.ID=cusstatement.invID  and `invoice`.`Date`=cusstatement.Date
                                                    WHERE `invoice`.`Stype` != 'Balance' 
                                                    AND `invoice`.`br_id`='$br_id' AND `invoice`.`Date`='$lstDate' AND cusstatement.RepID='Card' 
                                                    ");
                                                $tot_cardSale = $qry_cardSale->fetch_array();

                                                $qry_rChq = $mysqli->query("SELECT SUM(`chqAmount`) FROM `chq_recieve` WHERE `entryDate`='$lstDate' AND `br_id`='$br_id'");
                                                $rChq = $qry_rChq->fetch_array();

                                                $qry_ChqRtn = $mysqli->query("SELECT SUM(`amount`) FROM `bank_deposit` WHERE `rtnID` !='0' AND `br_id`='$br_id' AND `entryDate`='$lstDate' ");
                                                $ChqRtn = $qry_ChqRtn->fetch_array();

                                                $qry_Profit = $mysqli->query("SELECT (SUM(`DiscValue`)-SUM(`CostPrice`* Quantity)) FROM `invitem` WHERE `br_id`='$br_id' AND `Date`='$lstDate' ");
                                                $Profit = $qry_Profit->fetch_array();

                                                $qry_dueRecive = $mysqli->query("SELECT SUM(`Paid`) FROM `cusstatement` WHERE `br_id`='$br_id' AND `FromDue`='Due' AND `Date`='$lstDate'");
                                                $dueRecive = $qry_dueRecive->fetch_array();


                                                $sms_msg = $lstDate . "\n\nSales " . number_format($tot_sales[0]) . "\n(CASH " . number_format($tot_Csales[0]) . "\nCREDIT " . number_format($tot_sales[1]) . "\nCHQ " . number_format($tot_chqSale[0]) . "\nCARD " . number_format($tot_cardSale[0]) . ")\nDue RCVD " .
                                                    number_format($dueRecive[0]) . "\nCHQ RCVD " . number_format($rChq[0]) . "\nRTN CHQ " .
                                                    number_format($ChqRtn[0]) . "\n\nProfit " . number_format($Profit[0]);

                                                // SMS Sending ############################### Start ##############################

                                                $smsRst = '';
                                                $sql_cusDet = $mysqli->query("SELECT CustomerID, cusName, TelNo, SUM(Balance)  FROM invoice JOIN custtable ON
                                                invoice.CusID = custtable.CustomerID WHERE CusID ='$cusId' AND invoice.br_id='$br_id'");
                                                $rst_cusDet = $sql_cusDet->fetch_array();
                                                $cusNm = substr($rst_cusDet['cusName'], 0, 20);
                                                $mob = trim($rst_cusDet[2]);
                                                $cusBal = $rst_cusDet[3];

                                                $provider = '';


                                                $c = 0;
                                                $mNo2 = explode(",", $mNo);

                                                foreach ($mNo2 as $mNo3) {
                                                    $mobile = trim($mNo3);
                                                    
                                                    $qry_MSG = $mysqli->query("SELECT `SMS` FROM `sms_rights` WHERE `type`='$sms_type' ");
                                                    $rst_MSG = $qry_MSG->fetch_array();
                                                    $sms = '';

                                                    if ($sms_msg != '') {
                                                        $c++;
                                                        $sms = str_replace('CUS.NAME', $cusNm, $sms_msg);
                                                        $sms = str_replace('INV.AMOUNT', '' . number_format($totalAftertax, 2) . '', $sms);
                                                        $sms = str_replace('INV.DATE', '' . $B_date . '', $sms);
                                                        $sms = str_replace('INV.TIME', '' . $time . '', $sms);
                                                        $sms = str_replace('COM.MOB', '' . $com_mob . '', $sms);
                                                        $sms = str_replace('CUS.BALANCE', '' . number_format($cusBal, 2) . '', $sms);
                                                        $sms = str_replace('PAID.AMOUNT', '' . number_format($Amnt, 2) . '', $sms);
                                                        $sms = str_replace('COM.NAME', '' . substr($comNm, 0, 20) . '', $sms);
                                                        $sms = str_replace('PAID.TYPE', '' . strtoupper($paid_type) . '', $sms);
                                                        $sms = $branchDet['br_code'] . $sms;
                                                        $message = $sms;

                                                        $smsRst = messege($message, $sms_type, $sms_msg, $c, $br_id, $mobile, 'RETURN');
                                                        echo  $smsRst;
                                                    }
                                                    
                                                }
                                            }
                                        }
                                        // day end sms ####################### end


                                        $qry_dueDatesms = $mysqli->query("SELECT * FROM `sms_rights` WHERE `type`='Due Date Reminder' AND `user_right`='YES' AND `br_id`='$br_id'");
                                        if ($qry_dueDatesms->num_rows == true) {
                                            $qry_chkSMS = $mysqli->query("SELECT * FROM `sms_sendcount` WHERE `type`='Due Date Reminder' 
                                            AND `br_id`='$br_id' AND `rdate`='$rdate' ");
                                            $no_chkSMS = $qry_chkSMS->num_rows;

                                            if ($no_chkSMS == 0) {
                                                $qry_dueDate = $mysqli->query("SELECT invoice.Balance, invoice.cusTbID, InvTot, cusstatement.settlment_date, invoice.Date, invoice.NowTime, RcvdAmnt, DATEDIFF(CAST(CURRENT_TIMESTAMP AS DATE), invoice.Date) AS dateAge, invoice.InvNO, invoice.ID AS invID FROM invoice INNER JOIN cusstatement ON cusstatement.invID = invoice.ID
                                                					WHERE `invoice`.`Balance` != 0
                                                					AND invoice.`br_id`='$br_id' AND `cusstatement`.`settlment_date` = '$dateAc' AND  cusstatement.FromDue = ''
                                                					AND invoice.Date != `cusstatement`.`settlment_date`");
                                                while ($dueTotal = $qry_dueDate->fetch_assoc()) {
                                                    if ($dueTotal['Balance'] > 0) {
                                                        $sql_cusDet = $mysqli->query("SELECT CustomerID, cusName, TelNo FROM custtable 
                                                                                    WHERE ID ='$dueTotal[cusTbID]'");
                                                        $rst_cusDet = $sql_cusDet->fetch_array();

                                                        $mNo2 = explode(",", $rst_cusDet['TelNo']);
                                                        $c = 0;
                                                        foreach ($mNo2 as $mNo3) {
                                                            $mob = $mNo3;
                                                            if (strlen($mob) > 9) {
                                                                $mobile = substr($mob, strlen($mob) - 9, strlen($mob));
                                                            } else {
                                                                $mobile = $mob;
                                                            }

                                                            if (strlen($mobile) == 9) {
                                                                $rst_MSG = $qry_dueDatesms->fetch_array();
                                                                $sms = '';
                                                                if ($rst_MSG['SMS'] != '') {
                                                                    $c++;
                                                                    $sms = str_replace('CUS.NAME', $rst_cusDet['cusName'], $rst_MSG['SMS']);
                                                                    $sms = str_replace('INV.AMOUNT', '' . number_format($dueTotal['InvTot'], 2) . '', $sms);
                                                                    $sms = str_replace('INV.NO', '' . $dueTotal['InvNO'] . '', $sms);
                                                                    $sms = str_replace('INV.DATE', '' . $dueTotal['Date'] . '', $sms);
                                                                    $sms = str_replace('INV.TIME', '' . $dueTotal['NowTime'] . '', $sms);
                                                                    $sms = str_replace('CUS.BALANCE', '' . number_format($dueTotal['Balance'], 2) . '', $sms);
                                                                    $sms = str_replace('PAID.AMOUNT', '' . number_format($dueTotal['RcvdAmnt'], 2) . '', $sms);
                                                                    $sms = str_replace('SETTLE.DAY', '' . number_format($dueTotal['settlment_date'], 2) . '', $sms);
                                                                    $sms = str_replace('SETTLE.AGE', '' . number_format($dueTotal['dateAge'], 2) . '', $sms);
                                                                    $sms = str_replace('COM.NAME', '' . $branchDet['name'] . '', $sms);
                                                                    $previewLink = shortUrl($_SERVER['HTTP_HOST'] . "/x/i.php?i=" . urlencode(base64_encode($dueTotal['invID'] . "||XP||" . $com_id)));
                                                                    $sms = str_replace('INV.LINK', '' . $previewLink . '', $sms);
                                                                    $message = $sms;

                                                                    $smsRst = messege($message, 'Due Date Reminder', $rst_MSG['SMS'], $c, $br_id, $mobile, 'RETURN');
                                                                    echo  $smsRst;
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }

                                ?>
                            </div>

                            <?php
                            if ($com_id == '104'){
                                
                                $emailSetups = array(
                                    array(
                                        'id' => 1,
                                        'day' => 2,
                                        'emailHead' => 'Welcome to XPower – Let’s Get Started!'
                                    ),
                                    array(
                                        'id' => 2,
                                        'day' => 4,
                                        'emailHead' => 'Here’s How to Set Up Your XPower Account'
                                    ),
                                    array(
                                        'id' => 3,
                                        'day' => 6,
                                        'emailHead' => 'Explore XPower’s Powerful Accounting Features'
                                    ),
                                    array(
                                        'id' => 4,
                                        'day' => 8,
                                        'emailHead' => 'Inventory Made Simple with XPower'
                                    ),
                                    array(
                                        'id' => 5,
                                        'day' => 10,
                                        'emailHead' => 'Customize Invoices to Fit Your Brand'
                                    ),
                                    array(
                                        'id' => 6,
                                        'day' => 12,
                                        'emailHead' => 'Add Your Team & Collaborate Smarter'
                                    ),
                                    array(
                                        'id' => 7,
                                        'day' => 15,
                                        'emailHead' => 'Boost Efficiency with Keyboard Shortcuts & Tips'
                                    ),
                                    array(
                                        'id' => 8,
                                        'day' => 18,
                                        'emailHead' => 'Import Your Existing Data with Ease'
                                    ),
                                    array(
                                        'id' => 9,
                                        'day' => 21,
                                        'emailHead' => 'Need Help? We’re Here for You'
                                    ),
                                    array(
                                        'id' => 10,
                                        'day' => 24,
                                        'emailHead' => 'See Real Businesses Succeed with XPower'
                                    ),
                                    array(
                                        'id' => 11,
                                        'day' => 26,
                                        'emailHead' => 'Only 5 Days Left in Your Free Trial – Let’s Make the Most of It'
                                    ),
                                    array(
                                        'id' => 12,
                                        'day' => 29,
                                        'emailHead' => 'Your Trial is Almost Over – Don’t Lose Access!'
                                    ),
                                    array(
                                        'id' => 13,
                                        'day' => 30,
                                        'emailHead' => 'Upgrade Today – Get Full Access to XPower'
                                    )
                                );
                                
                                $sql_trial_customers = $xdatalogin->query("SELECT ID, email_address, rDateTime FROM trial_customers WHERE rDateTime >= NOW() - INTERVAL 35 DAY");
                                while ($trial_customers = $sql_trial_customers->fetch_assoc()) {
                                    $trialId = $trial_customers['ID'];

                                    $startDate = date('Y-m-d', strtotime($trial_customers['rDateTime']));
                                    $diffInSeconds = strtotime($date) - strtotime($startDate);
                                    $daysSince = $diffInSeconds / (60 * 60 * 24);
                                
                                    $sentQuery = $xdatalogin->query("SELECT email_id FROM trial_email_logs WHERE trial_customer_id = $trialId");
                                    $sentEmailIds = [];
                                    while ($row = $sentQuery->fetch_assoc()) {
                                        $sentEmailIds[] = (int)$row['email_id'];
                                    } 
                                
                                    foreach ($emailSetups as $email) {
                                        if ($email['day'] <= $daysSince && !in_array($email['id'], $sentEmailIds)) {
                                            sendEmailToTrailCustomer($trial_customers['email_address'], $email['id']);
                                
                                            $stmt = $xdatalogin->prepare("INSERT INTO trial_email_logs (trial_customer_id, email_id, sent_datetime) VALUES (?, ?, NOW())");
                                            $stmt->bind_param("ii", $trialId, $email['id']);
                                            $stmt->execute(); 
                                            $stmt->close();
                                
                                            break;
                                        }
                                    }
                                }

                                
                            }
                            function sendEmailToTrailCustomer($toEmail, $emailId){
                                    if($emailId == 1){
                                        $message = '
                                            <!DOCTYPE html>
                                            <html>
                                            <head>
                                              <meta charset="UTF-8">
                                              <title>Getting Started with XPower</title>
                                              <style>
                                                body {
                                                  font-family: \'Segoe UI\', Arial, sans-serif;
                                                  margin: 0;
                                                  background-color: #f5f3fa;
                                                  color: #2d2d2d;
                                                }
                                                .email-wrapper {
                                                  max-width: 600px;
                                                  margin: 0 auto;
                                                  background-color: #ffffff;
                                                  border-radius: 8px;
                                                  overflow: hidden;
                                                  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
                                                }
                                                .header {
                                                  background-color: #6a0dad;
                                                  color: white;
                                                  text-align: center;
                                                  padding: 40px 20px;
                                                }
                                                .header h1 {
                                                  margin: 0 0 10px;
                                                  font-size: 24px;
                                                }
                                                .header p {
                                                  margin: 0;
                                                  font-size: 16px;
                                                }
                                                .cta-button {
                                                  display: inline-block;
                                                  margin-top: 20px;
                                                  padding: 12px 24px;
                                                  background-color: #4a0072;
                                                  color: #fff;
                                                  text-decoration: none;
                                                  border-radius: 4px;
                                                  font-weight: bold;
                                                }
                                                .section {
                                                  padding: 30px 20px;
                                                  border-bottom: 1px solid #e6ddf2;
                                                }
                                                .section h2 {
                                                  font-size: 20px;
                                                  margin-bottom: 10px;
                                                  color: #6a0dad;
                                                }
                                                .section p {
                                                  font-size: 15px;
                                                  line-height: 1.6;
                                                }
                                                .section img {
                                                  width: 100%;
                                                  max-width: 520px;
                                                  border-radius: 6px;
                                                  margin: 15px 0;
                                                }
                                                .highlight {
                                                  background-color: #f1e7fd;
                                                  padding: 20px;
                                                  border-radius: 6px;
                                                  margin-top: 20px;
                                                }
                                                .footer {
                                                  text-align: center;
                                                  font-size: 12px;
                                                  padding: 20px;
                                                  color: #888;
                                                }
                                                .footer a {
                                                  color: #6a0dad;
                                                  text-decoration: none;
                                                  margin: 0 8px;
                                                }
                                              </style>
                                            </head>
                                            <body>
                                            
                                              <div class="email-wrapper">
                                            
                                                <div class="header">
                                                  <h1>Welcome to XPower</h1>
                                                  <p>Your smart accounting journey begins now</p>
                                                  <a href="https://help.go2xpower.com" class="cta-button">Start Tutorial</a>
                                                </div>
                                            
                                                <div class="section">
                                                  <h2>Quick Setup</h2>
                                                  <p>Add your business profile, products, and customers in just a few clicks. Get up and running in minutes with XPower’s smart tools.</p>
                                                  <img src="https://go2xpower.com/ajax/email_images/ItemCustomerGif.gif" alt="Quick Setup">
                                                </div>
                                            
                                                <div class="section">
                                                  <h2>Send Your First Invoice</h2>
                                                  <p>With our flexible invoice builder, you can generate professional invoices and email them instantly — with your branding and layout preferences.</p>
                                                  <img src="https://go2xpower.com/ajax/email_images/InvoiceGif.gif" alt="Send Your First Invoice">
                                                </div>
                                            
                                                <div class="section">
                                                  <h2>Live Stock & Payment Tracking</h2>
                                                  <p>Track inventory, customer balances, and due payments from a powerful, unified dashboard.</p>
                                                </div>
                                            
                                                <div class="section highlight">
                                                  <h2>Need help?</h2>
                                                  <p>We’re here for you. <a href="https://wa.me/94722693693">Whatsapp us</a> or click below to visit our Help Center.</p>
                                                  <a href="https://help.go2xpower.com" class="cta-button" style="background-color:#6a0dad;">Go to Help Center</a>
                                                </div>
                                            
                                                <div class="footer">
                                                  <p>© '.date('Y').' XPower. All rights reserved.</p>
                                                  <p>
                                                    <a href="https://go2xpower.com/Terms_and_conditions.php">Terms</a>
                                                  </p>
                                                </div>
                                            
                                              </div>
                                            </body>
                                            </html>
                                        ';
                                        $mail_subject = "Getting Started with XPower";
                                    
                                    }elseif($emailId == 2){
                                        $message = '
                                            <!DOCTYPE html>
                                            <html>
                                            <head>
                                              <meta charset="UTF-8">
                                              <title>Top 5 Features You\'ll Love – XPower</title>
                                              <style>
                                                body {
                                                  margin: 0;
                                                  font-family: \'Segoe UI\', Arial, sans-serif;
                                                  background-color: #f4f6f8;
                                                  color: #2c2c2c;
                                                }
                                                .container {
                                                  max-width: 650px;
                                                  margin: 0 auto;
                                                  background-color: #ffffff;
                                                  border-radius: 10px;
                                                  box-shadow: 0 4px 10px rgba(0,0,0,0.05);
                                                  overflow: hidden;
                                                }
                                                .header {
                                                  background: #333;
                                                  color: white;
                                                  padding: 40px 20px;
                                                  text-align: center;
                                                }
                                                .header h1 {
                                                  margin: 0;
                                                  font-size: 26px;
                                                }
                                                .header p {
                                                  font-size: 16px;
                                                  margin-top: 10px;
                                                }
                                                .feature {
                                                  padding: 30px 25px;
                                                  border-bottom: 1px solid #eee;
                                                }
                                                .feature h2 {
                                                  font-size: 18px;
                                                  margin-bottom: 10px;
                                                  color: #444;
                                                }
                                                .feature p {
                                                  font-size: 15px;
                                                  line-height: 1.6;
                                                  margin: 0 0 15px;
                                                }
                                                .feature img {
                                                  max-width: 100%;
                                                  border-radius: 8px;
                                                  box-shadow: 0 2px 6px rgba(0,0,0,0.05);
                                                }
                                                .footer {
                                                  text-align: center;
                                                  font-size: 12px;
                                                  padding: 20px;
                                                  color: #888;
                                                  background: #f9f9f9;
                                                }
                                                .footer a {
                                                  color: #444;
                                                  text-decoration: none;
                                                  margin: 0 6px;
                                                }
                                                .button {
                                                  display: inline-block;
                                                  padding: 12px 24px;
                                                  background: #f76b1c;
                                                  color: white;
                                                  text-decoration: none;
                                                  border-radius: 6px;
                                                  font-weight: bold;
                                                  margin-top: 20px;
                                                }
                                              </style>
                                            </head>
                                            <body>
                                              <div class="container">
                                            
                                                <div class="header">
                                                  <h1>🚀 5 Features You’ll Absolutely Love</h1>
                                                  <p>Boost speed, accuracy & growth with XPower</p>
                                                </div>
                                            
                                                <div class="feature">
                                                  <h2>⚡ Quick Billing (No Mouse Needed)</h2>
                                                  <p>Speed through invoice creation using only your keyboard. Tab through fields, hit Enter to add items, and finish faster than ever.</p>
                                                  <img src="https://go2xpower.com/ajax/email_images/NewInvoice.gif" alt="Quick Billing Demo">
                                                </div>
                                            
                                                <div class="feature">
                                                  <h2>📲 SMS Alerts in Real-Time</h2>
                                                  <p>Keep customers informed automatically. XPower sends SMS updates for invoices, payments, dues, and more — instantly.</p>
                                                  <img src="https://go2xpower.com/ajax/email_images/SMSNotification.gif" alt="SMS Notification Demo">
                                                </div>
                                            
                                                <div class="feature">
                                                  <h2>📉 Credit Blocks + Last Sold Prices</h2>
                                                  <p>Stay on top of credit risk while invoicing. Instantly see each customer’s balance, credit status, and last sold prices on the same screen.</p>
                                                </div>
                                            
                                                <div class="feature">
                                                  <h2>📊 Outstanding Monitor + Advance Tracking</h2>
                                                  <p>Monitor unpaid invoices and track customer advance payments. The dashboard lets you filter, follow up, and never miss a receivable.</p>
                                                </div>
                                            
                                                <div class="feature">
                                                  <h2>📦 Stock Management with Age & Profit Insights</h2>
                                                  <p>Track item aging to avoid dead stock. Plus, analyze sales trends and profitability with real-time data — all in your dashboard.</p>
                                                </div>
                                            
                                                <div class="feature" style="text-align: center;">
                                                  <a href="https://go2xpower.com/login.php?u'.$toEmail.'" class="button">Explore xPower Now</a>
                                                </div>
                                            
                                                <div class="footer">
                                                  <p>© '.date('Y-m-d').' xPower. All rights reserved.</p>
                                                  <p><a href="https://go2xpower.com/Terms_and_conditions.php">Terms</a></p>
                                                </div>
                                            
                                              </div>
                                            </body>
                                            </html>
                                        ';
                                        $mail_subject = "Top 5 Features You’ll Love in xPower";
                                    }elseif($emailId == 3){
                                        $message = '
                                            <!DOCTYPE html>
                                            <html>
                                            <head>
                                              <meta charset="UTF-8">
                                              <title>Create Your First Invoice or Stock Entry</title>
                                              <style>
                                                body {
                                                  font-family: \'Segoe UI\', Arial, sans-serif;
                                                  margin: 0;
                                                  background-color: #f2f4f7;
                                                  color: #333;
                                                }
                                                .container {
                                                  max-width: 660px;
                                                  margin: 30px auto;
                                                  background-color: #ffffff;
                                                  border-radius: 12px;
                                                  box-shadow: 0 4px 16px rgba(0,0,0,0.06);
                                                  overflow: hidden;
                                                }
                                                .header {
                                                  background: linear-gradient(90deg, #4facfe, #00f2fe);
                                                  padding: 40px 30px;
                                                  text-align: center;
                                                  color: white;
                                                }
                                                .header h1 {
                                                  margin: 0;
                                                  font-size: 26px;
                                                }
                                                .header p {
                                                  margin-top: 10px;
                                                  font-size: 16px;
                                                }
                                                .section {
                                                  padding: 30px 25px;
                                                  border-bottom: 1px solid #eee;
                                                }
                                                .section h2 {
                                                  font-size: 20px;
                                                  margin-bottom: 10px;
                                                  color: #1a1a1a;
                                                }
                                                .section p {
                                                  font-size: 15px;
                                                  line-height: 1.7;
                                                  margin-bottom: 15px;
                                                }
                                                .highlight-box {
                                                  background-color: #fef6e5;
                                                  padding: 18px 20px;
                                                  border-left: 5px solid #ffc107;
                                                  border-radius: 6px;
                                                  margin: 20px 0;
                                                }
                                                .highlight-box p {
                                                  margin: 6px 0;
                                                  font-size: 14px;
                                                }
                                                .image {
                                                  display: block;
                                                  margin: 15px auto;
                                                  max-width: 100%;
                                                  border-radius: 10px;
                                                  box-shadow: 0 2px 10px rgba(0,0,0,0.05);
                                                }
                                                .cta-button {
                                                  display: inline-block;
                                                  margin-top: 20px;
                                                  padding: 12px 24px;
                                                  background: #00c851;
                                                  color: #fff;
                                                  text-decoration: none;
                                                  border-radius: 6px;
                                                  font-weight: bold;
                                                }
                                                .footer {
                                                  text-align: center;
                                                  font-size: 13px;
                                                  color: #888;
                                                  background-color: #f7f9fc;
                                                  padding: 20px;
                                                }
                                                .footer a {
                                                  color: #4facfe;
                                                  margin: 0 6px;
                                                  text-decoration: none;
                                                }
                                              </style>
                                            </head>
                                            <body>
                                            
                                              <div class="container">
                                            
                                                <div class="header">
                                                  <h1>🎯 Let\'s Get Practical with XPower</h1>
                                                  <p>Set up your first invoice or stock entry in minutes</p>
                                                </div>
                                            
                                                <div class="section">
                                                  <h2>🧾 Create Your First Invoice</h2>
                                                  <p>Invoicing in XPower is lightning-fast and keyboard-friendly. You can even see credit limits and last sold prices while billing!</p>
                                                  <div class="highlight-box">
                                                    <p><strong>Step 1:</strong> Go to <em>Create New → Invoice</em></p>
                                                    <p><strong>Step 2:</strong> Select your customer & items</p>
                                                    <p><strong>Step 3:</strong> Click <strong>Bill</strong> — you’re done!</p>
                                                  </div>
                                                  <img src="https://go2xpower.com/ajax/email_images/NewInvoice.gif" alt="Invoicing Walkthrough" class="image">
                                                  <div style="text-align:center;">
                                                    <a href="https://go2xpower.com/login.php?u'.$toEmail.'=&b=https://go2xpower.com/Home/Invoice/invoice.php" class="cta-button">Try Invoicing Now</a>
                                                  </div>
                                                </div>
                                            
                                                <div class="section">
                                                  <h2>📦 Add Your First Stock Item</h2>
                                                  <p>Ready to build your product catalog? Add new stock items with all the essential details like units, cost, category, vendor, and barcode.</p>
                                                  <div class="highlight-box">
                                                    <p><strong>Step 1:</strong> Go to <em>Inventory → Item Create</em></p>
                                                    <p><strong>Step 2:</strong> Fill in product details like name, unit, price, and stock</p>
                                                    <p><strong>Step 3:</strong> Click <strong>Save</strong></p>
                                                  </div>
                                                  <img src="https://go2xpower.com/ajax/email_images/ItemCustomerGif.gif" alt="Stock Entry" class="image">
                                                  <div style="text-align:center;">
                                                    <a href="https://go2xpower.com/login.php?u'.$toEmail.'=&b=https://go2xpower.com/Home/new/create_item.php" class="cta-button" style="background:#ff8800;">Add First Item</a>
                                                  </div>
                                                </div>
                                            
                                                <div class="section">
                                                  <h2>📥 Bulk Upload via Excel</h2>
                                                  <p>Have a list of items ready? No need to enter one-by-one. Upload all your products using our Excel import feature!</p>
                                                  <div class="highlight-box" style="background-color:#e3f2fd; border-left-color:#2196f3;">
                                                    <p><strong>Step 1:</strong> Download the Excel template inside <em>Item Create</em></p>
                                                    <p><strong>Step 2:</strong> Fill in your product data</p>
                                                    <p><strong>Step 3:</strong> Click <strong>Bulk Items Create → Upload</strong></p>
                                                  </div>
                                                  <div style="text-align:center;">
                                                    <a href="https://go2xpower.com/login.php?u'.$toEmail.'=&b=https://go2xpower.com/Home/Utility/index.php/Create/ImportRecords" class="cta-button" style="background:#2196f3;">Upload via Excel</a>
                                                  </div>
                                                </div>
                                            
                                                <div class="footer">
                                                  <p>Need help? <a href="https://help.go2xpower.com">Visit Help Center</a> or <a href="https://wa.me/94722693693">Whatsapp us</a></p>
                                                  <p>© '.date('Y-m-d').' xPower. All rights reserved.</p>
                                                </div>
                                            
                                              </div>
                                            
                                            </body>
                                            </html>

                                        ';
                                        $mail_subject = "Build Your Catalog. Bill Your Clients. All in XPower";
                                    
                                    }elseif($emailId == 4){
                                        $message = '
                                            <!DOCTYPE html>
                                            <html>
                                            <head>
                                              <meta charset="UTF-8">
                                              <title>Need Help? Let’s Chat on WhatsApp</title>
                                              <style>
                                                body {
                                                  font-family: \'Segoe UI\', Arial, sans-serif;
                                                  margin: 0;
                                                  background-color: #f8f9fb;
                                                  color: #333;
                                                }
                                                .container {
                                                  max-width: 620px;
                                                  margin: 30px auto;
                                                  background-color: #ffffff;
                                                  border-radius: 10px;
                                                  box-shadow: 0 4px 12px rgba(0,0,0,0.06);
                                                  overflow: hidden;
                                                }
                                                .header {
                                                  background-color: #25d366;
                                                  padding: 40px 30px;
                                                  text-align: center;
                                                  color: white;
                                                }
                                                .header h1 {
                                                  font-size: 24px;
                                                  margin: 0 0 10px;
                                                }
                                                .header p {
                                                  font-size: 15px;
                                                  margin: 0;
                                                }
                                                .content {
                                                  padding: 30px;
                                                }
                                                .content h2 {
                                                  font-size: 20px;
                                                  margin-bottom: 10px;
                                                  color: #222;
                                                }
                                                .content p {
                                                  font-size: 15px;
                                                  line-height: 1.6;
                                                  margin-bottom: 15px;
                                                }
                                                .whatsapp-box {
                                                  background-color: #eafaf1;
                                                  border-left: 5px solid #25d366;
                                                  padding: 20px;
                                                  border-radius: 6px;
                                                  margin: 20px 0;
                                                }
                                                .whatsapp-box p {
                                                  margin: 6px 0;
                                                  font-size: 14px;
                                                }
                                                .cta {
                                                  text-align: center;
                                                  margin-top: 20px;
                                                }
                                                .cta a {
                                                  background-color: #25d366;
                                                  color: white;
                                                  padding: 12px 28px;
                                                  text-decoration: none;
                                                  border-radius: 6px;
                                                  font-weight: bold;
                                                  font-size: 15px;
                                                }
                                                .footer {
                                                  text-align: center;
                                                  font-size: 13px;
                                                  padding: 20px;
                                                  color: #999;
                                                  background: #f4f6f8;
                                                }
                                                .footer a {
                                                  color: #25d366;
                                                  text-decoration: none;
                                                  margin: 0 6px;
                                                }
                                              </style>
                                            </head>
                                            <body>
                                            
                                              <div class="container">
                                            
                                                <div class="header">
                                                  <h1>Need Help Getting Started?</h1>
                                                  <p>Our team is just a message away on WhatsApp</p>
                                                </div>
                                            
                                                <div class="content">
                                                  <h2>We’re Here to Support You</h2>
                                                  <p>Whether you have a quick question, need a feature walkthrough, or want a personalized demo — we\'re happy to help.</p>
                                            
                                                  <div class="whatsapp-box">
                                                    <p>✅ Available Monday to Saturday</p>
                                                    <p>✅ Quick replies from our product team</p>
                                                    <p>✅ Video or screen sharing support available</p>
                                                  </div>
                                            
                                                  <div class="cta">
                                                    <a href="https://wa.me/94722693693?text=Hi%20XPower%20Team,%20I%20need%20help%20getting%20started" target="_blank">
                                                      💬 Chat with Us on WhatsApp
                                                    </a>
                                                  </div>
                                                </div>
                                            
                                                <div class="footer">
                                                  <p>Still exploring? Visit the <a href="https://help.go2xpower.com/help">Help Center</a> or <a href="https://wa.me/94722693693">Whatsapp us</a>.</p>
                                                  <p>© '.date('Y-m-d').' xPower. All rights reserved.</p>
                                                </div>
                                            
                                              </div>
                                            
                                            </body>
                                            </html>
                                        ';
                                        $mail_subject = "The Easiest Way to Get xPower Support";
                                    }elseif($emailId == 5){
                                        $message = '
                                            <!DOCTYPE html>
                                            <html>
                                            <head>
                                              <meta charset="UTF-8">
                                              <title>How XPower Saves Time & Money</title>
                                              <style>
                                                body {
                                                  font-family: \'Segoe UI\', Arial, sans-serif;
                                                  background-color: #f3f4f6;
                                                  color: #333;
                                                  margin: 0;
                                                  padding: 0;
                                                }
                                                .container {
                                                  max-width: 660px;
                                                  margin: 30px auto;
                                                  background-color: #ffffff;
                                                  border-radius: 10px;
                                                  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
                                                  overflow: hidden;
                                                }
                                                .header {
                                                  background: linear-gradient(90deg, #6a11cb, #2575fc);
                                                  color: #fff;
                                                  padding: 40px 30px;
                                                  text-align: center;
                                                }
                                                .header h1 {
                                                  margin: 0;
                                                  font-size: 26px;
                                                }
                                                .header p {
                                                  font-size: 16px;
                                                  margin-top: 10px;
                                                }
                                                .section {
                                                  padding: 30px;
                                                }
                                                .section h2 {
                                                  color: #2d2d2d;
                                                  font-size: 20px;
                                                  margin-bottom: 10px;
                                                }
                                                .section p {
                                                  font-size: 15px;
                                                  line-height: 1.7;
                                                  margin-bottom: 20px;
                                                }
                                                .testimonial {
                                                  background-color: #eef2ff;
                                                  padding: 20px;
                                                  border-left: 4px solid #6a11cb;
                                                  font-style: italic;
                                                  border-radius: 6px;
                                                  margin: 30px 0;
                                                }
                                                .cta {
                                                  text-align: center;
                                                  margin-top: 30px;
                                                }
                                                .cta a {
                                                  background-color: #2575fc;
                                                  color: white;
                                                  text-decoration: none;
                                                  padding: 12px 28px;
                                                  font-weight: bold;
                                                  border-radius: 6px;
                                                  font-size: 15px;
                                                }
                                                .support-box {
                                                  background: #f5f5f5;
                                                  padding: 20px;
                                                  border-radius: 8px;
                                                  margin-top: 30px;
                                                  font-size: 14px;
                                                  text-align: center;
                                                  color: #555;
                                                }
                                                .support-box a {
                                                  display: inline-block;
                                                  margin-top: 10px;
                                                  padding: 10px 22px;
                                                  background-color: #25d366;
                                                  color: white;
                                                  font-weight: bold;
                                                  border-radius: 6px;
                                                  text-decoration: none;
                                                  font-size: 14px;
                                                }
                                                .footer {
                                                  background-color: #f9f9f9;
                                                  padding: 20px;
                                                  font-size: 12px;
                                                  color: #999;
                                                  text-align: center;
                                                }
                                                .footer a {
                                                  color: #6a11cb;
                                                  text-decoration: none;
                                                  margin: 0 6px;
                                                }
                                              </style>
                                            </head>
                                            <body>
                                            
                                              <div class="container">
                                            
                                                <div class="header">
                                                  <h1>Save Time. Cut Costs. Work Smart.</h1>
                                                  <p>Discover how XPower helps real businesses thrive</p>
                                                </div>
                                            
                                                <div class="section">
                                                  <h2>🚀 Automate Daily Tasks</h2>
                                                  <p>From invoicing and payment tracking to inventory aging and outstanding balances — XPower automates your workflow, so you can focus on growth.</p>
                                            
                                                  <h2>📉 Eliminate Costly Errors</h2>
                                                  <p>Get alerts on stock shortages, credit limits, and due invoices before they become problems. Reduce human error and maximize every transaction.</p>
                                            
                                                  <h2>📊 Instant Insights = Better Decisions</h2>
                                                  <p>Know what’s selling, who owes you, how much profit you’re making — all in real-time. No spreadsheets. No guesswork.</p>
                                            
                                                  <div class="testimonial">
                                                    “With XPower, we issue invoices faster, track payments effortlessly, and manage over 5,000+ stock items without confusion.”<br>
                                                    – Apeshop.lk, Colombo Sri Lanka
                                                  </div>
                                            
                                                  <div class="testimonial">
                                                    “We’ve switched from spreadsheets to XPower in our Dubai wholesale shop. It tracks our inventory and customer credits better than any system we’ve tried.”<br>
                                                    – Al Marwa Electronics, Dubai
                                                  </div>
                                            
                                                  <div class="testimonial">
                                                    “As a small business in Texas, I needed a reliable way to manage cash flow and stock without hiring extra staff. XPower delivered more than I expected.”<br>
                                                    – Brielle & Co., Texas
                                                  </div>
                                            
                                                  <div class="cta">
                                                    <a href="https://go2xpower.com/login.php">Log In to XPower</a>
                                                  </div>
                                            
                                                  <div class="support-box">
                                                    Need help getting started?<br>
                                                    Our team is available on WhatsApp for quick assistance.
                                                    <br>
                                                    <a href="https://wa.me/94722693693?text=Hi%20XPower%20Team,%20I%20need%20some%20help%20with%20getting%20started.">💬 Chat on WhatsApp</a>
                                                  </div>
                                                </div>
                                            
                                                <div class="footer">
                                                  <p>
                                                    <a href="https://help.go2xpower.com">Help Center</a> |
                                                    <a href="https://go2xpower.com/Terms_and_conditions.php">Terms & Conditions</a>
                                                  </p>
                                                  <p>© '.date('Y-m-d').' xPower. All rights reserved.</p>
                                                </div>
                                            
                                              </div>
                                            
                                            </body>
                                            </html>
                                        ';
                                        $mail_subject = "Why Businesses in Sri Lanka, Dubai & the USA Choose XPower";
                                    }elseif($emailId == 6){
                                        $message = '
                                            <!DOCTYPE html>
                                            <html>
                                            <head>
                                              <meta charset="UTF-8">
                                              <title>Hidden Gems in XPower</title>
                                              <style>
                                                body {
                                                  margin: 0;
                                                  background-color: #f5f7fa;
                                                  font-family: \'Segoe UI\', Arial, sans-serif;
                                                  color: #333;
                                                }
                                                .container {
                                                  max-width: 660px;
                                                  margin: 30px auto;
                                                  background-color: #ffffff;
                                                  border-radius: 10px;
                                                  overflow: hidden;
                                                  box-shadow: 0 4px 16px rgba(0,0,0,0.05);
                                                }
                                                .header {
                                                  background: linear-gradient(90deg, #ff8a00, #e52e71);
                                                  color: white;
                                                  text-align: center;
                                                  padding: 40px 30px;
                                                }
                                                .header h1 {
                                                  margin: 0;
                                                  font-size: 26px;
                                                }
                                                .header p {
                                                  margin: 10px 0 0;
                                                  font-size: 16px;
                                                }
                                                .section {
                                                  padding: 30px;
                                                }
                                                .section h2 {
                                                  font-size: 18px;
                                                  margin-bottom: 10px;
                                                  color: #e52e71;
                                                }
                                                .section p {
                                                  font-size: 15px;
                                                  line-height: 1.7;
                                                  margin-bottom: 18px;
                                                }
                                                .feature-box {
                                                  background: #fff3ec;
                                                  border-left: 5px solid #ff8a00;
                                                  padding: 18px 20px;
                                                  border-radius: 6px;
                                                  margin: 20px 0;
                                                }
                                                .feature-box h3 {
                                                  margin: 0 0 6px;
                                                  font-size: 16px;
                                                  color: #333;
                                                }
                                                .feature-box p {
                                                  margin: 0;
                                                  font-size: 14px;
                                                  color: #444;
                                                }
                                                .cta {
                                                  text-align: center;
                                                  margin-top: 30px;
                                                }
                                                .cta a {
                                                  background-color: #e52e71;
                                                  color: white;
                                                  text-decoration: none;
                                                  padding: 12px 28px;
                                                  font-weight: bold;
                                                  border-radius: 6px;
                                                  font-size: 15px;
                                                }
                                                .footer {
                                                  background-color: #f4f4f4;
                                                  padding: 20px;
                                                  font-size: 12px;
                                                  color: #888;
                                                  text-align: center;
                                                }
                                                .footer a {
                                                  color: #e52e71;
                                                  text-decoration: none;
                                                  margin: 0 6px;
                                                }
                                              </style>
                                            </head>
                                            <body>
                                            
                                              <div class="container">
                                            
                                                <div class="header">
                                                  <h1>💡 Hidden Gems in XPower</h1>
                                                  <p>Power-user tips that save time and unlock insights</p>
                                                </div>
                                            
                                                <div class="section">
                                                  <p>You already know XPower helps you invoice and manage inventory. But did you know it also comes packed with time-saving features many users miss?</p>
                                            
                                                  <div class="feature-box">
                                                    <h3>📤 SMS Alerts on Credit Limit Breach</h3>
                                                    <p>Automatically notify customers when their invoice exceeds credit terms — no manual follow-up needed.</p>
                                                  </div>
                                            
                                                  <div class="feature-box">
                                                    <h3>📊 Item & Customer Sales Trends</h3>
                                                    <p>See what’s selling and who’s buying with smart graphs — filter by item, customer, or month.</p>
                                                  </div>
                                            
                                                  <div class="feature-box">
                                                    <h3>🔁 Edit Invoices (With Audit Trail)</h3>
                                                    <p>Correct mistakes after printing — safely. Every change is logged for accountability.</p>
                                                  </div>
                                            
                                                  <div class="feature-box">
                                                    <h3>📦 Stock Reorder Suggestions (By Aging)</h3>
                                                    <p>Prioritize purchases using aging-based alerts. Avoid overstocking slow-moving items.</p>
                                                  </div>
                                            
                                                  <div class="feature-box">
                                                    <h3>🧮 Built-In Tax Breakdown</h3>
                                                    <p>Auto-calculate VAT/NBT at multiple rates and view clean summaries per invoice or customer.</p>
                                                  </div>
                                            
                                                  <div class="cta">
                                                    <a href="https://go2xpower.com/login.php?u='.$toEmail.'">Try These in XPower</a>
                                                  </div>
                                                </div>
                                            
                                                <div class="footer">
                                                  <p>
                                                    <a href="https://help.go2xpower.com">Help Center</a> |
                                                    <a href="https://go2xpower.com/Terms_and_conditions.php">Terms & Conditions</a>
                                                  </p>
                                                  <p>Need help? <a href="https://wa.me/94722693693">Chat on WhatsApp</a></p>
                                                  <p>© '.date('Y-m-d').' XPower. All rights reserved.</p>
                                                </div>
                                            
                                              </div>
                                            
                                            </body>
                                            </html>
                                        ';
                                        $mail_subject = "You’re Not Using xPower Fully Until You Try These";
                                    }elseif($emailId == 7){
                                        $message = '
                                            <!DOCTYPE html>
                                            <html>
                                            <head>
                                              <meta charset="UTF-8">
                                              <title>How’s Your Trial Going? Need Help with Anything?</title>
                                              <style>
                                                body {
                                                  font-family: \'Segoe UI\', Arial, sans-serif;
                                                  margin: 0;
                                                  background-color: #f2f4f7;
                                                  color: #333;
                                                }
                                                .container {
                                                  max-width: 660px;
                                                  margin: 30px auto;
                                                  background-color: #ffffff;
                                                  border-radius: 12px;
                                                  box-shadow: 0 4px 16px rgba(0,0,0,0.06);
                                                  overflow: hidden;
                                                }
                                                .header {
                                                  background: linear-gradient(90deg, #36d1dc, #5b86e5);
                                                  color: white;
                                                  padding: 40px 30px;
                                                  text-align: center;
                                                }
                                                .header h1 {
                                                  margin: 0;
                                                  font-size: 26px;
                                                }
                                                .header p {
                                                  margin-top: 10px;
                                                  font-size: 16px;
                                                }
                                                .section {
                                                  padding: 30px;
                                                }
                                                .section h2 {
                                                  font-size: 20px;
                                                  margin-bottom: 10px;
                                                  color: #333;
                                                }
                                                .section p {
                                                  font-size: 15px;
                                                  line-height: 1.7;
                                                  margin-bottom: 20px;
                                                }
                                                .cta-button {
                                                  display: inline-block;
                                                  margin: 10px 0;
                                                  padding: 12px 24px;
                                                  background: #5b86e5;
                                                  color: white;
                                                  text-decoration: none;
                                                  font-weight: bold;
                                                  border-radius: 6px;
                                                }
                                                .support {
                                                  background-color: #f7f9fb;
                                                  border: 1px solid #e1e8f0;
                                                  padding: 20px;
                                                  border-radius: 8px;
                                                  text-align: center;
                                                  margin-top: 30px;
                                                }
                                                .support a {
                                                  display: inline-block;
                                                  background-color: #25d366;
                                                  color: white;
                                                  padding: 10px 20px;
                                                  border-radius: 6px;
                                                  text-decoration: none;
                                                  font-weight: bold;
                                                  margin-top: 10px;
                                                }
                                                .footer {
                                                  background-color: #f5f5f5;
                                                  text-align: center;
                                                  padding: 20px;
                                                  font-size: 12px;
                                                  color: #888;
                                                }
                                                .footer a {
                                                  color: #5b86e5;
                                                  text-decoration: none;
                                                  margin: 0 6px;
                                                }
                                              </style>
                                            </head>
                                            <body>
                                            
                                              <div class="container">
                                            
                                                <div class="header">
                                                  <h1>👋 Just Checking In</h1>
                                                  <p>How’s your XPower trial going so far?</p>
                                                </div>
                                            
                                                <div class="section">
                                                  <h2>We’re Here If You Need Us</h2>
                                                  <p>You\'re halfway through your free trial, and we want to make sure everything is working smoothly. Have you run into any issues? Need help setting up a specific feature?</p>
                                                  <p>Don’t hesitate to reach out — we’re here to support you every step of the way.</p>
                                            
                                                  <div class="cta" style="text-align: center;">
                                                    <a href="https://help.go2xpower.com" class="cta-button">Visit Help Center</a>
                                                  </div>
                                            
                                                  <div class="support">
                                                    Prefer WhatsApp? Our support team is available for quick answers and personalized help.
                                                    <br>
                                                    <a href="https://wa.me/94722693693?text=Hi%20XPower%20Team,%20I%20have%20a%20question%20about%20my%20trial.">💬 Chat on WhatsApp</a>
                                                  </div>
                                                </div>
                                            
                                                <div class="footer">
                                                  <p>
                                                    <a href="https://help.go2xpower.com">Help Center</a> |
                                                    <a href="https://go2xpower.com/Terms_and_conditions.php">Terms & Conditions</a>
                                                  </p>
                                                  <p>© '.date('Y-m-d').' xPower. All rights reserved.</p>
                                                </div>
                                            
                                              </div>
                                            
                                            </body>
                                            </html>

                                        ';
                                        $mail_subject = "How’s Your Trial Going? Need Help with Anything?";
                                    }elseif($emailId == 8){
                                        $message = '
                                            <!DOCTYPE html>
                                            <html>
                                            <head>
                                              <meta charset="UTF-8">
                                              <title>Client Success Story – Al Marwa Electronics</title>
                                              <style>
                                                body {
                                                  font-family: \'Segoe UI\', Arial, sans-serif;
                                                  background-color: #f7f9fc;
                                                  color: #333;
                                                  margin: 0;
                                                  padding: 0;
                                                }
                                                .container {
                                                  max-width: 660px;
                                                  margin: 30px auto;
                                                  background-color: #ffffff;
                                                  border-radius: 10px;
                                                  box-shadow: 0 4px 14px rgba(0,0,0,0.05);
                                                  overflow: hidden;
                                                }
                                                .header {
                                                  background: linear-gradient(90deg, #00c6ff, #0072ff);
                                                  color: white;
                                                  text-align: center;
                                                  padding: 40px 30px;
                                                }
                                                .header h1 {
                                                  margin: 0;
                                                  font-size: 26px;
                                                }
                                                .header p {
                                                  font-size: 16px;
                                                  margin-top: 10px;
                                                }
                                                .section {
                                                  padding: 30px;
                                                }
                                                .section h2 {
                                                  font-size: 20px;
                                                  color: #0072ff;
                                                  margin-bottom: 15px;
                                                }
                                                .section p {
                                                  font-size: 15px;
                                                  line-height: 1.7;
                                                  margin-bottom: 20px;
                                                }
                                                .quote {
                                                  background-color: #f0f7ff;
                                                  border-left: 4px solid #00c6ff;
                                                  padding: 20px;
                                                  font-style: italic;
                                                  margin: 20px 0;
                                                  border-radius: 6px;
                                                  color: #444;
                                                }
                                                .results {
                                                  background-color: #fff8e1;
                                                  padding: 20px;
                                                  border-radius: 6px;
                                                  border-left: 5px solid #ffc107;
                                                  margin-bottom: 20px;
                                                }
                                                .results ul {
                                                  padding-left: 20px;
                                                  margin: 0;
                                                }
                                                .results li {
                                                  margin-bottom: 8px;
                                                }
                                                .cta {
                                                  text-align: center;
                                                  margin-top: 30px;
                                                }
                                                .cta a {
                                                  background-color: #0072ff;
                                                  color: white;
                                                  text-decoration: none;
                                                  padding: 12px 28px;
                                                  font-weight: bold;
                                                  border-radius: 6px;
                                                  font-size: 15px;
                                                }
                                                .footer {
                                                  background-color: #f1f1f1;
                                                  text-align: center;
                                                  padding: 20px;
                                                  font-size: 12px;
                                                  color: #888;
                                                }
                                                .footer a {
                                                  color: #0072ff;
                                                  text-decoration: none;
                                                  margin: 0 6px;
                                                }
                                              </style>
                                            </head>
                                            <body>
                                            
                                              <div class="container">
                                            
                                                <div class="header">
                                                  <h1>📈 Client Success Story</h1>
                                                  <p>How Al Marwa Electronics Transformed Operations with XPower</p>
                                                </div>
                                            
                                                <div class="section">
                                                  <h2>🛍️ About the Business</h2>
                                                  <p>Al Marwa Electronics is a Dubai-based wholesale and retail distributor of electronic accessories. They manage over 1,500 SKUs across multiple warehouses and deal with both cash and credit clients daily.</p>
                                            
                                                  <h2>⚠️ The Challenge</h2>
                                                  <p>Manual invoicing and outdated inventory tracking created billing delays and frequent stockouts. Credit sales were hard to manage, leading to overdue balances and customer disputes.</p>
                                            
                                                  <h2>✅ The XPower Solution</h2>
                                                  <p>With XPower, the team automated their billing workflow, enabled credit alerts via SMS, and began using the reorder suggestion tool based on real-time stock aging.</p>
                                            
                                                  <div class="quote">
                                                    “XPower helped us cut our billing time in half and finally gain full control over our inventory. Our customers also appreciate the automated SMS alerts on outstanding dues.”
                                                    <br>– Faizal, Operations Manager, Al Marwa Electronics
                                                  </div>
                                            
                                                  <div class="results">
                                                    <strong>Results after 30 days:</strong>
                                                    <ul>
                                                      <li>🕒 2x faster invoicing process</li>
                                                      <li>📉 30% fewer stockouts</li>
                                                      <li>📲 Better client follow-up using automated SMS</li>
                                                    </ul>
                                                  </div>
                                            
                                                  <div class="cta">
                                                    <a href="https://go2xpower.com/login.php?u='.$toEmail.'">Start Your Success Story</a>
                                                  </div>
                                                </div>
                                            
                                                <div class="footer">
                                                  <p>
                                                    <a href="https://help.go2xpower.com">Help Center</a> |
                                                    <a href="https://go2xpower.com/Terms_and_conditions.php">Terms & Conditions</a>
                                                  </p>
                                                  <p>Need support? <a href="https://wa.me/94722693693">WhatsApp Us</a></p>
                                                  <p>© '.date('Y-m-d').' XPower. All rights reserved.</p>
                                                </div>
                                            
                                              </div>
                                            
                                            </body>
                                            </html>

                                        ';
                                        $mail_subject = "How a Dubai Retailer Doubled Invoicing Speed with xPower";
                                    }elseif($emailId == 9){
                                        $message = '
                                            <!DOCTYPE html>
                                            <html>
                                            <head>
                                              <meta charset="UTF-8">
                                              <title>Inventory Features for Growing Businesses</title>
                                              <style>
                                                body {
                                                  font-family: \'Segoe UI\', Arial, sans-serif;
                                                  background-color: #f9f6fb;
                                                  color: #333;
                                                  margin: 0;
                                                }
                                                .container {
                                                  max-width: 660px;
                                                  margin: 30px auto;
                                                  background-color: #ffffff;
                                                  border-radius: 10px;
                                                  box-shadow: 0 4px 14px rgba(0,0,0,0.05);
                                                  overflow: hidden;
                                                }
                                                .header {
                                                  background: linear-gradient(90deg, #a64ac9, #ff6f61);
                                                  color: white;
                                                  padding: 40px 30px;
                                                  text-align: center;
                                                }
                                                .header h1 {
                                                  margin: 0;
                                                  font-size: 26px;
                                                }
                                                .header p {
                                                  font-size: 16px;
                                                  margin-top: 10px;
                                                }
                                                .section {
                                                  padding: 30px;
                                                }
                                                .section h2 {
                                                  font-size: 20px;
                                                  color: #a64ac9;
                                                  margin-bottom: 12px;
                                                }
                                                .section p {
                                                  font-size: 15px;
                                                  line-height: 1.7;
                                                  margin-bottom: 18px;
                                                }
                                                .feature-box {
                                                  background-color: #fdf0f7;
                                                  padding: 16px 20px;
                                                  border-left: 5px solid #ff6f61;
                                                  border-radius: 6px;
                                                  margin-bottom: 15px;
                                                }
                                                .feature-box h3 {
                                                  margin: 0 0 6px;
                                                  font-size: 16px;
                                                  color: #333;
                                                }
                                                .feature-box p {
                                                  margin: 0;
                                                  font-size: 14px;
                                                }
                                                .cta {
                                                  text-align: center;
                                                  margin-top: 30px;
                                                }
                                                .cta a {
                                                  background-color: #ff6f61;
                                                  color: white;
                                                  text-decoration: none;
                                                  padding: 12px 28px;
                                                  font-weight: bold;
                                                  border-radius: 6px;
                                                  font-size: 15px;
                                                }
                                                .footer {
                                                  background-color: #f4f4f4;
                                                  text-align: center;
                                                  padding: 20px;
                                                  font-size: 12px;
                                                  color: #888;
                                                }
                                                .footer a {
                                                  color: #a64ac9;
                                                  text-decoration: none;
                                                  margin: 0 6px;
                                                }
                                              </style>
                                            </head>
                                            <body>
                                            
                                              <div class="container">
                                            
                                                <div class="header">
                                                  <h1>📦 Powerful Inventory Made Simple</h1>
                                                  <p>Track stock across cities, countries, and branches</p>
                                                </div>
                                            
                                                <div class="section">
                                                  <p>Managing inventory across multiple branches and locations? Whether you\'re based in Sri Lanka, Dubai, Italy, or the US — XPower is built to simplify your stock operations and help you scale confidently.</p>
                                            
                                                  <div class="feature-box">
                                                    <h3>🌍 Multi-Location Stock Visibility</h3>
                                                    <p>See real-time inventory per branch, warehouse, or region. Transfer stock easily between locations.</p>
                                                  </div>
                                            
                                                  <div class="feature-box">
                                                    <h3>📉 Reorder Alerts by Location</h3>
                                                    <p>Set minimum stock levels and receive alerts before you run out — branch by branch.</p>
                                                  </div>
                                            
                                                  <div class="feature-box">
                                                    <h3>📅 Expiry & Aging Analysis</h3>
                                                    <p>Monitor slow-moving stock and products near expiry — ideal for FMCG, electronics, and pharmaceuticals.</p>
                                                  </div>
                                            
                                                  <div class="feature-box">
                                                    <h3>📊 Reports by Category or Region</h3>
                                                    <p>Generate performance reports by product, category, or location — perfect for decision-making.</p>
                                                  </div>
                                            
                                                  <div class="feature-box">
                                                    <h3>📥 Excel Import for Easy Setup</h3>
                                                    <p>Upload hundreds of products at once using our downloadable Excel template.</p>
                                                  </div>
                                            
                                                  <div class="cta">
                                                    <a href="https://go2xpower.com/login.php?u='.$toEmail.'">Manage My Inventory</a>
                                                  </div>
                                                </div>
                                            
                                                <div class="footer">
                                                  <p>
                                                    <a href="https://help.go2xpower.com">Help Center</a> |
                                                    <a href="https://go2xpower.com/Terms_and_conditions.php">Terms & Conditions</a>
                                                  </p>
                                                  <p>Need help? <a href="https://wa.me/94722693693">WhatsApp Us</a></p>
                                                  <p>© '.date('Y-m-d').' XPower. All rights reserved.</p>
                                                </div>
                                            
                                              </div>
                                            
                                            </body>
                                            </html>

                                        ';
                                        $mail_subject = "Powerful Inventory for Multi-Branch Businesses";
                                    }elseif($emailId == 10){
                                        $message = '
                                            <!DOCTYPE html>
                                            <html>
                                            <head>
                                              <meta charset="UTF-8">
                                              <title>Why Businesses Choose XPower</title>
                                              <style>
                                                body {
                                                  font-family: \'Segoe UI\', Arial, sans-serif;
                                                  margin: 0;
                                                  background-color: #f7f8fa;
                                                  color: #333;
                                                }
                                                .container {
                                                  max-width: 660px;
                                                  margin: 30px auto;
                                                  background: #ffffff;
                                                  border-radius: 10px;
                                                  box-shadow: 0 4px 16px rgba(0,0,0,0.05);
                                                  overflow: hidden;
                                                }
                                                .header {
                                                  background: linear-gradient(90deg, #7b4397, #dc2430);
                                                  color: white;
                                                  padding: 40px 30px;
                                                  text-align: center;
                                                }
                                                .header h1 {
                                                  margin: 0;
                                                  font-size: 26px;
                                                }
                                                .header p {
                                                  font-size: 16px;
                                                  margin-top: 10px;
                                                }
                                                .section {
                                                  padding: 30px;
                                                }
                                                .section h2 {
                                                  font-size: 20px;
                                                  color: #dc2430;
                                                  margin-bottom: 12px;
                                                }
                                                .section p {
                                                  font-size: 15px;
                                                  line-height: 1.7;
                                                  margin-bottom: 20px;
                                                }
                                                .comparison-table {
                                                  width: 100%;
                                                  border-collapse: collapse;
                                                  margin: 20px 0;
                                                  font-size: 14px;
                                                }
                                                .comparison-table th, .comparison-table td {
                                                  border: 1px solid #ddd;
                                                  padding: 12px;
                                                  text-align: center;
                                                }
                                                .comparison-table th {
                                                  background-color: #f5f0fb;
                                                  color: #444;
                                                }
                                                .comparison-table td:first-child {
                                                  text-align: left;
                                                  font-weight: bold;
                                                  background-color: #fcfcfc;
                                                }
                                                .check {
                                                  color: #28a745;
                                                  font-weight: bold;
                                                }
                                                .cross {
                                                  color: #e74c3c;
                                                  font-weight: bold;
                                                }
                                                .note {
                                                  font-size: 13px;
                                                  color: #777;
                                                  margin-top: 10px;
                                                  font-style: italic;
                                                }
                                                .cta {
                                                  text-align: center;
                                                  margin-top: 30px;
                                                }
                                                .cta a {
                                                  background-color: #dc2430;
                                                  color: white;
                                                  text-decoration: none;
                                                  padding: 12px 28px;
                                                  font-weight: bold;
                                                  border-radius: 6px;
                                                  font-size: 15px;
                                                }
                                                .footer {
                                                  background-color: #f1f1f1;
                                                  text-align: center;
                                                  padding: 20px;
                                                  font-size: 12px;
                                                  color: #888;
                                                }
                                                .footer a {
                                                  color: #7b4397;
                                                  text-decoration: none;
                                                  margin: 0 6px;
                                                }
                                              </style>
                                            </head>
                                            <body>
                                            
                                              <div class="container">
                                            
                                                <div class="header">
                                                  <h1>Why Businesses Choose XPower</h1>
                                                  <p>Here’s what sets us apart from the rest</p>
                                                </div>
                                            
                                                <div class="section">
                                                  <p>XPower does what every accounting software should — but we go beyond the basics. See what makes XPower the choice for modern, growing businesses:</p>
                                            
                                                  <table class="comparison-table">
                                                    <thead>
                                                      <tr>
                                                        <th>Feature</th>
                                                        <th><strong>XPower</strong></th>
                                                        <th>Other Software</th>
                                                      </tr>
                                                    </thead>
                                                    <tbody>
                                                      <tr>
                                                        <td>Quick Billing Without Mouse</td>
                                                        <td class="check">✔</td>
                                                        <td class="cross">✖</td>
                                                      </tr>
                                                      <tr>
                                                        <td>SMS & WhatsApp Invoice Sharing</td>
                                                        <td class="check">✔</td>
                                                        <td class="cross">✖</td>
                                                      </tr>
                                                      <tr>
                                                        <td>Stock Aging Report</td>
                                                        <td class="check">✔</td>
                                                        <td class="cross">✖</td>
                                                      </tr>
                                                      <tr>
                                                        <td>Cheque Management Module</td>
                                                        <td class="check">✔</td>
                                                        <td class="cross">✖</td>
                                                      </tr>
                                                      <tr>
                                                        <td>Multi 3 Users Included by Default</td>
                                                        <td class="check">✔</td>
                                                        <td class="cross">✖ (extra cost)</td>
                                                      </tr>
                                                      <tr>
                                                        <td>Expenses & Cash Book</td>
                                                        <td class="check">✔</td>
                                                        <td class="check">✔</td>
                                                      </tr>
                                                      <tr>
                                                        <td>Inventory & Outstanding Monitor</td>
                                                        <td class="check">✔</td>
                                                        <td class="check">✔</td>
                                                      </tr>
                                                      <tr>
                                                        <td>Profit & Loss / Trial Balance</td>
                                                        <td class="check">✔</td>
                                                        <td class="check">✔</td>
                                                      </tr>
                                                      <tr>
                                                        <td>Bank Reconciliation</td>
                                                        <td class="check">✔</td>
                                                        <td class="check">✔</td>
                                                      </tr>
                                                    </tbody>
                                                  </table>
                                            
                                                  <p class="note">✔ = Included | ✖ = Not available or requires 3rd-party tools</p>
                                            
                                                  <p>When you choose XPower, you’re not just getting accounting — you\'re unlocking a system that works like a business assistant.</p>
                                            
                                                  <div class="cta">
                                                    <a href="https://go2xpower.com/login.php?u='.$toEmail.'">Continue with xPower</a>
                                                  </div>
                                                </div>
                                            
                                                <div class="footer">
                                                  <p>
                                                    <a href="https://help.go2xpower.com">Help Center</a> |
                                                    <a href="https://go2xpower.com/Terms_and_conditions.php">Terms & Conditions</a>
                                                  </p>
                                                  <p>Need help? <a href="https://wa.me/94722693693">WhatsApp Us</a></p>
                                                  <p>© '.date('Y-m-d').' XPower. All rights reserved.</p>
                                                </div>
                                            
                                              </div>
                                            
                                            </body>
                                            </html>

                                        ';
                                        $mail_subject = "See What Only xPower Gives You (That Others Don’t)";
                                    }elseif($emailId == 11){
                                        $message = '
                                            <!DOCTYPE html>
                                            <html>
                                            <head>
                                              <meta charset="UTF-8">
                                              <title>You\'re Almost There â€” Upgrade to Full Access</title>
                                              <style>
                                                body {
                                                  font-family: \'Segoe UI\', Arial, sans-serif;
                                                  background-color: #fdf9f4;
                                                  color: #333;
                                                  margin: 0;
                                                }
                                                .container {
                                                  max-width: 660px;
                                                  margin: 30px auto;
                                                  background-color: #ffffff;
                                                  border-radius: 10px;
                                                  box-shadow: 0 4px 14px rgba(0,0,0,0.06);
                                                  overflow: hidden;
                                                }
                                                .header {
                                                  background: linear-gradient(90deg, #f857a6, #ff5858);
                                                  color: white;
                                                  padding: 40px 30px;
                                                  text-align: center;
                                                }
                                                .header h1 {
                                                  margin: 0;
                                                  font-size: 28px;
                                                }
                                                .header p {
                                                  font-size: 16px;
                                                  margin-top: 10px;
                                                }
                                                .section {
                                                  padding: 30px;
                                                }
                                                .section h2 {
                                                  font-size: 20px;
                                                  color: #f857a6;
                                                  margin-bottom: 12px;
                                                }
                                                .section p {
                                                  font-size: 15px;
                                                  line-height: 1.7;
                                                  margin-bottom: 20px;
                                                }
                                                .benefit {
                                                  background-color: #fff1f7;
                                                  padding: 16px 20px;
                                                  border-left: 5px solid #f857a6;
                                                  border-radius: 6px;
                                                  margin-bottom: 15px;
                                                }
                                                .benefit h3 {
                                                  margin: 0 0 6px;
                                                  font-size: 16px;
                                                  color: #333;
                                                }
                                                .benefit p {
                                                  margin: 0;
                                                  font-size: 14px;
                                                }
                                                .cta {
                                                  text-align: center;
                                                  margin-top: 30px;
                                                }
                                                .cta a {
                                                  background-color: #ff5858;
                                                  color: white;
                                                  text-decoration: none;
                                                  padding: 12px 28px;
                                                  font-weight: bold;
                                                  border-radius: 6px;
                                                  font-size: 16px;
                                                }
                                                .footer {
                                                  background-color: #f4f4f4;
                                                  text-align: center;
                                                  padding: 20px;
                                                  font-size: 12px;
                                                  color: #888;
                                                }
                                                .footer a {
                                                  color: #f857a6;
                                                  text-decoration: none;
                                                  margin: 0 6px;
                                                }
                                              </style>
                                            </head>
                                            <body>
                                            
                                              <div class="container">
                                            
                                                <div class="header">
                                                  <h1>You\'re Almost There</h1>
                                                  <p>Unlock the full power of XPower by upgrading today</p>
                                                </div>
                                            
                                                <div class="section">
                                                  <p>You\'ve explored the features, simplified your workflow, and seen how XPower can help you grow. Now itâ€™s time to take the final step.</p>
                                            
                                                  <h2>ðŸš€ Upgrade Now and Get Full Access To:</h2>
                                            
                                                  <div class="benefit">
                                                    <h3>âœ” Unlimited Invoices & Customers</h3>
                                                    <p>No more limits â€” grow your business freely with full-scale invoicing and customer tracking.</p>
                                                  </div>
                                            
                                                  <div class="benefit">
                                                    <h3>âœ” WhatsApp + SMS Invoice Sharing</h3>
                                                    <p>Send invoices in seconds via WhatsApp or SMS â€” faster follow-ups, faster payments.</p>
                                                  </div>
                                            
                                                  <div class="benefit">
                                                    <h3>âœ” Cheque & Credit Control</h3>
                                                    <p>Built-in cheque management and credit limits help avoid bad debts and delays.</p>
                                                  </div>
                                            
                                                  <div class="benefit">
                                                    <h3>âœ” Multi-User Access</h3>
                                                    <p>3 Users included by default â€” assign your staff roles and permissions easily.</p>
                                                  </div>
                                            
                                                  <div class="benefit">
                                                    <h3>âœ” Stock Aging + Reorder Alerts</h3>
                                                    <p>Get notified before stock expires or runs low â€” boost sales and reduce loss.</p>
                                                  </div>
                                            
                                                  <div class="cta">
                                                    <a href="https://go2xpower.com/login.php?u='.$toEmail.'">Upgrade My Account</a>
                                                  </div>
                                                </div>
                                            
                                                <div class="footer">
                                                  <p>
                                                    <a href="https://help.go2xpower.com">Help Center</a> |
                                                    <a href="https://go2xpower.com/Terms_and_conditions.php">Terms & Conditions</a>
                                                  </p>
                                                  <p>Need help? <a href="https://wa.me/94722693693">WhatsApp Us</a></p>
                                                  <p>Â© '.date('Y-m-d').' xPower. All rights reserved.</p>
                                                </div>
                                            
                                              </div>
                                            
                                            </body>
                                            </html>

                                        ';
                                        $mail_subject = "Grow Faster with Full Access to xPower";
                                    }elseif($emailId == 12){
                                        $message = '
                                            <!DOCTYPE html>
                                            <html>
                                            <head>
                                              <meta charset="UTF-8">
                                              <title>Trial Ending Soon – Don’t Lose Your Data!</title>
                                              <style>
                                                body {
                                                  font-family: \'Segoe UI\', Arial, sans-serif;
                                                  margin: 0;
                                                  background-color: #fff5f5;
                                                  color: #333;
                                                }
                                                .container {
                                                  max-width: 660px;
                                                  margin: 30px auto;
                                                  background: #ffffff;
                                                  border-radius: 10px;
                                                  box-shadow: 0 4px 14px rgba(0,0,0,0.06);
                                                  overflow: hidden;
                                                }
                                                .header {
                                                  background: linear-gradient(90deg, #ff416c, #ff4b2b);
                                                  color: white;
                                                  padding: 40px 30px;
                                                  text-align: center;
                                                }
                                                .header h1 {
                                                  margin: 0;
                                                  font-size: 28px;
                                                }
                                                .header p {
                                                  font-size: 16px;
                                                  margin-top: 10px;
                                                }
                                                .section {
                                                  padding: 30px;
                                                }
                                                .section h2 {
                                                  font-size: 20px;
                                                  color: #ff4b2b;
                                                  margin-bottom: 12px;
                                                }
                                                .section p {
                                                  font-size: 15px;
                                                  line-height: 1.7;
                                                  margin-bottom: 20px;
                                                }
                                                .alert-box {
                                                  background-color: #ffe9e9;
                                                  border-left: 5px solid #ff4b2b;
                                                  padding: 16px 20px;
                                                  border-radius: 6px;
                                                  margin-bottom: 20px;
                                                }
                                                .cta {
                                                  text-align: center;
                                                  margin-top: 30px;
                                                }
                                                .cta a {
                                                  background-color: #ff4b2b;
                                                  color: white;
                                                  text-decoration: none;
                                                  padding: 14px 30px;
                                                  font-weight: bold;
                                                  border-radius: 6px;
                                                  font-size: 16px;
                                                }
                                                .footer {
                                                  background-color: #f2f2f2;
                                                  text-align: center;
                                                  padding: 20px;
                                                  font-size: 12px;
                                                  color: #888;
                                                }
                                                .footer a {
                                                  color: #ff416c;
                                                  text-decoration: none;
                                                  margin: 0 6px;
                                                }
                                              </style>
                                            </head>
                                            <body>
                                            
                                              <div class="container">
                                            
                                                <div class="header">
                                                  <h1>🚨 Trial Ending in 1 Day</h1>
                                                  <p>Don’t lose your data — upgrade now to keep access</p>
                                                </div>
                                            
                                                <div class="section">
                                                  <div class="alert-box">
                                                    <strong>Your trial ends tomorrow.</strong><br>
                                                    After that, you’ll lose access to your invoices, customer records, and inventory history unless you upgrade.
                                                  </div>
                                            
                                                  <p>You’ve already seen what XPower can do — now’s your chance to keep growing with it. Upgrade now and enjoy full features with:</p>
                                            
                                                  <ul style="margin-left: 20px; line-height: 1.8;">
                                                    <li>✔ WhatsApp & SMS invoice sharing</li>
                                                    <li>✔ Unlimited customer & item records</li>
                                                    <li>✔ Cheque & credit management</li>
                                                    <li>✔ Multi-user access</li>
                                                    <li>✔ Priority support</li>
                                                  </ul>
                                            
                                                  <h2>🎁 Special Offer: Get 50% Off if You Upgrade Today</h2>
                                                  <p style="margin-bottom: 30px;">Or book a free 15-minute Zoom call to guide you through your setup.</p>
                                            
                                                  <div class="cta">
                                                    <a href="https://go2xpower.com/login.php?u='.$toEmail.'">Upgrade & Save 10%</a>
                                                  </div>
                                            
                                                  <p style="text-align: center; margin-top: 20px;">
                                                    Prefer personal help? <a href="https://wa.me/94722693693">Chat with us on WhatsApp</a>
                                                  </p>
                                                </div>
                                            
                                                <div class="footer">
                                                  <p>
                                                    <a href="https://help.go2xpower.com">Help Center</a> |
                                                    <a href="https://go2xpower.com/Terms_and_conditions.php">Terms & Conditions</a>
                                                  </p>
                                                  <p>© '.date('Y-m-d').' xPower. All rights reserved.</p>
                                                </div>
                                            
                                              </div>
                                            
                                            </body>
                                            </html>

                                        ';
                                        $mail_subject = "⏳ 1 Day Left! Don’t Lose Your Data";
                                    }elseif($emailId == 13){
                                        $message = '
                                            <!DOCTYPE html>
                                            <html>
                                            <head>
                                              <meta charset="UTF-8">
                                              <title>Trial Ends Today – Upgrade Now</title>
                                              <style>
                                                body {
                                                  margin: 0;
                                                  padding: 0;
                                                  background: #f3f4f6;
                                                  font-family: \'Inter\', \'Segoe UI\', sans-serif;
                                                  color: #111827;
                                                }
                                                .wrapper {
                                                  max-width: 640px;
                                                  margin: 40px auto;
                                                  background: #ffffff;
                                                  border-radius: 10px;
                                                  overflow: hidden;
                                                  box-shadow: 0 20px 60px rgba(0,0,0,0.05);
                                                }
                                                .top-bar {
                                                  height: 6px;
                                                  background: linear-gradient(90deg, #6366f1, #06b6d4);
                                                }
                                                .header {
                                                  padding: 40px 30px 20px;
                                                  text-align: center;
                                                }
                                                .header h1 {
                                                  margin: 0;
                                                  font-size: 26px;
                                                  color: #111827;
                                                }
                                                .header p {
                                                  margin-top: 12px;
                                                  color: #6b7280;
                                                  font-size: 16px;
                                                }
                                                .content {
                                                  padding: 30px;
                                                }
                                                .content h2 {
                                                  font-size: 18px;
                                                  margin-bottom: 16px;
                                                  color: #2563eb;
                                                }
                                                .content p {
                                                  font-size: 15px;
                                                  line-height: 1.6;
                                                  margin-bottom: 24px;
                                                }
                                                .features {
                                                  margin-bottom: 30px;
                                                }
                                                .features li {
                                                  margin-bottom: 10px;
                                                  font-size: 15px;
                                                  padding-left: 20px;
                                                  position: relative;
                                                }
                                                .features li::before {
                                                  content: "✓";
                                                  position: absolute;
                                                  left: 0;
                                                  color: #10b981;
                                                  font-weight: bold;
                                                }
                                                .bonus-box {
                                                  background: #ecfdf5;
                                                  border: 1px solid #10b981;
                                                  padding: 16px 20px;
                                                  border-radius: 8px;
                                                  font-size: 14px;
                                                  color: #065f46;
                                                  margin-bottom: 32px;
                                                }
                                                .cta {
                                                  text-align: center;
                                                }
                                                .cta a {
                                                  background: linear-gradient(90deg, #6366f1, #06b6d4);
                                                  color: white;
                                                  text-decoration: none;
                                                  padding: 14px 36px;
                                                  border-radius: 8px;
                                                  font-size: 16px;
                                                  font-weight: 600;
                                                  display: inline-block;
                                                }
                                                .footer {
                                                  text-align: center;
                                                  font-size: 12px;
                                                  color: #6b7280;
                                                  padding: 24px;
                                                  background: #f9fafb;
                                                }
                                                .footer a {
                                                  color: #6366f1;
                                                  text-decoration: none;
                                                  margin: 0 6px;
                                                }
                                              </style>
                                            </head>
                                            <body>
                                            
                                              <div class="wrapper">
                                                <div class="top-bar"></div>
                                            
                                                <div class="header">
                                                  <h1>🚨 Trial Ends Today</h1>
                                                  <p>Upgrade now to keep your data and unlock full power</p>
                                                </div>
                                            
                                                <div class="content">
                                                  <h2>Here’s what you’ll unlock instantly:</h2>
                                            
                                                  <ul class="features">
                                                    <li>Send invoices via WhatsApp & SMS</li>
                                                    <li>Unlimited items, customers & users</li>
                                                    <li>Quick keyboard billing (no mouse needed)</li>
                                                    <li>Cheque & credit control module</li>
                                                    <li>Stock aging + reorder alerts</li>
                                                    <li>Priority support with setup help</li>
                                                  </ul>
                                            
                                                  <div class="bonus-box">
                                                    🎁 <strong>Today only:</strong> Get 50% off + a free 15-minute onboarding call when you upgrade.
                                                  </div>
                                            
                                                  <div class="cta">
                                                    <a href="https://go2xpower.com/login.php?u='.$toEmail.'">Upgrade My Account</a>
                                                  </div>
                                            
                                                  <p style="text-align:center; margin-top: 20px;">
                                                    Have questions? <a href="https://wa.me/94722693693">Chat with our team</a>
                                                  </p>
                                                </div>
                                            
                                                <div class="footer">
                                                  <p>
                                                    <a href="https://help.go2xpower.com">Help Center</a> |
                                                    <a href="https://go2xpower.com/Terms_and_conditions.php">Terms & Conditions</a>
                                                  </p>
                                                  <p>© '.date('Y-m-d').' xPower. All rights reserved.</p>
                                                </div>
                                              </div>
                                            
                                            </body>
                                            </html>

                                        ';
                                        $mail_subject = "Today’s the Day – Keep xPower Access + Get a Bonus";
                                    }
                                    
                                    $fromEmail = "noreply@go2xpower.com";
                                	$headers = "From: xPower Family <" . $fromEmail . ">\r\n" .
                                		"Reply-To: " . $fromEmail . "\r\n" .
                                		"X-Mailer: PHP/" . phpversion();
                                	$parameters = "-f " . $fromEmail;
                                	
                                	$headers .= "MIME-Version: 1.0" . "\r\n";
                                	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                                    $email_body   = $message;
                                    
                                    $send_mail_result = mail($toEmail, $mail_subject, $email_body, $headers, $parameters);
                                    
                                }
                            // $sql_invTot = $mysqli->query("SELECT SUM(InvTot) AS invoiceTotal FROM invoice WHERE br_id = '$br_id' AND Date = '$rdate' AND `Stype` != 'Balance'AND InvNO NOT LIKE 'NOTE-%'");
                            // $invoiceTotal = $sql_invTot->fetch_array();
                            if ($user_type == 'Admin' && $showChart == 1) {

                                $sql_total_userCnt = $mysqli->query("SELECT userCount FROM `com_brnches` WHERE ID= '$br_id'");
                                $total_userCnt = $sql_total_userCnt->fetch_assoc()['userCount'];

                                $sql_userCount = $mysqli->query("SELECT `id` FROM `sys_users` WHERE active ='YES' AND br_id= '$br_id'");
                                $userCount = $sql_userCount->num_rows;

                                $sql_stfCount = $mysqli->query("SELECT `ID` FROM `salesrep` WHERE `Actives` = 'YES' AND br_id = '$br_id'");
                                $stfCount = $sql_stfCount->num_rows;

                                $sql_cusCount = $mysqli->query("SELECT `ID`, MIN(recordDate) AS firstDate, MAX(recordDate) AS lastDate 
                                FROM `custtable` 
                                WHERE br_id = '$br_id' AND Active2 = 'YES'");
                                $cusCount = $sql_cusCount->num_rows;
                                $dateClient = $sql_cusCount->Fetch_assoc();
                                echo '<input type="hidden" name="date1" class="date1" value="' . $dateClient['firstDate'] . '">';
                                echo '<input type="hidden" name="date2" class="date2" value="' . $dateClient['lastDate'] . '">';

                                $sql_cusCount_all = $mysqli->query("SELECT `ID` FROM `custtable` WHERE br_id= '$br_id'");
                                $cusCount_all = $sql_cusCount_all->num_rows;

                                $sql_itmCount = $mysqli->query("SELECT itemtable.`ID` FROM `br_stock` JOIN itemtable ON itemtable.ID = br_stock.itm_id WHERE br_stock.br_id= '$br_id' AND deleted_itm = 0 AND itemtable.itm_delete = 0");
                                $itmCount = $sql_itmCount->num_rows;

                                $sql_itmCount_active = $mysqli->query("SELECT itemtable.`ID` FROM `br_stock` JOIN itemtable ON itemtable.ID = br_stock.itm_id WHERE br_stock.br_id= '$br_id' AND Active!='1' AND deleted_itm = 0 AND itemtable.itm_delete = 0");
                                $itmCount_active = $sql_itmCount_active->num_rows;



                                echo '
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.4.1/chart.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/numeral.js/1.0.3/numeral.min.js"></script>';

            //                    if ($com_id == '104' || $com_id == '501' || $com_id == '502' || $com_id == '503' || $com_id == '505' || $com_id == '507' || $com_id == '508' || $com_id == '509' || $com_id == '514') {

            //                         echo '
            //     <div class="row">
            //         <div class="col-md-6 col-sm-12 col-xs-12" style="margin-top: 10px;">
            //             <ins class="adsbygoogle"
            //                     style="display:block"
            //                     data-ad-format="autorelaxed"
            //                     data-ad-client="ca-pub-9558967657995335"
            //                     data-ad-slot="7507038438"></ins>
            //             <script>
            //                     (adsbygoogle = window.adsbygoogle || []).push({});
            //             </script>
            //         </div>
            //         <div class="col-md-6 col-sm-12 col-xs-12"  style="margin-top: 10px;">
            //             <ins class="adsbygoogle"
            //                     style="display:block"
            //                     data-ad-format="autorelaxed"
            //                     data-ad-client="ca-pub-9558967657995335"
            //                     data-ad-slot="7507038438"></ins>
            //             <script>
            //                     (adsbygoogle = window.adsbygoogle || []).push({});
            //             </script>
            //         </div>
                    
            //     </div>
            // ';
            //                    }

                                echo '
            <div style="justify-content: end;align-items: end;display: flex;margin-top: -20px; margin-top:20px;">
                <select class="form-select showHideCardsSelector" style="background: transparent;border: none;">
                    <option selected>System Insight</option>
                    <option value="todaysInsight">Today\'s Insight</option>
                </select>
            </div>
            <div class="dashBoardM">
                <div class="todaysInsight" style="margin-left: 0px;padding-top: 15px;">
                    <div class="content">
                        <div class="row">
                            <div class="dashTiles"></div>
                        </div>
                    </div>
                </div>
            </div>
        ';

                                $currentDate = new DateTime();
                                $endDate = new DateTime($branchDet['expire_date']);
                                $interval = $currentDate->diff($endDate);
                                $expDate = $interval->format('%a');

                                $dateExp = $dateExp = $endDate->format('j') . '<sup>' . $endDate->format('S') . '</sup> ' . $endDate->format('M Y');;
                                $percentage1 = ($userCount / $stfCount) * 100;
                                $result = $percentage1 > 100 ? 100 : $percentage1;
                                echo '
            <div class="systemInsight" style="margin-left: 0px;padding-top: 15px;">
                <div class="content">
                    <div class="row">
                        <div class="col-lg-2 col-sm-12 col-12 d-flex" id="allStaff">
							<div class="dash-count row">
								<div class="dash-counts col-md-6 col-sm-6 col-xs-6">
                                    
									<h4>' . number_format($stfCount) . '<span style="float:right; font-size:9px; font-weight:bold;">' . number_format($userCount) . ' Users</span></h4>
									<h5>All Staff</h5>
								</div>
								<div class="dash-imgs col-md-6 col-sm-6 col-xs-6">
                                    <div class="circular-progress1">
                                        <span class="progress-value1" activeStaff="' . $result . '" valueStaff="100">0%</span>
                                    </div>
								</div>
							</div>
						</div>
                        <div class="col-lg-2 col-sm-12 col-12 col-xs-12 d-flex" id="products">
                            <div class="dash-count row">
                                <div class="dash-counts col-md-6 col-sm-6 col-xs-6">
                                    <h4 title="All Products">' . number_format($itmCount) . '</h4>
                                    <h5>Products</h5>
                                </div>
                                <div class="dash-imgs col-md-6 col-sm-6 col-xs-6">
                                    <div class="circular-progress-products">
                                        <span title="Active products" class="progress-value-products" activeProducts="' . $itmCount_active . '" valueproducts="' . $itmCount . '">0%</span>
                                    </div>
                                </div>
                            </div>
						</div>
                        <div class="col-lg-2 col-sm-12 col-12 col-xs-12 d-flex" id="client">
							<div class="dash-count row">
								<div class="dash-counts col-md-6 col-sm-6 col-xs-6">
                                    <h4 title="All Clients">' . number_format($cusCount_all) . '</h4>
                                    <h5>Clients</h5>
                                </div>
                                <div class="dash-imgs col-md-6 col-sm-6 col-xs-6">
                                    <div class="circular-progress-clients">
                                        <span  title="Active Clients" class="progress-value-clients" activeClients="' . $cusCount . '" valueClients="' . $cusCount_all . '">0%</span>
                                    </div>
                                </div>
							</div>
						</div>
                        <div class="col-lg-2 col-sm-12 col-12 d-flex">
                            <div class="dash-count row" style="' . ($smsBalz <= 50 ? 'background-color: #ffd0bf;' : 'background-color: #bfd1ff;') . '">
                                <div class="dash-counts col-md-6 col-sm-6 col-xs-6">
                                    <h4>' . $smsBalz . '</h4>
                                    <h5>SMS</h5>
                                </div>
                                <div class="dash-imgs col-md-6 col-sm-6 col-xs-6">
                                    <div class="circular-progress2">
                                        <span class="progress-value2" activeSMS="' . $smsBalz . '" valueSMS="1000">0%</span>
                                    </div>
                                </div>
                            </div>
                            <style>
                                .circular-progress2::before {
                                    content: "";
                                    position: absolute;
                                    height: 50px;
                                    width: 50px;
                                    border-radius: 50%;
                                    background-color: ' . ($smsBalz <= 50 ? '#ffd0bf;' : '#bfd1ff;') . ';
                                }
                            </style>
                        </div>
                        <div class="col-lg-2 col-sm-12 col-12 d-flex">
							<div class="dash-count row" style="' . ($expDate <= 10 ? 'background-color: #ffd0bf;' : 'background-color: #bfd1ff;') . '">
								<div class="dash-counts col-md-6 col-sm-6 col-xs-6">
									<h4 title="Expires on : ' . $branchDet['expire_date'] . '" style="font-size: 16px;">' . $dateExp . '</h4>
                                    <h5 style="margin-bottom: 0;">Valid till</h5>
								</div>
								<div class="dash-imgs col-md-6 col-sm-6 col-xs-6">
                                    <div class="circular-progress3">
                                        <span title="Days available from today till expire date." class="progress-value3" value3="' . $expDate . '">0%</span>
                                    </div>
                                </div>
							</div>
                            <style>
                                .circular-progress3::before {
                                    content: "";
                                    position: absolute;
                                    height: 50px;
                                    width: 50px;
                                    border-radius: 50%;
                                    background-color: ' . ($expDate <= 10 ? '#ffd0bf;' : '#bfd1ff;') . ';
                                }
                            </style>
						</div>';
                                $sql_outstanding = $mysqli->query("SELECT SUM(Balance) AS total_outstanding 
                        FROM `invoice` 
                        WHERE `Balance` != 0 
                          AND `Date` < DATE_SUB(CURDATE(), INTERVAL 3 MONTH) 
                          AND `br_id` = '$br_id'
                    ");

                                $outsanding = $sql_outstanding->fetch_array();

                                $sql_outstanding1 = $mysqli->query("SELECT SUM(Balance) FROM `invoice` WHERE 
						`Balance` != 0   
						 AND `invoice`.`br_id`='$br_id'");
                                $outsanding1 = $sql_outstanding1->fetch_array();
                                $percentage = $outsanding1[0] == 0? 0:($outsanding[0] / $outsanding1[0]) * 100;

                                if ($outsanding[0] > 0) {
                                    echo '
                                    <style>
                                        @keyframes blink {
                                            0% {
                                                background-color: #ef1f1f;
                                            }
                                            50% {
                                                background-color: inherit; /* Keeps the original background */
                                            }
                                            100% {
                                                background-color: #ef1f1f;
                                            }
                                        }
                                        .blink-bg {
                                            animation: blink 2s infinite;
                                        }
                                    </style>
                                    ';
                                }

                                echo '
                        <div class="col-lg-2 col-sm-12 col-12 d-flex" id="dueRec" style="cursor:pointer;"  title="Total Outstanding: ' . number_format($outsanding1[0], 2) . '">
                            <div class="dash-count row blink-bg">
                                <div class="dash-counts col-md-8 col-sm-6 col-xs-6">
                                    <h4 style="font-size:15px;">' . number_format($outsanding[0], 2) . '</h4>
                                    <h5>3 Months Overdue</h5>
                                </div>
                                <div class="dash-imgs col-md-4 col-sm-6 col-xs-6" style="padding:0;">
                                    <div class="circular-progress">
                                        <span class="progress-value" activeUsers="' . $percentage . '" valueUsers="100">0%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        ';
        $sql_pageRight = $mysqli->query("SELECT ID FROM pages WHERE page_title = 'New Repair' AND userRights = 'Y'");
        if($sql_pageRight->num_rows > 0){
        ?>
        <style>
  body {
    background-color: #f5f7fa;
    font-family: 'Arial', sans-serif;
  }

  .box {
    position: relative;
    text-align: left;
    color: #333;
    border-radius: 8px;
    margin-bottom: 20px;
    padding: 20px;
    height: 160px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    background-color: #fff;
  }

  .box h4 {
    font-size: 1.5rem;
    font-weight: bold;
    margin-top: 5px;
  }

  .box svg {
    position: absolute;
    top: 15px;
    right: 15px;
    z-index: 0;
    width: 80px;
    height: 80px;
  }

  .box circle {
    fill: none;
    stroke-width: 6;
    stroke-linecap: round;
  }

  .box .background {
    stroke: rgba(0, 0, 0, 0.1);
  }

  .box .progress {
    stroke-dasharray: 0 100;
    transition: stroke-dasharray 1s ease;
  }

  .box text {
    font-size: 14px;
    fill: rgba(0, 0, 0, 0.8);
    text-anchor: middle;
    dominant-baseline: middle;
    font-weight: bold;
  }

  .completed {
    border-left: 5px solid #007bff;
  }

  .pending {
    border-left: 5px solid #e74c3c;
  }

  .balance {
    border-left: 5px solid #6f42c1;
  }


  
</style>

<?php
  $sql_repair = $mysqli->query("SELECT ID FROM repair_tb WHERE br_id = '$br_id' AND rDate = '$rdate'");
  $total = $sql_repair->num_rows; 
  $sql_repair1 = $mysqli->query("SELECT ID FROM repair_tb WHERE status IN('Completed', 'Sent to Distributor') AND br_id = '$br_id' AND rDate = '$rdate'");
  $completed = $sql_repair1->num_rows;
  $balance = $total - $completed;

  $completed_percentage = $total > 0 ? round(($completed / $total) * 100) : 0;
  $balance_percentage = $total > 0 ? round(($balance / $total) * 100) : 0;
?>

<div class="container mt-5">
  <div class="row">
    <div class="col-md-4">
      <div class="box completed">
        <svg>
          <circle class="background" cx="40" cy="40" r="30"></circle>
          <circle class="progress" cx="40" cy="40" r="30" style="stroke: #0056b3;"></circle>
          <text x="40" y="40" id="completed-text">0%</text>
        </svg>
        <h4>Total Repairs for today </h4> <h1 style="font-size:30px;"><?php echo $total ?></h1>
      </div>
    </div>
    <div class="col-md-4">
      <div class="box pending">
        <svg>
          <circle class="background" cx="40" cy="40" r="30"></circle>
          <circle class="progress" cx="40" cy="40" r="30" style="stroke: #c0392b;"></circle>
          <text x="40" y="40" id="pending-text">0%</text>
        </svg>
        <h4>Completed Repairs</h4> <h1 style="font-size:30px;"><?php echo $completed ?></h1></h1>
      </div>
    </div>
    <div class="col-md-4">
      <div class="box balance">
        <svg>
          <circle class="background" cx="40" cy="40" r="30"></circle>
          <circle class="progress" cx="40" cy="40" r="30" style="stroke: #4b0082;"></circle>
          <text x="40" y="40" id="balance-text">0%</text>
        </svg>
        <h4>Pending Repairs</h4> <h1 style="font-size:30px;"><?php echo $balance ?></h1>
      </div>
    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script>
  const animateGraph = (selector, percentage, textSelector, delay = 0) => {
    const circle = document.querySelector(`${selector} .progress`);
    const text = document.querySelector(textSelector);
    const radius = circle.r.baseVal.value;
    const circumference = 2 * Math.PI * radius;

    circle.style.strokeDasharray = `${circumference} ${circumference}`;
    circle.style.strokeDashoffset = circumference;

    gsap.to(circle, {
      strokeDashoffset: circumference - (percentage / 100) * circumference,
      duration: 2,
      ease: "power1.out",
      delay: delay,
    });

    gsap.fromTo(
      text,
      { textContent: 0 },
      {
        textContent: percentage,
        duration: 2,
        ease: "power1.out",
        snap: { textContent: 1 },
        delay: delay,
        onUpdate: function () {
          text.textContent = `${Math.round(this.targets()[0].textContent)}%`;
        }
      }
    );
  };

  // Animations for each graph
  animateGraph(".completed", 100, "#completed-text"); // Total always 100%
  animateGraph(".pending", <?php echo $completed_percentage; ?>, "#pending-text", 0.5);
  animateGraph(".balance", <?php echo $balance_percentage; ?>, "#balance-text", 1);
</script>

        <?php
        }

                                $sql_pages = $mysqli->query("SELECT page_title, path, icon2 FROM pages WHERE likeFav=1");
                                $sql_reportPages = $mysqli->query("SELECT reportTitle, reportPath, barID FROM report_pages WHERE likeFav=1");
                                echo '
        <div class="row dashBoardM" style="margin-bottom: 20px;margin-top: -12px;">';
                                if ($sql_pages->num_rows > 0 || $sql_reportPages->num_rows > 0) {
                                    echo '<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
                    <div class="">
                        <h4 style="margin-bottom: 0;">Quick Links</h4>
                        <span style="color: gray;font-weight: 300;">Access reports and pages with quick links.</span>
                    </div>
                </div>';
                                }

                                echo '<div class="col-md-12 col-sm-12 col-xs-12 row"  style="margin-top: 10px;">';

                                while ($row = $sql_pages->fetch_assoc()) {
                                    $isPage = explode('_', $row['path']);
                                    $isPage = (count($isPage) > 1) ? $isPage :     explode('/', $row['path']);
                                    $path1 = '';
                                    if ($isPage[0] == 'create') {
                                        $path1 = 'https://' . $domainNm . '/Home/new/' . $row['path'] . '.php';
                                    } else if ($isPage[0] == 'due') {
                                        $path1 = 'https://' . $domainNm . '/Home/due_/' . $row['path'] . '.php';
                                    } else if ($isPage[0] == 'journal') {
                                        $path1 = 'https://' . $domainNm . '/Home/journal/' . $row['path'] . '.php';
                                    } else if ($isPage[0] == 'Good' && $isPage[1] == 'Transfer') {
                                        $path1 = 'https://' . $domainNm . '/Home/Good_Transfer/' . $row['path'] . '.php';
                                    } else if ($isPage[0] == 'Distributor') {
                                        $path1 = 'https://' . $domainNm . '/Home/Distributor/Repairs/' . $row['path'] . '.php';
                                    } else {
                                        $path1 = $path . '' . $row['path'] . '.php';
                                    }

                                    echo '
                    <div class="col-md-2 col-sm-3 col-xs-3 mb-4 tbsChecker">
                        <a class="" href="' . $path1 . '" target="_BLANK">
                            <div class="boxSahdz count_box" style="padding:10px; border-radius:5px;">
                                <p class="cardDtsText" style="text-align:center;display: contents;">' . $row['page_title'] . '</p>
                            </div>
                        </a>
                    </div>
                ';
                                }


                                while ($row = $sql_reportPages->fetch_assoc()) {
                                    $path2 = '';
                                    if ($row['barID'] == '1') {
                                        $path2 = 'https://' . $domainNm . '/Home/Reports/daily/' . $row['reportPath'] . '.php?print_type=undefined';
                                    } else if ($row['barID'] == '2') {
                                        $path2 = 'https://' . $domainNm . '/Home/Reports/satements/' . $row['reportPath'] . '.php';
                                    } else if ($row['barID'] == '3') {
                                        $path2 = 'https://' . $domainNm . '/Home/Reports/Cheque/' . $row['reportPath'] . '.php';
                                    } else if ($row['barID'] == '4') {
                                        $path2 = 'https://' . $domainNm . '/Home/Reports/Admin/' . $row['reportPath'] . '.php';
                                    } else if ($row['barID'] == '5') {
                                        $path2 = 'https://' . $domainNm . '/Home/Reports/stock/' . $row['reportPath'] . '.php';
                                    } else if ($row['barID'] == '6') {
                                        $path2 = 'https://' . $domainNm . '/Home/Reports/Account/' . $row['reportPath'] . '.php';
                                    } else if ($row['barID'] == '7') {
                                        $path2 = 'https://' . $domainNm . '/Home/Reports/factory/' . $row['reportPath'] . '.php';
                                    }

                                    echo '
                    <div class="col-md-2 col-sm-3 col-xs-3 mb-4 tbsChecker">
                        <a class="" href="' . $path2 . '" target="_BLANK">
                            <div class="boxSahdz count_box" style="padding:10px; border-radius:5px;">
                                <p class="cardDtsText" style="text-align:center;display: contents;">' . $row['reportTitle'] . '</p>
                            </div>
                        </a>
                    </div>
                ';
                                }

                                echo '</div>
    </div>';

                                $currentDate = date("Y-m-d");

                                $thisMonthFirstDate = new DateTime('first day of this month');
                                $currentDateThisMonth = $thisMonthFirstDate->format('Y-m-d');

                                $twoMonthsLaterLastDate = new DateTime('last day of +2 month');
                                $currentDateAfterTwoMonths = $twoMonthsLaterLastDate->format('Y-m-d');

                              

                                echo '
    <div class="row dashBoardM" id="dashBoardM" style="opacity:0;">
        <div class="col-md-6 col-sm-6 col-xs-12" style="margin-bottom: 15px;">
            <div class="dashboard_graph" style="padding-top:0">
                <div class="row x_title row">
                    <div class="col-md-6">
                        <h4 style="float:left;"><a target="_BLANK" href="https://' . $domainNm . '/Home/Reports/Cheque/chq_HandInChq.php?from_d=' . $currentDateThisMonth . '&to_d=' . $currentDateAfterTwoMonths . '" style="color:white;">Cheque In Hand</a> Vs <a target="_BLANK" href="https://' . $domainNm . '/Home/Reports/Cheque/chq_OwnChq.php?from_d=' . $currentDateThisMonth . '&to_d=' . $currentDateAfterTwoMonths . '" style="color:white;">Own Cheques</a> </h4>
                    </div>
                    <div class="col-md-6" style="display: contents;">
                  
                    <div id="chequeResValue"></div>

                    </div>
                    <div class="col-md-6" style="display: contents;">
                        <button class="btn btn-info" id="grab_chq_In_hand" style="float:right; margin-top: 0px; margin-bottom: 20px;">Load</button>
                    </div>
                </div>
        
                <canvas id="chart_div_chqInHand" height="170px"></canvas>
                
   
            </div>
            <div class="chqInHandAjaxResult">
            </div>
        </div>
    ';


                                $currentYear = date('Y');

                                // January 1st of the current year
                                $janFirst = new DateTime("$currentYear-01-01");
                                $janFirstDate = $janFirst->format('Y-m-d');

                                // December 31st of the current year
                                $decLast = new DateTime("$currentYear-12-31");
                                $decLastDate = $decLast->format('Y-m-d');

                               


                                echo '
                <div class="col-md-6 col-sm-6 col-xs-12" style="margin-bottom: 15px;">
                    <div class="col-md-5 col-sm-5 col-xs-12" style="display:none;">
                        <button type="button" class="btn btn-primary btn-lg" id="downloadClk">Download Local Inv</button>
                    </div>
                <div class="dashboard_graph" style="padding-top:0">
                    <div class="row x_title row">
                        <div class="col-md-6">
                            <h4 style="float:left;"><a href="https://' . $domainNm . '/Home/Reports/daily/daily_sales_report_frmt2.php?from_d=' . $janFirstDate . '&to_d=' . $decLastDate . '&sales_id=View%20All&ItemNm=undefined&ItemId=undefined&nametxt=undefined&va=link1&id=undefined&sl_name=View%20All&itemtxt=undefined&print_type=sal_rep&cus_id=View%20All&cat_id=undefined&view_type=undefined&nametxt2=undefined&myBR=1&mon=undefined&sl_year=undefined&user_ids=undefined&type=undefined&cusTb=undefined&location=undefined&cus_area=View%20All&itemtxt=undefined&stockReport=undefined%7CF%7Cundefined%7CF%7Cundefined" style="color:white;" target="_BLANK">Sales</a> Vs <a target="_BLANK" href="https://' . $domainNm . '/Home/Reports/satements/New_CustmrReceivable.php?from_d=' . $janFirstDate . '&to_d=' . $decLastDate . '" style="color:white;">Recievables</a></h4></h4>
                        </div>
                        <div class="col-md-6" style="display: contents;">
                          
                        <div id="profLossValue"></div>


                        </div>
                        
                        <div class="col-md-6" style="display: contents;">
                            <button class="btn btn-info loadSalesChart" style="float:right; margin-top: 0px; margin-bottom: 20px;">Load</button>
                        </div>
                        
                    </div>
                    
                    <canvas id="chart_div"  height="170px">
                        
                    </canvas>
                    
                    <div class="clearfix"></div>
                </div>
                <div class="ajaxResult"></div>
            </div>';
                            
          }

                            echo '</div>';
                            ?>
                            <div class="ActivationBarChart"></div>
                        </div>
                    </div>
                </div>
            </div>


            <?php include($path . 'footer.php') ?>
            <script>
                $(document).on('click', '.loadoutstandings', function() {

                    window.location.href = 'index.php?loadingOutsanding=yes';

                })

                // users daughnut
                let circularProgressusers = document.querySelector(".circular-progress"),
                    progressValueusers = document.querySelector(".progress-value");
                let valueusers = parseInt(progressValueusers.getAttribute('valueUsers'));
                let usersCount_active = parseInt(progressValueusers.getAttribute('activeUsers'));

                let progressStartValueusers = 0,
                    speedusers = 10;

                let progressusers = setInterval(() => {
                    progressStartValueusers++;
                    progressValueusers.textContent = `${Math.round((progressStartValueusers / valueusers) * 100)}%`;
                    circularProgressusers.style.background = `conic-gradient(#7EA1FF ${progressStartValueusers * (360 / valueusers)}deg, #00CFE8 0deg)`;
                    if (progressStartValueusers >= usersCount_active) {
                        clearInterval(progressusers);
                    }
                }, speedusers);

                // staff daughnut
                let circularProgressStaff = document.querySelector(".circular-progress1"),
                    progressValueStaff = document.querySelector(".progress-value1");
                let valueStaff = parseInt(progressValueStaff.getAttribute('valueStaff'));
                let StaffCount_active = parseInt(progressValueStaff.getAttribute('activeStaff'));

                let progressStartValueStaff = 0,
                    speedStaff = 10;

                let progressStaff = setInterval(() => {
                    progressStartValueStaff++;
                    progressValueStaff.textContent = `${Math.round((progressStartValueStaff / valueStaff) * 100)}%`;
                    circularProgressStaff.style.background = `conic-gradient(#7EA1FF ${progressStartValueStaff * (360 / valueStaff)}deg, #00CFE8 0deg)`;
                    if (progressStartValueStaff >= StaffCount_active) {
                        clearInterval(progressStaff);
                    }
                }, speedStaff);

                // SMS daughnut
                let circularProgressSMS = document.querySelector(".circular-progress2"),
                    progressValueSMS = document.querySelector(".progress-value2");
                let valueSMS = parseInt(progressValueSMS.getAttribute('valueSMS'));
                let SMSCount_active = parseInt(progressValueSMS.getAttribute('activeSMS'));

                let progressStartValueSMS = 0,
                    speedSMS = 10;

                let progressSMS = setInterval(() => {
                    progressStartValueSMS++;
                    let progressPercentage = Math.min(Math.round((progressStartValueSMS / valueSMS) * 100), 100);
                    progressValueSMS.textContent = `${progressPercentage}%`;
                    if (progressPercentage >= 100 && SMSCount_active > 100) {
                        clearInterval(progressSMS);
                    }
                    circularProgressSMS.style.background = `conic-gradient(#7EA1FF ${progressStartValueSMS * (360 / valueSMS)}deg, #00CFE8 0deg)`;

                    if (progressStartValueSMS >= SMSCount_active) {
                        clearInterval(progressSMS);
                    }

                    if (SMSCount_active <= 50) {
                        circularProgressSMS.style.background = `conic-gradient(#FF0000 ${progressStartValueSMS * 3.6}deg, #fff 0deg)`;
                    }
                }, speedSMS);




                // products daughnut
                let circularProgressproducts = document.querySelector(".circular-progress-products"),
                    progressValueproducts = document.querySelector(".progress-value-products");
                let valueproducts = parseInt(progressValueproducts.getAttribute('valueproducts'));
                let itmCount_active = parseInt(progressValueproducts.getAttribute('activeProducts'));

                let progressStartValueproducts = 0,
                    speedproducts = 10;

                let progressproducts = setInterval(() => {
                    progressStartValueproducts++;
                    progressValueproducts.textContent = `${itmCount_active}`;
                    circularProgressproducts.style.background = `conic-gradient(#7EA1FF ${progressStartValueproducts * (360 / valueproducts)}deg, #00CFE8 0deg)`;
                    if (progressStartValueproducts >= itmCount_active) {
                        clearInterval(progressproducts);
                    }
                }, speedproducts);

                // clients daughnut
                let circularProgressclients = document.querySelector(".circular-progress-clients"),
                    progressValueclients = document.querySelector(".progress-value-clients");
                let valueclients = parseInt(progressValueclients.getAttribute('valueClients'));
                let clientsCount_active = parseInt(progressValueclients.getAttribute('activeClients'));

                let progressStartValueclients = 0,
                    speedclients = 10;

                let progressclients = setInterval(() => {
                    progressStartValueclients++;
                    let percentage = Math.round((progressStartValueclients / valueclients) * 100);
                    progressValueclients.textContent = `${clientsCount_active}`;
                    circularProgressclients.style.background = `conic-gradient(#7EA1FF ${progressStartValueclients * (360 / valueclients)}deg, #00CFE8 0deg)`;
                    if (progressStartValueclients >= clientsCount_active) {
                        clearInterval(progressclients);
                    }
                }, speedclients);

                // date daughnut
                let circularProgress3 = document.querySelector(".circular-progress3"),
                    progressValue3 = document.querySelector(".progress-value3");
                let value3 = parseInt(progressValue3.getAttribute('value3'));
                let progressStartValue3 = 0,
                    progressEndValue3 = 90,
                    speed3 = 50;

                let progress3 = setInterval(() => {
                    progressStartValue3++;
                    progressValue3.textContent = `${value3}`;
                    circularProgress3.style.background = `conic-gradient(#7EA1FF ${progressStartValue3 * 3.6}deg, #00CFE8 0deg)`;
                    // border radius
                    circularProgress3.style.borderRadius = '50%';

                    if (progressStartValue3 == value3) {
                        clearInterval(progress3);
                    }

                    // Check if value3 is <= 10 to change background color
                    if (value3 <= 10) {
                        circularProgress3.style.background = `conic-gradient(#FF0000 ${progressStartValue3 * 3.6}deg, #fff 0deg)`;
                    }
                }, speed3);

                $(document).on('click', '.dueSettementReminder', function() {

                    window.location.href = 'indexTest.php?dueSettementReminder=yes';

                })

                $(document).on('click', '#grab_chq_In_hand', function(e) {
                    e.preventDefault();

                    $.ajax({
                        url: 'ajxNew/loadChart.php',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            btn: 'load_chq_In_Hand_graph',
                        },
                        success: function(data) {
                            $('.' + data.showClass).html(data.detail);
                        }
                    })
                })



                $('.todaysInsight').hide()
                $('.systemInsight').show()
                $(document).on('change', '.showHideCardsSelector', function(e) {
                    e.preventDefault();
                    let showHideCardsSelector = $(this).val();
                    if (showHideCardsSelector === 'todaysInsight') {
                        $('.systemInsight').hide()
                        $('.todaysInsight').show()
                    } else {
                        $('.systemInsight').show()
                        $('.todaysInsight').hide()
                    }
                })

                $(document).bind('keyup keydown', function(e) {
                    if (e.which === 121) { // F10 key code is 121
                        if (localStorage.getItem('div_visibility') === 'visible') {
                            // Hide the div element
                            $('.dashBoardM').hide();
                            // Update localStorage with new visibility state
                            localStorage.setItem('div_visibility', 'hidden');
                        } else {
                            // Show the div element
                            $('.dashBoardM').show();
                            // Update localStorage with new visibility state
                            localStorage.setItem('div_visibility', 'visible');
                        }
                    }
                });
            </script>

            <script type="text/javascript">
                const updateID = document.getElementById('updateID').value
                cookieUpdateID = getCookie("updateID");

                if (cookieUpdateID != updateID) {
                    setCookie("updateID", updateID, 1000);
                    $('#home-tab').html('What\'s New? <span id="newUpdate" style="display:inline-block; color:#fefefe; background-color:#59CE8F; padding:2px 3px; border-radius:3px; font-weight:300">New</span>');
                }

                function setCookie(cname, cvalue, exdays) {
                    const d = new Date();
                    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
                    let expires = "expires=" + d.toUTCString();
                    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
                }

                function getCookie(cname) {
                    let name = cname + "=";
                    let ca = document.cookie.split(';');
                    for (let i = 0; i < ca.length; i++) {
                        let c = ca[i];
                        while (c.charAt(0) == ' ') {
                            c = c.substring(1);
                        }
                        if (c.indexOf(name) == 0) {
                            return c.substring(name.length, c.length);
                        }
                    }
                    return "";
                }

                $(function() {
                    window.setInterval(function() {
                        $('.notice').toggleClass('blink');
                    }, 500);
                });

                <?php
                if ($showChart == 1) {
                    // echo "loadDaySalesChart('DaySalesChart');";
                }

                if ($com_id == '506' && $showChart == 1) {
                    echo "loadDaySalesChart('ActivationBarChart');";
                }
                ?>

                $(document).on('click', '.loadSalesChart', function() {
                    loadDaySalesChart('DaySalesChart');
                    // $('.loadSalesChart').hide();
                });

                loadDaySalesChart('DashTiles');
                $(document).on('click', '.loadTiles', function() {
                    loadDaySalesChart('DashTiles');
                    $('.loadTiles').html('Loading');
                });

                if (localStorage.getItem('div_visibility') === 'hidden') {
                    $('.dashBoardM').hide();
                }


                showHideChart();

                function showHideChart() {
                    var showChart = '<?php echo $showChart; ?>';

                    if (showChart == 1) {
                        $('.dashBoardM').css('opacity', '10');
                    } else {
                        $('.dashBoardM').css('opacity', '0');
                    }
                }

                function loadDaySalesChart(chartType) {
                    $('.btn_load').html('...');
                    $('.btn_load').css('opacity', '0.4');
                    $('.btn_load').css('pointer-events', 'none');
                    var monthNumber = $('#monthlyName').val();

                    $.ajax({
                        url: 'ajxNew/loadChartTwo.php',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            btn: chartType,
                            monthNumber: monthNumber,
                        },
                        success: function(data) {
                            $('.' + data.showClass).html(data.detail);
                            if (chartType == 'DashTiles') {
                                $('.loadTiles').hide();
                            }
                        }
                    })
                }

                $('#monthlyName').val('<?php echo date('m'); ?>');

                $(document).on('click', '#downloadClk', function() {
                    window.location = 'download.php';
                });

                loadPayrollAttendance();
                $(document).on('click', '.payrollLoad', function() {

                    loadPayrollAttendance();
                });

                function loadPayrollAttendance() {
                    var dateSelect = $('#com_date').val();
                    $('#atendTb').html("");

                    $('.payrollLoad').css('opacity', '0.4');
                    $('.payrollLoad').val('Loading');

                    $.ajax({
                        url: 'ajxNew/loadChart.php',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            btn: 'PayrollAttendance',
                            dateSelect: dateSelect,
                        },
                        success: function(data) {
                            $('.payrollLoad').css('opacity', '1');
                            $('.payrollLoad').val('Load');

                            $('#atendTb').html(data.attendTb);

                        }
                    })
                }
                // $('#mainBody').hide();
                // $('#bBtn').show();
                // $('#myCanvas').show();
                // $('#birthday').show();

                function bDayLoad() {
                    var dob = $('.dateOf').val();
                    var currentDate = new Date();
                    var dobDate = new Date(dob);

                    // Check if a cookie exists indicating that the content has been shown before
                    var contentShown = getCookie('contentShown');

                    if (
                        !contentShown && // Check if the content hasn't been shown before
                        dobDate.getDate() === currentDate.getDate() &&
                        dobDate.getMonth() === currentDate.getMonth()
                    ) {
                        $('#bBtn').show();
                        $('#myCanvas').show();
                        $('#birthday').show();
                        $('#mainBody').hide();

                        // Set a cookie to indicate that the content has been shown
                        setCookie('contentShown', 'true', 365); // This cookie will expire in 365 days
                    }
                }

                // Function to get a cookie by name
                function getCookie(name) {
                    var cookies = document.cookie.split(';');
                    for (var i = 0; i < cookies.length; i++) {
                        var cookie = cookies[i].trim();
                        if (cookie.startsWith(name + '=')) {
                            return cookie.substring(name.length + 1);
                        }
                    }
                    return null;
                }

                // Function to set a cookie
                function setCookie(name, value, days) {
                    var expires = '';
                    if (days) {
                        var date = new Date();
                        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                        expires = '; expires=' + date.toUTCString();
                    }
                    document.cookie = name + '=' + value + expires + '; path=/';
                }

                $(document).ready(function() {
                    bDayLoad();
                });




                // checkFirstPageReload();

                $(document).on('click', '#bBtn', function() {
                    $('#mainBody').show();
                    $('#myCanvas').hide();
                    $('#birthday').hide();
                    $(this).hide()
                });
                cusDob();

                function cusDob() {
                    $.ajax({
                        type: "POST",
                        url: "AJAX_Requst/cusDob.php",
                        dataType: "json",
                        success: function(res) {
                            if (res.customer != '') {
                                $('#cusBirthDiv').html(res.customer)
                            }
                            if (res.staff != '') {
                                $('#cusBirthDiv1').html(res.staff)
                            }


                        }
                    });
                }

                function openInNewTab(url) {
                    window.open(url, '_blank');
                }

                $(document).on('click', '.soldQty', function() {
                    openInNewTab('Reports/daily/report_item_sales_cat.php');
                });
                $(document).on('click', '.grossProfit', function() {
                    openInNewTab('Reports/Admin/New_GainNlooS.php');
                });
                $(document).on('click', '.totCost', function() {
                    openInNewTab('Reports/Admin/admin_sales_profit.php');
                });
                $(document).on('click', '.salesVal', function() {
                    openInNewTab('Reports/daily/daily_sales_report_frmt2.php');
                });

                emailSendLoad('<?php echo $lstDate; ?>');

                $(document).on('click', '#dueRec', function() {
                    const date = new Date();
                    const year = date.getFullYear();
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const day = String(date.getDate()).padStart(2, '0');
                    const currentDate = `${year}-${month}-${day}`;
                    window.open("<?php echo $full_domain; ?>/Home/Reports/satements/New_CustmrReceivable.php?from_d=2016-03-08&to_d=" + currentDate + "&sales_id=Load-Again&cus_id=View%20All&cus_name=View%20All&ven_id=undefined&ven_name=undefined&jou_name=undefined&jou_id=undefined&va=link26&print_type=undefined&serialNo=undefined&cus_area=undefined&due_frm=90&due_to=10000&rep_id=Load-Again&myBR=1&year=undefined&month=undefined");
                });

                $(document).on('click', '#allStaff', function() {
                    openInNewTab('new/create_rep.php');
                });

                $(document).on('click', '#products', function() {
                    openInNewTab('Reports/stock/detail_item_list.php');
                });
                $(document).on('click', '#client', function() {
                    var date1 = $('.date1').val();
                    var date2 = $('.date2').val();
                    openInNewTab('Reports/satements/New_CustmrReport.php?from_d=' + date1 + '&to_d=' + date2);

                });


            
               


                $(document).ready(function() {

                  $('.loadSalesChart').on('click', function() {
                    $.ajax({
                      url: 'ajxNew/loadChartTwo.php',
                      method: 'POST',
                      data: { btn: 'DashTiles' },
                      dataType: 'json',
                      beforeSend: function() {
                        console.log('Sending request to ajxNew/loadChartTwo.php...');
                      },
                      success: function(data) {
                        console.log('Success! Data:', data);
                        $('#profLossValue').text(data.balTT);
                      },
                      error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                        console.log('Response:', xhr.responseText); // Log the raw response
                        alert('Failed to load data. Check the console for details.');
                      }
                    });
                  });

                  $('#grab_chq_In_hand').on('click', function() {
                    $.ajax({
                      url: 'ajxNew/loadChart.php',
                      method: 'POST',
                      data: { btn: 'DashTiles' },
                      dataType: 'json',
                      beforeSend: function() {
                        console.log('Sending request to ajxNew/loadChart.php...');
                      },
                      success: function(data) {
                        console.log('Success! Data:', data);
                        $('#chequeResValue').text(data.total_nw);
                      },
                      error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                        console.log('Response:', xhr.responseText); // Log the raw response
                        alert('Failed to load data. Check the console for details.');
                      }
                    });
                  });

                  $("#chequeResValue").css("cursor", "pointer"); // make it look clickable
                  $("#chequeResValue").click(function() {
                    window.location.href = "Reports/Cheque/chq_HandInChq.php"; // redirect to chq_HandInChq
                  });

                  $("#profLossValue").css("cursor", "pointer"); // make it look clickable
                  $("#profLossValue").click(function() {
                    window.location.href = "Reports/satements/New_CustmrReceivable.php"; // redirect to New_CustmrReceivable
                  });

                });





                 
/*
                    $(document).ready(function() {
                        $.ajax({
                            url: 'your_php_file.php',
                            method: 'POST',
                            data: { btn: 'YourButtonValue' },
                            dataType: 'json',
                            success: function(data) {
                                // Display the total in the span
                                $('#profLossValue').text(data.cusinvTT);
                            },
                            error: function(xhr, status, error) {
                                console.error("Error:", error);
                            }
                        });
                    });

*/

            </script>