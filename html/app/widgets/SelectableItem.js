/** @jsx React.DOM */
define([
	'react',
	'map/MapController'
	],function(
		React2,
		MapController
	){
	'use strict';
	/*
	props: {
		classNames: Array<String>,
		selected: Boolean,
		changed: Function, //Optional
		label: String //Optional
	}
	*/	
	//Added by Vinayak 07.18.16
	//Flag to indicate which accordian it is
	//var accFlag;// test

	var SelectableItem = React.createClass({displayName: "SelectableItem",
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
		
		//Added by Vinayak 07.19.16 to handle machine readable part
/*		handleClick_mac: function() {

				console.log('handleClick_mac props',this.props);

				var macfilter = this.props;

				var props = this.props.keys;
				var selected = props.toggle ? !this.state.selected : true;
		    	this.setState({selected: selected });
		    	props.selected = selected;
		    	this.props.keys.changed && this.props.keys.changed(this.props.keys);
		    	
		    	//console.log('handleClick_mac props',props);				
		 },*/
		 //End of Addition by Vinayak

		//  componentWillReceiveProps: function(nextProps) {

		// },

		//  shouldComponentUpdate: function(nextProps, nextState) {

		// },

		render:function(){
			var props = this.props.keys;
			var handleClick = this.handleClick;
			
			//Added by Vinayak
			var handleClick_mac = this.handleClick_mac;

			var selectFilter = this.selectFilter;

			var classNameArray = props.classNames || [];
			var selected = props.selected || false;
			var classString;

			//console.log('this.props.keys.fieldName', this.props.keys.fieldName);//Vinayak
			//console.log('this.props.keys.value', this.props.keys.value);//Vinayak
			//console.log('this.props.keys', this.props.keys.value);//Vinayak


			if (this.props.keys.fieldName === 'data_type'){
			// debugger;
				
			}

			if (props.selected){
				classString = classNameArray.concat(['selected']).join(' ');
			}
			else{
				classString = classNameArray.join(' ')
			}
			
			//console.log('props.label', props.label);//Vinayak
			//console.log('this.props', this.props);//Vinayak
			//console.log('classString', this.classString);//Vinayak

			//This is worinking
/*
			return (
				React.createElement("div", {onClick: handleClick, className: classString}, 
					React.createElement("span", {className: "company-title-label"}, props.label)
				)
			);*/
			//This is working

			//test2

			//console.log('this.props.keys',this.props.keys.value);

			//console.log('this.props.keys.label', this.props.keys.label);

			//start of change MCR
/*			if (this.props.keys.label == 'NA')// || this.props.keys.value === 'machineread')//test
			{
			console.log('inside NA');
			return (	
				React.createElement("div", {className: null},

				React.createElement("div", {className: 'machine-text'}, 
					React.createElement("span", null, "The Machine Readability Projects shows uses of machine-readable open government data in low and lower middle income countries."))
				)

			);
			}*/

			if (this.props.keys.label == 'Yes')// || this.props.keys.value === 'machineread')//test
			{
			//console.log('inside Yes');
/*			return (	
				React.createElement("div", {className: null},

				React.createElement("div", {className: 'machine-text'}, 
					React.createElement("span", null, "The Machine Readability Projects shows uses of machine-readable open government data in low and lower middle income countries."))
				)

			);*/
			return (
			React.createElement("div", {onClick: handleClick, className: classString}, 
					React.createElement("span", {className: "company-title-label"}, "The Machine Readability Project, supported by the World Bank, displays use cases in low-middle income countries using machine readable open data.")
				));

			}

			else if (this.props.keys.value === 'machineread')
			{
							//console.log('inside machineread');
					return (
						React.createElement("div", {onClick: handleClick, className: classString}, 
								React.createElement("span", {className: "company-title-label"}, props.label))

						);


			}
			//else if (this.props.keys.label == 'Yes' || this.props.keys.label == 'No')
			else if (this.props.keys.label == 'No' || this.props.keys.label == 'NA')
			{
							//console.log('inside yes and no');
				return null
			}
			else
			{
			//console.log('false',this.props.keys);//Vinayak
			return (
				React.createElement("div", {onClick: handleClick, className: classString}, 
					React.createElement("span", {className: "company-title-label"}, props.label)
				));
			}

			//test
/*			if (this.props.keys.fieldName === 'machine_read' || this.props.keys.value === 'machineread')//test
			{
			console.log('true',this.props.keys);//Vinayak
			return null	
			}
			else
			{
			console.log('false',this.props.keys);//Vinayak
			return (
				React.createElement("div", {onClick: handleClick, className: classString}, 
					React.createElement("span", {className: "company-title-label"}, props.label)
				)
			);
			}*/
			//test
		}
	});
	return SelectableItem;
});