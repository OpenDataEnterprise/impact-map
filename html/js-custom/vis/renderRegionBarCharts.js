// draw org dist global chart
function renderRegionBarCharts (region, config) {
  var apiBaseURL = config.apiBaseURL;
  var encodedRegion = encodeURIComponent(region);

  // global variabls for all three charts
  // Define svg canvas dimensions
  var marginBar = {top: 15, right: 0, bottom: 45, left: 50};
  var widthBar = 1160 - marginBar.left - marginBar.right;
  var heightBar = 400 - marginBar.top - marginBar.bottom;

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

  var svgBar = d3.select("#bar").append("svg")
    .attr("class", "barSvg")
    .attr("width", widthBar + marginBar.left + marginBar.right)
    .attr("height", heightBar + marginBar.top + marginBar.bottom)
    .append("g")
    .attr("transform", "translate(" + marginBar.left + "," + marginBar.top + ")");

  var sectorQueryURL = apiBaseURL + 'region/' + encodedRegion +
    '/organization-sectors';
  d3.json(sectorQueryURL, function(error, data) {
    if (error) throw error;

    data.sort(function(a, b) {
        return b.organization_count - a.organization_count;
      });

    x.domain(data.map(function(d) {
      if (d.organization_count > 0) {
        return d.sector;
      }
    }));
    y.domain([0, d3.max(data, function(d) { return d.organization_count; })]);

    svgBar.append("g")
      .attr("class", "x baraxis")
      .attr("transform", "translate(0," + heightBar + ")")
      .call(xAxisBar)
      .selectAll(".tick text")
      .call(wrap, x.rangeBand());

    svgBar.append("g")
      .attr("class", "y baraxis")
      .call(yAxisBar)
      .append("text")
      .attr("transform", "rotate(-90)")
      .attr("dy", "-3.5em")
      .style("text-anchor", "end")
      .text("Number of Organizations")
      .style("font", "sans-serif 10px");

    svgBar.selectAll("#LACbar")
      .data(data)
      .enter().append("rect")
      .attr("id", "LACbar")
      .attr("x", function(d) { return x(d.sector); })
      .attr("width", x.rangeBand())
      .attr("y", function(d) { return y(d.organization_count); })
      .attr("height", function(d) { return heightBar - y(d.organization_count); })
      .style("fill", "#375f7a")
      .on("mouseover", function() { tooltipBar.style("display", null); })
      .on("mouseout", function() { tooltipBar.style("display", "none"); })
      .on("mousemove", function(d) {
        var xPosition = d3.mouse(d3.select('.barSvg').node())[0];
        var yPosition = d3.mouse(d3.select('.barSvg').node())[1] - 20;
        tooltipBar.attr("transform", "translate(" + xPosition + "," + yPosition + ")");
        tooltipBar.select("text").text(d.organization_count);
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
          tspan = text
            .append("tspan")
            .attr("x", 0)
            .attr("y", y)
            .attr("dy", ++lineNumber * lineHeight + dy + "em")
            .text(word);
        }
      }
    });
  }
}