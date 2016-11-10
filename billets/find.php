<?php session_start();
// If user hasn't logged in, have them do that now. 
if (!isset($_SESSION["uname"])) {
    header("Location: /login.php"); // comment this line to disable login (for debug) 
}
?>
<!DOCTYPE html> 
<html>
    <head> 
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no"/>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/include/head_common.php'; ?>

    <script type = "text/javascript" >

    var data = <?php echo $sql->queryJSON("select posn, tkey, val from billetData where tkey not like '%mail%' and tkey not in ('poc', 'lastOccupant') order by posn;"); ?>; 

    var favorites = <?php echo $sql->queryJSON("select posn from favorites where username = '" . $_SESSION["uname"] . "';") ?>;

    // Restructure the data from "long" form to "wide" form. 
    var completed = [];
    var outData = []; 
    
    // "Unmelt" the dataframe 
    for (var i = 0; i < data.length; ++i){
    	var scratch = {}; // the row we're going to add 
    	var id = data[i].posn;

    	// For each row, see if we've found a new billet 
    	if ($.inArray(id, completed) > -1){
    		continue; 
    	} else { // it's a new billet 
    		// Filter all of the data down to the one's we found 
    		var myData = data.filter(function(x) {
    			return x.posn == id; 
    		});

    		// Build out the row 
    		scratch.id = id; 
    		for (var j = 0; j < myData.length; ++j){
    			if (Object.keys(scratch).indexOf(myData[j].tkey) == -1){
    				scratch[myData[j].tkey] = myData[j].val;
    			} else { 
    				scratch[myData[j].tkey] += ", " + myData[j].val;
    			}
    		}

    		// Add the row 
    		outData.push(scratch);
    		// Don't do the same id again 
    		completed.push(id); 
    	}
    }
	test = data; 
    // rename and de-allocate extra 
    data = outData; outData = []; 

    var degreeDisplay = {
        "bs" : "None",
        "ms" : "MS",
        "phd": "PhD"
    };
    
    var aads = <?php echo $sql->queryJSON("select code, degree from allowableDegrees;"); ?>;
    var aadDisplay = {};
    $(aads).each(function(i, x){
        aadDisplay[x.code] = x.degree;
    });

    var acqDisplay = {
        " " : " None",                                                                   
 "1"    : "ENTRY LEVEL I",
 "2"    : "INTERMEDIATE LEVEL II",
 "3"    : "SENIOR LEVEL III",
 "4"    : "LEVEL III, CRITICAL, DIVISION HEAD",
 "5"    : "LEVEL II, CRITICAL, NON-DIVISION HEAD",
 "6"    : "LEVEL III, CRITICAL, NON-DIVISION HEAD",
 "7"    : "LEVEL III, NON-CRITICAL",
 "A"    : "ENTRY LEVEL I TRAINEE EXPOSED TO ACQ FUN",
 "B"    : "INTERMEDIATE LEVEL II CONT AREA SPEC/BRO",
 "C"    : "SENIOR LEVEL III IN DEPT KNOWLEDGE SPEC"
    }

    function toTitleCase(str)
    { try{
        return str.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
    } catch(e){
        return;
    }}

    function toggleFavorite(billet, x){
        $.ajax({
            url:"/billets/changeFavorite.php",
            type: 'post',
            data: {"billet" : billet,
                   "case" : x.checked}
        });
    }

    // Build a giant array of the data for table display 
    for (var i = 0; i < data.length; ++i){
    	outData.push(["<input type = 'checkbox' onchange='toggleFavorite(\"" + data[i].id + "\", this)' data-toggle='toggle' class = 'toggle' id = 'fav" + data[i].id + "'>",
            "<a href='/billets/view.php?billet=" + data[i].id + "'>" + data[i].id + "</a>",
    		          data[i].afsc, 
    		          data[i].grade,
    		          data[i].dutyTitle,
    		          data[i].location,
                      data[i].state,
    		          data[i].unit,
                      degreeDisplay[data[i].aadLevel],
                      toTitleCase(aadDisplay[data[i].aadDegree]),
                      toTitleCase(acqDisplay[data[i].acqLevel])]
    		          );
    }

    // Things to run after page load 
    $(function(){

        /*
        // initialize the map
        var map = L.map('map').setView([39.8282, -60], 2);

        // load a tile layer
        L.tileLayer('https://api.mapbox.com/styles/v1/jlepird/ciu4azfa300by2jo1vhynt4tl/tiles/256/{z}/{x}/{y}?access_token=pk.eyJ1IjoiamxlcGlyZCIsImEiOiJjaXU0YWpzMDcwaG1mMnRvMWQ1OWUyajNtIn0.GdK0FhpdJkfEvN3HxPwDDw',
        {
          attribution: 'Tiles by <a href="https://www.mapbox.com/">MapBox</a>',
          maxZoom: 17,
          minZoom: 1
        }).addTo(map);

        // Plot the locations of our data 
        
        for (var i = 0; i < data.length; ++i){
            var id = data[i].id;
             
            var marker = new L.marker([data[i].lon, data[i].lat],
                                   {bounceOnAdd: true}).addTo(map);

            marker.bindPopup("Billet: <a href='/billets/view.php?billet=" + id + "'>" + id + "</a>" + 
                              "<br>Location: " + data[i].location + 
                              "<br>Unit: " +     data[i].unit); 
                 
        }
        */
        

        // Charts
        var numberFormat = d3.format(".0f");
        var timeFormat = function(x) {
            var y = "0" + x;
            return y.substr(y.length - 2);
        }
        var barWidth = 250;

        billets = crossfilter(data);

        var billetsDim = billets.dimension(function(x){
            return x.id;
        });


        // Set ordering for favorites
        /* Create an array with the values of all the checkboxes in a column */
        // Function stolen shamelessly from https://datatables.net/examples/plug-ins/dom_sort
        $.fn.dataTable.ext.order['dom-checkbox'] = function  ( settings, col )
        {
            return this.api().column( col, {order:'index'} ).nodes().map( function ( td, i ) {
                return $('input', td).prop('checked') ? '1' : '0';
            } );
        }
 
        var toggleOptions = {
            on: "<span style='font-size: 100%;'> &starf; </span>",
            off: ""
        };
        
        function makeAllToggle(){
            $(".toggle").each(function(i,x){
                if ($(x).hasClass("toggleComplete")){
                    return;
                } else {
                    $(x).bootstrapToggle(toggleOptions);
                    $(x).addClass("toggleComplete");
                    return;
                }
            })
        }
        
        // Populate the table 
        var table = $('#mainTable')
               .on('search', function() {makeAllToggle();})
               .on('page', function() {makeAllToggle();})
               .DataTable({
                data: outData,
                colReorder: true,
                dom: 'Bfrtip',
                buttons: ['csv', 'excel'], 
                columns: [
                    {title: "Favorite", 
                    "orderDataType": "dom-checkbox"},
                    {title: "Billet Number", "defaultContent": "<i>None</i>"},
                    {title: "AFSC", "defaultContent": "<i>None</i>"},
                    {title: "Grade", "defaultContent": "<i>None</i>"},
                    {title: "Duty Title", "defaultContent": "<i>None</i>"},
                    {title: "Location", "defaultContent": "<i>None</i>"},
                    {title: "State", "defaultContent": "<i>None</i>"},
                    {title: "Unit", "defaultContent": "<i>None</i>"},
                    {title: "Degree", "defaultContent": "<i>None</i>"},
                    {title: "Degree Specialty", "defaultContent": "<i>None</i>"},
                    {title: "Acquisition Level", "defaultContent": "<i>None</i>"}
                    
                ]
            });
        table.draw();
        var selected = [];
        billetsDim.top(Infinity).forEach(function(x){
                selected.push(x.id);
            });
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex){
                return selected.indexOf(data[1]) >= 0;

        });

        // Inital checkboxing 
        $(favorites).each(function(i,x){
            $("#fav" + x.posn).attr("checked", "checked");
        })
    
        // Initial toggle update
        makeAllToggle();
        
        var updateTable = function(){
            selected = [];
            billetsDim.top(Infinity).forEach(function(x){
                selected.push(x.id);
            });
            table.draw();
            makeAllToggle();
        }
        // Initial toggle update

        // ============= BEGIN CHARTING ===============

        // ************* AFSC prefix pie chart ***************
        var afscPrefix = billets.dimension(function(x){
            return x.afsc.substring(0, 1); 
        });
        var afscPrefixGroup = afscPrefix.group();

        afscPrefixPieChart = dc.pieChart("#afscPrefixPie");
        afscPrefixPieChart.width(180)
                    .height(180)
                    .radius(80)
                    .ordinalColors(["#1f77b4", "#ff7f0e", "#2ca02c", "#d62728", "#9467bd",  "#8c564b", "#e377c2", "#7f7f7f", "#bcbd22", "#17becf"])
                    .dimension(afscPrefix)
                    .group(afscPrefixGroup)
                    .on("filtered", updateTable);

        // ************* AFSC pie chart ***************
        var afscs = billets.dimension(function(x){
            return x.afsc; 
        });
        var afscGroup = afscs.group();

        afscPieChart = dc.pieChart("#afscPie");
        afscPieChart.width(180)
                    .height(180)
                    .radius(80)
                    .ordinalColors(["#1f77b4", "#ff7f0e", "#2ca02c", "#d62728", "#9467bd",  "#8c564b", "#e377c2", "#7f7f7f", "#bcbd22", "#17becf"])
                    .dimension(afscs)
                    .group(afscGroup)
                    .on("filtered", updateTable);

        // ************* Grade chart ***************
        var grades = billets.dimension(function(x){
            if (x.grade.indexOf("O1") >= 0){
                return "O1";
            } else if (x.grade.indexOf("O2") >= 0) {
                return "O2";
            } else if (x.grade.indexOf("O3") >= 0) {
                return "O3";
            } else if (x.grade.indexOf("O4") >= 0) {
                return "O4";
            } else {
                return "O5";
            }
        });
        var gradeGroup = grades.group();
        gradeChart = dc.rowChart("#grade");
        gradeChart.width(barWidth)
                     .height(180)
                     .dimension(grades)
                     .group(gradeGroup)
                     .ordinalColors(["#1f77b4", "#ff7f0e", "#2ca02c", "#d62728", "#9467bd",  "#8c564b", "#e377c2", "#7f7f7f", "#bcbd22", "#17becf"])
                     .margins({top: 10, right: 50, bottom: 30, left: 40})
                     .elasticX(true)
                     .on("filtered", updateTable)
                     .xAxis().ticks(1);

        // ************* AAD Level ***************

        // Need to find the *minimum" aad level
        var aads = billets.dimension(function(x){
            if (x.aadLevel.indexOf("bs") >= 0){
                return "bs"; 
            } else if (x.aadLevel.indexOf("ms") >= 0){
                return "ms";
            } else {
                return "phd";
            }
        });
        var aadGroup = aads.group();
        aadChart = dc.rowChart("#aadLevel");
        aadChart.width(barWidth)
                .height(180)
                .dimension(aads)
                .group(aadGroup)
                .margins({top: 10, right: 50, bottom: 30, left: 40})
                .elasticX(true)
                .ordinalColors(["#1f77b4", "#ff7f0e", "#2ca02c", "#d62728", "#9467bd",  "#8c564b", "#e377c2", "#7f7f7f", "#bcbd22", "#17becf"])
                .label(function(d){
                    if (d.key == "ms"){
                        return "MS";
                    } else if (d.key == "phd"){
                        return "PhD"; 
                    } else {
                        return "None";
                    }
                })
                .on("filtered", updateTable)
                .xAxis().ticks(1);

        // ************* ACQ Levels  ***************
        var acqLevels = billets.dimension(function(x){
            return toTitleCase(acqDisplay[x.acqLevel]);
        });
        var acqLevelGroup = acqLevels.group();
        acqLevelChart = dc.rowChart("#acqLevel");
        acqLevelChart.width(barWidth)
                     .height(180)
                     .dimension(acqLevels)
                     .ordinalColors(["#1f77b4", "#ff7f0e", "#2ca02c", "#d62728", "#9467bd",  "#8c564b", "#e377c2", "#7f7f7f", "#bcbd22", "#17becf"])
                     .group(acqLevelGroup)
                     .margins({top: 10, right: 50, bottom: 30, left: 40})
                     .elasticX(true)
                     .on("filtered", updateTable)
                     .xAxis().ticks(1);

        // ************* CONUS pie chart ***************
        var conus = billets.dimension(function(x){
            return x.state == "OCONUS" ? "OCONUS" : "CONUS"; 
        });
        var conusGroup = conus.group();

        conusPieChart = dc.pieChart("#conusPie");
        conusPieChart.width(180)
                     .height(180)
                     .radius(80)
                     .ordinalColors(["#1f77b4", "#ff7f0e", "#2ca02c", "#d62728", "#9467bd",  "#8c564b", "#e377c2", "#7f7f7f", "#bcbd22", "#17becf"])
                     .dimension(conus)
                     .group(conusGroup)
                     .on("filtered", updateTable);

        // ************* Contact pie chart ***************
        var contact = billets.dimension(function(x){
            return x["contact?"] == "yes" ? "Yes" : "No"; 
        });
        var contactGroup = contact.group();

        contactPieChart = dc.pieChart("#contactPie");
        contactPieChart.width(180)
                     .height(180)
                     .radius(80)
                     .ordinalColors(["#1f77b4", "#ff7f0e", "#2ca02c", "#d62728", "#9467bd",  "#8c564b", "#e377c2", "#7f7f7f", "#bcbd22", "#17becf"])
                     .dimension(contact)
                     .group(contactGroup)
                     .on("filtered", updateTable);

        // ************* Deployable pie chart ***************
        var deployable = billets.dimension(function(x){
            return x["deployable"] == "yes" ? "Yes" : "No"; 
        });
        var deployableGroup = deployable.group();

        deployablePieChart = dc.pieChart("#deployablePie");
        deployablePieChart.width(180)
                     .height(180)
                     .radius(80)
                     .ordinalColors(["#1f77b4", "#ff7f0e", "#2ca02c", "#d62728", "#9467bd",  "#8c564b", "#e377c2", "#7f7f7f", "#bcbd22", "#17becf"])
                     .dimension(deployable)
                     .group(deployableGroup)
                     .on("filtered", updateTable);

        // ************* Predictable pie chart ***************
        var predictable = billets.dimension(function(x){
            return x.regularHours == "yes" ? "Yes" : "No"; 
        });
        var predictableGroup = predictable.group();

        predictablePieChart = dc.pieChart("#predictablePie");
        predictablePieChart.width(180)
                     .height(180)
                     .radius(80)
                     .ordinalColors(["#1f77b4", "#ff7f0e", "#2ca02c", "#d62728", "#9467bd",  "#8c564b", "#e377c2", "#7f7f7f", "#bcbd22", "#17becf"])
                     .dimension(predictable)
                     .group(predictableGroup)
                     .on("filtered", updateTable);

        // ************* Start Time Chart ***************
        var startTime = billets.dimension(function(x){
            var hr = +x.start.substring(0, 2);
            var min = +x.start.substring(2, 4)
            if (15 <= min <= 45){
                return hr + 0.5;
            } else if (min > 45){
                return hr + 1;
            } else {
                return hr;
            }
        });
        var startTimeGroup = startTime.group();

        var minStart = d3.min(startTimeGroup.top(Infinity), function(x){
            return x.key;
        });
        var maxStart = d3.max(startTimeGroup.top(Infinity), function(x){
            return x.key;
        });

        startTimeChart = dc.barChart("#startTimeChart")
                               .width("300")
                               .height("180")
                               .margins({top: 10, right: 50, bottom: 30, left: 40})
                               .dimension(startTime)
                               .group(startTimeGroup)
                               .elasticY(true)
                               .centerBar(true)
                               .x(d3.scale.linear().domain([minStart - 1, maxStart + 1
                                ]))
                               .renderHorizontalGridLines(true);
        startTimeChart.xAxis().tickFormat(function(v){
                                return timeFormat(Math.round(v)) + ":" + timeFormat(v % 1 * 30);
                               }).ticks(3);

        // ************* Stop Time Chart ***************
        var stopTime = billets.dimension(function(x){
            var hr = +x.stop.substring(0, 2);
            var min = +x.stop.substring(2, 4)
            if (15 <= min <= 45){
                return hr + 0.5;
            } else if (min > 45){
                return hr + 1;
            } else {
                return hr;
            }
        });
        var stopTimeGroup = stopTime.group();

        var minStop = d3.min(stopTimeGroup.top(Infinity), function(x){
            return x.key;
        });
        var maxStop = d3.max(stopTimeGroup.top(Infinity), function(x){
            return x.key;
        });

        stopTimeChart = dc.barChart("#stopTimeChart")
                               .width("300")
                               .height("180")
                               .margins({top: 10, right: 50, bottom: 30, left: 40})
                               .dimension(stopTime)
                               .group(stopTimeGroup)
                               .elasticY(true)
                               .elasticX(true)
                               .centerBar(true)
                               .x(d3.scale.linear().domain([minStop - 1, maxStop + 1
                                ]))
                               .renderHorizontalGridLines(true);
        stopTimeChart.xAxis().tickFormat(function(v){
                                return timeFormat(Math.round(v)) + ":" + timeFormat(v % 1 * 30);
                               }).ticks(3);

        // ************* Map ***************
        var states = billets.dimension(function(x){
            return x.state;
        });
        var statesGroup = states.group();
        usChart = dc.geoChoroplethChart("#conusMap");
        d3.json("../data/us-states.json", function(statesJSON){
                    usChart.width(900)
                    .height(500)
                    .dimension(states)
                    .group(statesGroup)
                    .colors(d3.scale.quantize().range(["#E2F2FF", "#C4E4FF", "#9ED2FF", "#81C5FF", "#6BBAFF", "#51AEFF", "#36A2FF", "#1E96FF", "#0089FF", "#0061B5"]))
                    .colorDomain([0, d3.max(statesGroup.all(), function(x){
                        return x.value;
                    })])
                    .colorCalculator(function (d) { return d ? usChart.colors()(d) : '#ccc'; })
                    .overlayGeoJson(statesJSON.features, "state", function (d) {
                        return d.properties.name;
                    })
                    .title(function (d) {
                        return "State: " + d.key + "\nBillets Available: " + numberFormat(d.value ? d.value : 0);
                    })
                    .on("filtered", updateTable)
                    .projection(d3.geo.albersUsa());

                    dc.renderAll();
                    
                    $(".col-md-10").fadeIn();
        });
    });



    </script>

    <style>
    	.map {
		  width: 900px;
		  height: 600px;
		  margin: 10px;
		  padding: 10px;
		}
    </style>

    </head>
