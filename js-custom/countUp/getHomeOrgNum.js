
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp1 = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp1 = new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp1.onreadystatechange = function() {
            if (xmlhttp1.readyState == 4 && xmlhttp1.status == 200) {
                document.getElementById('case-stat').innerHTML = xmlhttp1.responseText;
                // console.log(xmlhttp.responseText);
            }
        };

        xmlhttp1.open("GET", "js-custom/countUp/home_case_ticker.php", true);
        xmlhttp1.send();


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