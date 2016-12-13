/** @jsx React.DOM */
define(['react','map/MapController'],function(React2,MapController){
	'use strict';
	var self = this;

	return React.createClass({ 
		render:function(){
			var props = this.props.keys;
			return (
					React.createElement("li", {className: "baseMapItem", onClick: MapController.changeBaseMap.bind(props)}, 
						React.createElement("img", {id: props.name, className: "baseMapThumbnail", src: props.thumbnail})
					)
				);
		}
	});

});