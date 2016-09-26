// global variabls for all three charts
// Define svg canvas dimensions
var margin = {top: 0, right: 0, bottom: 150, left: 50},
    width = 600 - margin.left - margin.right,
    height = 400 - margin.top - margin.bottom;
// Define scale for x axis
var x = d3.scale.ordinal()
    .rangeRoundBands([0, width], .1);
// Define scale for y axis
var y = d3.scale.linear()
    .rangeRound([height, 0]);

// Define x axis, which takes x scale
var xAxis = d3.svg.axis()
    .scale(x)
    .orient("bottom")
    .innerTickSize([0]);

// Define y axis which takes y scale, specify tick style
var yAxis = d3.svg.axis()
    .scale(y)
    .orient("left")
    .ticks(5);
    // .tickFormat(d3.format("d"));

drawOrdDist();

// draw org dist global chart

function drawOrdDist() {

var svg1 = d3.select(".regionvizlanding").append("svg")
    .attr("class", "svgLanding")
    .attr("width", width + margin.left + margin.right)
    .attr("height", height + margin.top + margin.bottom)
    .append("g")
    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

// d3.csv("viz-data/data-regionLanding.csv", type, function(error, data) {
d3.json("js-custom/viz/regionViz/RegionLandingBarData.php", function(error, data) {
  if (error) throw error;
  // console.log(data[0]);
  data.sort(function(a, b) { return b.orgs - a.orgs; });
  x.domain(data.map(function(d) { return d.region; }));
  y.domain([0, d3.max(data, function(d) { return d.orgs; })]);
// console.log(data[0].orgs);
  // y.domain([0, d3.max([600,101,102,90,80])]);
  

  svg1.append("g")
      .attr("class", "x axis")
      .attr("transform", "translate(0," + height + ")")
      .call(xAxis)
      // .selectAll("text")
      // .attr("transform", "rotate(-60)")
      // .style("text-anchor", "end");
      .selectAll(".tick text")
      .call(wrap, x.rangeBand());


  svg1.append("g")
      .attr("class", "y axis")
      .call(yAxis);
      // .append("text")
      // .attr("transform", "rotate(-90)")
      // .attr("x", -)
      // .attr("y", -35)
      // .attr("dy", "-3.5em")
      // .style("text-anchor", "end")
      // .text("Number of Organizations")
      // .style("font", "sans-serif 10px");


  svg1.selectAll("#regionLandingBar")
      .data(data)
      .enter().append("rect")
      .attr("id", "regionLandingBar")
      .attr("x", function(d) { return x(d.region); })
      .attr("width", x.rangeBand())
      .attr("y", function(d) { return y(d.orgs); })
      .attr("height", function(d) { return height - y(d.orgs); })
      .style("fill", "#50b094")
      .on("mouseover", function() { tooltip1.style("display", null); })
      .on("mouseout", function() { tooltip1.style("display", "none"); })
      .on("mousemove", function(d) {
        var xPosition = d3.mouse(d3.select('.svgLanding').node())[0];
        var yPosition = d3.mouse(d3.select('.svgLanding').node())[1] - 20;
        tooltip1.attr("transform", "translate(" + xPosition + "," + yPosition + ")");
        tooltip1.select("text").text(d.orgs);
      });

  var tooltip1 = d3.select(".svgLanding").append("g")
        .attr("class", "tooltip")
        .style("display", "none");

      tooltip1.append("text")
        .attr("x", 15)
        .attr("dy", "1.2em")
        .style("text-anchor", "middle")
        .attr("font-size", "12px")
        .attr("font-weight", "bold");
  
});

// ensures the value you get is actually integers not strings...
// used with csv file, json file does not need this
// function type(d) {
//   d.orgs = +d.orgs;
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
        if (tspan.node().getComputedTextLength() > width) {
          line.pop();
          tspan.text(line.join(" "));
          line = [word];
          tspan = text.append("tspan").attr("x", 0).attr("y", y).attr("dy", ++lineNumber * lineHeight + dy + "em").text(word);
              }
          }
        });
      }


}
