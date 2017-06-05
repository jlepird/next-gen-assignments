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
    function toggleFavorite(billet, x){
    $.ajax({
        url:"/billets/changeFavorite.php",
        type: 'post',
        data: {"billet" : billet,
               "case" : x.checked}
    });
}  
    d3.csv('billets.csv', (data)=>{
    <?php /*echo $sql->queryJSON("select posn, tkey, val from billetData where tkey not like '%mail%' and tkey not in ('poc', 'lastOccupant') order by posn;");*/ ?>; 

    var favorites = <?php echo $sql->queryJSON("select posn from favorites where username = '" . $_SESSION["uname"] . "';") ?>;

    var numVisits = +<?php echo $sql->queryValue("select count(*) from useractivity where username = '" . $_SESSION["uname"] . "';"); ?>;

    // Restructure the data from "long" form to "wide" form. 
    var completed = [];
    var outData = []; 
    /*
    // "Unmelt" the dataframe 
    for (var i = 0; i < data.length; ++i){
    	var scratch = {}; // the row we're going to add 
    	var id = data[i].id;

    	// For each row, see if we've found a new billet 
    	if ($.inArray(id, completed) > -1){
    		continue; 
    	} else { // it's a new billet 
    		// Filter all of the data down to the one's we found 
    		var myData = data.filter(function(x) {
    			return x.id == id; 
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
*/
    //console.log(outData)
    // rename and de-allocate extra 
    //data = outData; outData = []; 


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

/*
    // Build a giant array of the data for table display 
    for (var i = 0; i < data.length; i++){
    	outData.push([
            "<a target = '_blank' href='/billets/view.php?billet=" + data[i].id + "'>" + data[i].id + "</a>",
    		          data[i].Rank,
    		          data[i].DutyTitle,
    		          data[i].Location,
                      data[i].State,
    		          data[i].Unit,
                      "<input type = 'checkbox' onchange='toggleFavorite(\"" + data[i].id + "\", this)' data-toggle='toggle' class = 'toggle' id = 'fav" + data[i].id + "'>"
    		          ]);
    }
*/
    // Things to run after page load 
    $(function(){

        // Charts
        var numberFormat = d3.format(".0f");
        var timeFormat = function(x) {
            var y = "0" + x;
            return y.substr(y.length - 2);
        }
        var barWidth = 220;
        data.forEach((billet)=>{
            billet.selected = false
            })
        billets = crossfilter(data);
        all = billets.groupAll()

        var billetsDim = billets.dimension(function(x){
            return x.id;
        });

        dc.dataCount(".dc-data-count")
        .dimension(billets)
        .group(all)


        dataTable = dc.dataTable("#dc-data-table")
          tableDim = billets.dimension(function(d){ return d.id})
          dataTable.width(1000)
            .height(500)
            .dimension(tableDim)
            .group(function(d) {return 'Showing only first 100'})
            .size(data.length)
            .columns([
              function(d) { return d.id},
              function(d) { return d.Rank },
              function(d) { return d.DutyTitle },
              function(d) { return d.Location },
              function(d) { return d.State },
              function(d) { return d.Unit },
              function(d) { return '<label class="switch"><input type="checkbox" onchange="toggleFavorite('+d.id+', this)" data-toggle="toggle" class = "toggle" id = "fav' + d.id + '"><div class="slider round"></div>'}
            ])
            .sortBy(function(d){ return +d.id })
            .order(d3.ascending)
            .showGroups(false)

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
        
        var toggled = [];
        function makeAllToggle(){
            $(".toggle").each(function(i,x){
            	if ($(x).is("input")){
	                if (toggled.indexOf($(x).attr("id")) > -1){
	                    return;
	                } else {
	                    $(x).bootstrapToggle(toggleOptions);
	                    toggled.push($(x).attr("id"));
	                    return;
	                }
            	}
            });
        }
        /*
        // Populate the table 
        var date = new Date(Date.now());
        var table = $('#mainTable')
               .on('search.dt', function() {setTimeout(makeAllToggle, 50);})
               .on('page.dt',   function() {setTimeout(makeAllToggle, 50);})
               .DataTable({
                data: outData,
                colReorder: false,
                dom: 'Bfrtip',
                buttons: [
                    { 
                        extend: 'csvHtml5',
                        title: "Billets Export " + date
                    }, 
                    {
                        extend: 'excelHtml5',
                        title: "Billets Export " + date
                    }], 
                columns: [
                    {title: "ID",     "defaultContent": "<i>None</i>"},
                    {title: "Number of Positions"},
                    {title: "Grade",             "defaultContent": "<i>None</i>"},
                    {title: "Duty Title",        "defaultContent": "<i>None</i>"},
                    {title: "Location",          "defaultContent": "<i>None</i>"},
                    {title: "State",             "defaultContent": "<i>None</i>"},
                    {title: "Unit",              "defaultContent": "<i>None</i>"},
                    {title: "Favorite",          "orderDataType": "dom-checkbox"}
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
        $(favorites).each(function(i, x){
            $("#fav" + x.posn).attr("checked", "checked");
        })
    
        // Initial toggle update
        makeAllToggle();
        
        function updateTable(){
            selected = [];
            billetsDim.top(Infinity).forEach(function(x){
                selected.push(x.id);
            });
            table.draw();
            makeAllToggle();
        }
        // Initial toggle update

        // ============= BEGIN CHARTING ===============
        
        var nrppDecoder = {
            "ent": "Entitlement",
            "ent+": "Priority",
            "mf": "Must-Fill"
        };
        */

        // ************* Grade chart ***************
        /*
        var grades = billets.dimension(function(x){
            if ("grade" in x){
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
            } else {
                return '(Unknown)';
            }
        });
        */
        var grades = billets.dimension((x)=>{
            return x.Rank
        })
        var gradeGroup = grades.group();
        gradeGroup = gradeGroup.reduce(function(p,v) {return p+(+v.NumAvailable);},
               function(p,v) {return p-(+v.NumAvailable);},
               function() {return 0;});

        gradeOrder = {'1LT': 0, 'CPT': 1, 'MAJ': 2, 'LTC': 3}
        gradeChart = dc.rowChart("#grade");
        gradeChart.width(barWidth)
                     .height(180)
                     .dimension(grades)
                     .group(gradeGroup)
                     .ordinalColors(["#1f77b4", "#ff7f0e", "#2ca02c", "#d62728", "#9467bd",  "#8c564b", "#e377c2", "#7f7f7f", "#bcbd22", "#17becf"])
                     .margins({top: 10, right: 50, bottom: 30, left: 10})
                     .ordering(function(d){
                        return gradeOrder[d.key]
                        })
                     .elasticX(true)
                     //.on("filtered", updateTable)
                     .xAxis().ticks(2);

        // ************* CONUS pie chart ***************
        var conus = billets.dimension(function(x){
            if ("CONUS" in x){
            	if (x.CONUS == 1){
            		return "CONUS";
            	} else {
            		return "OCONUS";
            	}
            }
        });
        var conusGroup = conus.group();
        conusGroup = conusGroup.reduce(function(p,v) {return p+(+v.NumAvailable);},
               function(p,v) {return p-(+v.NumAvailable);},
               function() {return 0;});

        conusPieChart = dc.pieChart("#conusPie");
        conusPieChart.width(180)
                     .height(180)
                     .radius(80)
                     .ordinalColors(["#1f77b4", "#ff7f0e", "#2ca02c", "#d62728", "#9467bd",  "#8c564b", "#e377c2", "#7f7f7f", "#bcbd22", "#17becf"])
                     .dimension(conus)
                     .group(conusGroup)
                     //.on("filtered", updateTable);
/*
        // ************* Contact pie chart ***************
        var contact = billets.dimension(function(x){
            if ("contact?" in x){
                return x["contact?"] == "yes" ? "Yes" : "No"; 
            } else {
                return "(Unknown)";
            }
            
        });
        var contactGroup = contact.group();
        contactGroup = contactGroup.reduce(function(p,v) {return p+(+v.NumAvailable);},
               function(p,v) {return p-(+v.NumAvailable);},
               function() {return 0;});

        contactPieChart = dc.pieChart("#contactPie");
        contactPieChart.width(180)
                     .height(180)
                     .radius(80)
                     .ordinalColors(["#1f77b4", "#ff7f0e", "#2ca02c", "#d62728", "#9467bd",  "#8c564b", "#e377c2", "#7f7f7f", "#bcbd22", "#17becf"])
                     .dimension(contact)
                     .group(contactGroup)
                     //.on("filtered", updateTable);
*/
        // ************** Assignment type *********************
        var type = billets.dimension(function(x){
        	if ("Type" in x){
        		return x.Type;
        	} else {
        		return "(Unknown)";
        	}
        });
        var typeGroup = type.group();
        typeChart = dc.rowChart("#typeChart");
        typeChart.width(barWidth)
                     .height(180)
                     .dimension(type)
                     .ordinalColors(["#1f77b4", "#ff7f0e", "#2ca02c", "#d62728", "#9467bd",  "#8c564b", "#e377c2", "#7f7f7f", "#bcbd22", "#17becf"])
                     .group(typeGroup)
                     .margins({top: 10, right: 50, bottom: 30, left: 10})
                     .elasticX(true)
                     //.on("filtered", updateTable)
                     .xAxis().ticks(2);

        // ************** AC *********************
        var ac = billets.dimension(function(x){
        	if ("AC" in x){
        		return x.AC;
        	} else {
        		return "(Unknown)";
        	}
        });
        var acGroup = ac.group();
        acGroup=acGroup.reduce(function(p,v) {return p+(+v.NumAvailable);},
               function(p,v) {return p-(+v.NumAvailable);},
               function() {return 0;});

        acChart = dc.rowChart("#acChart");
        acChart.width(barWidth)
                     .height(180)
                     .dimension(ac)
                     .ordinalColors(["#1f77b4", "#ff7f0e", "#2ca02c", "#d62728", "#9467bd",  "#8c564b", "#e377c2", "#7f7f7f", "#bcbd22", "#17becf"])
                     .group(acGroup)
                     .margins({top: 10, right: 50, bottom: 30, left: 10})
                     .elasticX(true)
                     //.on("filtered", updateTable)
                     .xAxis().ticks(2);

/*
        // ************* Assignment Length  ***************
        var length = billets.dimension(function(x){
            if ("length" in x){
                return x.length + " Years";  
            } else {
                return "(Unknown)";
            }
            
        });
        var lengthGroup = length.group();
        lengthGroup=lengthGroup.reduce(function(p,v) {return p+(+v.NumAvailable);},
               function(p,v) {return p-(+v.NumAvailable);},
               function() {return 0;});

        lengthChart = dc.rowChart("#lengthChart");
        lengthChart.width(barWidth)
                     .height(180)
                     .dimension(length)
                     .ordinalColors(["#1f77b4", "#ff7f0e", "#2ca02c", "#d62728", "#9467bd",  "#8c564b", "#e377c2", "#7f7f7f", "#bcbd22", "#17becf"])
                     .group(lengthGroup)
                     .margins({top: 10, right: 50, bottom: 30, left: 40})
                     .elasticX(true)
                     //.on("filtered", updateTable)
                     .xAxis().ticks(2);
*/
/*
        // ************* Predictable pie chart ***************
        var predictable = billets.dimension(function(x){
            if ("regularHours" in x){
                return x.regularHours == "yes" ? "Yes" : "No"; 
            } else {
                return "(Unknown)";
            }
            
        });
        var predictableGroup = predictable.group();
        predictableGroupGroup=predictableGroup.reduce(function(p,v) {return p+(+v.NumAvailable);},
               function(p,v) {return p-(+v.NumAvailable);},
               function() {return 0;});

        predictablePieChart = dc.pieChart("#predictablePie");
        predictablePieChart.width(180)
                     .height(180)
                     .radius(80)
                     .ordinalColors(["#1f77b4", "#ff7f0e", "#2ca02c", "#d62728", "#9467bd",  "#8c564b", "#e377c2", "#7f7f7f", "#bcbd22", "#17becf"])
                     .dimension(predictable)
                     .group(predictableGroup)
                     //.on("filtered", updateTable);
*/
/*
        // ************* Workweek pie chart ***************
        var weekDecoder = {
            "m-f":"Mon-Fri",
            "m-sa": "Mon-Sat",
            "m-su": "Mon-Sun",
            "irr" : "Irregular"
        };
        
        var week = billets.dimension(function(x){
            if ("workweek" in x){
                return weekDecoder[x.workweek]; 
            } else {
                return "(Unknown)";
            }
            
        });
        var weekGroup = week.group();
        weekGroup=weekGroup.reduce(function(p,v) {return p+(+v.NumAvailable);},
               function(p,v) {return p-(+v.NumAvailable);},
               function() {return 0;});

        weekPieChart = dc.pieChart("#weekPie");
        weekPieChart.width(180)
                     .height(180)
                     .radius(80)
                     .ordinalColors(["#1f77b4", "#ff7f0e", "#2ca02c", "#d62728", "#9467bd",  "#8c564b", "#e377c2", "#7f7f7f", "#bcbd22", "#17becf"])
                     .dimension(week)
                     .group(weekGroup)
                     //.on("filtered", updateTable);
*/
/*
       // ************* Report Chart ***************
       var monthDisplay = {
           "01": "Jan",
           "02": "Feb",
           "03": "Mar",
           "04": "Apr",
           "05": "May",
           "06": "Jun",
           "07": "Jul",
           "08": "Aug",
           "09": "Sep",
           "10": "Oct",
           "11": "Nov",
           "12": "Dec"
       }
               
        // Get version with keys/values swapped
        var invertedMonths = _.invert(monthDisplay);
        
        
        var report = billets.dimension(function(x){
            if ("report" in x){
                var spl = x.report.split("/");
                if (spl.length == 3){
                    month = spl[0];
                    yr = spl[2];
                    return yr + '-' + monthDisplay[month];
                }
            } else { 
            	return "(Unknown)";
            }
        });
        var reportGroup = report.group();
        reportGroup=reportGroup.reduce(function(p,v) {return p+(+v.NumAvailable);},
               function(p,v) {return p-(+v.NumAvailable);},
               function() {return 0;});

        reportChart = dc.rowChart("#reportChart")
                               .width(barWidth)
                               .height("180")
                               .dimension(report)
                               .group(reportGroup)
                               .ordinalColors(["#1f77b4", "#ff7f0e", "#2ca02c", "#d62728", "#9467bd",  "#8c564b", "#e377c2", "#7f7f7f", "#bcbd22", "#17becf"])
                               .margins({top: 10, right: 50, bottom: 30, left: 40})
                               .elasticX(true)
                               //.on("filtered", updateTable)
                               .ordering(function(d){
                                   if (d.key != "NA"){
                                        spl = d.key.split("-");
                                        return spl[0] + invertedMonths[spl[1]]; 
                                   } else {
                                       return "ZZZZZZZZ"; // so it's at the end
                                   }
                               })
                               .xAxis().ticks(2);

*/
        // ************* Map ***************
        var states = billets.dimension(function(x){
            if ("State" in x){
                return x.State;    
            } else {
                return "Unknown";
            }
            
        });
        
        function stripPX(x){
            return +x.substring(0, x.length - 2);
        }
        
        var mapWidth  = stripPX($("#conusMap").css("width")) - 2 * stripPX($("#conusMap").css("margin"));
        var mapHeight = stripPX($("#conusMap").css("height"))- 2 * stripPX($("#conusMap").css("margin"));
        var scale = Math.min(mapWidth * 1.3, mapHeight * 2.1);
        
        var statesGroup = states.group();
        statesGroup=statesGroup.reduce(function(p,v) {return p+(+v.NumAvailable);},
               function(p,v) {return p-(+v.NumAvailable);},
               function() {return 0;});

        usChart = dc.geoChoroplethChart("#conusMap");
        d3.json("../data/us-states.json", function(statesJSON){
                    usChart.width(mapWidth)
                    .height(mapHeight)
                    .dimension(states)
                    .group(statesGroup)
                    .colors(d3.scale.quantize().range(["#E2F2FF", "#C4E4FF", "#9ED2FF", "#81C5FF", "#6BBAFF", "#51AEFF", "#36A2FF", "#1E96FF", "#0089FF", "#0061B5"]))
                    .colorDomain([-10, d3.max(statesGroup.all(), function(x){
                        return x.value;
                    })])
                    .colorCalculator(function (d) { return d ? usChart.colors()(d) : '#ccc'; })
                    .overlayGeoJson(statesJSON.features, "state", function (d) {
                        return d.properties.name;
                    })
                    .title(function (d) {
                        return "State: " + d.key + "\nBillets Available: " + numberFormat(d.value ? d.value : 0);
                    })
                    //.on("filtered", updateTable)
                    .projection(d3.geo.albersUsa().scale(scale).translate([mapWidth/2, mapHeight/2]));

                    dc.renderAll();
                     // Persist favorite button states 
                     /*
                  $('#dc-data-table').on('click', '.dc-table-column', function(){
                    var id = d3.select(this.parentNode).select(".dc-table-column._0").text()
                    console.log(id)
                    var ind = _.findIndex(data, function(d){ return id == d.id})
                    console.log(ind)
                    data[ind].selected = d3.select(this).select('input').property('checked')
                    // INSERT php statement here, using data[ind].selected as "case"
                  });*/

                  $('#export-all').on('click', function(){ exportAll(false)})
                  $('#export-favorite').on('click', function() {exportAll(true)})
                  //Function to export into CSV
                  function exportAll(only_favorites) {
                      // prepare CSV data
                      var csvData = new Array()
                      var exportData = only_favorites ? data.filter(function(d){return d.selected}) : data 
                      csvData.push('"ID","Location","Duty Title","Unit"')
                      exportData.forEach(function (billet, index, array) {
                          csvData.push('"' + billet.id + '","' + billet.Location + '","' + billet.DutyTitle + '","' +billet.Unit+ '"' )
                      })

                      // download stuff
                      var fileName = "export.csv"
                      var buffer = csvData.join("\n")
                      var blob = new Blob([buffer], {
                          "type": "text/csvcharset=utf8"
                      })
                      var link = only_favorites ? document.getElementById("export-favorite") : document.getElementById("export-all")
                      
                      // Browsers that support HTML5 download attribute
                      link.setAttribute("href", window.URL.createObjectURL(blob))
                      link.setAttribute("download", fileName)
                  }
                    $("#loader").fadeOut(100);
                    $(".col-md-10").fadeIn(1000);


                 

                    // Suppress tutorial temporarily
                    if (numVisits < 0){
    					swal({title: "New here?",
    						  showCancelButton: true,
    						  confirmButtonText:"View the Tutorial",
    						  cancelButtonText:"Skip", 
    						  closeOnConfirm: false

    				}, tutorial)
    				}

        });
    });
})
    </script>

    <style>
    	.map {
		  width: 700px;
		  height: 500px;
		  margin: 10px;
		  padding: 10px;
		}

