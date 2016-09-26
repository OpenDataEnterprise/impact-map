define(['table/TableController', 'widgets/CompanyPopup', 'react'],function(TableController, CompanyPopup, React2){
	'use strict';

	var Data = [];
	var Data2 = [];
	var columnMetaData = [];

	var companyData = {};

	var rawData2;

	var tableResults = React.createClass({displayName: "tableResults",

		//Added by Vinayak to download data without filtering
		getInitialState: function() {
			//console.log('this.props', this.props);
		   	rawData2 = this.props;
		   	return null
		},

		showPopup: function(rowProps, evt){

			debugger;

			document.getElementById('popup-area').style.display='block';
			document.getElementById('popup-area').style.left = (evt.target.clientWidth + evt.target.offsetLeft) +"px";
			document.getElementById('popup-area').style.top = evt.target.offsetTop+"px";


			var itemData = rowProps.props.data;

			

			companyData.name = itemData['Company Name'];
			companyData.country = itemData['Country'];
			companyData.profileID = itemData['profileID'];
			console.log('itemData',itemData);

			var dataArray = [
				// {value: itemData['Country'],label:'Country'},
				{value: itemData['City'], label: 'City'},
				// {value: itemData['Founding Year'], label: 'Founding Year'},
				// {value: itemData['Size'], label: 'Size'},
				// {value: itemData['Organization Type'], label: 'Organization Type'},
				{value: itemData['URL'], label: 'URL'},
				{value: itemData['Description'], label: 'Description'},
				// {value: itemData['Industry Category'], label: 'Category'},
				// {value: itemData['Entry Based On'], label: "Entry Based On"},
				// {value: itemData['Type of Data Used'], label: 'Type of Data Used'}

			];
			// show type of data used only when there is an entry
			if(itemData['Type of Data Used']){
				dataArray.push({
					label: "Type of Data Used",
					value: itemData['Type of Data Used']
				})
			}

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


			// console.log("itemData['profileID']",itemData); //Vinayak

			React.render(React.createElement(CompanyPopup, {keys: {profileID: {value: itemData['profileID']}, items: dataArray, showContent: true, title: {label: itemData['Organization Name'], selected: true, toggle: false}}}), document.getElementById('company-popup'));

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
			console.log("I am in sendToEdit");
			var profileId = companyData.profileID;
			var url = 'http://odetest.govready.org/map/company/'+profileId+'/edit';
			window.open(url, '_blank');
			//window.location.href = url;

			//window.location.href = 'mailto:someone@example.com?&subject=Open%20Data%20Company%20Edit&body=Company:%20'+companyData.name+"%0D%0ACountry:%20"+companyData.country;
			//href: 'mailto:someone@example.com?&body=Company:%20'+this.currentCompany
		},

		exportTableDataJSON: function(){

			console.log('insied exportTableDataJSON');
			//Change for Download json data without filter
			//var jsonString = JSON.stringify(Data, null, 4);
			var jsonString = JSON.stringify(Data2, null, 4);

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
			fileSaveAs(blob, "Open Data Impact Map _ Data Export _ "+today+".json");


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

/*			console.log('Data', Data);
			console.log('Data2', Data2);*/


		//Start of Comment and change download data without filter Vinayak 08.10.16
/*			var exportData = _.map(Data, _.clone);
			delete exportData[0]['profileID'];
			//these fields included in the download fields as of 11/6/2015
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

			//the saveAs call downloads a file on the local machine
			fileSaveAs(new Blob([csvContent],{type:"text/csv;charset=UTF-8"}), "Open Data Impact Map _ Data Export _ "+today+".csv");*/

			var exportData = _.map(Data2, _.clone);
			delete exportData[0]['profileID'];
			//these fields included in the download fields as of 11/6/2015
			// delete exportData[0]['use_advocacy'];
			// delete exportData[0]['use_org_opt'];
			// delete exportData[0]['use_other'];
			// delete exportData[0]['use_prod_srvc'];
			// delete exportData[0]['use_research'];
			
			var data2 = [];
			data2.push(Object.keys(exportData[0]));

			_.forEach(exportData, function(company){

				_.forEach(company, function(value, index){
					company[index] = String(company[index]).replace(/,/g , " - ");
					company[index] = String(company[index]).replace(/(\r\n|\n|\r)/gm," ");
				})

				data2.push([
					company['Region'],
					company['Country'],
					company['Country Income Level'],
					company['Organization Name'],
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

				_.forEach(data2, function(row, outerIndex){
					_.forEach(row, function(item, innerIndex){
						if(item == 'null'){
							data2[outerIndex][innerIndex] = ' ';
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
			data2.forEach(function(infoArray, index){

				var dataString = infoArray.join(",");
				csvContent += index < data2.length ? dataString+ "\n" : dataString;

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

			//the saveAs call downloads a file on the local machine
			fileSaveAs(new Blob([csvContent],{type:"text/csv;charset=UTF-8"}), "Open Data Impact Map _ Data Export _ "+today+".csv");
		//End of Comment and change download data without filter Vinayak 08.10.16
		},

		render: function () {

			var rawData = this.props;

			//console.log('rawData', rawData);
			//console.log('rawData2', rawData2);

			var popupData;
			Data = [];

			Data2 = []; //Added by Vinayak Data Download

			columnMetaData = [
			{
				"columnName": "Organization Name",
				"visible": true,
				"cssClassName": "ColWidth11p"
			},{
				"columnName": "Region",
				"visible": true,
				"cssClassName": "ColWidth11p"
			}, {
				"columnName": "Country",
				"visible": true,
				"cssClassName": "ColWidth11p"
			},{
				"columnName": "Country Income Level",
				"visible": true,
				"cssClassName": "ColWidth11p"
			},{
				"columnName": "Organization Type",
				"visible": true,
				"cssClassName": "ColWidth11p"
			},{
				"columnName": "Sectors",
				"visible": true,
				"cssClassName": "ColWidth11p"
			},{
				"columnName": "Description",
				"visible": true,
				"cssClassName": 'description-column'
			},{
				"columnName": "Type of Data Used",
				"visible": true,
				"cssClassName": "ColWidth11p"
			}
			]

			//Change by Vinayak 07.08.2016
			//To Change Company Name label to Organization Name label and Insutry Category to Sectors
			//var columns = ["Company Name", "Region", "Country", "Organization Type", "Industry Category", "Description", "Data Use"];
			var columns = ["Organization Name", "Region", "Country", "Country Income Level", "Organization Type", "Sectors", "Description", "Type of Data Used"];

			//debugger; Commented by Vinayak

			_.forEach(rawData.keys, function(item){
				var attr = item.attributes;
			
			//Added by Vinayak Pande 07.13.2016
			//	
			var datause = attr.dataCell;
			var uniqueList=datause.split(', ').filter(function(item,i,allItems){
    		return i==allItems.indexOf(item);
			}).join(', ');
			if(uniqueList.endsWith(", "))
			{
				uniqueList = uniqueList.slice(0, -2);
			}
			attr.dataCell = uniqueList;

			//End of Addition

				//console.log("attr", attr); //Vinayak

				var data = {					
					"Region": attr.org_hq_country_region,
					"Country": attr.org_hq_country,
					"Country Income Level": attr.org_hq_country_income,
			//Change by Vinayak 07.08.2016
			//To Change Company Name label to Organization Name label
			//		"Company Name": attr.org_name,
					"Organization Name": attr.org_name,
					'Organization Type': attr.org_type,		
			//Change by Vinayak 07.12.16
			//To Change Insutry Category to Sectors	
					"Sectors": attr.industry_id,
					"Description": attr.org_description,
					'URL': attr.org_url,
					"City": attr.org_hq_city,
					"State/Region": attr.org_hq_st_prov,
					'Founding Year': attr.org_year_founded,
					'Size': attr.org_size_id,
					"Type of Data Used": attr.dataCell,
					//'profileID': attr.profile_id,
					'profileID': attr.profile_id, //Uncommented by Vinayak
					
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

			//Added by Vinayak Data Download
			_.forEach(rawData2.keys, function(item){
				var attr2 = item.attributes;
			
			//Added by Vinayak Pande 07.13.2016
			//	
			var datause2 = attr2.dataCell;
			var uniqueList2=datause2.split(', ').filter(function(item,i,allItems){
    		return i==allItems.indexOf(item);
			}).join(', ');
						if(uniqueList2.endsWith(", "))
			{
				uniqueList2 = uniqueList2.slice(0, -2);
			}
			attr2.dataCell = uniqueList2;
			//End of Addition

			//To prevent excel from converting size range to date Vinayak
			if (attr2.org_size_id) {
			//console.log('attr.org_size_id',attr.org_size_id);			
			attr2.org_size_id = attr2.org_size_id.replace("-", " to ");
			//console.log('attr.org_size_id',attr.org_size_id);
			}	

				//console.log("attr2", attr2); //Vinayak

				var data2 = {					
					"Region": attr2.org_hq_country_region,
					"Country": attr2.org_hq_country,
					"Country Income Level": attr2.org_hq_country_income,
			//Change by Vinayak 07.08.2016
			//To Change Company Name label to Organization Name label
			//		"Company Name": attr.org_name,
					"Organization Name": attr2.org_name,
					'Organization Type': attr2.org_type,		
			//Change by Vinayak 07.12.16
			//To Change Insutry Category to Sectors	
					"Sectors": attr2.industry_id,
					"Description": attr2.org_description,
					'URL': attr2.org_url,
					"City": attr2.org_hq_city,
					"State/Region": attr2.org_hq_st_prov,
					'Founding Year': attr2.org_year_founded,
					'Size': attr2.org_size_id,
					"Type of Data Used": attr2.dataCell,
					//'profileID': attr.profile_id,
					'profileID': attr2.profile_id, //Uncommented by Vinayak
					
					"Advocacy": (attr2.use_advocacy==1 ? "TRUE" : "FALSE"),
					"Advocacy Description": attr2.use_advocacy_desc,
					"Product/Service": (attr2.use_prod_srvc==1 ? "TRUE" : "FALSE"),
					"Product/Service Description": attr2.use_prod_srvc_desc,
					"Organizational Optimization": (attr2.use_org_opt==1 ? "TRUE" : "FALSE"),
					"Organizational Optimization Description": attr2.use_org_opt_desc,
					"Research": (attr2.use_research==1 ? "TRUE" : "FALSE"),
					"Research Description": attr2.use_research_desc,
					"Other": (attr2.use_other==1 ? "TRUE" : "FALSE"),
					"Use - Other Description": attr2.use_other_desc,
					'Entry Based On': attr2.org_profile_category

				};

				//Data.push(data);
				/* This is for inserting each element in a sorted order. */
				Data2.splice(sortedIndex(Data2, data2), 0, data2);
			});
			

			return (
				React.createElement("div", {id: "results-ontainer", className: 'results-container'},
					React.createElement("div", {className: "table-count"}, "Total : ", Data.length),
					React.createElement("div", {id: "table-area", className: "table-area"},
						React.createElement(Griddle, {results: Data, columnMetadata: columnMetaData, columns: columns, onRowClick: this.showPopup, tableClassName: "table", enableInfiniteScroll: false, resultsPerPage: 9, useFixedHeader: true, initialSort: "Organization Name", nextClassName: "griddle-nextcustom"}),
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
		//Change by Vinayak 07.08.2016
		//To Change Company Name label to Organization Name label
		//if (array[mid]["Company Name"] < value["Company Name"]) low = mid + 1;
		if (array[mid]["Organization Name"] < value["Organization Name"]) low = mid + 1;
			else high = mid;
	}
	return low;
}