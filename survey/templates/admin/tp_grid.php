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
        </style>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.min.css">
<link rel="stylesheet" href="http://js.arcgis.com/3.13/esri/css/esri.css">
<style>
  /*html, body {
    padding: 0;
    margin: 0;
    width: 100%;
    height: 100%;
    font-size: 1em;
    font-family: Roboto, "Helvetica Neue", Verdana, Geneva, Arial, Helvetica, sans-serif;
  }*/

  #map {
/*    position: absolute;
    top:60px;
    left:200px;*/
    /*width: 100%;*/
    /*height: 100%;*/
    width:100%;
    height:400px;
    z-index: 1;   
    border: 1px solid gray;
    margin: auto;
    margin-bottom: 12px;
  }

  #jqSlider {
    position: absolute;
    left: 2em; /* 32 pixels */
    top: 15.65em; /* 250 pixels */
    height: 12.5em; /* 200 pixels */
    z-index: 2;
    font-size: 0.75em; /* 12 pixels */
  }

  #ui-sample-description {
    position: absolute;
    top: 1.25em;
    left: 1.25em;
    right: 1.25em;
    z-index: 2;
    background-color: #fff;
    border-radius: 0.3125em;
    border: 0.0625em #AAAAAA solid;
  }

  #ui-sample-feedback {
    bottom: 1.25em;
    left: 1.25em;
    z-index: 2;
    position: absolute;
    text-align: center;
    background-color: #fff;
    border-radius: 0.3125em;
    border: 0.0625em #AAAAAA solid;
  }

  .simpleInfoWindow, .simpleInfoWindow .title {
    border-color: #5C9CFF;
  }

  .simpleInfoWindow .title {
    font-weight: bold;
  }

  .ui-header {
    top: 0;
    left: 0;
    right: 0;
    height: 1.875em;
    color: #FFFFFF;
    background-color: #67656c;
    padding: 0.625em 0 0 0.625em;
    border-radius: 0.3125em 0.3125em 0 0;
    border-bottom-color: #FFFFFF;
    border-bottom-width: 0.3125em;
  }

  .ui-content {
    color: #343434;
    background-color: #fff;
    padding: 0.625em 0.625em;
    border-radius: 0 0 0.3125em 0.3125em;
  }

  .ui-drop-shadow {
    -webkit-box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
    -moz-box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
  }

  .ui-state-default,
  .ui-widget-content .ui-state-default,
  .ui-widget-header .ui-state-default {
    border: 2px solid #67656c;
  }

  .ui-widget-content {
    border: 2px solid #67656c;
    color: #555555;
  }

  .org_description, .use_advocacy_desc, .use_prod_srvc_desc, .use_org_opt_desc, .use_research_desc, .use_other_desc, .org_additional {
    height: 60px !important;
    white-space: pre-line !important;
    word-wrap: break-word;
    overflow: scroll;
  }

</style>

