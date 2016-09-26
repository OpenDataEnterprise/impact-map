/** @jsx React.DOM */
define([
	'react',
	'widgets/CompanyPopup'
 ],function(
 	React2,
 	CompanyPopup
 ){
	'use strict';

	var ClusterPopup= React.createClass({
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
					<CompanyPopup keys={company} className={'company-popup'}/>
				);
			});
			return (
				<div>
					<div id={'header-container'}>
						<span className={'cluster-popup-header'}>Organizations</span>
					</div>
					<div>
						{companies}
					</div>
				</div>
			);
		}
	});
	return ClusterPopup;
});