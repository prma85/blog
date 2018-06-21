<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<!DOCTYPE html>
<html manifest="cache.manifest">
    <head>

        <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
        <meta name="apple-mobile-web-app-capable" content="yes" />

        <meta name="apple-mobile-web-app-status-bar-style" content="black" />
        <link rel="apple-touch-icon" href="icon.png"/>

        <link rel="apple-touch-startup-image" href="icon.png" />
        <link rel="stylesheet" href="index.css" type="text/css" media="screen, mobile" title="main" charset="utf-8">

        <link rel="apple-touch-icon" sizes="57x57" href="img/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="img/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="img/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="img/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="img/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="img/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="img/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="img/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="img/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="img/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="img/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="img/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="img/favicon-16x16.png">
        <link rel="manifest" href="img/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="img/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">

        <title>BRASA - Sign UP</title>
    </head>
    <body>
        <!-- Put your Markup Here -->
        <div id="content">
            <br />
            <div id="logo">
                <img src="logo.png" />
            </div>
            <form id="contact" name="contact" onsubmit="saveUser">
                <label for="name">Name: <input type="text" name="name" placeholder="First and last name" required="required" /> </label><br />
                <label for="email">Email: <input type="email" name="email" placeholder="First and last name" required="required" /> </label><br />
                <label for="student">Are you a Student: <select name="student"><option value="yes">Yes</option><option value="no">no</option></select> </label><br />
                <input id="send" type="submit" value="Save" />
            </form>
        </div>
        <script type="text/javascript" src="index.js"></script>
    </body>
</html>
