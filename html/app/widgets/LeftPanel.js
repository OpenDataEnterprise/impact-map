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
		    	//selectedTab: 'statistics', //Changed by Vinayak 07.13.16 to Remove Statistics
		    	selectedTab: 'filter',		//Changed by Vinayak 07.13.16 to Remove Statistics
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
			//console.log('inside select accordian');
			var filters = this.props.keys.accordian.items;
			var selected = filters[index].selected ? index: -1;
			this.setState({selectedAccordian:selected});
		},

		switchTabs: function(tab){
			this.setState({selectedTab:tab.value})
		},

		selectFilter: function(filterGroup){

			//console.log('inside selectfilter');
			//console.log('filterGroup', filterGroup);

			var me = this;
			//console.log('me', me);
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

			//console.log('curSelected',curSelected);

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
			

			//accFlag = 0; //test
			var accordianItems = accordian.items.map(function(accordianItem,accIndex){
				var filterOptions = accordianItem.items.map(function(filterItem,filterIndex){
				 	var childKey = filterItem.value + filterIndex.toString() + accIndex.toString();

				 // 	if (state.selectedAccordian == 4 && filterItem.value == "Low income"){
					// 	 		console.log(filterItem);//Vinayak
					// 	 		console.log(accordianItem);
						 		
					// 	 	filterItem.selected = true;
					// }
				 	//console.log('renderAccordian filterItem',filterItem);///Vinayak
				 	//console.log('renderAccordian First selectable item call');

				 	//test
/*					return(
						React.createElement(SelectableItem, {key: filterIndex, keys: filterItem})
					) */

/*				 	if (filterItem.fieldName != 'machine_read')
				 	{
				 	//console.log('renderAccordian != machine_read');
						return(
							React.createElement(SelectableItem, {key: filterIndex, keys: filterItem})
						) 
					}
					else
					{	
					//	console.log('renderAccordian == machine_read');
						return null
					}
*/
						return(
							React.createElement(SelectableItem, {key: filterIndex, keys: filterItem})
						) 

				})

				 //	console.log('renderAccordian accordianItems',accordianItems);///Vinayak
				 //	console.log('renderAccordian filterOptions',filterOptions);///Vinayak

				var divStyle = state.selectedAccordian === accIndex ? {} : {display:'none'};

				accordianItem.selected = state.selectedAccordian === accIndex
				accordianItem.toggle = true;

				//console.log('renderAccordian Second selectable item call', accordianItem);
				//test
/*				return( 
					React.createElement("div", {className: 'br-accordian'}, 
						React.createElement(SelectableItem, {key: accIndex, keys: accordianItem}
						), 
						React.createElement("div", {className: "accordian-content", style: divStyle}, 
							filterOptions
						)
					)
				);*/
/*				if(accordianItem.value != 'machineread')
				{
				return( 
					React.createElement("div", {className: 'br-accordian'}, 
						React.createElement(SelectableItem, {key: accIndex, keys: accordianItem}
						), 
						React.createElement("div", {className: "accordian-content", style: divStyle}, 
							filterOptions
						)
					)
				);
				}
				else
				{
					return null
				}*/


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

		//Added by Vinayak 07.18.16
		//For Machine Readable Accordian
		renderAccordian_mac: function(accordian,state){
			// accFlag = 1; //test
			var accordianItems = accordian.items.map(function(accordianItem,accIndex){
				var filterOptions = accordianItem.items.map(function(filterItem,filterIndex){
				 	var childKey = filterItem.value + filterIndex.toString() + accIndex.toString();

				 	//console.log('renderAccordian_mac childKey',childKey);///Vinayak
				 	//console.log('renderAccordian_mac filterItem',filterItem);///Vinayak
				 	//console.log('renderAccordian_mac First selectable item call');
				 	
				 	//test
/*				 	return(
						React.createElement(SelectableItem, {key: filterIndex, keys: filterItem})
					) */

					//console.log('renderAccordian_mac filterItem.fieldname', filterItem.fieldName);
				 	if (filterItem.fieldName == 'machine_read')
				 	{
						return(
							React.createElement(SelectableItem, {key: filterIndex, keys: filterItem})
						) 
					}
					else
					{	
					//	console.log('renderAccordian_mac no machine_read');
						return null}
					
				})

				 	//console.log('renderAccordian_mac accordianItems',accordianItems);///Vinayak
				 	//console.log('renderAccordian_mac filterOptions',filterOptions);///Vinayak

				var divStyle = state.selectedAccordian === accIndex ? {} : {display:'none'};

				accordianItem.selected = state.selectedAccordian === accIndex
				accordianItem.toggle = true;

				//console.log('renderAccordian_mac Second selectable item call', accordianItem.value);
				//test

/*				return( 
					React.createElement("div", {className: 'br-accordian'}, 
						React.createElement(SelectableItem, {key: accIndex, keys: accordianItem}
						), 
						React.createElement("div", {className: "accordian-content", style: divStyle}, 
							filterOptions
						)
					)
				);*/
				if(accordianItem.value == 'machineread')
				{
				return( 
					React.createElement("div", {className: 'br-accordian'}, 
						React.createElement(SelectableItem, {key: accIndex, keys: accordianItem}
						), 
						React.createElement("div", {className: "accordian-content", style: divStyle}, 
							filterOptions
						)
					)
				);
				}
				else
				{
					return null
				}

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
							//console.log('filterOptions',filterOptions);
			});

			//console.log('accordian',accordian);
			//console.log('accordianItems',accordianItems);


			this.props.keys.clearFilter();
			this.forceUpdate();
			this.props.keys.closePopups();
		},

		submitSearch: function(args){
			var searchValue = document.getElementById("search-box").value
			this.props.keys.setSearchFilter(searchValue);
		},



		render:function(){

			//console.log(props);

			var props = this.props.keys;
			var handleClick = this.handleClick;
			var state = this.state;
			var setState = this.setState;
			var self = this;

			//commented as functionality not required
			/*if (state.selectedAccordian == 4){
				props.accordian.items.forEach(function(item,index){
					//Myeong -- for now, the framework does not allow openning two filters.
					// console.log(item);
					// if (item.value == "country_income"){
					// 	self.selectAccordian(index);
					// }
					item.changed = function(args){
						self.selectAccordian(index);
					}

					item.items.forEach(function(subitem){
						if (state.cleared){
							subitem.selected = false;
						}

					//console.log('subitem',subitem);
						// myeong, 7/25
						if (subitem.value == "Low income" || subitem.value == "Low middle income" || subitem.value == "Lower middle income"){
						//if (subitem.value == "Yes"){
							subitem.selected = true;
							self.selectFilter(item);
						}
						subitem.changed = function(args){
							self.selectFilter(item);
						}
					});
				});
			} else {
				props.accordian.items.forEach(function(item,index){
					item.changed = function(args){
						self.selectAccordian(index);
					}
					item.items.forEach(function(subitem){
						if (state.cleared){
							subitem.selected = false;
						}
						subitem.changed = function(args){
							//console.log('inside leftpanel render before calling self.selectFilter(item)',self);
							self.selectFilter(item);
						}
					});
				});
			}*/

			if (state.selectedAccordian == 1){
				props.accordian.items.forEach(function(item,index){
					//Myeong -- for now, the framework does not allow openning two filters.
					// console.log(item);
					// if (item.value == "country_income"){
					// 	self.selectAccordian(index);
					// }
					//To reorder the country income level values from high income to low income by Vinayak					
					if(item.value == 'country_income'){
						if (item.items[3].value == 'Upper middle income') 
						{
						var temp = item.items[1];
						item.items[1] = item.items[3];
						item.items[3] = temp;
						}
					}

					item.changed = function(args){
						self.selectAccordian(index);
					}

					item.items.forEach(function(subitem){
						if (state.cleared){
							subitem.selected = false;
						}

					//console.log('subitem',subitem);
						// myeong, 7/25
/*						if (subitem.value == "Low income" || subitem.value == "Low middle income" || subitem.value == "Lower middle income"){
						//if (subitem.value == "Yes"){
							subitem.selected = true;
							self.selectFilter(item);
						}*/
						subitem.changed = function(args){
							self.selectFilter(item);
						}
					});
				});
			} else {
				props.accordian.items.forEach(function(item,index){
					item.changed = function(args){
						self.selectAccordian(index);
					}
					item.items.forEach(function(subitem){
						if (state.cleared){
							subitem.selected = false;
						}
						subitem.changed = function(args){
							//console.log('inside leftpanel render before calling self.selectFilter(item)',self);
							self.selectFilter(item);
						}
					});
				});
			}

/*
			props.accordian.items.forEach(function(item,index){
					item.changed = function(args){
						self.selectAccordian(index);
					}
					item.items.forEach(function(subitem){
						if (state.cleared){
							subitem.selected = false;
						}
						subitem.changed = function(args){
							//console.log('inside leftpanel render before calling self.selectFilter(item)',self);
							self.selectFilter(item);
						}
					});
				});
*/
			var accordianItems = this.renderAccordian(props.accordian,state);
			//Added csv json
			//var accordianItems2 = this.renderAccordian(props.accordian2,state);
				//Added by Vinayak 07.18.16
			//var accordianItems_mac = this.renderAccordian_mac(props.accordian,state);

			//console.log("accordianItems", accordianItems);
			//console.log("accordianItems_mac", accordianItems_mac);

			//Changed by Vinayak 07.13.16 to Remove Statistics
			//var accordianDisplay = props.tabs.items[1].value == this.state.selectedTab ? {}:{display:'none'};
			
			//To remove filters
			//var accordianDisplay = props.tabs.items[0].value == this.state.selectedTab ? {}:{display:'none'};
			var accordianDisplay = {};

			//console.log('accordianDisplay', accordianDisplay);
			//Commented by Vinayak 07.13.16 to Remove Statistics
			//var statsDisplay = props.tabs.items[0].value == this.state.selectedTab ? {}:{display:'none'};
			//props.tabs.changed = this.switchTabs;

			//console.log("before return accordianItems",accordianItems);

			
			return (
				React.createElement("div", {className: "left-panel-container absolute no-right no-left no-top no-bottom"}, 
					//React.createElement("div", {className: 'selectable-group-container'}, 	//Related to Statistics Tab				
						//React.createElement(SelectableGroup, {keys: props.tabs}), 			//Related to Statistics Tab
						React.createElement("div", {className: 'tab-content'}, 
							React.createElement("div", {className: 'input-container'}, 
								React.createElement("input", {id: "search-box", placeholder: 'Search: i.e. Org Name, Sector, Region', onChange: _.debounce(this.submitSearch, 500)})
							), 
							React.createElement("div", {className: 'accordian-container', style: accordianDisplay}, 
								accordianItems
							), 

							//Commented by Vinayak 07.13.16 to Remove Statistics
							/*React.createElement("div", {style: statsDisplay}, 
								React.createElement("div", {id: props.statisticsDiv})
							), 
							*/
							//End of Comment

							React.createElement("button", {className: 'export-button', onClick: this.clearFilters}, "Clear Filters"), 

							//test
/*							React.createElement("div", {className: 'accordian-container_mac', style: accordianDisplay}, 
								accordianItems_mac
							), */
							//React.createElement("button", {className: 'export-button', onClick: this.setMachine}, "Machine Readable"), 
							//Start of Comment by Vinayak 07.13.16
							//To remove download buttons
							React.createElement("button", {className: 'download-button',  onClick: props.exportTableData, id: 'export-button'}, "Download CSV Data"),
							React.createElement("button", {className: 'download-button',  onClick: props.exportTableDataJSON, id: 'export-button2'}, "Download JSON Data"),
							
							//added csv json
/*							React.createElement("div", {className: 'accordian-container',  style: accordianDisplay}, 
								accordianItems2
							),*/
							//React.createElement("button", {className: 'export-button', onClick: props.exportTableData, id: 'export-button'}, "Download filtered data - CSV"), 
							//React.createElement("button", {className: 'export-button', onClick: props.exportTableDataJSON, id: 'export-button-json'}, "Download filtered data - JSON"), 

							//****Add comma at the end of previous line if adding anything after this

							//Start of Comment by Vinayak 07.07.16
            				//To remove export map from filters
            				//To remove export maap from filters
							//React.createElement("button", {className: 'export-button', onClick: props.exportMap, id: 'export-map-button'}, "Export Map"), 
							//End of Comment by Vinayak 07.07.16
							//To remove Take Survey Button Vinayak Pande 07.12.16
							//React.createElement("button", {className: 'export-button', onClick: this.loadSurvey, id: 'survey-button'}, "Take Survey"), 
							
							//test
							//React.createElement("button", {className: 'export-button', onClick: }, "Machine Readability"),

							React.createElement("span", {className: 'license-holder'}, " ")

							//Start of Comment to remove license holder
/*							React.createElement("div", {className: 'license-holder'}, 
								//React.createElement("span", null, "The Open Data Impact Map, a project of the Center for Open Data Enterprise as part of the OD4D network, is licensed under ", React.createElement("a", {href: 'http://creativecommons.org/licenses/by-sa/4.0/'}, "Creative Commons Attribution-ShareAlike 4.0 International License"))
								React.createElement("span", null, "Some text Some text Some text Some text Some text Some text")
							
							)*///, 
							//React.createElement("div", {className: 'creative-commons-logo'})
						
						)
					//) //Related to Statistics Tab
				)
			);
		}
	});

	return function(props, id){
		return React.render(React.createElement(LeftPanel, {keys: props}), document.getElementById(id));
	}
});
//<button className={'export-button'} onClick={props.exportMap} id={'export-map-button'}>Export Map</button>
