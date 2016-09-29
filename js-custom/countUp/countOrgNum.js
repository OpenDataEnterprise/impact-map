$.when( $.ajax( "js-custom/countUp/home_case_ticker.php" ) ).done(function() {

     function count2($this){
        var current2 = parseInt($this.html(), 20);

    $this.html(current2 = current2 + 1); // set the interval for cases
      if(current2 > $this.data('count2')){
          $this.html($this.data('count2'));
      } else {    
          setTimeout(function(){count2($this)}, 25); // set the timeout for cases - smaller the quicker
      }
      }        

$("#case-stat").each(function() {
  $(this).data('count2', parseInt($(this).html(), 10));
  $(this).html('0');
  count2($(this));
 });

});