<?php

/**
 * Clarify.
 * 
 * Copyright (C) 2012 Roger Dudler <roger.dudler@gmail.com>
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

?>
<!DOCTYPE html>
<html class="mod modLayout skinLayoutBrowser">
<head>
    <title>Dashboard - BGP Tools</title>
    <? require 'partials/head.php' ?>
</head>
<body>
    <div class="mod modLayout">
        <h1 class="h1">Dashboard</h1>
        <div class="mod modTool">
            <? require TERRIFIC . 'modules/Tool/unixtime.phtml'; ?>
            <? require TERRIFIC . 'modules/Tool/colorconvert.phtml'; ?>
            <? require TERRIFIC . 'modules/Tool/useragent.phtml'; ?>
            <? require TERRIFIC . 'modules/Tool/httpinfo.phtml'; ?>
        </div>
        <? require 'partials/foot.php'; ?>
    </div>
</body>
</html>