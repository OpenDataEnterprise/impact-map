import $ from 'jQuery';

export function counter (options) {
  options = $.extend({}, $.fn.countTo.defaults, options || {});

  var loops = Math.ceil(options.speed / options.refreshInterval);
  var increment = (options.to - options.from) / loops;

  return $(this).each(function () {
    var _this = this;
    var loopCount = 0;
    var value = options.from;
    var interval = setInterval(function () {
      value += increment;
      loopCount++;
      $(_this).html(value.toFixed(options.decimals));

      if (typeof(options.onUpdate) == 'function') {
        options.onUpdate.call(_this, value);
      }

      if (loopCount >= loops) {
        clearInterval(interval);
        value = options.to;

        if (typeof(options.onComplete) == 'function') {
          options.onComplete.call(_this, value);
        }
      }
    }, options.refreshInterval);
  });
};

export function renderCounter (type, value, config) {
  var apiBaseURL = config.apiBaseURL;
  var encodedValue = encodeURIComponent(value);

  $.fn.countTo = counter;

  $.fn.countTo.defaults = {
    from: 0,  // the number the element should start at
    to: 100,  // the number the element should end at
    speed: 1000,  // how long it should take to count between the target numbers
    refreshInterval: 100,  // how often the element should be updated
    decimals: 0,  // the number of decimal places to show
    onUpdate: null,  // callback method for every time the element is updated,
    onComplete: null,  // callback method for when the element finishes updating
  };

  var countQueryURL = apiBaseURL + type + '/' + encodedValue +
    '/total-organizations';
  $.ajax({
    url: countQueryURL,
    success: function (result) {
      let count = result['organization_count'];

      $('#stattss').countTo({
        from: 0,
        to: count,
        speed: 1400,
        refreshInterval: 10,
        onComplete: function (value) {
          console.debug(this);
        }
      });
    },
    error: function (xhr, status, error) {
      console.error(error);
    },
  });
}

export function renderHomeCounters (config) {
  var apiBaseURL = config.apiBaseURL;

  $.fn.countTo = counter;

  $.fn.countTo.defaults = {
    from: 0,  // the number the element should start at
    to: 100,  // the number the element should end at
    speed: 1000,  // how long it should take to count between the target numbers
    refreshInterval: 100,  // how often the element should be updated
    decimals: 0,  // the number of decimal places to show
    onUpdate: null,  // callback method for every time the element is updated,
    onComplete: null,  // callback method for when the element finishes updating
  };

  var queryURL = apiBaseURL + 'impact-map/stats';
  $.ajax({
    url: queryURL,
    success: function (result) {
      $('#country-stat').countTo({
        from: 0,
        to: result['country_count'],
        speed: 1400,
        refreshInterval: 10,
        onComplete: function(value) {
          console.debug(this);
        },
      });

      $('#case-stat').countTo({
        from: 0,
        to: result['organization_count'],
        speed: 1400,
        refreshInterval: 10,
        onComplete: function (value) {
          console.debug(this);
        },
      });
    },
    error: function (xhr, status, error) {
      console.error(error);
    },
  });
}