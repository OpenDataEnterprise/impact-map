import { config } from 'config/config';
import { applicationTooltips } from 'tooltips/applicationTooltips';
import { dataTypeTooltips } from 'tooltips/dataTypeTooltips';
import { renderBarChart } from 'vis/renderBarCharts';
import { renderCounter } from 'vis/renderCounters';
import { renderDonutCharts } from 'vis/renderDonutCharts';
import { renderUseCases } from 'vis/renderUseCases';

export function renderSectorPage (sector) {
  let apiBaseURL = config.apiBaseURL;
  let encodedSector = encodeURIComponent(sector);
  let dataTypeQueryURL = apiBaseURL + 'sector/' + encodedSector + '/data-types';
  let applicationQueryURL = apiBaseURL + 'sector/' + encodedSector +
    '/organization-applications';
  let margin = { top: 15, right: 0, bottom: 45, left: 50 };

  renderCounter('sector', sector, config);
  renderBarChart(1160, 400, margin, 'dataTypeBar', 'data_type',
    dataTypeQueryURL, '#50b094', '0.8em', 30, true, dataTypeTooltips, config);
  renderDonutCharts('sector', sector, config);
  renderBarChart(400, 300, margin, 'appBar', 'application', applicationQueryURL,
    '#375f7a', '1.1em', 30, true, applicationTooltips, config);
  renderUseCases('sector', sector, config);
}