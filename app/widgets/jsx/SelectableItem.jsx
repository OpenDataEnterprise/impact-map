/** @jsx React.DOM */
define(['react'],function(React2){
	'use strict';
	/*
	props: {
		classNames: Array<String>,
		selected: Boolean,
		changed: Function, //Optional
		label: String //Optional
	}
	*/

	var SelectableItem = React.createClass({
		getInitialState: function() {

		    return {selected: this.props.keys.selected || false};
		 },

		handleClick: function() {
				var props = this.props.keys;
				var selected = props.toggle ? !this.state.selected : true;
		    	this.setState({selected: selected });
		    	props.selected = selected;
		    	this.props.keys.changed && this.props.keys.changed(this.props.keys);
		 },

		//  componentWillReceiveProps: function(nextProps) {

		// },

		//  shouldComponentUpdate: function(nextProps, nextState) {

		// },

		render:function(){
			var props = this.props.keys;
			var handleClick = this.handleClick;
			var classNameArray = props.classNames || [];
			var selected = props.selected || false;
			var classString;
			if (this.props.keys.fieldName === 'data_type'){
			// debugger;
				
			}
			if (props.selected){
				classString = classNameArray.concat(['selected']).join(' ');
			}
			else{
				classString = classNameArray.join(' ')
			}
			

			return (
				<div onClick={handleClick} className={classString}>
					<span className={"company-title-label"}>{props.label}</span>
				</div>
			);
		}
	});
	return SelectableItem;
});