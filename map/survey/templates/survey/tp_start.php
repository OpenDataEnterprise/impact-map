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
                        <li><a href="/admin/login/">login</a></li>
                        <li><a href="/">Start page</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <div class="container-fluid" style="border:0px solid orange;">
            <div class="row">
                <div class="col-md-1 visible-md visible-lg" style="border:0px solid green;">
                    <div class="affix">
                        <!--
                        view recent
                        <br />
                        <a href="/survey/opendata/" target="_blank">new survey</a>
                        <br />
                        -->
                        <!--a href="">all</a-->
                    </div>
                </div>
                <div class="col-md-10" style="border:0px solid blue;">
                    <div style="text-align:center;">
                        <img class="logo" src="http://uploads.webflow.com/54c24a0650f1708e4c8232a0/54c24f1f6631ca2737e86a02_Logo-Mark.png" width="60" alt="54c24f1f6631ca2737e86a02_Logo-Mark.png">
                        <img class="logo" src="http://uploads.webflow.com/54c24a0650f1708e4c8232a0/54c24fc57bbf1d8c4cfd6581_Logo-Text.png" width="400" alt="54c24fc57bbf1d8c4cfd6581_Logo-Text.png"></a>
                    </div>

                    <div style="margin:10% 30% 0 30%;height:600px;text-align:center;">
                        <h3><a href="/map/survey/start">Take survey</a></h3>

                        <h3><a href="/map/survey/opendata/list/new">View submitted surveys</a></h3>

                        <h3><a href="/map/survey/opendata/data/flatfile.json">Combined flatfile (json)</a></h3>
                        <h3><a href="/map/viz/index.html">map/viz</a></h3>
                        <h4><a href="http://s3.amazonaws.com/stg.blueraster.com/opendata/index.html">Blue Raster Map (s3.amazonaws.com)</a></h4>

                        <h3>Administration</h3>

                        <h4><a href="/map/survey/admin/login/">Admin login</a></h4>
                        <h4><a href="https://github.com/GovReady/odesurvey">GitHub Code Repository</a><br><small>login required</small></h4>
                        <h4><a href="https://github.com/notifications">GitHub Issue Notifications</a> <br><small>login required</small></h4>
                        
                        <h3>Location lookup</h3>
                        <form>
                          <!-- Location -->  
                          <div class="form-group col-md-12">
                            <div class="form-group col-md-12 details">

                              <label for="org_hq_city_all">Location <small class="required">(Please provide as specific as possible)*</small></label>
                              <input type="text" class="form-control" id="org_hq_city_all" name="org_hq_city_all">

                              <label for="org_hq_city">City</label>
                              <input type="text" class="form-control" id="org_hq_city" name="org_hq_cityx" data-geo="locality">

                              <label for="org_hq_st_prov">State/Province</label>
                              <input type="text" class="form-control" id="org_hq_st_provx" name="org_hq_st_provx" data-geo="administrative_area_level_1">

                              <label for="org_hq_country">Country code</label>
                              <input type="text" class="form-control" id="org_hq_countryx" name="org_hq_countryx" data-geo="country_short">

                              <label for="org_hq_country">Country</label>
                              <input type="text" class="form-control" id="org_hq_countryxx" name="org_hq_countryxx" data-geo="country">

                              <label for="latitude">lat</label>
                              <input type="text" class="form-control" id="latitudex" name="latitudex" data-geo="lat">
                              <label for="longitude">lng</label>
                              <input type="text" class="form-control" id="longitudex" name="longitudex" data-geo="lng">
                            </div>
                          </div>
                      </form>

                    </div>

                </div>
            </div>
        </div>

        <footer id="footer" style="margin-top:50px;text-align:center;">
            © Copyright 2015, Center for Open Data Enterprise
        </footer>

        <script src="/map/survey/lib/jquery-1.11.1.min.js"></script>
        <script src="/map/survey/js3/bootstrap.js"></script>
        <script src="/map/survey/dist/jquery.bootgrid.js"></script>
          <!-- geocomplete -->
      <script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places"></script>
      <script src="/map/survey/js/vendor/ubilabs-geocomplete-eb38f45/jquery.geocomplete.js"></script>

        <script>
            $(function()
            {
                function init()
                {
                    $("#grid").bootgrid({
                        formatters: {
                            "link": function(column, row)
                            {
                                return "<a href=\"/survey/opendata/" + row.id + "/submitted/\">" + row.organization + " survey</a>";
                            }
                        }
                    });
                }
                
                init();
                
                $("#clear").on("click", function ()
                {
                    $("#grid").bootgrid("clear");
                });
                
                $("#removeSelected").on("click", function ()
                {
                    $("#grid").bootgrid("remove");
                });
                
                $("#init").on("click", init);

                // Geocomplete
                $('#org_hq_city_all').geocomplete({ 
                    details: ".details",
                    detailsAttribute: "data-geo"
                });
            });
        </script>
    </body>
</html>