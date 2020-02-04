<?php 
session_start(); ?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>QR Scanner Demo</title>
        <script type="text/javascript" src="jquery-3.3.1.min.js"></script>

    </head>
    <body>

        <style>
            canvas {
                display: none;
            }
            hr {
                margin-top: 32px;
            }
            input[type="file"] {
                display: block;
                margin-bottom: 16px;
            }
            div {
                margin-bottom: 16px;
            }
        </style>
        <div style="text-align:center; " >
        <img width ="20%"src="../../../images/logo.png">
           <br>
            <b>Device has camera: </b>
            <span id="cam-has-camera"></span>
            <br>
            <video muted width="25%" position="center" playsinline id="qr-video"></video>
            <br>
            <span id="test" style="color: green; font-weight: bold;"></span>
             <br>
             <br>
             <b>Detected QR code: </b>
        
        <span id="cam-qr-result">None</span>
        <br>
        </div>
       
        </div>
    <div>
        <!--<select id="inversion-mode-select">
<option value="original">Scan original (dark QR code on bright background)</option>
<option value="invert">Scan with inverted colors (bright QR code on dark background)</option>
<option value="both">Scan both</option>
</select>-->
        

        <!--<b>Last detected at: </b>
<span id="cam-qr-result-timestamp"></span>
<hr>-->

        <!--
<h1>Scan from File:</h1>
<input type="file" id="file-selector">
<b>Detected QR code: </b>
<span id="file-qr-result">None</span>
-->

        <script type="module">
            import QrScanner from "../qr-scanner.min.js";
            QrScanner.WORKER_PATH = '../qr-scanner-worker.min.js';

            const video = document.getElementById('qr-video');
            const camHasCamera = document.getElementById('cam-has-camera');
            const camQrResult = document.getElementById('cam-qr-result');
            /*
    const camQrResultTimestamp = document.getElementById('cam-qr-result-timestamp');
*/
            /*
            const fileSelector = document.getElementById('file-selector');
*/
            const fileQrResult = document.getElementById('file-qr-result');

            function setResult(label, result) {
                label.textContent = result;

                /*      
        camQrResultTimestamp.textContent = new Date().toString();
*/

                label.style.color = 'teal';
                clearTimeout(label.highlightTimeout);
                label.highlightTimeout = setTimeout(() => label.style.color = 'inherit', 100);
                scan(result);
            }

            // ####### Web Cam Scanning #######

            QrScanner.hasCamera().then(hasCamera => camHasCamera.textContent = hasCamera);

            const scanner = new QrScanner(video, result => setResult(camQrResult, result));
            scanner.start();

          

            /*  // ####### File Scanning #######

    fileSelector.addEventListener('change', event => {
        const file = fileSelector.files[0];
        if (!file) {
            return;
        }
        QrScanner.scanImage(file)
            .then(result => setResult(fileQrResult, result))
            .catch(e => setResult(fileQrResult, e || 'No QR code found.'));
    });
*/

            function scan(content) { 

                jQuery.ajax({
                    url: "ajax.php",
                    data:'id='+content,
                    type:"POST",
                    success:function(data)
                    {
                        document.getElementById('test').innerHTML=data;
                    }
                });
            }

        </script>
        </body>
</html>