<script src="http://js.arcgis.com/3.13compact/"></script>
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


        <div class="container-fluid" style="border:0px solid orange;">
            <div class="row">
                <div class="col-md-1 visible-md visible-lg" style="border:0px solid green;">
                    <div class="affix">
                        <!--a href="/survey/opendata/list/new/">view recent</a-->
                        Admin
                        <br />
                        view recent
                        <br />
                        <a href="/map/survey/start/internal/add" target="_blank">add min survey</a>
                        <br />
                        <a href="/survey/opendata/data/flatfile.json">flatfile (json)</a>
                        <br />
                        <a href="/map/survey/admin/survey/duplicate/">duplicate data</a>
                        <br />
                        <a href="/map/survey/admin/survey/grid/">reset table</a>
                        <br />
                        
                        <!--a href="">all</a-->
                    </div>
                </div>
                <div class="col-md-10" style="border:0px solid blue;">
                    <div style="text-align:center;margin-bottom:12px;">
                        <img class="logo" src="http://uploads.webflow.com/54c24a0650f1708e4c8232a0/54c24f1f6631ca2737e86a02_Logo-Mark.png" width="60" alt="54c24f1f6631ca2737e86a02_Logo-Mark.png">
                        <img class="logo" src="http://uploads.webflow.com/54c24a0650f1708e4c8232a0/54c24fc57bbf1d8c4cfd6581_Logo-Text.png" width="400" alt="54c24fc57bbf1d8c4cfd6581_Logo-Text.png"></a>
                    </div>


                    <!-- <button id="removeSelected" type="button" class="btn btn-default">Remove Selected</button>
                    <button id="clear" type="button" class="btn btn-default">Clear</button>
                    <button id="init" type="button" class="btn btn-default">Init</button> -->
                    <button id="status" type="button" class="btn btn-default" style="color:green;">&nbsp;</button>
                    <!--div class="table-responsive"-->
                        <table id="grid" class="table table-condensed table-hover table-striped" data-selection="false" data-multi-select="true" data-row-select="true" data-keep-selection="true">
                            <thead>
                                <tr>
                                    <th data-column-id="id" data-identifier="true">ID</th>
                                    <th data-order="asc" data-align="left" data-header-align="left" data-visible="true"  data-filterable="true" data-sortable="true" data-column-id="org_name"        data-formatter="org_name">org_name</th>
                                    <th data-order="asc" data-align="left" data-header-align="left" data-visible="true"  data-filterable="true" data-sortable="true" data-column-id="org_type"        data-formatter="org_type">org_type</th>
                                    <th data-order="asc" data-align="left" data-header-align="left" data-visible="false" data-filterable="true" data-sortable="true" data-column-id="org_type_other"  data-formatter="org_type_other">org_type_other</th>
                                    
                                    <th data-order="asc" data-align="left" data-header-align="left" data-visible="false" data-filterable="true" data-sortable="true" data-column-id="org_url"  data-formatter="org_url">org_url</th>
                                    <th data-order="asc" data-align="left" data-header-align="left" data-visible="false" data-filterable="true" data-sortable="true" data-column-id="no_org_url"  data-formatter="no_org_url">no_org_url</th>
                                    
                                    <th data-order="asc" data-align="left" data-header-align="left" data-visible="true" data-filterable="true" data-sortable="true" data-column-id="org_year_founded"  data-formatter="org_year_founded">org_year_founded</th>

                                    <th data-order="asc" data-align="left" data-header-align="left" data-visible="false" data-filterable="true" data-sortable="true" data-column-id="org_size_id"  data-formatter="org_size_id">org_size_id</th>
                                    <th data-order="asc" data-align="left" data-header-align="left" data-visible="false" data-filterable="true" data-sortable="true" data-column-id="industry_id"  data-formatter="industry_id">industry_id</th>

                                    <th data-order="asc" data-align="left" data-header-align="left" data-visible="false" data-filterable="true" data-sortable="true" data-column-id="org_greatest_impact"  data-formatter="org_greatest_impact">org_greatest_impact</th>
                                    <th data-order="asc" data-align="left" data-header-align="left" data-visible="false" data-filterable="true" data-sortable="true" data-column-id="org_greatest_impact_detail"  data-formatter="org_greatest_impact_detail">org_greatest_impact_detail</th>

                                    <th data-order="asc" data-align="left" data-header-align="left" data-visible="false" data-filterable="true" data-sortable="true" data-column-id="data_country_count"  data-formatter="data_country_count">data_country_count</th>
                                    <th data-order="asc" data-align="left" data-header-align="left" data-visible="false" data-filterable="true" data-sortable="true" data-column-id="data_use_type"  data-formatter="data_use_type">data_use_type</th>
                                    <th data-order="asc" data-align="left" data-header-align="left" data-visible="false" data-filterable="true" data-sortable="true" data-column-id="use_advocacy"  data-formatter="use_advocacy">use_advocacy</th>
                                    <th data-order="asc" data-align="left" data-header-align="left" data-visible="false" data-filterable="true" data-sortable="true" data-column-id="use_advocacy_desc"  data-formatter="use_advocacy_desc">use_advocacy_desc</th>

                                    <th data-order="asc" data-align="left" data-header-align="left" data-visible="false" data-filterable="true" data-sortable="true" data-column-id="use_prod_srvc"  data-formatter="use_prod_srvc">use_prod_srvc</th>
                                    <th data-order="asc" data-align="left" data-header-align="left" data-visible="false" data-filterable="true" data-sortable="true" data-column-id="use_prod_srvc_desc"  data-formatter="use_prod_srvc_desc">use_prod_srvc_desc</th>
                                    <th data-order="asc" data-align="left" data-header-align="left" data-visible="false" data-filterable="true" data-sortable="true" data-column-id="use_org_opt"  data-formatter="use_org_opt">use_org_opt</th>
                                    <th data-order="asc" data-align="left" data-header-align="left" data-visible="false" data-filterable="true" data-sortable="true" data-column-id="use_org_opt_desc"  data-formatter="use_org_opt_desc">use_org_opt_desc</th>
                                    <th data-order="asc" data-align="left" data-header-align="left" data-visible="false" data-filterable="true" data-sortable="true" data-column-id="use_research"  data-formatter="use_research">use_research</th>
                                    <th data-order="asc" data-align="left" data-header-align="left" data-visible="false" data-filterable="true" data-sortable="true" data-column-id="use_research_desc"  data-formatter="use_research_desc">use_research_desc</th>
                                    <th data-order="asc" data-align="left" data-header-align="left" data-visible="false" data-filterable="true" data-sortable="true" data-column-id="use_other"  data-formatter="use_other">use_other</th>
                                    <th data-order="asc" data-align="left" data-header-align="left" data-visible="false" data-filterable="true" data-sortable="true" data-column-id="use_other_desc"  data-formatter="use_other_desc">use_other_desc</th>

                                    <th data-order="asc" data-align="left" data-header-align="left" data-visible="true" data-filterable="true" data-sortable="true" data-column-id="org_hq_city"  data-formatter="org_hq_city">org_hq_city</th>
                                    <th data-order="asc" data-align="left" data-header-align="left" data-visible="false" data-filterable="true" data-sortable="true" data-column-id="org_hq_st_prov"  data-formatter="org_hq_st_prov">org_hq_st_prov</th>
                                    <th data-order="asc" data-align="left" data-header-align="left" data-visible="true" data-filterable="true" data-sortable="true" data-column-id="org_hq_country"  data-formatter="org_hq_country">org_hq_country</th>

                                    <th data-order="asc" data-align="left" data-header-align="left" data-visible="false" data-filterable="true" data-sortable="true" data-column-id="latitude"  data-formatter="latitude">latitude</th>
                                    <th data-order="asc" data-align="left" data-header-align="left" data-visible="false" data-filterable="true" data-sortable="true" data-column-id="longitude"  data-formatter="longitude">longitude</th>
                                    <th data-order="asc" data-align="left" data-header-align="left" data-visible="false" data-filterable="false" data-sortable="true" data-column-id="org_hq_country_locode"  data-formatter="org_hq_country_locode">org_hq_country_locode</th>

                                    <th data-order="asc" data-align="left" data-header-align="left" data-visible="false" data-filterable="true" data-sortable="true" data-column-id="org_hq_country_region"  data-formatter="org_hq_country_region">org_hq_country_region</th>
                                    <th data-order="asc" data-align="left" data-header-align="left" data-visible="false" data-filterable="true" data-sortable="true" data-column-id="org_hq_country_income"  data-formatter="org_hq_country_income">country_income</th>
                                    <th data-order="asc" data-align="left" data-header-align="left" data-visible="false" data-filterable="true" data-sortable="true" data-column-id="org_hq_country_income_code"  data-formatter="org_hq_country_income_code">country_income_code</th>
                                    <th data-order="asc" data-align="left" data-header-align="left" data-visible="false" data-filterable="true" data-sortable="true" data-column-id="org_additional"  data-formatter="org_additional">org_additional</th>

                                    <th data-order="asc" data-align="left" data-header-align="left" data-visible="false" data-filterable="true" data-sortable="true" data-column-id="org_description"  data-formatter="org_description">org_description</th>

                                    <th data-order="asc" data-align="left" data-header-align="left" data-visible="true"  data-filterable="true" data-sortable="true" data-column-id="org_profile_status" data-formatter="org_profile_status">org_profile_status</th>

                                    <th data-order="asc" data-align="left" data-header-align="left" data-visible="true"  data-filterable="true" data-sortable="true" data-column-id="org_profile_src" data-formatter="org_profile_src">org_profile_src</th>

                                    <th data-order="asc" data-align="left" data-header-align="left" data-visible="true" data-filterable="false" data-sortable="true" data-column-id="org_profile_category"  data-formatter="org_profile_category">org_profile_category</th>
                                    <th data-column-id="link" data-sortable="true" data-formatter="link">link</th>
                                    <!-- <th data-column-id="commands" data-formatter="commands" data-sortable="false">Commands</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                
                                <?php

    foreach ($org_profiles as $org_profile) {
        // echo "<pre>"; print_r($org_profile); echo "..".$org_profile['org_name']."</pre>";
        // if ( array_key_exists('org_name', $org_profile) && $org_profile['org_profile_status'] == 'submitted') { 
        if ( array_key_exists('org_name', $org_profile) ) { 
            // check whether this page is for duplicate list.
            if (isset($duplicate_list)){
                if (!in_array($org_profile['profile_id'], $duplicate_list) ){
                    continue;
                }
            }
            echo "<tr>";
        
            echo "<td>${org_profile['profile_id']}</td>";
            // $keys is reusable list of field names for org_profile record - Also used to make fields editable
            $keys = array("org_name", "org_type", "org_type_other", "org_url", "no_org_url", "org_year_founded", "org_size_id", "industry_id",
                "org_greatest_impact", "org_greatest_impact_detail", "data_country_count", "data_use_type", "use_advocacy", "use_advocacy_desc",
                "use_prod_srvc", "use_prod_srvc_desc", "use_org_opt", "use_org_opt_desc", "use_research", "use_research_desc", "use_other", "use_other_desc",
                "org_hq_city", "org_hq_st_prov", "org_hq_country", "latitude", "longitude", "org_hq_country_locode",
                "org_hq_country_region", "org_hq_country_income", "org_hq_country_income_code", "org_additional",
                "org_description",
                "org_profile_status", "org_profile_src", "org_profile_category");
            foreach ($keys as $key) {                
                if ( array_key_exists($key, $org_profile) ) {
                    if ($key == "data_use_type"){
                        echo "<td>";
                        print_r($org_profile[$key]);    
                        echo "</td>";    
                    } else {
                        echo "<td>".$org_profile[$key]."</td>";
                    }
                } else {
                     echo "<td></td>";
                }
            }

            echo "<td></td>";
            echo "</tr>";
        }
    }
