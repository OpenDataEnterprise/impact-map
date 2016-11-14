/** @jsx React.DOM */
define([],function(){
	'use strict';

	var Accordian = React.createClass({
		getInitialState: function() {
		    return {selected: 0};
		 },


		handleClick: function(index) {
		    this.setState({selected: index});
		 },

		render:function(){
			var props = this.props.keys;
			var handleClick = this.handleClick;
			var state = this.state;
			var accordians = props.items.map(function(item,index){
				var classString = ['br-radio']
				if (index === state.selected){
					classString.push('selected');
				}
				var click = function(){
					handleClick(index);
				};

				return(
					<div onClick={click} className={classString.join(' ')} value={item.value}>{item.label}
					</div>
				);
			});
			return (
				<div className={props.id}>
					{radios}
				</div>
			);
		}
	});
	return function(props, id){
		React.render(<Accordian keys={props} />, document.getElementById(id));
	}
});