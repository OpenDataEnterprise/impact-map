/** @jsx React.DOM */
define([
	'react',
	'widgets/SelectableGroup',
    'widgets/SelectableItem'
 ],function(
 	React2,
 	SelectableGroup,
 	SelectableItem
 ){
	'use strict';
	var applicationState;

	var LeftPanel = React.createClass({displayName: "LeftPanel",
		getInitialState: function() {
		    return {
		    	selected: 0,
		    	selectedTab: 'statistics',
		    	selectedAccordian: -1,
		    	cleared: false
		    };
		},

		handleChange: function(selectedItems){
			

		},

		loadSurvey: function(){
			var url = 'http://opendataenterprise.org/map/survey';
			window.open(url, '_blank');
		},

		selectAccordian: function(index){
			var filters = this.props.keys.accordian.items;
			var selected = filters[index].selected ? index: -1;
			this.setState({selectedAccordian:selected});
		},

		switchTabs: function(tab){
			this.setState({selectedTab:tab.value})
		},

		selectFilter: function(filterGroup){

			var me = this;
			//have to determine if application lost a value
			if(filterGroup.value == 'dataApplication'){

				if(!applicationState){
					applicationState = _.map(filterGroup.items, _.clone)
					_.forEach(applicationState, function(item){
						item.selected = false;
					})
				}
				//check if filtergroup.item lost and item
				var previouslySelected = _.where(applicationState, {selected: true});
				var currentlySelected = _.where(filterGroup.items, {selected: true});
				applicationState = _.map(filterGroup.items, _.clone);
				if (currentlySelected.length < previouslySelected.length) {
					//WE LOST ONE!

					var difference = [];
					_.forEach(previouslySelected, function(item){
						var bad = false;
						_.forEach(currentlySelected, function(current){
							if(current.label == item.label){
								bad = true;
							}
						})
						if(!bad){
							difference.push(item);
						}
					})
					_.forEach(difference, function(item){
						_.debounce(me.props.keys.selectFilter([],item.field), 500);
					})
				} else {
					//WE GAINED ONE

					var difference = [];
					_.forEach(currentlySelected, function(item){
						var bad = false;
						_.forEach(previouslySelected, function(current){
							if(current.label == item.label){
								bad = true;
							}
						})
						if(!bad){
							difference.push(item);
						}
					})
					_.forEach(difference, function(item){
						_.debounce(me.props.keys.selectFilter([item],item.field), 500);
					})
				}
			}

			if(filterGroup.value == 'ageorg'){

				var currentlySelected = _.where(filterGroup.items, {selected: true});
				var years = [];

				_.forEach(currentlySelected, function(item){

					var current_year = new Date().getFullYear();

					if (item.label == "0 - 10 years"){						
						_.forEach(_.range(10), function(i){
							years.push(current_year - i);		
						});
						item.value = years;						
					} else if (item.label == "11 - 20 years"){
						_.forEach(_.range(11,20), function(i){
							years.push(current_year - i);		
						});
						item.value = years;
					} else if (item.label == "21 - 30 years"){
						_.forEach(_.range(21,30), function(i){
							years.push(current_year - i);		
						});
						item.value = years;
					} else if (item.label == "30+ years"){
						_.forEach(_.range(31, 120), function(i){
							years.push(current_year - i);		
						});
						item.value = years;
					}
					_.debounce(me.props.keys.selectFilter([item], item.field), 500);
				});
			}

			var curSelected = filterGroup.items.filter(function(item){
				if (item.selected){
					return true;
				}
			});
			if(filterGroup.source){
				if(filterGroup.source.field){
					me.props.keys.selectFilter(curSelected,filterGroup.source.field);
				}
			}
		},

		componentWillReceiveProps: function(nextProps){
		},

		renderAccordian: function(accordian,state){
			var accordianItems = accordian.items.map(function(accordianItem,accIndex){
				var filterOptions = accordianItem.items.map(function(filterItem,filterIndex){
				 	var childKey = filterItem.value + filterIndex.toString() + accIndex.toString();
					return(
						React.createElement(SelectableItem, {key: filterIndex, keys: filterItem})
					) 
				})

				var divStyle = state.selectedAccordian === accIndex ? {} : {display:'none'};
				accordianItem.selected = state.selectedAccordian === accIndex
				accordianItem.toggle = true;
				return( 
					React.createElement("div", {className: 'br-accordian'}, 
						React.createElement(SelectableItem, {key: accIndex, keys: accordianItem}
						), 
						React.createElement("div", {className: "accordian-content", style: divStyle}, 
							filterOptions
						)
					)
				);
			});
			return accordianItems;
		},

		clearFilters: function(){
			var self = this;
			var accordian = this.props.keys.accordian;
			var accordianItems = accordian.items.map(function(accordianItem,accIndex){
				var filterOptions = accordianItem.items.map(function(filterItem,filterIndex){

					filterItem.selected = false;
				});
			});
			this.props.keys.clearFilter();
			this.forceUpdate();
			this.props.keys.closePopups();
		},

		submitSearch: function(args){
			var searchValue = document.getElementById("search-box").value
			this.props.keys.setSearchFilter(searchValue);
		},

		render:function(){
			var props = this.props.keys;
			var handleClick = this.handleClick;
			var state = this.state;
			var setState = this.setState;
			var self = this;
			props.accordian.items.forEach(function(item,index){
				item.changed = function(args){
					self.selectAccordian(index);
				}
				item.items.forEach(function(subitem){
					if (state.cleared){
						subitem.selected = false;
					}
					subitem.changed = function(args){
						self.selectFilter(item);
					}
				});
			});

			var accordianItems = this.renderAccordian(props.accordian,state);

			var accordianDisplay = props.tabs.items[1].value == this.state.selectedTab ? {}:{display:'none'};
			var statsDisplay = props.tabs.items[0].value == this.state.selectedTab ? {}:{display:'none'};
			props.tabs.changed = this.switchTabs;
			
			return (
				React.createElement("div", {className: "left-panel-container absolute no-right no-left no-top no-bottom"}, 
					React.createElement("div", {className: 'selectable-group-container'}, 
						React.createElement(SelectableGroup, {keys: props.tabs}), 
						React.createElement("div", {className: 'tab-content'}, 
							React.createElement("div", {className: 'input-container'}, 
								React.createElement("input", {id: "search-box", placeholder: 'search for organization', onChange: _.debounce(this.submitSearch, 500)})
							), 
							React.createElement("div", {className: 'accordian-container', style: accordianDisplay}, 
								accordianItems
							), 
							React.createElement("div", {style: statsDisplay}, 
								React.createElement("div", {id: props.statisticsDiv})
							), 
							React.createElement("button", {className: 'export-button', onClick: this.clearFilters}, "Clear Filters"), 
							React.createElement("button", {className: 'export-button', onClick: props.exportTableData, id: 'export-button'}, "Download filtered data - CSV"), 
							React.createElement("button", {className: 'export-button', onClick: props.exportTableDataJSON, id: 'export-button-json'}, "Download filtered data - JSON"), 
							React.createElement("button", {className: 'export-button', onClick: props.exportMap, id: 'export-map-button'}, "Export Map"), 
							React.createElement("button", {className: 'export-button', onClick: this.loadSurvey, id: 'survey-button'}, "Take Survey"), 
							React.createElement("div", {className: 'license-holder'}, 
								React.createElement("span", null, "The Open Data Impact Map, a project of the Center for Open Data Enterprise as part of the OD4D network, is licensed under ", React.createElement("a", {href: 'http://creativecommons.org/licenses/by-sa/4.0/'}, "Creative Commons Attribution-ShareAlike 4.0 International License"))
							), 
							React.createElement("div", {className: 'creative-commons-logo'})
						)
					)
				)
			);
		}
	});
	return function(props, id){
		return React.render(React.createElement(LeftPanel, {keys: props}), document.getElementById(id));
	}
});
//<button className={'export-button'} onClick={props.exportMap} id={'export-map-button'}>Export Map</button>
