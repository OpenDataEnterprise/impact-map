/** @jsx React.DOM */
'use strict';

define(
  [
    'react',
    'map/MapController'
  ],
  function (
    React2,
    MapController
  ) {
    var SelectableItem = React.createClass(
      {
        displayName: 'SelectableItem',
        getInitialState: function () {
          return { selected: this.props.keys.selected || false };
        },
        handleClick: function () {
          var props = this.props.keys;
          var selected = props.toggle ? !this.state.selected : true;
          this.setState({ selected: selected });
          props.selected = selected;
          this.props.keys.changed && this.props.keys.changed(this.props.keys);
        },
        render:function () {
          var props = this.props.keys;
          var handleClick = this.handleClick;
          var handleClick_mac = this.handleClick_mac;
          var selectFilter = this.selectFilter;
          var classNameArray = props.classNames || [];
          var selected = props.selected || false;
          var classString;

          if (props.selected) {
            classString = classNameArray.concat(['selected']).join(' ');
          } else {
            classString = classNameArray.join(' ');
          }

          if (this.props.keys.label == 'Yes') {
            return (
              React.createElement(
                'div',
                { onClick: handleClick, className: classString },
                React.createElement(
                  'span',
                  { className: 'company-title-label' },
                  'The Machine Readability Project, supported by the World ' +
                  'Bank, displays use cases in low-middle income countries ' +
                  'using machine readable open data.'
                )
              )
            );
          } else if (this.props.keys.value === 'machineread') {
            return (
              React.createElement(
                'div',
                { onClick: handleClick, className: classString },
                React.createElement(
                  'span',
                  { className: 'company-title-label' },
                  props.label
                )
              )
            );
          } else if (this.props.keys.label == 'No' ||
            this.props.keys.label == 'NA') {
            return null
          } else {
            return (
              React.createElement(
                'div',
                { onClick: handleClick, className: classString },
                React.createElement(
                  'span',
                  { className: 'company-title-label'},
                  props.label
                )
              )
            );
          }
        }
      }
    );

    return SelectableItem;
  }
);