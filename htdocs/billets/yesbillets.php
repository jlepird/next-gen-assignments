<script type="text/javascript">
$( function(){ 

	vals = <?php echo $res; ?>;
	data = <?php echo $data; ?>;
	// Add elements to the values that will 
	d3.select("#billetSelector")
	  .selectAll("option")
	  .data(vals)
	  .enter()
	  .append("option")
	  .text(function(d) {
	  	return d.posn;
	  })
	  .attr("value", function(d) {
	  	return d.posn;
	  });
});
  </script>

<h5 >Please select your billet:</h5>
<select id = "billetSelector" onchange="updateBilletData(this.value)" class = "center">
<!-- Template, javascript will fill in --> 
</select>