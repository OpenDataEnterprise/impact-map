/** @jsx React.DOM */
define([
	'react',
	'widgets/SelectableItem'
 ],function(
 	React2,
 	SelectableItem
 ){
	'use strict';

	var CompanyPopup = React.createClass({displayName: "CompanyPopup",
		getInitialState: function() {
		    return {visibleContent:this.props.keys.showContent};
		 },

		 handleChange: function(selectedItems){

		 },

		 changedTitle: function(title){
		 	this.setState({visibleContent:title.selected});
		 },

		sendToEdit: function(){

			console.log("I am in CompanyPopup sendToEdit"); //Vinayak

			var profileId = this.props.keys.profileID.value
			console.log("profileId", profileId); //Vinayak
			
			var url = 'http://' + location.host + '/map/survey/edit/' + profileId;
			console.log(url);
			window.open(url, '_blank');
		},

		 
		render:function(){
			var props = this.props.keys;
			var state = this.state;
			var setState = this.setState;
			var self = this;

			var properties = props.items.map(function(item){
				// var text = item.label + ": " + item.value;
				var bold = {'font-weight': 'bold'};
				if(item.label == "URL"){
					return (
						React.createElement("li", null, React.createElement("span", {style: bold}, item.label, ": "), React.createElement("a", {href: item.value, target: '_black'}, item.value))
					)
				} else {
					return(
						React.createElement("li", null, React.createElement("span", {style: bold}, item.label, ": "), item.value)
					)
				}


			});


			props.title.changed = this.changedTitle;
			props.title.classNames = ['company-popup-title'];

			var contentDisplay = state.visibleContent ? {}:{'display':'none'};
			return (
				React.createElement("div", {className: 'company-popup'}, 
					React.createElement(SelectableItem, {keys: props.title}), 
					React.createElement("div", {style: contentDisplay, className: 'company-popup-content'}, 
						properties, 
						React.createElement("div", {className: "edit-button-holder"}, 
							React.createElement("button", {className: "edit-button", onClick: this.sendToEdit}, "Edit")
						)
					)
				)
			);
		}
	});
	return CompanyPopup
});

//React.createElement("div", {className: "edit-button-holder"},
//	React.createElement('button', {className: "edit-button", onClick:this.sendToEdit}, 'Edit')
//)

//<div className={"edit-button-holder"}>
//	<button className={"edit-button"} onClick={this.sendToEdit}>Edit</button>
//</div>