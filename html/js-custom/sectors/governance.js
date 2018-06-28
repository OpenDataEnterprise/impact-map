(function ($, config) {
  var sector = 'Governance';

  renderCounter('sector', sector, config);
  renderDataTypeBarChart(sector, config);
  renderPieCharts('sector', sector, config);
  renderApplicationBarChart(sector, config);
  renderUseCases('sector', sector, config);
})(jQuery, config);