/** @jsx React.DOM */
define(['react'],function(React2){
	'use strict';

	var SelectableGroup = React.createClass({
		getInitialState: function() {
			var selected = 0;
			_.forEach(this.props.keys.items, function(item, index){ if(item.selected){selected = index}})
		    return {selected: selected};
		 },

		 handleChange: function(index){
			var props = this.props.keys
		    props.changed(props.items[index]);

		 },


		handleClick: function(index) {
			var changed = this.state.selected != index;
			if (changed){
		    	this.setState({selected: index});
		    	this.handleChange(index);
			}

		    // this.props.changed(index);
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
				var innerContent = props.idPrefix ? <div className='innerContent' id={props.idPrefix+item.value}></div> : "";

				var classNameArray = [props.idPrefix+"-label",item.value].join(' ');
				return(
					<div  onClick={click} className={classString.join(' ')} value={item.value}>
						<div className={classNameArray}>
							{item.label}
						</div>
						{innerContent}
					</div>
				);
			});
			
			return (
				<div>
					<div className={props.id}>
						{radios}
					</div>
				</div>
			);
		}
	});
	return SelectableGroup
});