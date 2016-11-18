define(['table/TableController', 'widgets/CompanyPopup', 'react'],function(TableController, CompanyPopup, React2){
	'use strict';

	var Data = [];
	var columnMetaData = [];

	var companyData = {};

	var tableResults = React.createClass({displayName: "tableResults",

		showPopup: function(rowProps, evt){

			debugger;

			document.getElementById('popup-area').style.display='block';
			document.getElementById('popup-area').style.left = (evt.target.clientWidth + evt.target.offsetLeft) +"px";
			document.getElementById('popup-area').style.top = evt.target.offsetTop+"px";


			var itemData = rowProps.props.data;

			companyData.name = itemData['Company Name'];
			companyData.country = itemData['Country'];
			companyData.profileID = itemData['profileID'];

			var dataArray = [
				{value: itemData['Country'],label:'Country'},
				{value: itemData['City'], label: 'City'},
				{value: itemData['Founding Year'], label: 'Founding Year'},
				{value: itemData['Size'], label: 'Size'},
				{value: itemData['Organization Type'], label: 'Organization Type'},
				{value: itemData['URL'], label: 'URL'},
				{value: itemData['Description'], label: 'Description'},
				{value: itemData['Industry Category'], label: 'Category'},
				{value: itemData['Entry Based On'], label: "Entry Based On"},
				{value: itemData['Data Use'], label: 'Data Use'}

			]

			if(itemData['use_advocacy'] == '1'){
				dataArray.push({
					label: "Application",
					value: "Advocacy: " + itemData['use_advocacy_desc']
				})
			}
			if(itemData['use_prod_srvc'] == '1'){
				dataArray.push({
					label: "Application",
					value: "New Products and Services: " + itemData['use_prod_srvc_desc']
				})
			}
			if(itemData['use_org_opt'] == '1'){
				dataArray.push({
					label: "Application",
					value: "Organizational Optimization: " + itemData['use_org_opt_desc']
				})
			}

			if(itemData['use_research'] == '1'){
				dataArray.push({
					label: "Application",
					value: "Research: " + itemData['use_research_desc']
				})
			}
			if(itemData['use_other'] == '1'){
				dataArray.push({
					label: "Application",
					value: "Other: " + itemData['use_other_desc']
				})
			}



			React.render(React.createElement(CompanyPopup, {keys: {profileID: {value: itemData['profileID']}, items: dataArray, showContent: true, title: {label: itemData['Company Name'], selected: true, toggle: false}}}), document.getElementById('company-popup'));

		},

		componentDidMount: function () {
			//global = this.props;
		},

		hidePopup: function(evt, args){
			//load component
			document.getElementById('popup-area').style.display='none';

		},

		sendToEdit: function(){

			//GET PROFILE ID

			var profileId = companyData.profileID;
			var url = 'http://odetest.govready.org/map/company/'+profileId+'/edit';
			window.open(url, '_blank');
			//window.location.href = url;

			//window.location.href = 'mailto:someone@example.com?&subject=Open%20Data%20Company%20Edit&body=Company:%20'+companyData.name+"%0D%0ACountry:%20"+companyData.country;
			//href: 'mailto:someone@example.com?&body=Company:%20'+this.currentCompany
		},

		exportTableDataJSON: function(){

			var jsonString = JSON.stringify(Data, null, 4);

			var today = new Date();
			var dd = today.getDate();
			var mm = today.getMonth()+1; //January is 0!

			var yyyy = today.getFullYear();
			if(dd<10){
				dd='0'+dd
			}
			if(mm<10){
				mm='0'+mm
			}
			var today = dd+'_'+mm+'_'+yyyy;
			var blob = new Blob([jsonString], {type: "text/plain;charset=utf-8"});
			fileSaveAs(blob, "Open Data Impact Map _ Data Export _ "+today+".txt");
		},

		exportTableData: function(){

			//var wb = {}
			//wb.Sheets = {};
			//wb.Props = {};
			//wb.SSF = {};
			//wb.SheetNames = ['Company Data'];
			//
			//
			//var ws = {}
			//var data = [];
			//var wscols = [];
			//data.push(Object.keys(Data[0]))
			//
			//
			//_.forEach(Data, function(company){
			//	var tempData = [];
			//	_.forEach(data[0], function(key){
			//		tempData.push(company[key]);
			//	})
			//	data.push(tempData);
			//})
			//
			//
			///* the range object is used to keep track of the range of the sheet */
			//var range = {s: {c:0, r:0}, e: {c:0, r:0 }};
			//
			///* Iterate through each element in the structure */
			//for(var R = 0; R != data.length; ++R) {
			//	if(range.e.r < R) range.e.r = R;
			//	for(var C = 0; C != data[R].length; ++C) {
			//		if(range.e.c < C) range.e.c = C;
			//
			//		/* create cell object: .v is the actual data */
			//		var cell = { v: data[R][C] };
			//		if(cell.v == null) continue;
			//
			//		/* create the correct cell reference */
			//		var cell_ref = XLSX.utils.encode_cell({c:C,r:R});
			//
			//		/* determine the cell type */
			//		if(typeof cell.v === 'number') cell.t = 'n';
			//		else if(typeof cell.v === 'boolean') cell.t = 'b';
			//		else cell.t = 's';
			//
			//		/* add to structure */
			//		ws[cell_ref] = cell;
			//	}
			//}
			//ws['!ref'] = XLSX.utils.encode_range(range);
			//
			//for(var i=0; i<data[0].length; i++){
			//	wscols.push({wch:30})
			//}
			//
			//ws['!cols'] = wscols;
			//
			///* add worksheet to workbook */
			//wb.Sheets["Company Data"] = ws;
			//
			//var wopts = { bookType:'xlsx', bookSST:false, type:'binary' };
			//
			//var wbout = XLSX.write(wb,wopts);
			//
			//function s2ab(s) {
			//	var buf = new ArrayBuffer(s.length);
			//	var view = new Uint8Array(buf);
			//	for (var i=0; i!=s.length; ++i) view[i] = s.charCodeAt(i) & 0xFF;
			//	return buf;
			//}

			var exportData = _.map(Data, _.clone);
			delete exportData[0]['profileID'];
			/* these fields included in the download fields as of 11/6/2015 */
			// delete exportData[0]['use_advocacy'];
			// delete exportData[0]['use_org_opt'];
			// delete exportData[0]['use_other'];
			// delete exportData[0]['use_prod_srvc'];
			// delete exportData[0]['use_research'];
			
			var data = [];
			data.push(Object.keys(exportData[0]));

			_.forEach(exportData, function(company){

				_.forEach(company, function(value, index){
					company[index] = String(company[index]).replace(/,/g , " - ");
					company[index] = String(company[index]).replace(/(\r\n|\n|\r)/gm," ");
				})

				data.push([
					company['Region'],
					company['Country'],
					company['Company Name'],
					company['Organization Type'],					
					company['Industry Category'],
					company['Description'],
					company['URL'],
					company['City'],
					company['State/Region'],
					company['Founding Year'],
					company['Size'],
					company['Data Use'],					
					company['Advocacy'],
					company['Advocacy Description'],
					company['Product/Service'],
					company['Product/Service Description'],
					company['Organizational Optimization'],
					company['Organizational Optimization Description'],
					company['Research'],
					company['Research Description'],
					company['Other'],
					company['Use - Other Description'],
					company['Entry Based On']
				]);

				_.forEach(data, function(row, outerIndex){
					_.forEach(row, function(item, innerIndex){
						if(item == 'null'){
							data[outerIndex][innerIndex] = ' ';
						}
					})
				});


				//"use_advocacy": attr.use_advocacy,
				//	"Advocacy": attr.use_advocacy_desc,
				//	"use_prod_srvc": attr.use_prod_srvc,
				//	"New Products and Services": attr.use_prod_srvc_desc,
				//	"use_org_opt": attr.use_org_opt,
				//	"Organizational Optimization": attr.use_org_opt_desc,
				//	"use_research": attr.use_research,
				//	"Research": attr.use_research_desc,
				//	"use_other": attr.use_other,
				//	"Other": attr.use_other_desc
				//var tempData = [];
				//_.forEach(data[0], function(key){
				//	tempData.push(company[key]);
				//	debugger;
				//})
				//data.push(tempData);
			});

			var csvContent = "";
			data.forEach(function(infoArray, index){

				var dataString = infoArray.join(",");
				csvContent += index < data.length ? dataString+ "\n" : dataString;

			});


			var today = new Date();
			var dd = today.getDate();
			var mm = today.getMonth()+1; //January is 0!

			var yyyy = today.getFullYear();
			if(dd<10){
				dd='0'+dd
			}
			if(mm<10){
				mm='0'+mm
			}
			var today = dd+'_'+mm+'_'+yyyy;

			/* the saveAs call downloads a file on the local machine */
			fileSaveAs(new Blob([csvContent],{type:"text/csv;charset=UTF-8"}), "Open Data Impact Map _ Data Export _ "+today+".csv");
		},

		render: function () {

			var rawData = this.props;
			var popupData;
			Data = [];

			columnMetaData = [
			{
				"columnName": "Company Name",
				"visible": true
			},{
				"columnName": "Region",
				"visible": true
			}, {
				"columnName": "Country",
				"visible": true
			},{
				"columnName": "Organization Type",
				"visible": true
			},{
				"columnName": "Industry Category",
				"visible": true
			},{
				"columnName": "Description",
				"visible": true,
				"cssClassName": 'description-column'
			},{
				"columnName": "Data Use",
				"visible": true
			}
			]

			var columns = ["Company Name", "Region", "Country", "Organization Type", "Industry Category", "Description", "Data Use"];

			debugger;

			_.forEach(rawData.keys, function(item){
				var attr = item.attributes;
				var data = {					
					"Region": attr.org_hq_country_region,
					"Country": attr.org_hq_country,
					"Company Name": attr.org_name,
					'Organization Type': attr.org_type,					
					"Industry Category": attr.industry_id,
					"Description": attr.org_description,
					'URL': attr.org_url,
					"City": attr.org_hq_city,
					"State/Region": attr.org_hq_st_prov,
					'Founding Year': attr.org_year_founded,
					'Size': attr.org_size_id,
					"Data Use": attr.dataCell,
					//'profileID': attr.profile_id,
					"Advocacy": (attr.use_advocacy==1 ? "TRUE" : "FALSE"),
					"Advocacy Description": attr.use_advocacy_desc,
					"Product/Service": (attr.use_prod_srvc==1 ? "TRUE" : "FALSE"),
					"Product/Service Description": attr.use_prod_srvc_desc,
					"Organizational Optimization": (attr.use_org_opt==1 ? "TRUE" : "FALSE"),
					"Organizational Optimization Description": attr.use_org_opt_desc,
					"Research": (attr.use_research==1 ? "TRUE" : "FALSE"),
					"Research Description": attr.use_research_desc,
					"Other": (attr.use_other==1 ? "TRUE" : "FALSE"),
					"Use - Other Description": attr.use_other_desc,
					'Entry Based On': attr.org_profile_category
				};

				//Data.push(data);
				/* This is for inserting each element in a sorted order. */
				Data.splice(sortedIndex(Data, data), 0, data);

			});
			
			return (
				React.createElement("div", {id: "results-ontainer", className: 'results-container'},
					React.createElement("div", {id: "table-area", className: "table-area"},
						React.createElement(Griddle, {results: Data, columnMetadata: columnMetaData, columns: columns, onRowClick: this.showPopup, enableInfiniteScroll: false, resultsPerPage: 9, useFixedHeader: true, tableClassName: "table"}),
						React.createElement("div", {id: "popup-area", className: "table-company-popup"},
							React.createElement("span", {className: "close-popup", onClick: this.hidePopup}, "X"),
							React.createElement("div", {id: "company-popup"})
						)
					)
				)
			)
		}
	});

	return tableResults;

});

/* Finding an index to insert a value in a sorted order. For the key "Company Name " */
function sortedIndex(array, value) {
	var low = 0,
		high = array.length;

	while (low < high) {
		var mid = low + high >>> 1;
		if (array[mid]["Company Name"] < value["Company Name"]) low = mid + 1;
		else high = mid;
	}
	return low;
}