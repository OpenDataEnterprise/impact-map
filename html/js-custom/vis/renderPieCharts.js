function getOrganizationCount (data) {
  var total = 0;
  for (i = 0; i < data.length; i++) {
    total += data[i].organization_count;
  }
  return total;
}

function getArcLegend (chart, arc) {
  var legendClass = '';
  var classRegex = /arc-[\d]+/;
  var arcClass = d3.select(arc).attr('class');
  var classMatch = arcClass.match(classRegex);

  if (classMatch[0]) {
    var indexRegex = /[\d]+/;
    var indexMatch = classMatch[0].match(indexRegex);

    if (indexMatch[0]) {
      legendClass = 'legend-' + indexMatch[0];
    }
  }

  return chart.select('.' + legendClass);
}

function renderChart (width, height, radius, id, data, dataKey, colors) {
  var pie = d3.layout.pie()
    .sort(null)
    .value(function (d) { return d.organization_count; });

  var arc = d3.svg.arc()
    .outerRadius(radius)
    .innerRadius(radius - 35);

  var formatPercent = d3.format(',.0%');

  var svg = d3.select('#threePie')
    .append('svg')
    .attr('id', id)
    .attr('class', 'pieSvg')
    .attr('width', width)
    .attr('height', height)
    .attr('overflow', 'visible')
    .append('g')
    .attr('transform', 'translate(' + width / 2 + ',' + height / 2 + ')');

  var g = svg.selectAll('.arc')
    .data(pie(data))
    .enter()
    .append('g')
    .attr('class', function (d, i) {
      return 'arc arc-' + (i + 1);
    })
    .on('mouseover', function (d) {
      var chart = d3.select('#' + id);
      var arc = d3.select(this);
      var legend = getArcLegend(svg, this);

      // Define legend transformations.
      var x = legend.attr('data-coord-x');
      var y = legend.attr('data-coord-y');
      var scale = 'scale(1.3)';
      var translate = 'translate(' + x + ', ' + y + ')';

      // Make the legend entry of the current arc pop out.
      legend.attr('transform-origin', '90% 0');
      legend.attr('transform', translate + scale);

      // Display data through tooltip.
      var percentage = formatPercent(d.value / total);
      tooltip.select('text').text(percentage);
      tooltip.style('visibility', 'visible');

      // Bring legend node forward in z-axis.
      legend.node().parentElement.appendChild(legend.node());
    })
    .on('mousemove', function () {
      var domRect = tooltip.node().getBoundingClientRect();
      var xBound = 300 - domRect.width;
      var yBound = 300 - domRect.height;

      var x = d3.mouse(svg.node())[0] + (width / 2) + 10;
      var y = d3.mouse(svg.node())[1] + (height / 2) + 10;

      // Ensure that tooltip doesn't go out of visible bounds.
      if (x > xBound) {
        x = xBound;
      }
      if (y > yBound) {
        y = yBound;
      }

      // Move tooltip with the cursor.
      tooltip.attr('transform', 'translate(' + x + ',' + y + ')');
    })
    .on('mouseout', function () {
      tooltip.style('visibility', 'hidden');

      var arc = d3.select(this);
      var legend = getArcLegend(svg, this);

      var x = legend.attr('data-coord-x');
      var y = legend.attr('data-coord-y');
      var scale = 'scale(1)';
      var translate = 'translate(' + x + ', ' + y + ')';

      // Revert legend entry to original appearance.
      legend.attr('transform', translate + scale);
    });

  var tooltip = d3.select('#' + id)
    .append('g')
    .attr('class', 'tooltip')
    .style('visibility', 'visible');

  tooltip.append('text')
    .attr('x', 15)
    .attr('dy', '1em')
    .style('text-anchor', 'middle')
    .style('font-size', '1.25em')
    .style('font-weight', 'bold');

  total = getOrganizationCount(data);

  g.append('path')
    .attr('d', arc)
    .style('fill', function (d) {
      return colors(d.data[dataKey]);
    });

  return svg;
}

function renderLegend (title, width, svg, data, colors) {
  var legend = svg.selectAll('.legend')
    .data(colors.domain().slice())
    .enter()
    .append('g')
    .attr('class', function (d, i) {
      return 'legend legend-' + (i + 1);
    })
    .attr('transform', function (d, i) {
      var x = -245;
      var y = (i - 1) * 20;
      var legend = d3.select(this);

      legend.attr('data-coord-x', x);
      legend.attr('data-coord-y', y);

      return 'translate(' + x + ', ' + y + ')';
    });

  var legendTitle = svg.selectAll('.legendTitle')
    .data([title])
    .enter()
    .append('g')
    .attr('class', 'legendTitle')
    .attr('transform', 'translate(-175, -25)')
    .append('text')
    .attr('x', width - 80)
    .attr('y', -10)
    .style('text-anchor', 'end')
    .style('font-weight', 'bold')
    .style('font-size', '12px')
    .text(title);

  legend.append('rect')
    .attr('x', width - 40)
    .attr('y', -5)
    .attr('width', 18)
    .attr('height', 18)
    .style('fill', colors);

  legend.append('text')
    .attr('x', width - 45)
    .attr('y', 8)
    .style('text-anchor', 'end')
    .style('font-size', '12px')
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
      ['#50b094', '#73bfa9', '#96cfbe', '#b9dfd4', '#dcefe9']
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
      ['#f3ddd9', '#e7bbb3', '#dc998d', '#d07767', '#c55542']
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
    renderLegend('Organization Size', width, svg, data, colors);
  });

  // pie three --- breakdown by org age
  var ageQueryURL = apiBaseURL + type + '/' + encodedValue +
    '/organization-ages';
  d3.json(ageQueryURL, function (error, data) {
    if (error) {
      throw error;
    }

    var colors = d3.scale.ordinal().range(
      ['#e0c7de', '#c28fbe', '#a4579e']
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
    renderLegend('Founding Year', width, svg, data, colors);
  });
}