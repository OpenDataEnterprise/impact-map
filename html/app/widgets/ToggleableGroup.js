/** @jsx React.DOM */
define(['react'],function(React2){
	'use strict';

	var ToggleableGroup = React.createClass({displayName: "ToggleableGroup",
		getInitialState: function() {
		    return {selected: 0};
		 },

		 handleChange: function(selectedItems){
			var props = this.props.keys
			if (selectedItems.length){
		   		props.changed(selectedItems,props.items[0].fieldName);
			}
			else{
				props.changed([],props.items[0].fieldName);
			}

		 },


		handleClick: function(clickedItem) {
			var curSelected = this.props.keys.items.filter(function(item){
				if (item == clickedItem ){
					item.selected = !item.selected;
				}
				if (item.selected){
					return true;
				}
			});

		    	this.setState({selected: curSelected});
		    	this.handleChange(curSelected);

		    // this.props.changed(index);
		 },

		render:function(){
			var props = this.props.keys;
			var handleClick = this.handleClick;
			var state = this.state;
			var radios = props.items.map(function(item,index){
				var classString = [props.uiClass]
				if (item.selected){
					classString.push('selected');
				}
				var click = function(){
					handleClick(item);
				};
				var innerContent = props.idPrefix ? React.createElement("div", {className: "innerContent", id: props.idPrefix+item.value}) : "";

				return(
					React.createElement("div", {onClick: click, className: classString.join(' '), value: item.value}, 
						React.createElement("div", {className: props.idPrefix+"-label"}, 
							item.label
						), 
						innerContent
					)
				);
			});
			return (
				React.createElement("div", null, 
					React.createElement("div", {className: props.id}, 
						radios
					)
				)
			);
		}
	});
	// return function(props, id){
	// 	React.render(<ToggleableGroup keys={props} />, document.getElementById(id));
	// }
	return ToggleableGroup;
});