/** @jsx React.DOM */
define(['react'],function(React2){
	'use strict';

	var ToggleableGroup = React.createClass({
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
				var innerContent = props.idPrefix ? <div className='innerContent' id={props.idPrefix+item.value}></div> : "";

				return(
					<div  onClick={click} className={classString.join(' ')} value={item.value}>
						<div  className={props.idPrefix+"-label"}>
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
	// return function(props, id){
	// 	React.render(<ToggleableGroup keys={props} />, document.getElementById(id));
	// }
	return ToggleableGroup;
});