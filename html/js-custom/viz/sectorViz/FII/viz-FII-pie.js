// define svg canvas dimensions
// setting global variables
var width = 300,
    height = 300,
    radius = Math.min(width, height-20) / 2;

var arc = d3.svg.arc()
    .outerRadius(radius)
    .innerRadius(radius-35);

var labelArc = d3.svg.arc()
    .outerRadius(radius)
    .innerRadius(radius-10);

var pie = d3.layout.pie()
    .sort(null)
    .value(function(d) { return d.number; });

// pie one --- breakdown by orgtype
var color = d3.scale.ordinal()
    // old sad rainbow
    // .range(["#98abc5", "#7b6888", "#a05d56", "#ff8c00"]);
    .range(["#b88832", "#deb264", "#e6c58b", "#eed8b1", "#f6ebd8"]);

var svg = d3.select("#threePie").append("svg")
    .attr("id", "byType")
    .attr("class", "pieSvg")
    .attr("width", width)
    .attr("height", height)
    .append("g")
    .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

// d3.csv("js-custom/viz/sectorViz/FII/FIITypePieData.php", type, function(error, data) {
d3.json("js-custom/viz/sectorViz/FII/FIITypePieData.php", function(error, data) {
  if (error) throw error;

  total1 = 0;
  for (i=0; i<data.length; i++) {
    total1 = total1 + data[i].number;
  }

  var formatPercent = d3.format(",.0%");

  var g = svg.selectAll(".arc")
      .data(pie(data))
      .enter().append("g")
      .attr("class", "arc")
      .on("mouseover", function() { tooltip.style("display", null); })
      .on("mouseout", function() { tooltip.style("display", "none"); })
      .on("mousemove", function(d) {
        var xPosition = d3.mouse(d3.select('#byType').node())[0] - 20;
        var yPosition = d3.mouse(d3.select('#byType').node())[1] - 20;
        tooltip.attr("transform", "translate(" + xPosition + "," + yPosition + ")");
        // tooltip.select("text").text(d.value + " (" + formatPercent(d.value/total) + ")"); // d.data.org_type for org type name
        tooltip.select("text").text(formatPercent(d.value/total1));
      });

  g.append("path")
      .attr("d", arc)
      .style("fill", function(d) { return color(d.data.org_type); });

  var legend = svg.selectAll(".legend")
      .data(color.domain().slice())
      .enter().append("g")
      .attr("class", "legend")
      .attr("transform", function(d, i) { return "translate(-245," + (i-1) * 20 + ")"; });

  var title = ["Organization Type"];
  var legendTitle = svg.selectAll(".legendTitle")
      .data(title)
      .enter().append("g")
      .attr("class", "legendTitle")
      .attr("transform", "translate(-175,-25)")
      .append("text")
      .attr("x", width-75)
      .attr("y", -20)
      .style("text-anchor", "end")
      .style("font-weight", "bold")
      .style("font-size", "12px")
      .text(title);

   legend.append("rect")
      .attr("x", width - 25)
      .attr("y", -5)
      .attr("width", 18)
      .attr("height", 18)
      .style("fill", color);
      // offset between rect and text is 6
  legend.append("text")
      .attr("x", width - 30)
      .attr("y", 8)
      .style("text-anchor", "end")
      .style("font-size", "12px")
      .text(function(d) { return d; });

});

function type(d) {
  d.number = +d.number;
  return d;
}

// pie two --- breakdown by org size
var color2 = d3.scale.ordinal()
  // sad rainbow color
    // .range(["#ffd369", "#376d86", "#926239", "#a4579e", "#50b094"]);
    .range(["#f3ddd9", "#e7bbb3", "#dc998d", "#d07767", "#c55542"]);

var svg2 = d3.select("#threePie").append("svg")
    .attr("id", "bySize")
    .attr("class", "pieSvg")
    .attr("width", width)
    .attr("height", height)
    .append("g")
    .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

// d3.csv("js-custom/viz/sectorViz/IG/SizeTypePieData.php", type, function(error, data) {
d3.json("js-custom/viz/sectorViz/FII/FIISizePieData.php", function(error, data) {
  if (error) throw error;

  total2 = 0;
    for (i=0; i<data.length; i++) {
      total2 = total2 + data[i].number;
    }

  var formatPercent = d3.format(",.0%");

  var g = svg2.selectAll(".arc")
      .data(pie(data))
      .enter().append("g")
      .attr("class", "arc")
      .on("mouseover", function() { tooltip2.style("display", null); })
      .on("mouseout", function() { tooltip2.style("display", "none"); })
      .on("mousemove", function(d) {
        var xPosition = d3.mouse(d3.select('#bySize').node())[0] - 20;
        var yPosition = d3.mouse(d3.select('#bySize').node())[1] - 20;
        tooltip2.attr("transform", "translate(" + xPosition + "," + yPosition + ")");
        // tooltip2.select("text").text(d.value + " (" + formatPercent(d.value/total) + ")"); // d.data.org_size for org size label
        tooltip2.select("text").text(formatPercent(d.value/total2));
      });

  g.append("path")
      .attr("d", arc)
      .style("fill", function(d) { return color2(d.data.org_size); });

  var legend2 = svg2.selectAll(".legend")
      .data(color2.domain().slice())
      .enter().append("g")
      .attr("class", "legend")
      .attr("transform", function(d, i) { return "translate(-245," + (i-1) * 20 + ")"; });

  var title2 = ["Organization Size"];
  var legendTitle2 = svg2.selectAll(".legendTitle")
      .data(title2)
      .enter().append("g")
      .attr("class", "legendTitle")
      .attr("transform", "translate(-175,-25)")
      .append("text")
      .attr("x", width-75)
      .attr("y", -20)
      .style("text-anchor", "end")
      .style("font-weight", "bold")
      .style("font-size", "12px")
      .text(title2);

   legend2.append("rect")
      .attr("x", width - 40)
      .attr("y", -5)
      .attr("width", 18)
      .attr("height", 18)
      .style("fill", color2);
      // offset between rect and text is 6
  legend2.append("text")
      .attr("x", width - 45)
      .attr("y", 8)
      .style("text-anchor", "end")
      .style("font-size", "12px")
      .text(function(d) { return d; });

});

