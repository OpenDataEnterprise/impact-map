/** @jsx React.DOM */
/***
	props={
		id:
	}
**/
define(['react'],function(React2){
	'use strict';
	var Switch = React.createClass({
		render:function(){
			var props = this.props.keys;
			return (
				<div className="switch">
					<label for={props.id}></label>
					<input id={props.id} type="checkbox" onChange={props.onChange} />
				</div>
				
			);

		}
	});
	return function(props, id){
		React.render(<Switch keys={props} />, document.getElementById(id));
	}
});