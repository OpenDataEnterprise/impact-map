import { config } from 'config/config';
import { renderBarChart } from 'vis/renderBarCharts';
import { renderCounter } from 'vis/renderCounters';
import { renderDonutCharts } from 'vis/renderDonutCharts';
import { renderRegionOrgMap } from 'vis/renderRegionOrgMap';
import { renderUseCases } from 'vis/renderUseCases';

export function renderRegionPage (region, barChartWidth, barChartHeight,
  bounds, view, regionGeoJSON) {
  let apiBaseURL = config.apiBaseURL;
  let encodedRegion = encodeURIComponent(region);
  let queryURL = apiBaseURL + 'region/' + encodedRegion +
    '/organization-sectors';
  let margin = { top: 15, right: 0, bottom: 45, left: 50 };

  renderCounter('region', region, config);
  renderRegionOrgMap(region, regionGeoJSON, bounds, view, config);
  renderDonutCharts('region', region, config);
  renderBarChart(barChartWidth, barChartHeight, margin, 'bar', 'sector',
    queryURL, '#375f7a', '1.1em', 30, true, null, config);
  renderUseCases('region', region, config);
}