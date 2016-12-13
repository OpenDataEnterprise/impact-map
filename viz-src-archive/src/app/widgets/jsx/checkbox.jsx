/** @jsx React.DOM */
define(['react'],function(React2){
	'use strict';
	var Checkbox = React.createClass({
		render:function(){
			var props = this.props.keys;
			return (
				<div>
					<h2>{props.title}</h2>
					<p>{props.name}</p>
				</div>
			);
		}
	});
	return function(props, id){
		React.render(<Checkbox keys={props} />, document.getElementById(id));
	}
});