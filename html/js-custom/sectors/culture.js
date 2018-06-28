(function ($, config) {
  var sector = 'Arts, culture and tourism';

  renderCounter('sector', sector, config);
  renderDataTypeBarChart(sector, config);
  renderPieCharts('sector', sector, config);
  renderApplicationBarChart(sector, config);
  renderUseCases('sector', sector, config);
})(jQuery, config);