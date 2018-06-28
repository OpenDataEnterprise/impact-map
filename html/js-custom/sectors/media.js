(function ($, config) {
  var sector = 'Media and communications';

  renderCounter('sector', sector, config);
  renderDataTypeBarChart(sector, config);
  renderPieCharts('sector', sector, config);
  renderApplicationBarChart(sector, config);
  renderUseCases('sector', sector, config);
})(jQuery, config);