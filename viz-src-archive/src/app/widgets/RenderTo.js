/** @jsx React.DOM */
define([
	'react',
	'widgets/SelectableItem',
	'widgets/CompanyPopup'
 ],function(
 	React,
 	SelectableItem,
 	CompanyPopup
 ){
	'use strict';

	var factory = {};

	var renderTo = function(component,props,id){
		return React.render(React.createElement(component, {keys: props}), document.getElementById(id));
	}

	factory.CompanyPopup = function(props,id){
		return renderTo(CompanyPopup,props,id);
	}

	return factory;
});