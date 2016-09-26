/** @jsx React.DOM */
define([
	'react',
	'widgets/SelectableItem'
 ],function(
 	React2,
 	SelectableItem
 ){
	'use strict';

	var CompanyPopup = React.createClass({
		getInitialState: function() {
		    return {visibleContent:this.props.keys.showContent};
		 },

		 handleChange: function(selectedItems){

		 },

		 changedTitle: function(title){
		 	this.setState({visibleContent:title.selected});
		 },

		sendToEdit: function(){
			var profileId = this.props.keys.profileID.value
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
						<li><span style={bold}>{item.label}: </span><a href={item.value} target={'_black'}>{item.value}</a></li>
					)
				} else {
					return(
						<li><span style={bold}>{item.label}: </span>{item.value}</li>
					)
				}


			});


			props.title.changed = this.changedTitle;
			props.title.classNames = ['company-popup-title'];

			var contentDisplay = state.visibleContent ? {}:{'display':'none'};
			return (
				<div className={'company-popup'}>
					<SelectableItem keys={props.title} />
					<div style={contentDisplay} className={'company-popup-content'}>
						{properties}
						<div className={"edit-button-holder"}>
							<button className={"edit-button"} onClick={this.sendToEdit}>Edit</button>
						</div>
					</div>
				</div>
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