/** @jsx React.DOM */
'use strict';
define(
  ['react', 'widgets/SelectableItem'],
  function (React2, SelectableItem) {
    var CompanyPopup = React.createClass(
      {
        displayName: "CompanyPopup",
        getInitialState: function () {
          return { visibleContent: this.props.keys.showContent };
        },
        handleChange: function (selectedItems) {},
        changedTitle: function (title) {
          this.setState({ visibleContent:title.selected });
        },
        sendToEdit: function () {
          var profileId = this.props.keys.profileID.value
          var url = 'http://' + location.host + '/survey/edit/' + profileId;
          window.open(url, '_blank');
        },
        render: function () {
          var props = this.props.keys;
          var state = this.state;
          var setState = this.setState;
          var self = this;
          var properties = props.items.map(function (item) {
            var bold = {'font-weight': 'bold'};
            if (item.label == 'URL') {
              return (
                React.createElement(
                  'li',
                  null,
                  React.createElement(
                    'span',
                    { style: bold },
                    item.label,
                    ': '
                  ),
                  React.createElement(
                    'a',
                    { href: item.value, target: '_black' },
                    item.value
                  )
                )
              );
            } else {
              return (
                React.createElement(
                  'li',
                  null,
                  React.createElement(
                    'span',
                    { style: bold },
                    item.label,
                    ': '
                  ),
                  item.value
                )
              );
            }
          });
          props.title.changed = this.changedTitle;
          props.title.classNames = ['company-popup-title'];
          var contentDisplay = state.visibleContent ? {} : { 'display':'none' };
          return (
            React.createElement(
              'div',
              { className: 'company-popup' },
              React.createElement(SelectableItem, { keys: props.title }),
              React.createElement(
                'div',
                {
                  style: contentDisplay,
                  className: 'company-popup-content'
                },
                properties
              )
            )
          );
        }
      }
    );
    return CompanyPopup;
  }
);