setTimeout( function() {
$.when( $.ajax( "js-custom/countUp/home_country_ticker.php" ), $.ajax( "js-custom/countUp/home_case_ticker.php" ) ).done(function() {
    function count1($this){
        var current = parseInt($this.html(), 10);
        current = current + 1; // set the interval

    $this.html(++current);
      if(current > $this.data('count1')){
          $this.html($this.data('count1'));
      } else {    
          setTimeout(function(){count1($this)}, 20); //set the timeout
      }
    }        

$(".stat").each(function() {
  $(this).data('count1', parseInt($(this).html(), 10));
  $(this).html('0');
  count1($(this));
 });

});

}, 1000);
