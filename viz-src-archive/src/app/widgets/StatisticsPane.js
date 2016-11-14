/** @jsx React.DOM */
define([
	'react',
	'widgets/SelectableGroup',
    'widgets/SelectableItem'
 ],function(
 	React2,
 	SelectableGroup,
 	SelectableItem
 ){
	'use strict';

	var StatisticsPane = React.createClass({displayName: "StatisticsPane",
		getInitialState: function() {
		    return {selected: 0,selectedTab: 0,selectAccordian:'filter'};
		 },

		 handleChange: function(selectedItems){
			

		 },


		// handleClick: function(clickedItem) {
			
		// 	return;
		//     // this.props.changed(index);
		//  },

		//  selectAccordian: function(index){
		//  	this.setState({selectedAccordian:index})
		//  },

		

		render:function(){
			var props = this.props.keys;
			var handleClick = this.handleClick;
			var state = this.state;
			var setState = this.setState;
			var self = this;


			var filterElements = props.filters ? props.filters.map(function(filter){
				return filter.label;
			}) : [];

			var filterText = filterElements.length ? "Filters: " + filterElements.join(', ') : 'Filters: Not Applied';

			var statElements = props.stats.map(function(field){
				var liArray = _.keys(field.count).map(function(key){
					var label = key + ": "+field.count[key];

					return(
						React.createElement("li", null, label)
					)
				});

				//order the outputs 'For-Profit', 'Nonprofit', 'Developer Group', 'Other'
				var tempLiArray = [];

				_.forEach(liArray,function(reacEl){
					if(reacEl.props){
						if(reacEl.props.children.match(/For-profit/ig)){
							tempLiArray.push(reacEl);
						}
					}
				})
				_.forEach(liArray,function(reacEl){
					if(reacEl.props){
						if(reacEl.props.children.match(/Nonprofit/ig)){
							tempLiArray.push(reacEl);
						}
					}
				})
				_.forEach(liArray,function(reacEl){
					if(reacEl.props){
						if(reacEl.props.children.match(/Developer/ig)){
							tempLiArray.push(reacEl);
						}
					}
				})
				_.forEach(liArray,function(reacEl){
					if(reacEl.props){
						if(reacEl.props.children.match(/Other/ig)){
							tempLiArray.push(reacEl);
						}
					}
				})
				return tempLiArray;
				
			});

			var totalCountries = ' Countries: ' + props.totalCountries;
			statElements.unshift(React.createElement("li", null, totalCountries))

			var totalLabel = 'Total Use Cases: ' + props.totalCases;
			statElements.unshift(React.createElement("li", null, totalLabel))

			statElements = _.flatten(statElements);

			return (
				React.createElement("div", null, 
					React.createElement("div", null, filterText), 
					React.createElement("ul", {className: props.id}, 
						statElements
					)
				)
			);
		}
	});
	return function(props, id){
		return React.render(React.createElement(StatisticsPane, {keys: props}), document.getElementById(id));
	}
});

