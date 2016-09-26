// global variabls for all three charts
// Define svg canvas dimensions
var marginAppBar = {top: 15, right: 0, bottom: 45, left: 40},
    widthAppBar = 400 - marginAppBar.left - marginAppBar.right,
    heightAppBar = 300 - marginAppBar.top - marginAppBar.bottom;
// Define scale for x axis
var xAppBar = d3.scale.ordinal()
    .rangeRoundBands([0, widthAppBar], .1);
// Define scale for y axis
var yAppBar = d3.scale.linear()
    .rangeRound([heightAppBar, 0]);

// Define x axis, which takes x scale
var xAxisAppBar = d3.svg.axis()
    .scale(xAppBar)
    .orient("bottom")
    .innerTickSize([0]);

// Define y axis which takes y scale, specify tick style
var yAxisAppBar = d3.svg.axis()
    .scale(yAppBar)
    .orient("left")
    .ticks(5);
    // .tickFormat(d3.format("d"));

drawDataTypeBar();

// draw org dist global chart

function drawDataTypeBar() {

var svgAppBar = d3.select("#appBar").append("svg")
    .attr("class", "barSvg")
    .attr("id", "appBarSvg")
    .attr("width", widthAppBar + marginAppBar.left + marginAppBar.right)
    .attr("height", heightAppBar + marginAppBar.top + marginAppBar.bottom)
    .append("g")
    .attr("transform", "translate(" + marginAppBar.left + "," + marginAppBar.top + ")");

// d3.csv("viz-data/data-sample-sectorAppBar.csv", type, function(error, dataAppBar) {
d3.json("js-custom/viz/sectorViz/Edu/EduAppBarData.php", function(error, dataAppBar) {
  if (error) throw error;

  dataAppBar.sort(function(a, b) { return b.number - a.number; });
  xAppBar.domain(dataAppBar.map(function(d) { return d.app_type; }));
  yAppBar.domain([0, d3.max(dataAppBar, function(d) { return d.number; })]);
// console.log(data[0].number);
  // y.domain([0, d3.max([600,101,102,90,80])]);
  // console.log(data);

  svgAppBar.append("g")
      .attr("class", "x baraxis")
      .attr("transform", "translate(0," + heightAppBar + ")")
      .call(xAxisAppBar)
      // .selectAll("text")
      // .attr("transform", "rotate(-60)")
      // .style("text-anchor", "end");
      .selectAll(".tick text")
      .call(wrap, xAppBar.rangeBand());


  svgAppBar.append("g")
      .attr("class", "y baraxis")
      .call(yAxisAppBar)
      .append("text")
      .attr("transform", "rotate(-90)")
      // .attr("x", -)
      // .attr("y", -35)
      .attr("dy", "-2.5em")
      .style("text-anchor", "end")
      .text("Number of Organizations")
      .style("font", "Arial 10px");


  svgAppBar.selectAll("#LACbar")
      .data(dataAppBar)
      .enter().append("rect")
      .attr("id", "LACbar")
      .attr("x", function(d) { return xAppBar(d.app_type); })
      .attr("width", xAppBar.rangeBand())
      .attr("y", function(d) { return yAppBar(d.number); })
      .attr("height", function(d) { return heightAppBar - yAppBar(d.number); })
      .style("fill", "#375f7a")
      .on("mouseover", function() { tooltipAppBar.style("display", null); })
      .on("mouseout", function() { tooltipAppBar.style("display", "none"); })
      .on("mousemove", function(d) {
        var xPositionAppBar = d3.mouse(d3.select('#appBarSvg').node())[0];
        var yPositionAppBar = d3.mouse(d3.select('#appBarSvg').node())[1] - 20;
        tooltipAppBar.attr("transform", "translate(" + xPositionAppBar + "," + yPositionAppBar + ")");
        tooltipAppBar.select("text").text(d.number);
      });

  var tooltipAppBar = d3.select("#appBarSvg").append("g")
        .attr("class", "tooltip")
        .style("display", "none");

      tooltipAppBar.append("text")
        .attr("x", 15)
        .attr("dy", "1.2em")
        .style("text-anchor", "middle")
        .style("font", "Arial 10px")
        .attr("font-size", "12px")
        .attr("font-weight", "bold");
  
});

// for csv - ensures the value you get is Consuually integers not strings...
// function type(d) {
//   d.number = +d.number;
//   return d;
// }

function wrap(text, width) {
        text.each(function() {
          var text = d3.select(this),
          words = text.text().split(/\s+/).reverse(),
          word,
          line = [],
          lineNumber = 0,
          lineHeight = 1.1, // ems
          y = text.attr("y"),
          dy = parseFloat(text.attr("dy")),
          tspan = text.text(null).append("tspan").attr("x", 0).attr("y", y).attr("dy", dy + "em");
      while (word = words.pop()) {
        line.push(word);
        tspan.text(line.join(" "));
        if (tspan.node().getComputedTextLength() > (width+10)) {
          line.pop();
          tspan.text(line.join(" "));
          line = [word];
          tspan = text.append("tspan").attr("x", 0).attr("y", y).attr("dy", ++lineNumber * lineHeight + dy + "em").text(word);
              }
          }
        });
      }


}