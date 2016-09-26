$.when( $.ajax( "js-custom/countUp/home_country_ticker.php" ), $.ajax( "js-custom/countUp/home_case_ticker.php" ) ).done(function() {
    function count1($this){
        var current1 = parseInt($this.html(), 10);
        // console.log(current1);

    $this.html(current1 = current1 + 10); // set the interval for country - bigger the quicker
      if(current1 > $this.data('count1')){
          $this.html($this.data('count1'));
      } else {    
          setTimeout(function(){count1($this)}, 50); //set the timeout for country
      }
    } 

     function count2($this){
        var current2 = parseInt($this.html(), 20);
        // console.log(current2);

    $this.html(current2 = current2 + 1); // set the interval for cases
      if(current2 > $this.data('count2')){
          $this.html($this.data('count2'));
      } else {    
          setTimeout(function(){count2($this)}, 25); // set the timeout for cases - smaller the quicker
      }
    }        

$("#country-stat").each(function() {
  $(this).data('count1', parseInt($(this).html(), 10));
  $(this).html('0');
  count1($(this));
 });

$("#case-stat").each(function() {
  $(this).data('count2', parseInt($(this).html(), 10));
  $(this).html('0');
  count2($(this));
 });

});