/** @jsx React.DOM */
define(['react'],function(React2){
	'use strict';

	var SelectableGroup = React.createClass({
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
			var radios = props.items.map(function(item,index){
				var classString = [props.uiClass]
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
		React.render(<SelectableGroup keys={props} />, document.getElementById(id));
	}
});