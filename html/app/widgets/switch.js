/** @jsx React.DOM */
/***
	props={
		id:
	}
**/
define(['react'],function(React2){
	'use strict';
	var Switch = React.createClass({displayName: "Switch",
		render:function(){
			var props = this.props.keys;
			return (
				React.createElement("div", {className: "switch"}, 
					React.createElement("label", {for: props.id}), 
					React.createElement("input", {id: props.id, type: "checkbox", onChange: props.onChange})
				)
				
			);

		}
	});
	return function(props, id){
		React.render(React.createElement(Switch, {keys: props}), document.getElementById(id));
	}
});