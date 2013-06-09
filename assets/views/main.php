<!DOCTYPE html>
<html>
<head>
    <link href="/css/bootstrap-combined.min.css" rel="stylesheet"/>
    <link href="/js/jqrowl/jquery.jgrowl.min.css" rel="stylesheet" />
    <link href="/css/my.css" rel="stylesheet" />
    <script src="/js/jquery.js"></script>
    <script src="/js/purl.js"></script>
    <script src="/js/jqrowl/jquery.jgrowl.min.js"></script>
    <title>Система рассчета компенсаций</title>
    <script>
        $(document).ready(function() {
            $("#loading").hide();
            $(document).ajaxStart(function() {
                $("#loading").show();
            });
            $(document).ajaxStop(function() {
                $("#loading").hide();
            });
        });


    </script>
</head>
<body>
<div id="loading">
    <img src="/img/black-load.gif">
</div>
<div class="container">
    <div class="row">
        <div class="row-fluid span8">
            <?php
            if ($logged) {
                $menu = '<div class="main_menu">
                    <a href="/" class="btn btn-spacing" style="float: left;">На главную</a>';
                if ($is_admin) {
                    $menu .= '<a href="/admin" class="btn btn-spacing" style="float: left;">Админка</a>';
                }
                $menu .= '<a href="/login/logout" class="btn btn-spacing" style="float: right;">Выход</a>
                </div>';
                echo $menu;
            }
            ?>

            <?php
            //Include the subview
            include($subview.'.php');
            ?>
        </div>
    </div>
</div>
</body>
</html>