?>
                            </tbody>
                        </table>
                    <!--/div-->
                </div>
            </div>
        </div>

<!--         <div>
          <a href="#" class="btn btn-lg btn-success" data-toggle="modal" data-target="#basicModal">Click to open Modal</a>
        </div> -->

        <div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&amp;times;</button>
                <h4 class="modal-title" id="myModalLabel">Edit Record</h4>
                </div>
                <div class="modal-body" id="modal-body">
                    <h3>Modal Body</h3>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
          </div>
        </div>


        <footer id="footer" style="margin-top:50px;text-align:center;">
            © Copyright 2015, Center for Open Data Enterprise
        </footer>

        <!--script src="/lib/jquery-1.11.1.min.js"></script-->
        <script src="/map/survey/js3/bootstrap.js"></script>
        <script src="/map/survey/dist/jquery.bootgrid.js"></script>
        <!--script src="/map/survey/js/vendor/mindmup-editableTableWidget/mindmup-editabletable.js"></script-->
        <script>
            $(function()
            {
                function init()
                {
                    var grid = $("#grid").bootgrid({
                        rowCount: [10, 25, 50, 100, 500, -1],
                        formatters: {
                            "link": function(column, row)
                            {
                                return "<a href=\"/map/survey/edit/" + row.id + "/form\" target=\"_blank\">" + row.org_name + " survey</a>";
                            },

                            "commands": function(column, row)
                            {
                                return "<button type=\"button\" class=\"btn btn-xs btn-default command-edit\" data-row-id=\"" + row.id + "\"><span class=\"fa fa-pencil\">edit</span></button> " + 
                                    "<button type=\"button\" class=\"btn btn-xs btn-default command-delete\" data-row-id=\"" + row.id + "\"><span class=\"fa fa-trash-o\">other...</span></button>";
                            },

                            // "org_name": function(column, row) { return "<div id='" + "org_name:" + row.id + "' contenteditable='true' onclick=\"document.execCommand('selectAll',false,null)\">" + row.org_name  + "</div>"; }
                            // "org_type": function(column, row) { return "<div id='" + "org_type:" + row.id + "' contenteditable='true' onclick=\"document.execCommand('selectAll',false,null)\">" + row.org_type  + "</div>"; }

                    <?php
                        foreach ($keys as $key) {
                            $this_row = <<<EOF
                            "$key": function(column, row) { return "<div id='" + "$key:" + row.id + "' orig='"+ row.$key +"' contenteditable='true' class='$key' onclick=\"document.execCommand('selectAll',false,null)\">" + row.$key  + "</div>"; },
EOF;
                            echo $this_row;
                        }
                    ?>

                        }
                    }).on("loaded.rs.jquery.bootgrid", function()
                    {
                        // alert('here');

                        /* Executes after data is loaded and rendered */

                        // Attach contenteditable listener
                        var message_status = $("#status");
                        message_status.hide();

                        // Have return key blur field insted of add carriage return
                        $("div[contenteditable=true]").on('keydown', function(e) {  
                            if(e.keyCode == 13)
                            {
                                e.preventDefault();
                                this.blur();
                            }
                        });
                        $("div[contenteditable=true]").blur(function(){
                            // alert('blur');
                            var field_and_id = $(this).attr("id");
                            var value = $(this).text(); 

                            // split field information into field name and profile id
                            var fieldinfo = field_and_id.split(':');
                            field_name = fieldinfo[0];
                            profile_id = fieldinfo[1];
                            
                            message_status.show();
                            message_status.text(profile_id + ", " + field_name + ", " + value );
                            message_status.text('Status message: '+'/map/survey/admin/survey/updatefield/'+profile_id+", "+ field_name + "=" + value);
                            // hide the message
                            // setTimeout(function(){message_status.hide()},6000);
                            
                            if ( $(this).attr("orig") != value ) {
                                // alert( $(this).attr("orig") + ' vs ' + value );
                                // Followed tutorial: http://w3lessons.info/2014/04/13/html5-inline-edit-with-php-mysql-jquery-ajax/
                                // alert('trying to save');
                                $.post('/map/survey/admin/survey/updatefield/'+profile_id, field_name + "=" + value, function(data){
                                    if(data != '')
                                    {
                                        message_status.show();
                                        message_status.text(data);
                                        // hide the message
                                        // setTimeout(function(){message_status.hide()},5000);
                                    } else {
                                        alert("Data did not get saved");
                                    }
                                });
                            }
                        });

                        // Add command buttons
                        grid.find(".command-edit").on("click", function(e)
                        {
                            event.preventDefault();

                            // Retrieve record information
                            
                            // alert("You pressed edit on row: " + $(this).data("row-id"));
                            var content = "<p>You pressed edit on row: " + $(this).data("row-id")+"</p>";
                            // update modal content
                            $('#modal-body').html(content);
                            $("#basicModal").modal('show');
                            
                        }).end().find(".command-delete").on("click", function(e)
                        {
                            var content = "<p>You pressed other on row: " + $(this).data("row-id")+"</p>";
                            // update modal content
                            $('#modal-body').append(content);
                            $("#basicModal").modal('show');
                        });
                    });
                }
                
                init();
                
                // $("#clear").on("click", function ()
                // {
                //     $("#grid").bootgrid("clear");
                // });
                
                // $("#removeSelected").on("click", function ()
                // {
                //     $("#grid").bootgrid("remove");
                // });
                
                // $("#init").on("click", init);


            });
        </script>
    </body>
</html>