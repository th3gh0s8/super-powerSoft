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
//('display_errors', 1);

//echo $_SESSION['u_id'].' xPower4';
?>

<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;700;900&display=swap" rel="stylesheet">

 <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@400;700;900&family=Rajdhani:wght@400;700;900&display=swap" rel="stylesheet">

 <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&display=swap" rel="stylesheet">

 <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">




<style type="text/css">

    /*3.9.2025 start*/

    /*.web-join-link {
      display: block;
      text-align: center;
      margin: 0 auto;
      font-size: 2rem;      
      color: #0078D7;        
      font-weight: bold;
      text-decoration: none;
      animation: blink 1.5s infinite; 
      margin: 30px 0;
    }

    @keyframes blink {
      0%, 50%, 100% { opacity: 1; }
      25%, 75% { opacity: 0; }
    }


    .guid-container {
      max-width: 900px;
      margin: auto;
      padding: 20px;
      font-family: Arial, sans-serif;
      line-height: 1.6;
    }

    .guid-main-heading {
      text-align: center;
      font-size: 3rem;
      font-weight: 900;
      margin-bottom: 50px;
      color: #0078D7;
    }

    .guid-section {
      display: flex;
      flex-direction: row;
      justify-content: space-between;
      align-items: flex-start;
      margin-bottom: 50px;
      gap: 20px;
    }

    .guid-text {
      flex: 1;
    }


    .guid-heading {
      font-size: 2rem;
      font-weight: 900; 
      margin-bottom: 15px;
      display: flex;
      align-items: center;
    }

    .guid-number {
      display: inline-block;
      background-color: #0078D7;
      color: #fff;
      width: 40px;
      height: 40px;
      line-height: 35px;
      border-radius: 50%;
      text-align: center;
      font-weight: bold;
      margin-right: 15px;
      font-family: Arial, sans-serif;
    }


    .guid-steps {
      list-style: decimal;
      padding-left: 20px;
      color: #888888; 
      text-align: left;
    }

    .guid-steps li{
        font-size: 1.5rem;
    }

    .guid-img {
      width: 150px;
      height: auto;
      border-radius: 10px;
      float: right;
    }

    .guid-text a {
      font-size: 1.5rem; 
      color: #0078D7;
      text-decoration: none;
    }


    .live-notice {
      display: none; 
      text-align: center;
      font-family: Arial, sans-serif;
      font-size: 2rem;
      margin: 20px 0;
    }

    .live-text {
      font-weight: bold;
      color: red;
    }

    .live-link {
      color: #0078D7;
      text-decoration: underline;
      font-weight: bold;
    }

    .hotline {
      text-align: center;
      font-family: Arial, sans-serif;
      font-size: 1.7rem;
      color: #000;
      margin: 30px 0 10px 0; 
    }


    @media (max-width: 900px) {
      .guid-container {
        text-align: left; 
      }
      .guid-main-heading {
        font-size: 3.2rem;
        margin-bottom: 40px;
        text-align: left;
      }
      .guid-heading {
        font-size: 1.7rem;
        text-align: left;
        justify-content: flex-start;
      }
      .guid-number {
        width: 30px;
        height: 30px;
        line-height: 30px;
        margin-right: 12px;
      }
      .guid-steps li {
        font-size: 0.95rem;
        text-align: left;
      }
      .guid-img {
        width: 130px;
        float: right;
      }
    }

    @media (max-width: 768px) {
      .guid-section {
        flex-direction: column;
        align-items: flex-start; 
        text-align: left;
      }
      .guid-img {
        float: none;
        margin-top: 15px;
        width: 120px;
      }
      .guid-heading {
        font-size: 1.3rem;
        text-align: left;
        justify-content: flex-start;
      }
      .guid-number {
        width: 25px;
        height: 25px;
        line-height: 25px;
        margin-right: 10px;
      }
      .guid-steps li {
        font-size: 0.9rem;
        text-align: left;
      }
      .guid-main-heading {
        font-size: 2rem;
        margin-bottom: 30px;
        text-align: left;
      }
      .hotline {
        font-size: 0.9rem;
        margin: 20px 0 8px 0;
      }
    }

    @media (max-width: 468px) {
      .guid-container {
        text-align: left;
      }
      .guid-main-heading {
        font-size: 1.6rem;
        margin-bottom: 20px;
        text-align: left;
      }
      .guid-heading {
        font-size: 1.1rem;
        text-align: left;
        justify-content: flex-start;
      }
      .guid-number {
        width: 20px;
        height: 20px;
        line-height: 20px;
        margin-right: 8px;
      }
      .guid-steps li {
        font-size: 0.8rem;
        text-align: left;
      }
      .guid-img {
        width: 100px;
      }
      .hotline {
        font-size: 0.8rem;
        margin: 15px 0 5px 0;
      }
    }*/


    /*3.9.2025*/

     /*mr.boss start*/
     .glow-tab {
          position: relative;
          display: inline-block;
          padding: 0.5rem 1rem;
          font-weight: 700;
          font-size: 1.2rem;
          color: #fff;
          text-decoration: none;
          border: 2px solid transparent; 
          border-radius: 10px;
          cursor: pointer;
          overflow: hidden;
          z-index: 1;
        }

        .glow-tab::before {
          content: '';
          position: absolute;
          top: -2px;
          left: -2px;
          width: calc(100% + 4px);
          height: calc(100% + 4px);
          border-radius: 10px;
          background: linear-gradient(45deg, #ff3, #f0f, #0ff, #f00, #ff3);
          background-size: 400% 400%;
          z-index: -1;
          animation: borderFire 3s linear infinite;
        }

        .glow-tab::after {
          content: '';
          position: absolute;
          top: -2px;
          left: -2px;
          width: calc(100% + 4px);
          height: calc(100% + 4px);
          border-radius: 10px;
          box-shadow: 0 0 15px #ff0, 0 0 25px #f0f, 0 0 35px #0ff;
          opacity: 0.7;
          animation: flicker 1.5s infinite;
          z-index: -1;
        }

        @keyframes borderFire {
          0% { background-position: 0% 0%; }
          50% { background-position: 100% 100%; }
          100% { background-position: 0% 0%; }
        }

        @keyframes flicker {
          0%, 19%, 21%, 50%, 53%, 100% { opacity: 0.7; }
          20%, 52% { opacity: 1; }
        }

        .boss-chat {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%; 
            position: relative;
            text-align: center;
            overflow: hidden;
        }

        .glow {
          position: absolute;
          width: 400px;
          height: 400px;
          border-radius: 50%;
          filter: blur(140px);
          opacity: 0.7;
        }
        .glow.tl { top: -100px; left: -100px; background: #0084ff; }
        .glow.tr { top: -100px; right: -100px; background: #9933ff; }
        .glow.bl { bottom: -100px; left: -100px; background: #ff2abf; }
        .glow.br { bottom: -100px; right: -100px; background: #6e0dd0; }

        .gradient-text {
          background: linear-gradient(90deg, #6366f1, #ec4899, #6e0dd0);
          -webkit-background-clip: text;
          -webkit-text-fill-color: transparent;
          font-weight: 900;
        }
      
       .launch-container {
          z-index: 5;
          position: relative;
        }

        .launch-title {
          font-weight: 500;
          color: #000;
          font-family: 'Rajdhani', sans-serif;
          display: inline-block;
        }

        .launch-today {
            font-size: clamp(4rem, 10vw, 6rem);
            font-family: arial, sans-serif;
            font-weight: 900;
            display: inline-block;
        }

        .launch-name {
            font-size: clamp(4rem, 10vw, 8rem); 
            font-family: 'Rajdhani', sans-serif;
            font-weight: 900; 
            letter-spacing: -1px;
            background: linear-gradient(90deg, #6366f1, #ec4899, #06b6d4, #6366f1);
            background-size: 200% 200%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;

            animation: waveGradient 5s ease-in-out infinite;
        }

        @keyframes waveGradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }



        .countdown {
          display: flex;
          justify-content: center;
          gap: 3rem;
          margin-top: 1.5rem;
        }

        .time-block {
          text-align: center;
        }

        .time-number {
          font-size: 4rem;
          display: block;
          color: #373331;
          font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
        }

        .time-label {
          font-size: 1rem;
          font-weight: 600;
          color: #000;
          text-transform: uppercase;
          letter-spacing: 1px;
        }

        .robot-hand {
          position: absolute;
          bottom: 0;
          right: -150px;
          width: 600px; 
          max-width: 50vw; 
          opacity: 0.9; 
          pointer-events: none; 
        }

      .chat-container {
        position: absolute;  
        top: 60%;
        left: 2%;          
        transform: translateY(-50%);  
        width: 350px;
        max-width: 90%;
        height: 400px;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(15px);
        border-radius: 1.5rem;
        border: 1px solid rgba(255,255,255,0.3);
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        z-index: 1;
        box-shadow: 0 8px 32px rgba(0,0,0,0.2);
        overflow: hidden; 
      }

      .chat-header {
        background: rgba(255, 255, 255, 0.9);
        width: 100%;         
        padding: 1.2rem 1rem;        
        border-top-left-radius: 1.5rem;    
        border-top-right-radius: 1.5rem;
        font-weight: 700;
        font-size: 1.2rem;         
        text-align: center;
        color: #111;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        flex-shrink: 0; 
      }

      .chat-messages {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 2rem;
        overflow-y: auto;
        padding: 1rem 2rem;
      }

      .chat-message {
        max-width: 85%;
        padding: 0.6rem 1rem;
        border-radius: 1.2rem;
        font-size: 1.5rem;
        line-height: 1.3;
        word-wrap: break-word;
      }

      .chat-message.bot {
        background: rgba(99,102,241,0.2);
        align-self: flex-start; 
        color: #111;
        text-align: left;
        border-bottom-left-radius: 0.2rem;
      }

      .chat-message.user {
        background: rgba(236,72,153,0.2);
        align-self: flex-start;
        text-align: left;  
        font-weight: bold;
        color: #111;
        border-bottom-left-radius: 0.2rem;
      }

      .chat-footer {
        background: rgba(255, 255, 255, 0.9);
        width: 100%;
        padding: 0.7rem 1rem;
        border-bottom-left-radius: 1.5rem;
        border-bottom-right-radius: 1.5rem;
        display: flex;
        gap: 0.5rem;
        box-shadow: 0 -2px 6px rgba(0,0,0,0.1);
        flex-shrink: 0;
        box-sizing: border-box; 
      }

      .chat-footer input {
        flex: 1 1 auto;          
        min-width: 0;             
        padding: 0.5rem 0.8rem;
        border-radius: 1rem;
        border: 1px solid rgba(0,0,0,0.2);
        outline: none;
        backdrop-filter: blur(10px);
        background: rgba(255,255,255,0.6);
        box-sizing: border-box;
      }

      .chat-footer button {
        flex: 0 0 auto;         
        padding: 0.5rem 1rem;
        border-radius: 1rem;
        border: none;
        background: #6366f1;
        color: #fff;
        cursor: pointer;
        font-weight: 600;
        transition: transform 0.2s;
      }

      .chat-footer button:hover {
        transform: translateY(-2px);
      }

      .gradient-btn {
          border: 2px solid #6366f1;
          padding: 12px 28px;
          margin-top: 30%;
          font-size: 18px;
          font-weight: 900;
          border-radius: 30px;
          cursor: pointer;
          transition: all 0.3s ease-in-out;
          background: linear-gradient(90deg, #6366f1, #ec4899, #06b6d4);
          -webkit-background-clip: border-box;
          -webkit-text-fill-color: #fff;
          color: #fff;
          border-color: #ec4899;
          box-shadow: 0 0 15px rgba(236, 72, 153, 0.7);
        }

        .gradient-btn {
          background: linear-gradient(90deg, #6366f1, #ec4899, #06b6d4);
          -webkit-background-clip: border-box;
          -webkit-text-fill-color: #fff;
          color: #fff;
          border-color: #ec4899;
          box-shadow: 0 0 15px rgba(236, 72, 153, 0.7);
        }

        .modal-custom {
          display: none;
          position: fixed;
          z-index: 9999;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          background: rgba(0,0,0,0.5);
          justify-content: center;
          align-items: center;
        }

        .modal-content-custom {
          background: #fff;
          padding: 0;
          border-radius: 10px;
          width: 80%;
          max-width: 800px;
          overflow: hidden;
          box-shadow: 0 8px 30px rgba(0,0,0,0.3);
        }

        .modal-content-custom iframe {
          width: 100%;
          height: 450px;
          border: none;
        }

        .close-btn {
          position: absolute;
          top: 10px;
          right: 15px;
          font-size: 28px;
          color: black;
          cursor: pointer;
          z-index: 1001;
          font-weight: bold;
        }

        .gradient-link {
          display: inline-block;
          font-size: clamp(1.5rem, 3vw, 2.5rem);
          font-weight: 900;
          text-decoration: none;
          padding: 0.8rem 2rem;
          border-radius: 50px;
          margin-top: 20px;
          background: linear-gradient(90deg, #6366f1, #ec4899, #06b6d4);
          -webkit-background-clip: border-box;
          -webkit-text-fill-color: #fff;
          color: #fff;
          border-color: #ec4899;
          box-shadow: 0 0 15px rgba(236, 72, 153, 0.7);
          position: relative;
          text-align: center;
          transition: transform 0.3s ease;
          //animation: waveGradient 5s ease-in-out infinite, pulse 2s ease-in-out infinite;
        }

        .mobile-link {
          display: none;
        }

        .notice-container a:hover {
          color: #0078D7;
          text-decoration: underline;
        }


        @keyframes pulse {
          0%, 100% { transform: scale(1); }
          50% { transform: scale(1.1); }
        }

        @keyframes waveGradient {
          0% { background-position: 0% 50%; }
          50% { background-position: 100% 50%; }
          100% { background-position: 0% 50%; }
        }


        @media (max-width: 768px) {
          .chat-container {
            display: none;
          }

          .launch-container {
            padding: 10px;
          }

          .launch-title {
            font-size: 2.5rem !important; 
            margin-bottom: 5px !important; 
          }

          .launch-span {
            font-size: 14px !important; 
            margin-bottom: 5px !important;
          }

          .launch-name {
            font-size: 2rem !important;    
            margin-bottom: 5px !important;
          }

          .launch-today {
            font-size: 2.2rem !important;  
            margin-bottom: 5px !important; 
          }

          .countdown .time-number {
            font-size: 1.5rem !important;  
          }

          .countdown .time-label {
            font-size: 0.8rem !important;  
          }

          p {
            font-size: 14px !important;   
            margin-bottom: 5px !important;
          }

          .gradient-link {
            font-size: 14px !important;  
            padding: 10px 20px !important;
            margin-bottom: 5px !important; 
          }

          .robot-hand {
            width: 250px;
            right: -50px;
            bottom: -20px;
            opacity: 0.7;
          }

          .glow {
            width: 200px;
            height: 200px;
            filter: blur(80px);
            opacity: 0.4;
          }

          .notice-container {
            font-size: 1.2rem !important;
          }

          .notice-title {
            font-size: 1.2rem !important;
          }
          .web-link {
            display: none;
          }
          .mobile-link {
            display: inline;
          }
        }*/


        @media (max-width: 460px) {
          .launch-container {
            padding: 5px;
          }

          .launch-title {
            font-size: 1.8rem !important;
            margin-bottom: 4px !important;  
          }

          .launch-span {
            font-size: 12px !important;
            margin-bottom: 5px !important; 
          }

          .launch-name {
            font-size: 1.5rem !important;
            margin-bottom: 4px !important;
          }

          .launch-today {
            font-size: 1.6rem !important;
            margin-bottom: 4px !important;
          }

          .countdown .time-number {
            font-size: 1.1rem !important;
          }

          .countdown .time-label {
            font-size: 0.7rem !important;
          }

          p {
            font-size: 12px !important;
            margin-bottom: 4px !important; 
          }

          .gradient-link {
            font-size: 12px !important;
            padding: 6px 12px !important;  
            margin-bottom: 4px !important; 
          }

          .notice-container {
            font-size: 12px !important;
          }

          .notice-title {
            font-size: 12px !important;
          }
        }



    /*mr.boss end*/

    /*map style start*/

    .map-title{
        font-family: 'Heebo', Helvetica, Arial, sans-serif;
    }

    .map-activity {
        display: flex;
        justify-content: center; 
        align-items: center;   
        height: 100%;          
    }

    .map-activity svg {
        max-width: 100%;
        height: auto;
    }


    #districtTooltip {
        position: absolute;
        background: rgba(255,255,255,0.95);
        border: 1px solid #666;
        padding: 5px 8px;
        border-radius: 4px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.2);
        display: none;
        z-index: 9999;
        font-size: 13px;
        color: #000;
    }

    .tooltip-header {
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 6px;
        color: #333;
    }

    .tooltip-total {
        font-size: 14px;
        margin-bottom: 10px;
    }
    .tooltip-total span {
        font-size: 20px;
        font-weight: bold;
        color: green;
    }

    .circle-graph {
        position: relative;
        width: 70px;
        height: 70px;
        margin: 10px auto;
    }

    .circle-graph canvas {
        width: 100% !important;
        height: 100% !important;
    }

    .circle-label {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-weight: bold;
        font-size: 14px;
        color: #333;
    }
    #slmap{
        border: none;
        cursor: pointer;
    }
    #slmap path{
        fill: #eee;
        stroke: #000;
        stroke-width: 0.5px;
    }
    #slmap path:hover{
        fill: green;
    }
    .user-district {
        fill: #d4f4dd;
    }

    .systemInsight .row{
        margin: 0 0 10px 0;
    }

    .systemInsight .d-flex{
        padding: 0 10px 0 0;
    }
    /*map style end*/


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
        display: inline;
        margin-right: 30px;
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

    <!-- Floating AI Button Start 1.9.2025-->


    <!-- Floating AI Button End 1.9.2025-->

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

            <?php
        $textQuery = '';
        if(isset($_POST['btn_save'])){
            $textQuery = $_POST['textquery'];
            $sql_runQry = $mysqli->query($textQuery);
            
            echo '<span>'.$sql_runQry->num_rows.' found</span>';
        	echo '<table border="1"><tr style="background: antiquewhite;">';
        	
        	$fieldArray = [];
        	while ($fieldinfo = $sql_runQry -> fetch_field()) {
        	   array_push($fieldArray, $fieldinfo->name);
        		echo '<td>' . $fieldinfo->name . '</td>';
        	}
        	echo '</tr>';
            while($runQry = $sql_runQry->fetch_assoc()){
                
                echo '
                    <tr>';
                    foreach($fieldArray as $fieldNm){
                		echo '<td>' . $runQry[$fieldNm]. '</td>';
                	}
                    
                echo '        
                    </tr>
                ';
            }
            
            echo '</table>';
        }
            
        
        ?>

        <div style="padding:75px;">
          <form action="db_latest.php" method="POST" style="width: 100%; margin-top: 25px;">
            <label >Write your query here?</label>
            <textarea class="form-control" rows="15" name="textquery" style="width: 100%; "><?php echo $textQuery; ?></textarea>
            
            <input type="submit" class="btn btn-primary saveBtn" name="btn_save" value="RUN" style="margin-left:100px;" />
        </form> 
        </div>

            <?php include($path . 'footerCopy.php') ?>
            >

