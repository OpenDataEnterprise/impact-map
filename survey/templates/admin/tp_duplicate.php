<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Open Data Survey 2015 - List</title>
        <link href="/map/survey/css3/bootstrap.css" rel="stylesheet" />
        <link href="/map/survey/dist/jquery.bootgrid.css" rel="stylesheet" />
        <script src="/map/survey/js3/modernizr-2.8.1.js"></script>
        <style>
            @-webkit-viewport { width: device-width; }
            @-moz-viewport { width: device-width; }
            @-ms-viewport { width: device-width; }
            @-o-viewport { width: device-width; }
            @viewport { width: device-width; }

            body { padding-top: 70px; }
            
            .column .text { color: #f00 !important; }
            .cell { font-weight: bold; }
            .duplicate {
                padding-left: 20%;
                padding-right: 20%;
                margin-left: auto;
                margin-right: auto;
                min-height: 200px;
            }

        </style>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.min.css">

<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="http://code.jquery.com/ui/1.11.1/jquery-ui.min.js"></script>

    </head>
    <body>
        <header id="header" class="navbar navbar-default navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar">t1</span>
                        <span class="icon-bar">t2</span>
                        <span class="icon-bar"></span>
                    </button>
                    <span class="navbar-brand" data-i18n="title">Open Data Enterprise 2015 Survey</span>
                </div>
                <nav id="menu" class="navbar-collapse collapse" role="navigation">

                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#">(<?php echo $_SESSION['username'];?>)</a></li>
                        <li><a href="/map/survey/admin/logout/">logout</a></li>
                        <li><a href="/map/survey/admin/survey/submitted/">Recently submitted surveys</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <div class="duplicate" style="border:0px solid orange;">
            <div class="col-md-12" style="border:0px solid blue;">
            <?php 
                echo '<table id="grid" class="table table-condensed table-hover table-striped">';
                echo '<thead><tr><th>Organization Name</th><th>Profile IDs</th></tr></thead>';
                foreach ($duplicate_list as $key => $value){
                    echo "<tr><td>" . $key . "</td><td>" . $value . "</td></tr>";
                } 
                echo "</table>";
            ?>
            </div>
        </div>

        <script src="/map/survey/dist/jquery.bootgrid.js"></script>

        <footer id="footer" style="margin-top:50px;text-align:center;">
            © Copyright 2015, Center for Open Data Enterprise
        </footer>

    </body>
</html>