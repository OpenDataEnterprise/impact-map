import * as d3 from 'd3';
import d3Tip from 'd3-tip';

function wrap (text, width) {
  text.each(function () {
    let text = d3.select(this),
    words = text.text().split(/\s+/).reverse(),
    word,
    line = [],
    lineNumber = 0,
    lineHeight = 1.1, // ems
    y = text.attr('y'),
    dy = parseFloat(text.attr('dy')),
    tspan = text.text(null)
      .append('tspan')
      .attr('x', 0)
      .attr('y', y)
      .attr('dy', dy + 'em');

    while (word = words.pop()) {
      line.push(word);
      tspan.text(line.join(' '));

        if (tspan.node().getComputedTextLength() > width) {
          line.pop();
          let joinedText = line.join(' ');

          if (joinedText) {
            tspan.text(joinedText);
            tspan = text.append('tspan')
              .attr('x', 0)
              .attr('y', y)
              .attr('dy', ++lineNumber * lineHeight + dy + 'em')
              .text(word);
          }

          line = [word];
        }
    }
  });
}

export function renderBarChart (width, height, margin, chartID, dataKey,
  queryURL, barColor, labelSize, labelPadding, yLabel, tooltips, config) {
  let chartWidth = width - margin.left - margin.right;
  let chartHeight = height - margin.top - margin.bottom;

  let xScale = d3.scaleBand().rangeRound([0, chartWidth]).padding(0.1);
  let yScale = d3.scaleLinear().rangeRound([chartHeight, 0]);

  let xAxis = d3.axisBottom(xScale).tickSizeInner([0]);
  let yAxis = d3.axisLeft(yScale).ticks(5);

  let svg = d3.select('#' + chartID).append('svg');

  svg.attr('width', width).attr('height', height);

  let chartWrapper = svg.append('g')
    .attr('transform', 'translate(' + margin.left + ',' + margin.top + ')');

  d3.json(queryURL).then(function (data) {
    data.sort(function (a, b) {
        return b.organization_count - a.organization_count;
      });

    xScale.domain(data.map(function (d) {
      if (d.organization_count > 0) {
        return d[dataKey];
      }
    }));

    yScale.domain([0, d3.max(data, function (d) {
      return d.organization_count;
    })]);

    let chartX = chartWrapper.append('g')
      .attr('class', 'x axis')
      .attr('transform', 'translate(0,' + chartHeight + ')')
      .call(xAxis)
      .selectAll('.tick text')
      .call(wrap, xScale.bandwidth())
      .style('font-size', labelSize);

    let chartY = chartWrapper.append('g')
      .attr('class', 'y axis')
      .call(yAxis)
      .append('text')
      .attr('transform', 'rotate(-90)')
      .attr('dx', '-3em')
      .attr('dy', '-3em')
      .style('fill', 'black')
      .style('font-size', '1.2em')
      .style('text-anchor', 'end');

    if (yLabel) {
      chartY.text('Number of Organizations');
    }

    let tooltip = d3.select(svg.node())
      .append('g')
      .attr('class', 'tooltip')
      .style('visibility', 'hidden');

    chartWrapper.selectAll('.bar')
      .data(data)
      .enter().append('rect')
      .attr('class', 'bar')
      .attr('x', function (d) {
        return xScale(d[dataKey]);
      })
      .attr('width', xScale.bandwidth())
      .attr('y', function (d) {
        return yScale(d.organization_count);
      })
      .attr('height', function (d) {
        return chartHeight - yScale(d.organization_count);
      })
      .style('fill', barColor)
      .on('mouseover', function (d) {
        tooltip.style('visibility', 'visible');
        tooltip.select('text').text(d.organization_count);
      })
      .on('mousemove', function () {
        let x = d3.mouse(this)[0] + 50;
        let y = d3.mouse(this)[1] - 20;
        tooltip.attr('transform', 'translate(' + x + ',' + y + ')');
      })
      .on('mouseout', function () {
        tooltip.style('visibility', 'hidden');
      });

    if (tooltips) {
      // Assign tooltips.
      let tip = d3Tip()
        .attr('class', 'd3-tip')
        .offset([-10, 0])
        .html(function (d) {
          return tooltips[d];
        });

      chartWrapper.call(tip);

      // Attach mouse event triggers to show tooltips.
      chartWrapper.select('.x.axis')
        .selectAll('.tick')
        .on('mouseover', tip.show)
        .on('mouseout', tip.hide);
    }
  });
}

export function renderLandingChart (width, height, chartID, dataKey, queryURL,
  barColor, config) {
  const margin = { top: 0, right: 0, bottom: 150, left: 50 };
  renderBarChart(width, height, margin, chartID, dataKey, queryURL, barColor,
    '1em', 0, false, null, config);
}