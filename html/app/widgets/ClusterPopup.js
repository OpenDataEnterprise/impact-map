/** @jsx React.DOM */
define([
	'react',
	'widgets/CompanyPopup'
 ],function(
 	React2,
 	CompanyPopup
 ){
	'use strict';

	var ClusterPopup= React.createClass({displayName: "ClusterPopup",
		getInitialState: function() {
		    return {};
		 },

		 handleChange: function(selectedItems){

		 },

		 
		render:function(){
			var props = this.props.keys;
			var state = this.state;
			var setState = this.setState;
			var self = this;

			var companies = props.companies.map(function(company){
				return(
					React.createElement(CompanyPopup, {keys: company, className: 'company-popup'})
				);
			});
			return (
				React.createElement("div", null, 
					React.createElement("div", {id: 'header-container'}, 
						React.createElement("span", {className: 'cluster-popup-header'}, "Organizations")
					), 
					React.createElement("div", null, 
						companies
					)
				)
			);
		}
	});
	return ClusterPopup;
});