<body>
<?php include '../banner.php'; ?>

<div class="col-md-1" align="right">  
</div>
<div class="col-md-10" hidden>
    <br> <br> <br> <br> 

    <div class = "row">
    <div id ="conusMap" class = "map dc-chart" > 
    <div style="margin-left: 400px;">
    <strong> Location  </strong>       
            <a class="reset"
                  href='javascript:usChart.filterAll();dc.redrawAll();'
                  style="display: none;">reset</a>
            <div class = "clearfix"></div>
    </div>
    </div>

    <div id = "conusPie" class = "dc-chart" style = "padding: 50px;">
        <strong> Location (Overseas) </strong>
        <a class="reset"
              href='javascript:conusPieChart.filterAll();dc.redrawAll();'
              style="display: none;">reset</a>
        <div class = "clearfix"></div>
    </div>
    </div>

    <div class = "row">
        <div id = "afscPrefixPie" class = "dc-chart" >
            <strong> Preferred AFSC Prefix </strong>
            <a class="reset"
                  href='javascript:afscPrefixPieChart.filterAll();dc.redrawAll();'
                  style="display: none;">reset</a>
            <div class = "clearfix"></div>
        </div>
        <div id = "afscPie" class = "dc-chart">
            <strong> Preferred AFSCs </strong>
            <a class="reset"
                  href='javascript:afscPieChart.filterAll();dc.redrawAll();'
                  style="display: none;">reset</a>
            <div class = "clearfix"></div>
        </div>
        <div id = "grade">            
        <strong> Preferred Grades </strong>
            <a class="reset"
                  href='javascript:gradeChart.filterAll();dc.redrawAll();'
                  style="display: none;">reset</a>
            <div class = "clearfix"></div>
        </div>

        <div id = "aadLevel">
            <strong> Preferred Degree </strong>
            <a class="reset"
                  href='javascript:aadChart.filterAll();dc.redrawAll();'
                  style="display: none;">reset</a>
            <div class = "clearfix"></div>
        </div>
        
        <div id = "acqLevel">
            <strong> Minimum Acquisition Level </strong>
            <a class="reset"
                  href='javascriptacqLevelChart.filterAll();dc.redrawAll();'
                  style="display: none;">reset</a>
            <div class = "clearfix"></div>
        </div>
    </div>

    <div class = "row">
        <div id = "contactPie" class = "dc-chart">
            <strong> Allowed to Contact? </strong>
            <a class="reset"
                  href='javascript:contactPieChart.filterAll();dc.redrawAll();'
                  style="display: none;">reset</a>
            <div class = "clearfix"></div>
        </div>

        <div id = "deployablePie" class = "dc-chart">
            <strong> Deployable? </strong>
            <a class="reset"
                  href='javascript:deployablePieChart.filterAll();dc.redrawAll();'
                  style="display: none;">reset</a>
            <div class = "clearfix"></div>
        </div>


        <div id = "predictablePie" class = "dc-chart">
            <strong> Predictable Hours? </strong>
            <a class="reset"
                  href='javascript:predictablePieChart.filterAll();dc.redrawAll();'
                  style="display: none;">reset</a>
            <div class = "clearfix"></div>
        </div>

        <div id = "startTimeChart" class = "dc-chart">
            <strong> Typical Work Start Time </strong>
            <a class="reset"
                  href='javascript:startTimeChart.filterAll();dc.redrawAll();'
                  style="display: none;">reset</a>
            <div class = "clearfix"></div>
        </div>

        <div id = "stopTimeChart" class = "dc-chart">
            <strong> Typical Work Stop Time </strong>
            <a class="reset"
                  href='javascript:stopTimeChart.filterAll();dc.redrawAll();'
                  style="display: none;">reset</a>
            <div class = "clearfix"></div>
        </div>
        
    </div>

    <br> 

    <table id = "mainTable" class="display" cellspacing="0" width="100%">
    </table>


    </div>

</div>


</body>
</html>
