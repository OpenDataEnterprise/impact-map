// global variabls for all three charts
// Define svg canvas dimensions
var marginBar = {top: 15, right: 0, bottom: 45, left: 40},
    widthBar = 1100 - marginBar.left - marginBar.right,
    heightBar = 350 - marginBar.top - marginBar.bottom;
// Define scale for x axis
var x = d3.scale.ordinal()
    .rangeRoundBands([0, widthBar], .1);
// Define scale for y axis
var y = d3.scale.linear()
    .rangeRound([heightBar, 0]);

// Define x axis, which takes x scale
var xAxisBar = d3.svg.axis()
    .scale(x)
    .orient("bottom")
    .innerTickSize([0]);

// Define y axis which takes y scale, specify tick style
var yAxisBar = d3.svg.axis()
    .scale(y)
    .orient("left")
    .ticks(5);
    // .tickFormat(d3.format("d"));
// Explanation for data type tick labels 
var typeLabelExplainations = {
    'Geospatial & Mapping':"I am an explanation for <br> Geospatial & Mapping",
    'Environment':"I am an explanation for <br> Environment",
    'Transportation':"I am an explanation for <br> Transportation",
    'Demographics & Social':"I am an explanation for <br> Government Operations",
    'Housing':"I am an explanation for <br> Housing",
    'Economics':"I am an explanation for <br> Economics",
    'Education':"I am an explanation for <br> Education",
    'Health':"I am an explanation for <br> Health",
    'Finance':"I am an explanation for <br> Finance",
    'Public Safety':"I am an explanation for <br> Public Safety",
    'Energy':"I am an explanation for <br> Energy",
    'Legal':"I am an explanation for <br> Legal",
    'Tourism':"I am an explanation for <br> Tourism",
    'Manufacturing':"I am an explanation for <br> Manufacturing",
    'Science & Research':"I am an explanation for <br> Science & Research",
    'Other':"I am an explanation for <br> Other",
    'Consumer':"I am an explanation for <br> Consumer",
    'Business':"I am an explanation for <br> Business",
    'International Development':"I am an explanation for <br> International Development",
    'Agriculture':"I am an explanation for <br> Agriculture",
    'Arts & Culture':"I am an explanation for <br> Arts & Culture",
    'Government Operations':"I am an explanation for <br> Government Operations"
};
drawDataTypeBar();

// draw org dist global chart

function drawDataTypeBar() {

var svgBar = d3.select("#dataTypeBar").append("svg")
    .attr("class", "barSvg")
    .attr("width", widthBar + marginBar.left + marginBar.right)
    .attr("height", heightBar + marginBar.top + marginBar.bottom)
    .append("g")
    .attr("transform", "translate(" + marginBar.left + "," + marginBar.top + ")");

// d3.csv("viz-data/data-sample-sectorDataTypeBar.csv", type, function(error, data) {
d3.json("js-custom/viz/sectorViz/FII/FIIDataTypeBarData.php", function(error, data) {
  if (error) throw error;

  data.sort(function(a, b) { return b.number - a.number; });
  x.domain(data.map(function(d) { return d.app_type; }));
  y.domain([0, d3.max(data, function(d) { return d.number; })]);
// console.log(data[0].number);
  // y.domain([0, d3.max([600,101,102,90,80])]);
  // console.log(data);

  svgBar.append("g")
      .attr("class", "x baraxis")
      .attr("id", "typebarxaxis")
      .attr("transform", "translate(0," + heightBar + ")")
      .call(xAxisBar)
      // .selectAll("text")
      // .attr("transform", "rotate(-60)")
      // .style("text-anchor", "end");
      .selectAll(".tick text")
      .call(wrap, x.rangeBand())
      .style("font-size","8px");

   // initiate tips
   var tip = d3.tip()
    .attr('class', 'd3-tip')
    .offset([-10, 0])
    .html(function(d) {
      return typeLabelExplainations[d];
    })
  svgBar.call(tip);
  // show tip for ticks
  d3.select('#typebarxaxis')
    .selectAll('.tick')
    .on('mouseover', tip.show)
    .on('mouseout', tip.hide)


  svgBar.append("g")
      .attr("class", "y baraxis")
      .call(yAxisBar)
      .append("text")
      .attr("transform", "rotate(-90)")
      // .attr("x", -)
      // .attr("y", -35)
      .attr("dy", "-2.5em")
      .style("text-anchor", "end")
      .text("Number of Organizations")
      .style("font", "sans-serif 10px");


  svgBar.selectAll("#LACbar")
      .data(data)
      .enter().append("rect")
      .attr("id", "LACbar")
      .attr("x", function(d) { return x(d.app_type); })
      .attr("width", x.rangeBand())
      .attr("y", function(d) { return y(d.number); })
      .attr("height", function(d) { return heightBar - y(d.number); })
      .style("fill", "#50b094")
      .on("mouseover", function() { tooltipBar.style("display", null); })
      .on("mouseout", function() { tooltipBar.style("display", "none"); })
      .on("mousemove", function(d) {
        var xPosition = d3.mouse(d3.select('.barSvg').node())[0];
        var yPosition = d3.mouse(d3.select('.barSvg').node())[1] - 20;
        tooltipBar.attr("transform", "translate(" + xPosition + "," + yPosition + ")");
        tooltipBar.select("text").text(d.number);
      });

  var tooltipBar = d3.select(".barSvg").append("g")
        .attr("class", "tooltip")
        .style("display", "none");

      tooltipBar.append("text")
        .attr("x", 15)
        .attr("dy", "1.2em")
        .style("text-anchor", "middle")
        .attr("font-size", "12px")
        .attr("font-weight", "bold");
  
});

// for csv - ensures the value you get is actually integers not strings...
// function type(d) {
//   d.number = +d.number;
//   return d;
// }

function wrap(text, width) {
        text.each(function() {
          var text = d3.select(this),
          words = text.text().split(/\s+/).reverse(),
          // word,
          line = [],
          lineNumber = 0,
          lineHeight = 1, // ems
          y = text.attr("y"),
          dy = parseFloat(text.attr("dy")),
          tspan = text.text(null).append("tspan").attr("x", 0).attr("y", y).attr("dy", dy + "em");
      while (word = words.pop()) {
        line.push(word);
        tspan.text(line.join(" "));
        if (tspan.node().getComputedTextLength() > (width+30)) {
          line.pop();
          tspan.text(line.join(" "));
          line = [word];
          tspan = text.append("tspan").attr("x", 0).attr("y", y).attr("dy", ++lineNumber * lineHeight + dy + "em").text(word);
              }
          }
        });
      }


}
