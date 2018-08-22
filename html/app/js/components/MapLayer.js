'use strict';

define([], function() {
  return {
    createDomObject: function() {
      $('leftPanel').append('<button class="'+id+'">'+name+"</button>");
    }
  }
});