$.when( $.ajax( "js-custom/countUp/home_country_ticker.php" ) ).done(function() {
    function count1($this){
        var current1 = parseInt($this.html(), 10);

    $this.html(current1 = current1 + 10); // set the interval for country - bigger the quicker
      if(current1 > $this.data('count1')){
          $this.html($this.data('count1'));
      } else {    
          setTimeout(function(){count1($this)}, 50); //set the timeout for country
      }
    } 
          
$("#country-stat").each(function() {
  $(this).data('count1', parseInt($(this).html(), 10));
  $(this).html('0');
  count1($(this));
 });

});