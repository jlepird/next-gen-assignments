<?php session_start();
// If user hasn't logged in, have them do that now. 
if (!isset($_SESSION["uname"])) {
    header("Location: /login.php"); // comment this line to disable login (for debug) 
}
if ($_SESSION['isOwner'] != 't' ){
  header("Location: ./input.php"); // Unless user is being assigned, they have no reason to be on this page. 
}
?>

<!DOCTYPE html5>
<html>
<head>
<meta charset='utf-8' http-equiv="X-UA-Compatible" content="IE=9;IE=10;IE=Edge,chrome=1"/>
<title>Find an Officer</title>
<?php 
  include $_SERVER['DOCUMENT_ROOT'] . '/include/head_common.php';
?>
<script type="text/javascript">
  var favorites = <?php echo $sql->queryJSON("select id from amnfavorites where username = '" . $_SESSION["uname"] . "';") ?>;
  function toggleFavorite(officer, x){
  	  // First update our local copy of what favs the user has. 
      if (x.checked){
      	favorites.push({id:officer});
      } else { 
      	var index = array.indexOf({id:officer});
      	if (index > -1){
      		favorites.splice(index, 1); // remove one element
      	}
      }

      // Then inform the server of the changes
      $.ajax({
          url:"/officers/changeFavorite.php",
          type: 'post',
          data: {"officer" : officer,
                 "case"    : x.checked}
      });
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



</script>
</head>
<body>
<?php include '../banner.php'; ?>
	<div class='container' style="font-family: Lucida Sans Unicode, Lucida Grande, sans-seriff">
  <p></p>
<br> <br>
            <div class="row">
                   <div class="dc-data-count" style="float: left;">
                       <h4>
                           <span>
                               <span class="filter-count"></span>
                               selected out of
                               <span class="total-count"></span>
                               records |
                               <a href="javascript:dc.filterAll(); dc.renderAll();">Reset All</a>
                               
                           </span>
                       </h4>
                </div>
            </div>

	<div class='row'>
		<div class='col-xs-6' id='dc-TIS-chart'>
			<h4>
				Time in Service
				<span>
					<a class="reset"
					href="javascript:tisChart.filterAll();dc.redrawAll();"
					style="display: none;">
					reset
				</a>
			</span>
		</h4>
	</div>
    <div class='col-xs-6' id='dc-instructor-hours-chart'>
      <h4>
        Instructor hours
        <span>
          <a class="reset"
          href="javascript:instHoursChart.filterAll();dc.redrawAll();"
          style="display: none;">
          reset
        </a>
      </span>
    </h4>
  </div>
</div>


        <div class='row'>
            <div class='col-xs-2' id='dc-grade-chart'>
                <h4>
                    Grade
                    <span>
                        <a class="reset"
                           href="javascript:gradeChart.filterAll();dc.redrawAll();"
                           style="display: none;">
                            reset
                        </a>
                    </span>

                </h4>
            </div>
            <div class='col-xs-2' id='dc-MWS-chart'>
                <h4>
                    MWS
                    <span>
                        <a class="reset"
                           href="javascript:mwsChart.filterAll();dc.redrawAll();"
                           style="display: none;">
                            reset
                        </a>
                    </span>
                </h4>
            </div>
    <div class='col-xs-2' id='dc-MAJCOM-chart'>
        <h4>
            MAJCOM
            <span>
                <a class="reset"
                   href="javascript:majcomChart.filterAll();dc.redrawAll();"
                   style="display: none;">
                    reset
                </a>
            </span>

        </h4>
    </div>
    <div class='col-xs-2' id='dc-TIER-chart'>
        <h4>
            RSAP Tier
            <span>
                <a class="reset"
                   href="javascript:tierChart.filterAll();dc.redrawAll();"
                   style="display: none;">
                    reset
                </a>
            </span>
        </h4>
    </div>

    <div class='col-xs-2' id='dc-STATUS-chart'>
        <h4>
            Status
            <span>
                <a class="reset"
                   href="javascript:statusChart.filterAll();dc.redrawAll();"
                   style="display: none;">
                    reset
                </a>
            </span>

        </h4>
    </div>
      <div class='col-xs-2' id='dc-RDTM-chart'>
        <h4>
          Aircraft
          <span>
            <a class="reset"
            href="javascript:rdtmChart.filterAll();dc.redrawAll();"
            style="display: none;">
            reset
          </a>
        </span>
      </h4>
        </div>
</div>

<br> <br>

<div class="row justify-content-md-end">
  <div class="col-xs-12">
      <a role="button" class="btn btn-secondary" href="#" id="export-all">
        Export All
      </a>
      <a role="button" class="btn btn-primary" href="#" id="export-favorite">
        Export Favorites
      </a>
  </div>
</div>
<div class='row'>
	<table class='col-xs-12 table table-hover' id='dc-data-table'>
		<thead>
			<tr class='header'>
			    <th class='th_FAV'>Favorite</th>
				<th class='th_ID'>ID</th>
				<th class='th_Grade'>Grade</th>
				<th class='th_Location'>Location</th>
				<th class='th_PAS'>PAS</th>
				<th class='th_Unit'>Unit</th>
				<th class='th_RDTM'>A/C</th>
				<th class='th_RTG'>RTG</th>
			</tr>
		</thead>
	</table>
</div>
</div>

<script type="text/javascript">


  // Create the dc.js chart objects & link to div

var width = 1140

var numVisits = +<?php echo $sql->queryValue("select count(*) from useractivity where username = '" . $_SESSION["uname"] . "';"); ?>;


// load data from a csv file
var data;
$(function(){
  data = <?php echo $sql->queryJSON("select * from officers;"); ?>;

  var dateParse = d3.time.format("%Y%m%d").parse;
  data.forEach(function(d){
    d.das = dateParse("" + d.das)
    d.tafmsd = dateParse("" + d.tafmsd)

    // Estimated time on station
    d.TOS =  +d3.format('.1f')((new Date() - d.das) / (1000*60*60*24*30*12))

    // Estimated time in service
    d.TIS =  +d3.format('.1f')((new Date() - d.tafmsd) / (1000*60*60*24*30*12))

    d.IP_HOURS = Math.round(Math.min(d.ip_hours,2000) / 10 ) * 10

    d.selected = d.selected || false

    d.id = d.ri_person_id
    delete d.ri_person_id
  });


// function to handle small negative numbers caused by math
  function snap_to_zero(source_group) {
      return {
          all:function () {
              return source_group.all().map(function(d) {
                  return {key: d.key, 
                      value: (Math.abs(d.value)<1e-6) ? 0 : d.value}
              })
          }
      }
  }

  // Run the data through crossfilter and load our 'facts'
  var facts = crossfilter(data)
  var all = facts.groupAll()
  
  // count all the facts
  dc.dataCount(".dc-data-count")
    .dimension(facts)
    .group(all)

  asofDate = d3.max(data, function (d) { return d.ASOFDATE })
  
  d3.select(".asof").text(asofDate)

  tisChart = dc.barChart("#dc-TIS-chart")

  // Total Active Federal Military Service
  var tis = facts.dimension(function(d){
    return d.TIS
  })

  var tisGroup = tis.group().reduceCount(function(d) { return d.TIS})
  maxTIS = d3.max(tisGroup.top(Infinity).map(function(d){return d.key}))+.2

  // TIS Bar Graph Counted
  tisChart.width(width/2)
    .height(150)
    .margins({top: 10, right: 10, bottom: 20, left: 40})
    .dimension(tis)
    .group(snap_to_zero(tisGroup))
    .transitionDuration(500)
    .centerBar(true)  
    .gap(20)  // 65 = norm
    .x(d3.scale.linear().domain([0,maxTIS]))
    .brushOn(true)
    .elasticY(true)
    .xAxis().ticks(20)  

  instHoursChart = dc.barChart("#dc-instructor-hours-chart")
  var instHours = facts.dimension(function(d){
    return d.ip_hours;
  })

  var instHoursGroup = instHours.group().reduceCount(function(d) { return d.IP_HOURS})
  maxIP = d3.max(instHoursGroup.top(Infinity).map(function(d){return d.key}))+1000

  // TIS Bar Graph Counted
  instHoursChart.width(width/2)
    .height(150)
    .margins({top: 10, right: 10, bottom: 20, left: 40})
    .dimension(instHours)
    .group(snap_to_zero(instHoursGroup))
    .transitionDuration(500)
    .centerBar(true)  
    .x(d3.scale.linear().domain([0,2001]))
    .xUnits(function(){return 100})
    .brushOn(true)
    .elasticY(true)
    .xAxis().ticks(10)  

  gradeChart = dc.rowChart("#dc-grade-chart")
  // Grade
  var grade = facts.dimension(function (d){
    return d.grd
  })
  var gradeGroup = grade.group()

  // Manual ordering of grade
  gradeOrder = {'LT':0, 'CPT': 1, 'MAJ': 2, 'LTC': 3}

  gradeChart.width(width/6)
    .height(200)
    .margins({top: 5, left: 10, right: 10, bottom: 20})
    .ordering(function(d){ 
      return gradeOrder[d.key]
    })
    .dimension(grade)
    .group(gradeGroup)
    .colors(d3.scale.category10())
    .label(function (d){
       return d.key
    })
    .title(function(d){return d.value})
    .elasticX(true)
    .xAxis().ticks(4)



  mwsChart = dc.rowChart("#dc-MWS-chart")
  // MWS
  var mws = facts.dimension(function (d){
      return d['mws']
  })
  var mwsGroup = mws.group()

  mwsChart.width(width/6)
    .height(200)
    .margins({top: 5, left: 10, right: 10, bottom: 20})
    .dimension(mws)
    .group(mwsGroup)
    .colors(d3.scale.category20())
    .label(function (d){
        return d.key
    })
    .title(function(d){return d.value})
    .elasticX(true)
    .ordering(function(d) { return -d.value})
    .xAxis().ticks(4)



  majcomChart = dc.rowChart("#dc-MAJCOM-chart")
  // MAJCOM
  var majcom = facts.dimension(function (d){
      return d['majcom']
  })
  var majcomGroup = majcom.group()

  majcomChart.width(width/6)
    .height(200)
    .margins({top: 5, left: 10, right: 10, bottom: 20})
    .dimension(majcom)
    .group(majcomGroup)
    .colors(d3.scale.category10())
    .label(function (d){
       return d.key
    })
    .title(function(d){return d.value})
    .elasticX(true)
    .ordering(function(d) { return -d.value})
    .xAxis().ticks(4)

  // TIER
  tierChart = dc.rowChart("#dc-TIER-chart")

  var tier = facts.dimension(function (d){
    return d['tier']
  })
  var tierGroup = tier.group()

  tierChart.width(width/6)
    .height(200)
    .margins({top: 5, left: 10, right: 10, bottom: 20})
    .dimension(tier)
    .group(tierGroup)
    .colors(d3.scale.category10())
    .label(function (d){
       return d.key
    })
    .title(function(d){return d.value})
    .elasticX(true)
    .ordering(function(d) { return -d.value})
    .xAxis().ticks(4)


  // STATUS
  statusChart = dc.rowChart("#dc-STATUS-chart")

  var status = facts.dimension(function (d){
      return d['status']
  })
  var statusGroup = status.group()

  statusChart.width(width/6)
    .height(200)
    .margins({top: 5, left: 10, right: 10, bottom: 20})
    .dimension(status)
    .group(statusGroup)
    .colors(d3.scale.category20())
    .label(function (d){
        return d.key
    })
    .title(function(d){return d.value})
    .elasticX(true)
    .ordering(function(d) { return -d.value})
    .xAxis().ticks(4)

  // RDTM to Aircraft
  rdtmChart = dc.rowChart("#dc-RDTM-chart")
  var rdtmValue = facts.dimension(function(d){
      return d.rdtm_aircraft
  })
  var rdtmValueGroup = rdtmValue.group()

  rdtmChart.width(width/6)
    .height(200)
    .margins({top: 5, right: 10, bottom: 20, left: 10})
    .dimension(rdtmValue)
    .group(rdtmValueGroup)
    .colors(d3.scale.category20())
    .label(function (d){
        return d.key
    })
    .title(function(d){return d.value})
    .elasticX(true)
    .ordering(function(d) { return -d.value})
    .xAxis().ticks(4)

  locationChart = dc.barChart("#dc-location-chart");

  // Location
  var location = facts.dimension(function (d){
    return d['location']
  })
  var locationGroup = location.group() ;

  locationChart.width(width)
    .height(300)
    .margins({top: 10, right: 10, bottom: 100, left: 40})
    .dimension(location)
    .group(snap_to_zero(locationGroup))
    .x(d3.scale.ordinal())
    .xUnits(dc.units.ordinal)
    .brushOn(false)
    .elasticY(true)
    .ordering(function(d) { return -d.value});


  dataTable = dc.dataTable("#dc-data-table")
  var tableDim = facts.dimension(function(d){ return d.id})
  dataTable.width(width)
    .dimension(tableDim)
    .group(function(d) {return 'Showing only first 100'})
    .size(data.length)
    .columns([
      function(d) {return "<input type = 'checkbox' onchange='toggleFavorite(\"" + d.id + "\", this)' data-toggle='toggle' class = 'toggle' id = 'fav" + d.id + "'>"
      },
      function(d) { return '<a href="surf.php?id=' + d.id + '" target="_blank">'+d.id+'</a>' },
      function(d) { return d.grd },
      function(d) { return d.location},
      function(d) { return d.pas },
      function(d) { return d.unit },
      function(d) { return d['rdtm_aircraft'] },
      function(d) { return d['rtg'] },
 
    ])
    .sortBy(function(d){ return d.id })
    .order(d3.ascending)
    .showGroups(false);

  // Render the Charts
  dc.renderAll();

  // Inital checkboxing 
  $(favorites).each(function(i, x){
      $("#fav" + x.id).attr("checked", "checked");
  })

  // Make the favorites pretty.
  makeAllToggle();

  // Persist favorite button states
  /*
  $('#dc-data-table').on('click', '.dc-table-column', function(){
    var id = d3.select(this.parentNode).select(".dc-table-column._0").text()
    var ind = _.findIndex(data, function(d){ return id == d.id})
    data[ind].selected = d3.select(this).select('input').property('checked')
    // INSERT php statement here, using data[ind].selected as "case"
  });
  */

  $('#export-all').on('click', function(){ exportAll(false)})
  $('#export-favorite').on('click', function() {exportAll(true)})
  //Function to export into CSV
  function exportAll(only_favorites) {
  	  var favsArray = [];
  	  favorites.forEach(function(d){
  	  	if ("id" in d){
  	  		favsArray.push(d.id);
  	  	}
  	  });

      // prepare CSV data
      var csvData = new Array()
      var exportData = only_favorites ? data.filter(function(d){return ($.inArray(d.id, favsArray) > -1);}) : data;
      csvData.push('"ID","LOCATION","PAS","UNIT"')
      exportData.forEach(function (airman, index, array) {
          csvData.push('"' + airman.id + '","' + airman.location + '","' + airman.pas + '","' +airman.unit+ '"' )
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

  if (numVisits < 2){
    swal({title: "New here?",
        showCancelButton: true,
        confirmButtonText:"View the Tutorial",
        cancelButtonText:"Skip", 
        closeOnConfirm: false

  }, tutorial)
  }
});



</script>
</body>
</html>
