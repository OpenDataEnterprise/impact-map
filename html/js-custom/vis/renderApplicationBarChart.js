function renderApplicationBarChart (sector, config) {
  var apiBaseURL = config.apiBaseURL;
  var encodedSector = encodeURIComponent(sector);

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

  // Explanation for data type tick labels 
  var appLabelExplainations = {
    'Organizational Optimization':"E.g. streamline operations,<br>inform strategy, provide<br>competitive information",
    'Development of Products/Services':"E.g. web and mobile applications,<br>visualization and analytical tools,<br>advisory services",
    'Advocacy':"E.g. public awareness campaigns,<br>lobbying, promotional, and<br>educational activities",
    'Research':"E.g. academic, industry,<br>scientific research, and<br>investigative journalism",
    // 'Other':"I am an explanation for <br> Other"
  };

  var svgAppBar = d3.select("#appBar").append("svg")
    .attr("class", "barSvg")
    .attr("id", "appBarSvg")
    .attr("width", widthAppBar + marginAppBar.left + marginAppBar.right)
    .attr("height", heightAppBar + marginAppBar.top + marginAppBar.bottom)
    .append("g")
    .attr("transform", "translate(" + marginAppBar.left + "," + marginAppBar.top + ")");

  var applicationQueryURL = apiBaseURL + 'sector/' + encodedSector +
    '/organization-applications';
  d3.json(applicationQueryURL, function(error, data) {
    if (error) throw error;

    data.sort(function(a, b) {
      return b.organization_count - a.organization_count;
    });
    xAppBar.domain(data.map(function(d) { return d.application; }));
    yAppBar.domain([0, d3.max(data, function(d) { return d.organization_count; })]);

    svgAppBar.append("g")
      .attr("class", "x baraxis")
      .attr("id", "appbarxaxis")
      .attr("transform", "translate(0," + heightAppBar + ")")
      .call(xAxisAppBar)
      .selectAll(".tick text")
      .call(wrap, xAppBar.rangeBand());

    // initiate tips
    var tip = d3.tip()
      .attr('class', 'd3-tip')
      .offset([-10, 0])
      .html(function(d) {
        return appLabelExplainations[d];
      })
    svgAppBar.call(tip);

    // show tip for ticks
    d3.select('#appbarxaxis')
      .selectAll('.tick')
      .on('mouseover', tip.show)
      .on('mouseout', tip.hide)

    svgAppBar.append("g")
      .attr("class", "y baraxis")
      .call(yAxisAppBar)
      .append("text")
      .attr("transform", "rotate(-90)")
      .attr("dy", "-2.5em")
      .style("text-anchor", "end")
      .text("Number of Organizations")
      .style("font", "sans-serif 10px");

    svgAppBar.selectAll("#LACbar")
      .data(data)
      .enter().append("rect")
      .attr("id", "LACbar")
      .attr("x", function(d) { return xAppBar(d.application); })
      .attr("width", xAppBar.rangeBand())
      .attr("y", function(d) { return yAppBar(d.organization_count); })
      .attr("height", function(d) { return heightAppBar - yAppBar(d.organization_count); })
      .style("fill", "#375f7a")
      .on("mouseover", function() { tooltipAppBar.style("display", null); })
      .on("mouseout", function() { tooltipAppBar.style("display", "none"); })
      .on("mousemove", function(d) {
        var xPositionAppBar = d3.mouse(d3.select('#appBarSvg').node())[0];
        var yPositionAppBar = d3.mouse(d3.select('#appBarSvg').node())[1] - 20;
        tooltipAppBar.attr("transform", "translate(" + xPositionAppBar + "," + yPositionAppBar + ")");
        tooltipAppBar.select("text").text(d.organization_count);
      });

    var tooltipAppBar = d3.select("#appBarSvg").append("g")
      .attr("class", "tooltip")
      .style("display", "none");

    tooltipAppBar.append("text")
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
          if (tspan.node().getComputedTextLength() > width+10) {
            line.pop();
            tspan.text(line.join(" "));
            line = [word];
            tspan = text.append("tspan").attr("x", 0).attr("y", y).attr("dy", ++lineNumber * lineHeight + dy + "em").text(word);
                }
            }
          });
        }


  }