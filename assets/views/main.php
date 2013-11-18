<!DOCTYPE html>
<html>
<head>
    <link href="/css/bootstrap-combined.min.css" rel="stylesheet"/>
    <link href="/js/jqrowl/jquery.jgrowl.min.css" rel="stylesheet" />
    <link href="/css/my.css" rel="stylesheet" />
    <script src="/js/jquery.js"></script>
    <script src="/js/purl.js"></script>
    <script src="/js/jqrowl/jquery.jgrowl.min.js"></script>
    <script src="/js/jquery-migrate-1.2.1.min.js"></script>
    <title>Система расчета компенсаций</title>
    <script>
        $(document).ready(function() {
            $("#loading").hide();
            $(document).ajaxStart(function() {
                $("#loading").show();
            });
            $(document).ajaxStop(function() {
                $("#loading").hide();
            });

            $("#old_browser").hide();
            if ($.browser != null && $.browser.mozilla && $.browser.version < 4) {
                $("#old_browser").show();
            } else
            if ($.browser != null && $.browser.msie && $.browser.version < 10) {
                $("#old_browser").show();
            } else
            if ($.browser != null &&  $.browser.opera && $.browser.version < 11) {
                $("#old_browser").show();
            }
            <?php
                if (isset($_GET['message'])) {
                   echo '$.jGrowl("'.$_GET['message'].'");';
                }
           ?>
        });

        function hand_made_validation() {
            var res = 0;
            var first = 0;
            $("input[type=number]").each(function (index) {
                $(this).removeClass("invalid");
                if (!$.isNumeric($(this).val())) {
                    $(this).addClass("invalid");
                    res = 1;
                }
                if (parseInt($(this).val()) != $(this).val()) {
                    $(this).addClass("invalid");
                    res = 2;
                }
                if (parseInt($(this).val()) < 0) {
                    $(this).addClass("invalid");
                    res = 3;
                }
                if ((parseInt($(this).val()) > 10000)) {
                    $(this).addClass("invalid");
                    res = 4;
                }

                if (first == 0 && res != null) {
                    first = res;
                }
            });
            if (first == 1) {
                $.jGrowl("Проверьте корректность вводимых данных!");
            }
            if (first == 2) {
                $.jGrowl("Вводимые числа должны быть целыми!");
            }
            if (first == 3) {
                $.jGrowl("Числа должны быть положительными!");
            }
            if (first == 4) {
                $.jGrowl("Число подозрительно большое...");
            }
            return res;
        }
    </script>
</head>
<body>
<div id="loading">
    <img src="/img/black-load.gif">
</div>
<div id="old_browser" class="alert-error" hidden>
    Система не будет корректно работать с устаревшими браузерами. Обновите свой бразузер или установите какой либо из списка ниже <br/>
    <a href="http://download.microsoft.com/download/5/D/4/5D405568-02E9-414D-BA52-A8D9890C1D31/IE10-Windows6.1-ru-ru.exe">Internet Explorer 10</a><br/>
    <a href="https://download.mozilla.org/?product=firefox-21.0&os=win&lang=ru">Fire Fox</a><br/>
    <a href="http://www.opera.com/computer/thanks?partner=www&par=id%3D35677%26amp;location%3D360&gaprod=opera">Opera</a><br/>
    <a href="https://www.google.com/intl/ru/chrome/browser/index.html#eula">Google Chrome</a><br/>
</div>
<div class="container">
    <div class="row">
        <div class="row-fluid span8 main_container">
            <?php
            if ($logged) {
                $menu = '<div class="main_menu">
                    <a href="/" class="btn btn-spacing" style="float: left;">На главную</a>';
                if ($is_admin) {
                    $menu .= '<a href="/admin" class="btn btn-spacing" style="float: left;">Админка</a>';
                }
//                if ($inActual) {
//                    $menu .= "<span style='width: 150px;'>Вы внесли изменения в данные, <br/>необходим перерасчет для акутализации данных</span>";
//                }
//                if (isset($_SESSION['dirty_year']) && isset($_SESSION['dirty_stage'])) {
//                    $menu .= '<div style="display:inline; color: #FF2F2D; font-weight:bold;">Изменены данные за '.$_SESSION['dirty_stage'].' этап '.$_SESSION['dirty_year'].' года!</div>';
//                }
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