#dc-data-table table {
    table-layout: inherit;
}

#dc-data-table tbody {
    display: block;
    height: 300px;
    overflow-y: auto;
    overflow-x: hidden;
}


#dc-data-table>thead>tr>th, #dc-data-table>tbody>tr>td {
    float: left;
    line-height: 1em;
    border: 0px;
    padding: 5px;
}

#dc-data-table>thead>tr>th {
    font-weight: normal;
}

.dc-chart {
    padding: 0px;
}

#dc-data-table .th_ID , #dc-data-table .dc-table-column._0 { 
  width: 50px;
  text-align: left;
  padding-right:
  5px; 
}

#dc-data-table .th_grade, #dc-data-table .dc-table-column._1 { width: 100px; text-align: left; padding-left: 10px; }
#dc-data-table .th_duty_title, #dc-data-table .dc-table-column._2 { width: 350px; text-align: left; padding-left: 10px;}
#dc-data-table .th_location, #dc-data-table .dc-table-column._3 { width: 200px; text-align: left; padding-left: 10px;}
#dc-data-table .th_state, #dc-data-table .dc-table-column._4 { width: 80px; text-align: left; padding-left: 10px;}
#dc-data-table .th_unit, #dc-data-table .dc-table-column._5 { width: 260px; text-align: left; padding-left: 0px; }
#dc-data-table .th_favorite, #dc-data-table .dc-table-column._6 { width: 110px; text-align: left; padding-left: 0px; }

