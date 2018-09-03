import { config } from 'config/config';
import { renderLandingChart } from 'vis/renderBarCharts';

(function (config) {
  let queryURL = config.apiBaseURL + 'regions/total-organizations';
  renderLandingChart(600, 400, 'region-organizations-chart', 'region',
    queryURL, '#50b094', config);
})(config);