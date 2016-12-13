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
              selected: true,
              value: 'map',
              label: 'Map'
          },
          {
              selected: false,
              value: 'Table',
              label: 'Table'
          }

       ],

       panels: [
           {
               selected: true,
               value: 'statistics',
               label: 'Statistics'
           },
          {
              selected: false,
              value: 'filter',
              label: 'Filter'
          }
          //,
          // {
          //     selected: true,
          //     value: 'details',
          //     label: 'Details'
          // }
       ],

       
   }
});