function type(d) {
  d.number = +d.number;
  return d;
}

// pie three --- breakdown by org age
var color3 = d3.scale.ordinal()
    // sad rainbow color
    // .range(["#0055A4", "#b88832", "#c55542"]); 
    .range(["#e0c7de", "#c28fbe", "#a4579e"]);

var svg3 = d3.select("#threePie").append("svg")
     .attr("id", "byAge")
     .attr("class", "pieSvg")
    .attr("width", width)
    .attr("height", height)
    .append("g")
    .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

// d3.csv("js-custom/viz/sectorViz/FII/FIIAgePieData.php", type, function(error, data) {
d3.json("js-custom/viz/sectorViz/FII/FIIAgePieData.php", function(error, data) {

  if (error) throw error;

  total3 = 0;
    for (i=0; i<data.length; i++) {
      total3 = total3 + data[i].number;
    }

  var formatPercent = d3.format(",.0%");

  var g = svg3.selectAll(".arc")
      .data(pie(data))
      .enter().append("g")
      .attr("class", "arc")
      .on("mouseover", function() { tooltip3.style("display", null); })
      .on("mouseout", function() { tooltip3.style("display", "none"); })
      .on("mousemove", function(d) {
        var xPosition = d3.mouse(d3.select('#byAge').node())[0] - 20;
        var yPosition = d3.mouse(d3.select('#byAge').node())[1] - 20;
        tooltip3.attr("transform", "translate(" + xPosition + "," + yPosition + ")");
        // tooltip3.select("text").text(d.value + " (" + formatPercent(d.value/total) + ")"); // d.data.org_age for org age label
        tooltip3.select("text").text(formatPercent(d.value/total3));
      });

  g.append("path")
      .attr("d", arc)
      .style("fill", function(d) { return color3(d.data.org_age); });

  var legend3 = svg3.selectAll(".legend")
      .data(color3.domain().slice())
      .enter().append("g")
      .attr("class", "legend")
      .attr("transform", function(d, i) { return "translate(-245," + (i-1) * 20 + ")"; });

  var title3 = ["Founding Year"];
  var legendTitle3 = svg3.selectAll(".legendTitle")
      .data(title3)
      .enter().append("g")
      .attr("class", "legendTitle")
      .attr("transform", "translate(-175,-25)")
      .append("text")
      .attr("x", width-90)
      .attr("y", -20)
      .style("text-anchor", "end")
      .style("font-weight", "bold")
      .style("font-size", "12px")
      .text(title3);

   legend3.append("rect")
      .attr("x", width - 40)
      .attr("y", -5)
      .attr("width", 18)
      .attr("height", 18)
      .style("fill", color3);
      // offset between rect and text is 6
  legend3.append("text")
      .attr("x", width - 45)
      .attr("y", 8)
      .style("text-anchor", "end")
      .style("font-size", "12px")
      .text(function(d) { return d; });

});

function type(d) {
  d.number = +d.number;
  return d;
}

// Prep the tooltips, initial display is hidden
      var tooltip = d3.select("#byType").append("g")
        .attr("class", "tooltip")
        .style("display", "none");

      tooltip.append("text")
        .attr("x", 15)
        .attr("dy", "1em")
        .style("text-anchor", "middle")
        .attr("font-size", "12px")
        .attr("font-weight", "bold");

      var tooltip2 = d3.select("#bySize").append("g")
        .attr("class", "tooltip")
        .style("display", "none");

      tooltip2.append("text")
        .attr("x", 15)
        .attr("dy", "1em")
        .style("text-anchor", "middle")
        .attr("font-size", "12px")
        .attr("font-weight", "bold");

      var tooltip3 = d3.select("#byAge").append("g")
        .attr("class", "tooltip")
        .style("display", "none");

      tooltip3.append("text")
        .attr("x", 15)
        .attr("dy", "1em")
        .style("text-anchor", "middle")
        .attr("font-size", "12px")
        .attr("font-weight", "bold");