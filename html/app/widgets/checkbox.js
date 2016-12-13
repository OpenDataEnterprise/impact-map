/** @jsx React.DOM */
define(['react'],function(React2){
	'use strict';
	var Checkbox = React.createClass({displayName: "Checkbox",
		render:function(){
			var props = this.props.keys;
			return (
				React.createElement("div", null, 
					React.createElement("h2", null, props.title), 
					React.createElement("p", null, props.name)
				)
			);
		}
	});
	return function(props, id){
		React.render(React.createElement(Checkbox, {keys: props}), document.getElementById(id));
	}
});