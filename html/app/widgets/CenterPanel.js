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

	var CenterPanel = React.createClass({displayName: "CenterPanel",
		getInitialState: function() {
		    return {
		    	selectedTab: 'map', //vintab
		    	//selectedTab: 'Table', //vintab
		    };
		},

		handleChange: function(selectedItems){
			

		},

		switchTabs: function(tab){
			this.setState({selectedTab:tab.value})
		},

		componentWillReceiveProps: function(nextProps){
		},

		loadSurvey:function(){
			var url = 'http://opendataenterprise.org/map/survey';
			window.open(url, '_blank');
		},

		render:function(){
			var props = this.props.keys;
			var handleClick = this.handleClick;
			var state = this.state;
			var setState = this.setState;
			var self = this;

			var mapDisplay = props.tabs.items[0].value == this.state.selectedTab ? {}:{display:'none'};

			var tableDisplay = props.tabs.items[1].value == this.state.selectedTab ? {}:{display:'none'};

			//console.log('mapDisplay',mapDisplay);
			//console.log('tableDisplay',tableDisplay);

			props.tabs.changed = this.switchTabs;
			
			return (
				React.createElement("div", {id: "mapArea", className: props.id}, 
					React.createElement(SelectableGroup, {keys: props.tabs}), 
					React.createElement("div", {id: props.mapId, style: mapDisplay}), 
					React.createElement("div", {id: props.tableId, style: tableDisplay}
					)
				)
			);
		}
	});
	return function(props, id){
		return React.render(React.createElement(CenterPanel, {keys: props}), document.getElementById(id));
	}
});