#dc-data-table input[type="checkbox"] {
    padding: 0;
    margin-left: 15px;
    margin-right: 10px;
    margin-top: 0px;
    margin-bottom: 0px;
} 

#dc-data-table td {
    cursor: pointer; 
    color: #333;
    font-size: 13px;
    border: 0px;
}

#dc-data-table thead tr {
    background: #333;
    background-color: #ddd;
    color: #333;
    font-weight: normal;
    padding: 0px;
}

#dc-data-table tbody tr {
    background: #333;
    background-color: #eee;
    border-top: 1px solid #ddd;
    font-weight: normal;
}

#dc-data-table tr:hover {
    background: #ccc;
}

#dc-data-table tr:hover td {
    font-weight: bold;
}


/* The switch - the box around the slider */
.switch {
  position: relative;
  display: inline-block;
  width: 32px;
  height: 20px;
}

/* Hide default HTML checkbox */
.switch input {display:none;}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #515151;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 12px;
  width: 12px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(12px);
  -ms-transform: translateX(12px);
  transform: translateX(12px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 15px;
}

.slider.round:before {
  border-radius: 50%;
}

    </style>

    </head>
<body>


<?php include '../banner.php'; ?>

<div class = "wrapper">
<div class="col-md-1" align="right">  
</div>
<div id = "loader"></div>
<div class="col-md-10" hidden>
    <br> <br> <br> <br> 
    <div class='container'>
            <div class="row">
                   <div class="dc-data-count" style="float: left;">
                       <h4>
                           <span>
                               <span class="filter-count"></span>
                               selected out of
                               <span class="total-count"></span>
                               billets |
                               <a href="javascript:dc.filterAll(); dc.renderAll();">Reset All</a>
                           </span>
                       </h4>
                </div>
            </div>

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
<!--         <div id = "prioritizationPie" class = "dc-chart" >
            <strong> Prioritization Level <img src="../images/help.jpg"  style="width:20px;height:20px; cursor: pointer;" onclick="helpNRPP();"> </strong>
            <a class="reset"
                  href='javascript:prioritizationPieChart.filterAll();dc.redrawAll();'
                  style="display: none;">reset</a>
            <div class = "clearfix"></div>
        </div> -->

        <div id = "typeChart" class = "dc-chart" >
            <strong> Assignment Type </strong>
            <a class="reset"
                  href='javascript:typeChart.filterAll();dc.redrawAll();'
                  style="display: none;">reset</a>
            <div class = "clearfix"></div>
        </div>

        <div id = "acChart" class = "dc-chart" >
            <strong> Aircraft  </strong>
            <a class="reset"
                  href='javascript:acChart.filterAll();dc.redrawAll();'
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
        

        </div>
