function getOrganizationCount (data) {
  var total = 0;
  for (i = 0; i < data.length; i++) {
    total += data[i].organization_count;
  }
  return total;
}

function renderChart (width, height, radius, id, data, dataKey, colors) {
  var pie = d3.layout.pie()
    .sort(null)
    .value(function (d) { return d.organization_count; });

  var arc = d3.svg.arc()
    .outerRadius(radius)
    .innerRadius(radius - 35);

  var formatPercent = d3.format(",.0%");

  var svg = d3.select("#threePie").append("svg")
    .attr("id", id)
    .attr("class", "pieSvg")
    .attr("width", width)
    .attr("height", height)
    .append("g")
    .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

  var g = svg.selectAll(".arc")
    .data(pie(data))
    .enter().append("g")
    .attr("class", "arc");

  var tooltip = d3.select('#' + id)
    .append("g")
    .attr("class", "tooltip")
    .style("visibility", "visible");

  tooltip.append("text")
    .attr("x", 15)
    .attr("dy", "1em")
    .style("text-anchor", "middle")
    .attr("font-size", "12px")
    .attr("font-weight", "bold");

  total = getOrganizationCount(data);

  g.append("path")
    .attr("d", arc)
    .style("fill", function (d) {
      return colors(d.data[dataKey]);
    })
    .on("mouseover", function (d) {
      tooltip.style("visibility", "visible");
      var percentage = formatPercent(d.value / total);
      tooltip.select("text").text(percentage);
    })
    .on("mousemove", function () {
      var x = d3.mouse(d3.select('#' + id).node())[0] - 20;
      var y = d3.mouse(d3.select('#' + id).node())[1] - 20;
      tooltip.attr("transform", "translate(" + x + "," + y + ")");
    })
    .on("mouseout", function () {
      tooltip.style("visibility", "hidden");
    });

  return svg;
}

function renderLegend (title, width, svg, data, colors) {
  var legend = svg.selectAll(".legend")
    .data(colors.domain().slice())
    .enter().append("g")
    .attr("class", "legend")
    .attr("transform",
      function (d, i) {
        return "translate(-245," + (i-1) * 20 + ")";
      }
    );

  var legendTitle = svg.selectAll(".legendTitle")
    .data([title])
    .enter().append("g")
    .attr("class", "legendTitle")
    .attr("transform", "translate(-175,-25)")
    .append("text")
    .attr("x", width - 80)
    .attr("y", -10)
    .style("text-anchor", "end")
    .style("font-weight", "bold")
    .style("font-size", "12px")
    .text(title);

  legend.append("rect")
    .attr("x", width - 40)
    .attr("y", -5)
    .attr("width", 18)
    .attr("height", 18)
    .style("fill", colors);

  legend.append("text")
    .attr("x", width - 45)
    .attr("y", 8)
    .style("text-anchor", "end")
    .style("font-size", "12px")
    .text(function (d) { return d; });
}

function renderPieCharts (type, value, config) {
  var apiBaseURL = config.apiBaseURL;
  var encodedValue = encodeURIComponent(value);

  // define svg canvas dimensions
  var width = 300;
  var height = 300;
  var radius = Math.min(width, height - 20) / 2;

  // pie one --- breakdown by orgtype
  var typeQueryURL = apiBaseURL + type + '/' + encodedValue +
    '/organization-types';
  d3.json(typeQueryURL, function (error, data) {
    if (error) {
      throw error;
    }

    var colors = d3.scale.ordinal().range(
      ["#50b094", "#73bfa9", "#96cfbe", "#b9dfd4", "#dcefe9"]
    );

    var svg = renderChart(
      width,
      height,
      radius,
      'byType',
      data,
      'organization_type',
      colors
    );
    renderLegend('Organization Type', width, svg, data, colors);
  });

  // pie two --- breakdown by org size
  var sizeQueryURL = apiBaseURL + type + '/' + encodedValue +
    '/organization-sizes';
  d3.json(sizeQueryURL, function (error, data) {
    if (error) {
      throw error;
    }

    var colors = d3.scale.ordinal().range(
      ["#f3ddd9", "#e7bbb3", "#dc998d", "#d07767", "#c55542"]
    );

    var svg = renderChart(
      width,
      height,
      radius,
      'bySize',
      data,
      'organization_size',
      colors
    );
    renderLegend("Organization Size", width, svg, data, colors);
  });

  // pie three --- breakdown by org age
  var ageQueryURL = apiBaseURL + type + '/' + encodedValue +
    '/organization-ages';
  d3.json(ageQueryURL, function (error, data) {
    if (error) {
      throw error;
    }

    var colors = d3.scale.ordinal().range(
      ["#e0c7de", "#c28fbe", "#a4579e"]
    );

    var svg = renderChart(
      width,
      height,
      radius,
      'byAge',
      data,
      'age_group',
      colors
    );
    renderLegend("Founding Year", width, svg, data, colors);
  });
}