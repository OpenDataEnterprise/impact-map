import { config } from 'config/config';
import { renderLandingChart } from 'vis/renderBarCharts';

(function (config) {
  let queryURL = config.apiBaseURL + 'sectors/total-organizations';
  renderLandingChart(1160, 400, 'sector-organizations-chart', 'sector',
    queryURL, '#a1af00', config);
})(config);