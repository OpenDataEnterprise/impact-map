/** @jsx React.DOM */
define([
	'widgets/SelectableItem',
	'widgets/ClusterPopup',
	'widgets/CompanyPopup',
	'widgets/tableResults'
 ],function(
 	SelectableItem,
 	ClusterPopup,
 	CompanyPopup,
	TableResults
 ){
	'use strict';

	var factory = {};

	var renderTo = function(component,props,id){
		return React.render(React.createElement(component, {keys: props}), document.getElementById(id));
	}

	factory.CompanyPopup = function(props,id){
		return renderTo(CompanyPopup,props,id);
	}

	factory.ClusterPopup = function(props,id){
		return renderTo(ClusterPopup,props,id);
	}

	factory.TableResults = function(props,id){
		return renderTo(TableResults,props,id);
	}

	return factory;
});