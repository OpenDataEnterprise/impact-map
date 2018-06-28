function renderLandingBarChart (type, config) {
  var apiBaseURL = config.apiBaseURL;

  var barChartConfig = {
    region: {
      plural: 'regions',
      width: 600,
      height: 400,
      fillColor: '#50b094',
    },
    sector: {
      plural: 'sectors',
      width: 1160,
      height: 400,
      fillColor: '#a1af00',
    }
  }

  // global variabls for all three charts
  // Define svg canvas dimensions
  var margin = {top: 0, right: 0, bottom: 150, left: 50};
  var width = barChartConfig[type].width - margin.left - margin.right;
  var height = barChartConfig[type].height - margin.top - margin.bottom;

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

  var svg1 = d3.select('.' + type + 'vizlanding').append("svg")
    .attr("class", "svgLanding")
    .attr("width", width + margin.left + margin.right)
    .attr("height", height + margin.top + margin.bottom)
    .append("g")
    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

  var queryURL = apiBaseURL + barChartConfig[type].plural +
    '/total-organizations';
  d3.json(queryURL, function(error, data) {
    if (error) throw error;

    data.sort(function(a, b) {
      return b.organization_count - a.organization_count;
    });
    x.domain(data.map(function(d) {
      if (d.organization_count > 0) {
        return d[type];
      }
    }));
    y.domain([0, d3.max(data, function(d) { return d.organization_count; })]);

    svg1.append("g")
      .attr("class", "x axis")
      .attr("transform", "translate(0," + height + ")")
      .call(xAxis)
      .selectAll(".tick text")
      .call(wrap, x.rangeBand());

    svg1.append("g")
      .attr("class", "y axis")
      .call(yAxis);

    svg1.selectAll('#' + type + 'LandingBar')
      .data(data)
      .enter().append("rect")
      .attr("id", type + 'LandingBar')
      .attr("x", function(d) { return x(d[type]); })
      .attr("width", x.rangeBand())
      .attr("y", function(d) { return y(d.organization_count); })
      .attr("height", function(d) { return height - y(d.organization_count); })
      .style("fill", barChartConfig[type].fillColor)
      .on("mouseover", function() { tooltip1.style("display", null); })
      .on("mouseout", function() { tooltip1.style("display", "none"); })
      .on("mousemove", function(d) {
        var xPosition = d3.mouse(d3.select('.svgLanding').node())[0];
        var yPosition = d3.mouse(d3.select('.svgLanding').node())[1] - 20;
        tooltip1.attr("transform", "translate(" + xPosition + "," + yPosition + ")");
        tooltip1.select("text").text(d.organization_count);
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

  function wrap (text, width) {
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