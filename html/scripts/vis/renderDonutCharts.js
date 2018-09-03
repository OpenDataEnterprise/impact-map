import * as d3 from 'd3';

function getOrganizationCount (data) {
  let total = 0;
  const n = data.length;
  for (let i = 0; i < n; i++) {
    total += data[i].organization_count;
  }
  return total;
}

function getChartColors(data, colorRange) {
  let interpolator = d3.interpolateRgb(colorRange[0], colorRange[1]);

  const dataCount = data.length;
  let colorCodes = data.map(function (d, i) {
    const interpFactor = i / dataCount;
    const colorCode = interpolator(interpFactor);
    return colorCode;
  });

  let colors = d3.scaleOrdinal().range(colorCodes);
  return colors;
}

function getArcLegend (chart, arc) {
  let legendClass = '';
  let classRegex = /arc-[\d]+/;
  let arcClass = d3.select(arc).attr('class');
  let classMatch = arcClass.match(classRegex);

  if (classMatch[0]) {
    let indexRegex = /[\d]+/;
    let indexMatch = classMatch[0].match(indexRegex);

    if (indexMatch[0]) {
      legendClass = '.legend-' + indexMatch[0];
    }
  }

  let legend = d3.select(chart).select(legendClass);

  return legend;
}

function renderDonutChart (width, height, radius, id, data, dataKey, colors) {
  const organizationCount = getOrganizationCount(data);

  let donut = d3.pie()
    .sort(null)
    .value(function (d) { return d.organization_count; });

  let arc = d3.arc()
    .outerRadius(radius)
    .innerRadius(radius - 35);

  let formatPercent = d3.format(',.0%');

  let svg = d3.select('#threePie')
    .append('svg')
    .attr('id', id)
    .attr('class', 'pieSvg')
    .attr('width', width)
    .attr('height', height)
    .attr('overflow', 'visible')
    .append('g')
    .attr('transform', 'translate(' + width / 2 + ',' + height / 2 + ')');

  let tooltip = d3.select('#' + id)
    .append('g')
    .attr('class', 'tooltip')
    .style('visibility', 'hidden');

  tooltip.append('text')
    .attr('x', 15)
    .attr('dy', '1em')
    .style('text-anchor', 'middle')
    .style('font-size', '1.25em')
    .style('font-weight', 'bold');

  let g = svg.selectAll('.arc')
    .data(donut(data))
    .enter()
    .append('g')
    .attr('class', function (d, i) {
      return 'arc arc-' + (i + 1);
    })
    .on('mouseover', function (d) {
      let chart = d3.select('#' + id).node();
      let legend = getArcLegend(chart, this);

      // Define legend transformations.
      let x = legend.attr('data-coord-x');
      let y = legend.attr('data-coord-y');
      let scale = 'scale(1.3)';
      let translate = 'translate(' + x + ', ' + y + ')';

      // Make the legend entry of the current arc pop out.
      legend.attr('transform-origin', '90% 0');
      legend.attr('transform', translate + scale);

      // Display data through tooltip.
      let percentage = formatPercent(d.value / organizationCount);
      tooltip.select('text').text(percentage);
      tooltip.style('visibility', 'visible');

      // Bring legend node forward in z-axis.
      legend.node().parentElement.appendChild(legend.node());
    })
    .on('mousemove', function () {
      let domRect = tooltip.node().getBoundingClientRect();
      let xBound = 300 - domRect.width;
      let yBound = 300 - domRect.height;

      let svgNode = svg.node();
      let x = d3.mouse(svgNode)[0] + (width / 2) + 10;
      let y = d3.mouse(svgNode)[1] + (height / 2) + 10;

      // Ensure that the displayed tooltip doesn't go out of visible bounds.
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

      let chart = d3.select('#' + id).node();
      let legend = getArcLegend(chart, this);

      let x = legend.attr('data-coord-x');
      let y = legend.attr('data-coord-y');
      let scale = 'scale(1)';
      let translate = 'translate(' + x + ', ' + y + ')';

      // Revert legend entry to original appearance.
      legend.attr('transform', translate + scale);
    });

  g.append('path')
    .attr('d', arc)
    .style('fill', function (d) {
      return colors(d.data[dataKey]);
    });

  return svg;
}

function renderLegend (title, width, svg, data, colors) {
  let legend = svg.selectAll('.legend')
    .data(colors.domain().slice())
    .enter()
    .append('g')
    .attr('class', function (d, i) {
      return 'legend legend-' + (i + 1);
    })
    .attr('transform', function (d, i) {
      let x = -245;
      let y = (i - 1) * 20;
      let legend = d3.select(this);

      legend.attr('data-coord-x', x);
      legend.attr('data-coord-y', y);

      return 'translate(' + x + ', ' + y + ')';
    });

  let legendTitle = svg.selectAll('.legendTitle')
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

export function renderDonutCharts (type, value, config) {
  let apiBaseURL = config.apiBaseURL;
  let encodedValue = encodeURIComponent(value);

  // define svg canvas dimensions
  let width = 300;
  let height = 300;
  let radius = Math.min(width, height - 20) / 2;

  let chartMetadata = [
    {
      queryURL: apiBaseURL + type + '/' + encodedValue + '/organization-types',
      chartID: 'byType',
      chartName: 'Organization Type',
      dataKey: 'organization_type',
      colorRange: ['#dcefe9', '#50b094']
    },
    {
      queryURL: apiBaseURL + type + '/' + encodedValue + '/organization-sizes',
      chartID: 'bySize',
      chartName: 'Organization Size',
      dataKey: 'organization_size',
      colorRange: ['#f3ddd9', '#c55542']
    },
    {
      queryURL: apiBaseURL + type + '/' + encodedValue + '/organization-ages',
      chartID: 'byAge',
      chartName: 'Organization Age',
      dataKey: 'age_group',
      colorRange: ['#e0c7de', '#a4579e']
    },
  ]

  let promises = [];

  for (let i = 0, n = chartMetadata.length; i < n; i++) {
    promises.push(d3.json(chartMetadata[i].queryURL));
  }

  Promise.all(promises).then(function (results) {
    for (let i = 0, n = results.length; i < n; i++) {
      let colors = getChartColors(results[i], chartMetadata[i].colorRange);

      let svg = renderDonutChart(
        width,
        height,
        radius,
        chartMetadata[i].chartID,
        results[i],
        chartMetadata[i].dataKey,
        colors
      );

      renderLegend(chartMetadata[i].chartName, width, svg, results[i], colors);
    }
  });
}