<!--         <div class = "row">
        
        
        
        <div id = "contactPie" class = "dc-chart">
            <strong> Allowed to Contact? </strong>
            <a class="reset"
                  href='javascript:contactPieChart.filterAll();dc.redrawAll();'
                  style="display: none;">reset</a>
            <div class = "clearfix"></div>
        </div>
        
        <div id = "reportChart" class = "dc-chart">
            <strong> Desired Report Month </strong>
            <a class="reset"
                  href='javascript:reportChart.filterAll();dc.redrawAll();'
                  style="display: none;">reset</a>
            <div class = "clearfix"></div>
        </div>

        
        <div id = "lengthChart" class = "dc-chart">
            <strong> Assignment Length </strong>
            <a class="reset"
                  href='javascript:lengthChart.filterAll();dc.redrawAll();'
                  style="display: none;">reset</a>
            <div class = "clearfix"></div>
        </div>
    </div>
 -->
<!--     <div class = "row">


        <div id = "predictablePie" class = "dc-chart">
            <strong> Predictable Hours? </strong>
            <a class="reset"
                  href='javascript:predictablePieChart.filterAll();dc.redrawAll();'
                  style="display: none;">reset</a>
            <div class = "clearfix"></div>
        </div>
        
        <div id = "weekPie" class = "dc-chart">
            <strong> Typical Workweek </strong>
            <a class="reset"
                  href='javascript:weekPieChart.filterAll();dc.redrawAll();'
                  style="display: none;">reset</a>
            <div class = "clearfix"></div>
        </div>
    </div>
 -->
    <br> 
    <div class="row justify-content-md-end">
      <div class="col-xs-12">
          <a role="button" class="btn btn-success" href="#" id="export-all">
            Export All
          </a>
          <a role="button" class="btn btn-primary" href="#" id="export-favorite">
            Export Favorites
          </a>
      </div>
    </div>
    <div class="row">
        <table class="col-xs-12 table table-hoever" id="dc-data-table">
            <thead>
                <tr class="header">
                <th class="th_ID">ID</th>
                <th class="th_grade">Grade</th>
                <th class="th_duty_title">Duty Title</th>
                <th class="th_location">Location</th>
                <th class="th_state">State</th>
                <th class="th_unit">Unit</th>
                <th class="th_favorite">Favorite</th>
                </tr>
            </thead>
        </table>
    </div>
    <!--<div style="margin-bottom: 1cm;">
        <table id = "mainTable" class="display" cellspacing="0" width="100%" >
        </table>
    </div>-->

    </div>

</div>
</div>
</div>



<div id = "footer"> For Official Use Only (FOUO) </div>
</body>
</html>
