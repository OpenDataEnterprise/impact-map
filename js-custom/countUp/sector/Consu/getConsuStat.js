function insertCaseStat() {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp1 = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp1 = new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp1.onreadystatechange = function() {
            if (xmlhttp1.readyState == 4 && xmlhttp1.status == 200) {
                document.getElementById('stattss').innerHTML = xmlhttp1.responseText;
                // console.log(xmlhttp.responseText);
            }
        };

        xmlhttp1.open("GET", "js-custom/countUp/sector/Consu/Consu_ticker.php", true);
        xmlhttp1.send();
    }

 insertCaseStat();


// setTimeout(function () {
//         //get the current stat number on the page - supposed to be done after PHP grabbed and inserted the value
//         var countryStat = parseInt(document.getElementById('country-stat').innerHTML); 
//         var caseStat = parseInt(document.getElementById('case-stat').innerHTML); 

//         // console.log(countryStat);

//         // count from 1
//         var a = 1;
//         var b = 1;
//         // function for counting up one by one
//         function call1() {
//             // set the stat to current counter value "b"
//             document.getElementById('country-stat').innerHTML = a.toString();
//             a++; // add one to the counter
//             setTimeout(function() {
//                 // if smaller, continue counting
//                 if (a <= countryStat) call1();
//             },9);
//         };
//         function call2() {
//             // set the stat to current counter value "b"
//             document.getElementById('case-stat').innerHTML = b.toString();
//             b=b+10; // add one to the counter
//             setTimeout(function() {
//                 // if smaller, continue counting
//                 if (b <= caseStat) call2();
//             },1);
//         };

//         // call function to count
//         call1();
//         call2();
//     }, 50);
 

