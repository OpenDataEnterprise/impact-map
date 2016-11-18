/**
 * Created by jnordling on 12/14/14.
 */
define([],function(){
   return{
       layers :[
           {
               'name': 'Layer1',
               'url': '#'
           },
           {
               'name':'Layer2',
               'url':'#'
           },
           {
               'name':'Layer3',
               'url':'#'
           }
       ],
       pannel_state: true,

       map_panels: [
          {
              selected: true, //Vintab
              value: 'map',
              label: 'Map'
          },
          {
              selected: false, //Vintab
              value: 'Table',
              label: 'Table'
          }

       ],

       panels: [
      //Commented by Vinayak 07.13.16 to Remove Statistics
/*        {
               selected: false, //true, 
               value: 'statistics',
               label: 'Statistics'
           },*/
      //End of Comment
/*          {
              selected: true, //false, //Changed by Vinayak 07.13.16 to Remove Statistics
              value: 'filter',
              label: 'Filter'
          }*/
          //,
          // {
          //     selected: true,
          //     value: 'details',
          //     label: 'Details'
          // }
       ],

       
   }
});