// get the data
$(document).ready(function() {
    $.ajax({
        url: "js-custom/usecase/UseCaseData.csv",
        success: function(data) {processData(data);}
     });
});

function processData(allText) {
    // clear the first row of data
    var dataArray = $.csv.toArrays(allText);
    dataArray.shift();

        $(".agri-mr-container").hide();
        $(".act-mr-container").hide();
        $(".brc-mr-container").hide();
        $(".consu-mr-container").hide();
        $(".edu-mr-container").hide();
        $(".ec-mr-container").hide();
        $(".fi-mr-container").hide();
        $(".gov-mr-container").hide();
        $(".heal-mr-container").hide();
        $(".hcr-mr-container").hide();
        $(".ig-mr-container").hide();
        $(".mc-mr-container").hide();
        $(".tl-mr-container").hide();

    // conditionally, clone and append template containers, add data to container
    $.each(dataArray, function(index, value) {
        // append case in alphabetical view
        // replace all white spaces periods and paprenthese in the case tile with an underscore
        var underscoreTitle = value[1].replace(/\.| |\(|\)/g, "");
       
        $("#templateAbc").clone(true).removeAttr('id').attr('id', underscoreTitle).appendTo(".abc-case-container");
        $('img', "#"+underscoreTitle).attr('src', 'useCaseImage/'+value[9]);
        $("#"+underscoreTitle).find('h3.case-study-title').text(value[1]);
        $("#"+underscoreTitle).find('h1.expand-case-header').text(value[1]);
        $("#"+underscoreTitle).find('div.case-study-subtitle').text(value[2]);
        $("#"+underscoreTitle).find('div.full-use-case-para').text(value[2]);
        $("#"+underscoreTitle).find('a.useCaseURL').text(value[3]).attr('href', value[3]);
        $("#"+underscoreTitle).find('p.countryMark').html('<strong>Country:</strong> '+value[4]);
        $("#"+underscoreTitle).find('p.sectorMark').html('<strong>Sector:</strong> '+value[5]);
        $("#"+underscoreTitle).find('p.impactMark').html('<strong>Impact:</strong> '+value[6]);
        $("#"+underscoreTitle).find('p.dataMark').html('<strong>Data Used:</strong> '+value[7]);
        $("#"+underscoreTitle).find('p.longDesc').html(value[8]);
        
        // append case in region view
        if (value[10] === 'East Asia & Pacific') {
            $("#templateRegion").clone(true).removeAttr('id').attr('id', 'region' + index).appendTo(".ea-case-container");
            $('img', "#region"+index).attr('src', 'useCaseImage/'+value[9]);
            $("#region"+index).find('h3.case-study-title').text(value[1]);
            $("#region"+index).find('h1.expand-case-header').text(value[1]);
            $("#region"+index).find('div.case-study-subtitle').text(value[2]);
            $("#region"+index).find('div.full-use-case-para').text(value[2]);
            $("#region"+index).find('a.useCaseURL').text(value[3]).attr('href', value[3]);
            $("#region"+index).find('p.countryMark').html('<strong>Country:</strong> '+value[4]);
            $("#region"+index).find('p.sectorMark').html('<strong>Sector:</strong> '+value[5]);
            $("#region"+index).find('p.impactMark').html('<strong>Impact:</strong> '+value[6]);
            $("#region"+index).find('p.dataMark').html('<strong>Data Used:</strong> '+value[7]);
            $("#region"+index).find('p.longDesc').html(value[8]);
        }
        if (value[10] === 'Europe & Central Asia') {
            $("#templateRegion").clone(true).removeAttr('id').attr('id', 'region' + index).appendTo(".eca-case-container");
            $('img', "#region"+index).attr('src', 'useCaseImage/'+value[9]);
            $("#region"+index).find('h3.case-study-title').text(value[1]);
            $("#region"+index).find('h1.expand-case-header').text(value[1]);
            $("#region"+index).find('div.case-study-subtitle').text(value[2]);
            $("#region"+index).find('div.full-use-case-para').text(value[2]);
            $("#region"+index).find('a.useCaseURL').text(value[3]).attr('href', value[3]);
            $("#region"+index).find('p.countryMark').html('<strong>Country:</strong> '+value[4]);
            $("#region"+index).find('p.sectorMark').html('<strong>Sector:</strong> '+value[5]);
            $("#region"+index).find('p.impactMark').html('<strong>Impact:</strong> '+value[6]);
            $("#region"+index).find('p.dataMark').html('<strong>Data Used:</strong> '+value[7]);
            $("#region"+index).find('p.longDesc').html(value[8]);
        }
        if (value[10] === 'Latin America & Caribbean') {
            $("#templateRegion").clone(true).removeAttr('id').attr('id', 'region' + index).appendTo(".lac-case-container");
            $('img', "#region"+index).attr('src', 'useCaseImage/'+value[9]);
            $("#region"+index).find('h3.case-study-title').text(value[1]);
            $("#region"+index).find('h1.expand-case-header').text(value[1]);
            $("#region"+index).find('div.case-study-subtitle').text(value[2]);
            $("#region"+index).find('div.full-use-case-para').text(value[2]);
            $("#region"+index).find('a.useCaseURL').text(value[3]).attr('href', value[3]);
            $("#region"+index).find('p.countryMark').html('<strong>Country:</strong> '+value[4]);
            $("#region"+index).find('p.sectorMark').html('<strong>Sector:</strong> '+value[5]);
            $("#region"+index).find('p.impactMark').html('<strong>Impact:</strong> '+value[6]);
            $("#region"+index).find('p.dataMark').html('<strong>Data Used:</strong> '+value[7]);
            $("#region"+index).find('p.longDesc').html(value[8]);
        }
        if (value[10] === 'Middle East & North Africa') {
            $("#templateRegion").clone(true).removeAttr('id').attr('id', 'region' + index).appendTo(".mena-case-container");
            $('img', "#region"+index).attr('src', 'useCaseImage/'+value[9]);
            $("#region"+index).find('h3.case-study-title').text(value[1]);
            $("#region"+index).find('h1.expand-case-header').text(value[1]);
            $("#region"+index).find('div.case-study-subtitle').text(value[2]);
            $("#region"+index).find('div.full-use-case-para').text(value[2]);
            $("#region"+index).find('a.useCaseURL').text(value[3]).attr('href', value[3]);
            $("#region"+index).find('p.countryMark').html('<strong>Country:</strong> '+value[4]);
            $("#region"+index).find('p.sectorMark').html('<strong>Sector:</strong> '+value[5]);
            $("#region"+index).find('p.impactMark').html('<strong>Impact:</strong> '+value[6]);
            $("#region"+index).find('p.dataMark').html('<strong>Data Used:</strong> '+value[7]);
            $("#region"+index).find('p.longDesc').html(value[8]);
        }
        if (value[10] === 'North America') {
            $("#templateRegion").clone(true).removeAttr('id').attr('id', 'region' + index).appendTo(".na-case-container");
            $('img', "#region"+index).attr('src', 'useCaseImage/'+value[9]);
            $("#region"+index).find('h3.case-study-title').text(value[1]);
            $("#region"+index).find('h1.expand-case-header').text(value[1]);
            $("#region"+index).find('div.case-study-subtitle').text(value[2]);
            $("#region"+index).find('div.full-use-case-para').text(value[2]);
            $("#region"+index).find('a.useCaseURL').text(value[3]).attr('href', value[3]);
            $("#region"+index).find('p.countryMark').html('<strong>Country:</strong> '+value[4]);
            $("#region"+index).find('p.sectorMark').html('<strong>Sector:</strong> '+value[5]);
            $("#region"+index).find('p.impactMark').html('<strong>Impact:</strong> '+value[6]);
            $("#region"+index).find('p.dataMark').html('<strong>Data Used:</strong> '+value[7]);
            $("#region"+index).find('p.longDesc').html(value[8]);
        }
        if (value[10] === 'South Asia') {
            $("#templateRegion").clone(true).removeAttr('id').attr('id', 'region' + index).appendTo(".sa-case-container");
            $('img', "#region"+index).attr('src', 'useCaseImage/'+value[9]);
            $("#region"+index).find('h3.case-study-title').text(value[1]);
            $("#region"+index).find('h1.expand-case-header').text(value[1]);
            $("#region"+index).find('div.case-study-subtitle').text(value[2]);
            $("#region"+index).find('div.full-use-case-para').text(value[2]);
            $("#region"+index).find('a.useCaseURL').text(value[3]).attr('href', value[3]);
            $("#region"+index).find('p.countryMark').html('<strong>Country:</strong> '+value[4]);
            $("#region"+index).find('p.sectorMark').html('<strong>Sector:</strong> '+value[5]);
            $("#region"+index).find('p.impactMark').html('<strong>Impact:</strong> '+value[6]);
            $("#region"+index).find('p.dataMark').html('<strong>Data Used:</strong> '+value[7]);
            $("#region"+index).find('p.longDesc').html(value[8]);
        }
        if (value[10] === 'Sub-Saharan Africa') {
            $("#templateRegion").clone(true).removeAttr('id').attr('id', 'region' + index).appendTo(".ssa-case-container");
            $('img', "#region"+index).attr('src', 'useCaseImage/'+value[9]);
            $("#region"+index).find('h3.case-study-title').text(value[1]);
            $("#region"+index).find('h1.expand-case-header').text(value[1]);
            $("#region"+index).find('div.case-study-subtitle').text(value[2]);
            $("#region"+index).find('div.full-use-case-para').text(value[2]);
            $("#region"+index).find('a.useCaseURL').text(value[3]).attr('href', value[3]);
            $("#region"+index).find('p.countryMark').html('<strong>Country:</strong> '+value[4]);
            $("#region"+index).find('p.sectorMark').html('<strong>Sector:</strong> '+value[5]);
            $("#region"+index).find('p.impactMark').html('<strong>Impact:</strong> '+value[6]);
            $("#region"+index).find('p.dataMark').html('<strong>Data Used:</strong> '+value[7]);
            $("#region"+index).find('p.longDesc').html(value[8]);
        }

        // append case in sector view
        if (value[5] === 'Agriculture') {
            $("#templateSector").clone(true).removeAttr('id').attr('id', 'sector' + index).appendTo(".agri-row-container");
            $('img', "#sector"+index).attr('src', 'useCaseImage/'+value[9]);
            $("#sector"+index).find('h3.case-study-title').text(value[1]);
            $("#sector"+index).find('h1.expand-case-header').text(value[1]);
            $("#sector"+index).find('div.case-study-subtitle').text(value[2]);
            $("#sector"+index).find('div.full-use-case-para').text(value[2]);
            $("#sector"+index).find('a.useCaseURL').text(value[3]).attr('href', value[3]);
            $("#sector"+index).find('p.countryMark').html('<strong>Country:</strong> '+value[4]);
            $("#sector"+index).find('p.sectorMark').html('<strong>Sector:</strong> '+value[5]);
            $("#sector"+index).find('p.impactMark').html('<strong>Impact:</strong> '+value[6]);
            $("#sector"+index).find('p.dataMark').html('<strong>Data Used:</strong> '+value[7]);
            $("#sector"+index).find('p.longDesc').html(value[8]);
        }
        if (value[5] === 'Arts, culture and tourism') {
            $("#templateSector").clone(true).removeAttr('id').attr('id', 'sector' + index).appendTo(".act-row-container");
            $('img', "#sector"+index).attr('src', 'useCaseImage/'+value[9]);
            $("#sector"+index).find('h3.case-study-title').text(value[1]);
            $("#sector"+index).find('h1.expand-case-header').text(value[1]);
            $("#sector"+index).find('div.case-study-subtitle').text(value[2]);
            $("#sector"+index).find('div.full-use-case-para').text(value[2]);
            $("#sector"+index).find('a.useCaseURL').text(value[3]).attr('href', value[3]);
            $("#sector"+index).find('p.countryMark').html('<strong>Country:</strong> '+value[4]);
            $("#sector"+index).find('p.sectorMark').html('<strong>Sector:</strong> '+value[5]);
            $("#sector"+index).find('p.impactMark').html('<strong>Impact:</strong> '+value[6]);
            $("#sector"+index).find('p.dataMark').html('<strong>Data Used:</strong> '+value[7]);
            $("#sector"+index).find('p.longDesc').html(value[8]);
        }
        if (value[5] === 'Business, research and consulting') {
            $("#templateSector").clone(true).removeAttr('id').attr('id', 'sector' + index).appendTo(".brc-row-container");
            $('img', "#sector"+index).attr('src', 'useCaseImage/'+value[9]);
            $("#sector"+index).find('h3.case-study-title').text(value[1]);
            $("#sector"+index).find('h1.expand-case-header').text(value[1]);
            $("#sector"+index).find('div.case-study-subtitle').text(value[2]);
            $("#sector"+index).find('div.full-use-case-para').text(value[2]);
            $("#sector"+index).find('a.useCaseURL').text(value[3]).attr('href', value[3]);
            $("#sector"+index).find('p.countryMark').html('<strong>Country:</strong> '+value[4]);
            $("#sector"+index).find('p.sectorMark').html('<strong>Sector:</strong> '+value[5]);
            $("#sector"+index).find('p.impactMark').html('<strong>Impact:</strong> '+value[6]);
            $("#sector"+index).find('p.dataMark').html('<strong>Data Used:</strong> '+value[7]);
            $("#sector"+index).find('p.longDesc').html(value[8]);
        }
        if (value[5] === 'Consumer') {
            $("#templateSector").clone(true).removeAttr('id').attr('id', 'sector' + index).appendTo(".consu-row-container");
            $('img', "#sector"+index).attr('src', 'useCaseImage/'+value[9]);
            $("#sector"+index).find('h3.case-study-title').text(value[1]);
            $("#sector"+index).find('h1.expand-case-header').text(value[1]);
            $("#sector"+index).find('div.case-study-subtitle').text(value[2]);
            $("#sector"+index).find('div.full-use-case-para').text(value[2]);
            $("#sector"+index).find('a.useCaseURL').text(value[3]).attr('href', value[3]);
            $("#sector"+index).find('p.countryMark').html('<strong>Country:</strong> '+value[4]);
            $("#sector"+index).find('p.sectorMark').html('<strong>Sector:</strong> '+value[5]);
            $("#sector"+index).find('p.impactMark').html('<strong>Impact:</strong> '+value[6]);
            $("#sector"+index).find('p.dataMark').html('<strong>Data Used:</strong> '+value[7]);
            $("#sector"+index).find('p.longDesc').html(value[8]);
        }
        if (value[5] === 'Education') {
            $("#templateSector").clone(true).removeAttr('id').attr('id', 'sector' + index).appendTo(".edu-row-container");
            $('img', "#sector"+index).attr('src', 'useCaseImage/'+value[9]);
            $("#sector"+index).find('h3.case-study-title').text(value[1]);
            $("#sector"+index).find('h1.expand-case-header').text(value[1]);
            $("#sector"+index).find('div.case-study-subtitle').text(value[2]);
            $("#sector"+index).find('div.full-use-case-para').text(value[2]);
            $("#sector"+index).find('a.useCaseURL').text(value[3]).attr('href', value[3]);
            $("#sector"+index).find('p.countryMark').html('<strong>Country:</strong> '+value[4]);
            $("#sector"+index).find('p.sectorMark').html('<strong>Sector:</strong> '+value[5]);
            $("#sector"+index).find('p.impactMark').html('<strong>Impact:</strong> '+value[6]);
            $("#sector"+index).find('p.dataMark').html('<strong>Data Used:</strong> '+value[7]);
            $("#sector"+index).find('p.longDesc').html(value[8]);
        }
        if (value[5] === 'Energy and climate') {
            $("#templateSector").clone(true).removeAttr('id').attr('id', 'sector' + index).appendTo(".ec-row-container");
            $('img', "#sector"+index).attr('src', 'useCaseImage/'+value[9]);
            $("#sector"+index).find('h3.case-study-title').text(value[1]);
            $("#sector"+index).find('h1.expand-case-header').text(value[1]);
            $("#sector"+index).find('div.case-study-subtitle').text(value[2]);
            $("#sector"+index).find('div.full-use-case-para').text(value[2]);
            $("#sector"+index).find('a.useCaseURL').text(value[3]).attr('href', value[3]);
            $("#sector"+index).find('p.countryMark').html('<strong>Country:</strong> '+value[4]);
            $("#sector"+index).find('p.sectorMark').html('<strong>Sector:</strong> '+value[5]);
            $("#sector"+index).find('p.impactMark').html('<strong>Impact:</strong> '+value[6]);
            $("#sector"+index).find('p.dataMark').html('<strong>Data Used:</strong> '+value[7]);
            $("#sector"+index).find('p.longDesc').html(value[8]);
        }
        if (value[5] === 'Finance and insurance') {
            $("#templateSector").clone(true).removeAttr('id').attr('id', 'sector' + index).appendTo(".fi-row-container");
            $('img', "#sector"+index).attr('src', 'useCaseImage/'+value[9]);
            $("#sector"+index).find('h3.case-study-title').text(value[1]);
            $("#sector"+index).find('h1.expand-case-header').text(value[1]);
            $("#sector"+index).find('div.case-study-subtitle').text(value[2]);
            $("#sector"+index).find('div.full-use-case-para').text(value[2]);
            $("#sector"+index).find('a.useCaseURL').text(value[3]).attr('href', value[3]);
            $("#sector"+index).find('p.countryMark').html('<strong>Country:</strong> '+value[4]);
            $("#sector"+index).find('p.sectorMark').html('<strong>Sector:</strong> '+value[5]);
            $("#sector"+index).find('p.impactMark').html('<strong>Impact:</strong> '+value[6]);
            $("#sector"+index).find('p.dataMark').html('<strong>Data Used:</strong> '+value[7]);
            $("#sector"+index).find('p.longDesc').html(value[8]);
        }
        if (value[5] === 'Governance') {
            $("#templateSector").clone(true).removeAttr('id').attr('id', 'sector' + index).appendTo(".gov-row-container");
            $('img', "#sector"+index).attr('src', 'useCaseImage/'+value[9]);
            $("#sector"+index).find('h3.case-study-title').text(value[1]);
            $("#sector"+index).find('h1.expand-case-header').text(value[1]);
            $("#sector"+index).find('div.case-study-subtitle').text(value[2]);
            $("#sector"+index).find('div.full-use-case-para').text(value[2]);
            $("#sector"+index).find('a.useCaseURL').text(value[3]).attr('href', value[3]);
            $("#sector"+index).find('p.countryMark').html('<strong>Country:</strong> '+value[4]);
            $("#sector"+index).find('p.sectorMark').html('<strong>Sector:</strong> '+value[5]);
            $("#sector"+index).find('p.impactMark').html('<strong>Impact:</strong> '+value[6]);
            $("#sector"+index).find('p.dataMark').html('<strong>Data Used:</strong> '+value[7]);
            $("#sector"+index).find('p.longDesc').html(value[8]);
        }
        if (value[5] === 'Healthcare') {
            $("#templateSector").clone(true).removeAttr('id').attr('id', 'sector' + index).appendTo(".heal-row-container");
            $('img', "#sector"+index).attr('src', 'useCaseImage/'+value[9]);
            $("#sector"+index).find('h3.case-study-title').text(value[1]);
            $("#sector"+index).find('h1.expand-case-header').text(value[1]);
            $("#sector"+index).find('div.case-study-subtitle').text(value[2]);
            $("#sector"+index).find('div.full-use-case-para').text(value[2]);
            $("#sector"+index).find('a.useCaseURL').text(value[3]).attr('href', value[3]);
            $("#sector"+index).find('p.countryMark').html('<strong>Country:</strong> '+value[4]);
            $("#sector"+index).find('p.sectorMark').html('<strong>Sector:</strong> '+value[5]);
            $("#sector"+index).find('p.impactMark').html('<strong>Impact:</strong> '+value[6]);
            $("#sector"+index).find('p.dataMark').html('<strong>Data Used:</strong> '+value[7]);
            $("#sector"+index).find('p.longDesc').html(value[8]);
        }
        if (value[5] === 'Housing, construction & real estate') {
            $("#templateSector").clone(true).removeAttr('id').attr('id', 'sector' + index).appendTo(".hcr-row-container");
            $('img', "#sector"+index).attr('src', 'useCaseImage/'+value[9]);
            $("#sector"+index).find('h3.case-study-title').text(value[1]);
            $("#sector"+index).find('h1.expand-case-header').text(value[1]);
            $("#sector"+index).find('div.case-study-subtitle').text(value[2]);
            $("#sector"+index).find('div.full-use-case-para').text(value[2]);
            $("#sector"+index).find('a.useCaseURL').text(value[3]).attr('href', value[3]);
            $("#sector"+index).find('p.countryMark').html('<strong>Country:</strong> '+value[4]);
            $("#sector"+index).find('p.sectorMark').html('<strong>Sector:</strong> '+value[5]);
            $("#sector"+index).find('p.impactMark').html('<strong>Impact:</strong> '+value[6]);
            $("#sector"+index).find('p.dataMark').html('<strong>Data Used:</strong> '+value[7]);
            $("#sector"+index).find('p.longDesc').html(value[8]);
        }
        if (value[5] === 'IT and geospatial') {
            $("#templateSector").clone(true).removeAttr('id').attr('id', 'sector' + index).appendTo(".ig-row-container");
            $('img', "#sector"+index).attr('src', 'useCaseImage/'+value[9]);
            $("#sector"+index).find('h3.case-study-title').text(value[1]);
            $("#sector"+index).find('h1.expand-case-header').text(value[1]);
            $("#sector"+index).find('div.case-study-subtitle').text(value[2]);
            $("#sector"+index).find('div.full-use-case-para').text(value[2]);
            $("#sector"+index).find('a.useCaseURL').text(value[3]).attr('href', value[3]);
            $("#sector"+index).find('p.countryMark').html('<strong>Country:</strong> '+value[4]);
            $("#sector"+index).find('p.sectorMark').html('<strong>Sector:</strong> '+value[5]);
            $("#sector"+index).find('p.impactMark').html('<strong>Impact:</strong> '+value[6]);
            $("#sector"+index).find('p.dataMark').html('<strong>Data Used:</strong> '+value[7]);
            $("#sector"+index).find('p.longDesc').html(value[8]);
        }
        if (value[5] === 'Media and communications') {
            $("#templateSector").clone(true).removeAttr('id').attr('id', 'sector' + index).appendTo(".mc-row-container");
            $('img', "#sector"+index).attr('src', 'useCaseImage/'+value[9]);
            $("#sector"+index).find('h3.case-study-title').text(value[1]);
            $("#sector"+index).find('h1.expand-case-header').text(value[1]);
            $("#sector"+index).find('div.case-study-subtitle').text(value[2]);
            $("#sector"+index).find('div.full-use-case-para').text(value[2]);
            $("#sector"+index).find('a.useCaseURL').text(value[3]).attr('href', value[3]);
            $("#sector"+index).find('p.countryMark').html('<strong>Country:</strong> '+value[4]);
            $("#sector"+index).find('p.sectorMark').html('<strong>Sector:</strong> '+value[5]);
            $("#sector"+index).find('p.impactMark').html('<strong>Impact:</strong> '+value[6]);
            $("#sector"+index).find('p.dataMark').html('<strong>Data Used:</strong> '+value[7]);
            $("#sector"+index).find('p.longDesc').html(value[8]);
        }
        if (value[5] === 'Transportation and logistics') {
            $("#templateSector").clone(true).removeAttr('id').attr('id', 'sector' + index).appendTo(".tl-row-container");
            $('img', "#sector"+index).attr('src', 'useCaseImage/'+value[9]);
            $("#sector"+index).find('h3.case-study-title').text(value[1]);
            $("#sector"+index).find('h1.expand-case-header').text(value[1]);
            $("#sector"+index).find('div.case-study-subtitle').text(value[2]);
            $("#sector"+index).find('div.full-use-case-para').text(value[2]);
            $("#sector"+index).find('a.useCaseURL').text(value[3]).attr('href', value[3]);
            $("#sector"+index).find('p.countryMark').html('<strong>Country:</strong> '+value[4]);
            $("#sector"+index).find('p.sectorMark').html('<strong>Sector:</strong> '+value[5]);
            $("#sector"+index).find('p.impactMark').html('<strong>Impact:</strong> '+value[6]);
            $("#sector"+index).find('p.dataMark').html('<strong>Data Used:</strong> '+value[7]);
            $("#sector"+index).find('p.longDesc').html(value[8]);
        }

        // append case in machine readable view
        
        if (value[5] === 'Agriculture' && value[11] === 'Yes') {
            $(".agri-mr-container").show();
            $("#templateMrble").clone(true).removeAttr('id').attr('id', 'mrble' + index).appendTo(".agri-mr-container");
            $('img', "#mrble"+index).attr('src', 'useCaseImage/'+value[9]);
            $("#mrble"+index).find('h3.case-study-title').text(value[1]);
            $("#mrble"+index).find('h1.expand-case-header').text(value[1]);
            $("#mrble"+index).find('div.case-study-subtitle').text(value[2]);
            $("#mrble"+index).find('div.full-use-case-para').text(value[2]);
            $("#mrble"+index).find('a.useCaseURL').text(value[3]).attr('href', value[3]);
            $("#mrble"+index).find('p.countryMark').html('<strong>Country:</strong> '+value[4]);
            $("#mrble"+index).find('p.sectorMark').html('<strong>Sector:</strong> '+value[5]);
            $("#mrble"+index).find('p.impactMark').html('<strong>Impact:</strong> '+value[6]);
            $("#mrble"+index).find('p.dataMark').html('<strong>Data Used:</strong> '+value[7]);
            $("#mrble"+index).find('p.longDesc').html(value[8]);
        }
        if (value[5] === 'Arts, culture and tourism' && value[11] === 'Yes') {
            $(".act-mr-container").show();
            $("#templateMrble").clone(true).removeAttr('id').attr('id', 'mrble' + index).appendTo(".act-mr-container");
            $('img', "#mrble"+index).attr('src', 'useCaseImage/'+value[9]);
            $("#mrble"+index).find('h3.case-study-title').text(value[1]);
            $("#mrble"+index).find('h1.expand-case-header').text(value[1]);
            $("#mrble"+index).find('div.case-study-subtitle').text(value[2]);
            $("#mrble"+index).find('div.full-use-case-para').text(value[2]);
            $("#mrble"+index).find('a.useCaseURL').text(value[3]).attr('href', value[3]);
            $("#mrble"+index).find('p.countryMark').html('<strong>Country:</strong> '+value[4]);
            $("#mrble"+index).find('p.sectorMark').html('<strong>Sector:</strong> '+value[5]);
            $("#mrble"+index).find('p.impactMark').html('<strong>Impact:</strong> '+value[6]);
            $("#mrble"+index).find('p.dataMark').html('<strong>Data Used:</strong> '+value[7]);
            $("#mrble"+index).find('p.longDesc').html(value[8]);
        }
        if (value[5] === 'Business, research and consulting' && value[11] === 'Yes') {
            $(".brc-mr-container").show();
            $("#templateMrble").clone(true).removeAttr('id').attr('id', 'mrble' + index).appendTo(".brc-mr-container");
            $('img', "#mrble"+index).attr('src', 'useCaseImage/'+value[9]);
            $("#mrble"+index).find('h3.case-study-title').text(value[1]);
            $("#mrble"+index).find('h1.expand-case-header').text(value[1]);
            $("#mrble"+index).find('div.case-study-subtitle').text(value[2]);
            $("#mrble"+index).find('div.full-use-case-para').text(value[2]);
            $("#mrble"+index).find('a.useCaseURL').text(value[3]).attr('href', value[3]);
            $("#mrble"+index).find('p.countryMark').html('<strong>Country:</strong> '+value[4]);
            $("#mrble"+index).find('p.sectorMark').html('<strong>Sector:</strong> '+value[5]);
            $("#mrble"+index).find('p.impactMark').html('<strong>Impact:</strong> '+value[6]);
            $("#mrble"+index).find('p.dataMark').html('<strong>Data Used:</strong> '+value[7]);
            $("#mrble"+index).find('p.longDesc').html(value[8]);
        }
        if (value[5] === 'Consumer' && value[11] === 'Yes') {
            $(".consu-mr-container").show();
            $("#templateMrble").clone(true).removeAttr('id').attr('id', 'mrble' + index).appendTo(".consu-mr-container");
            $('img', "#mrble"+index).attr('src', 'useCaseImage/'+value[9]);
            $("#mrble"+index).find('h3.case-study-title').text(value[1]);
            $("#mrble"+index).find('h1.expand-case-header').text(value[1]);
            $("#mrble"+index).find('div.case-study-subtitle').text(value[2]);
            $("#mrble"+index).find('div.full-use-case-para').text(value[2]);
            $("#mrble"+index).find('a.useCaseURL').text(value[3]).attr('href', value[3]);
            $("#mrble"+index).find('p.countryMark').html('<strong>Country:</strong> '+value[4]);
            $("#mrble"+index).find('p.sectorMark').html('<strong>Sector:</strong> '+value[5]);
            $("#mrble"+index).find('p.impactMark').html('<strong>Impact:</strong> '+value[6]);
            $("#mrble"+index).find('p.dataMark').html('<strong>Data Used:</strong> '+value[7]);
            $("#mrble"+index).find('p.longDesc').html(value[8]);
        }
        if (value[5] === 'Education' && value[11] === 'Yes') {
            $(".edu-mr-container").show();
            $("#templateMrble").clone(true).removeAttr('id').attr('id', 'mrble' + index).appendTo(".edu-mr-container");
            $('img', "#mrble"+index).attr('src', 'useCaseImage/'+value[9]);
            $("#mrble"+index).find('h3.case-study-title').text(value[1]);
            $("#mrble"+index).find('h1.expand-case-header').text(value[1]);
            $("#mrble"+index).find('div.case-study-subtitle').text(value[2]);
            $("#mrble"+index).find('div.full-use-case-para').text(value[2]);
            $("#mrble"+index).find('a.useCaseURL').text(value[3]).attr('href', value[3]);
            $("#mrble"+index).find('p.countryMark').html('<strong>Country:</strong> '+value[4]);
            $("#mrble"+index).find('p.sectorMark').html('<strong>Sector:</strong> '+value[5]);
            $("#mrble"+index).find('p.impactMark').html('<strong>Impact:</strong> '+value[6]);
            $("#mrble"+index).find('p.dataMark').html('<strong>Data Used:</strong> '+value[7]);
            $("#mrble"+index).find('p.longDesc').html(value[8]);
        }
        if (value[5] === 'Energy and climate' && value[11] === 'Yes') {
            $(".ec-mr-container").show();
            $("#templateMrble").clone(true).removeAttr('id').attr('id', 'mrble' + index).appendTo(".ec-mr-container");
            $('img', "#mrble"+index).attr('src', 'useCaseImage/'+value[9]);
            $("#mrble"+index).find('h3.case-study-title').text(value[1]);
            $("#mrble"+index).find('h1.expand-case-header').text(value[1]);
            $("#mrble"+index).find('div.case-study-subtitle').text(value[2]);
            $("#mrble"+index).find('div.full-use-case-para').text(value[2]);
            $("#mrble"+index).find('a.useCaseURL').text(value[3]).attr('href', value[3]);
            $("#mrble"+index).find('p.countryMark').html('<strong>Country:</strong> '+value[4]);
            $("#mrble"+index).find('p.sectorMark').html('<strong>Sector:</strong> '+value[5]);
            $("#mrble"+index).find('p.impactMark').html('<strong>Impact:</strong> '+value[6]);
            $("#mrble"+index).find('p.dataMark').html('<strong>Data Used:</strong> '+value[7]);
            $("#mrble"+index).find('p.longDesc').html(value[8]);
        }
        if (value[5] === 'Finance and insurance' && value[11] === 'Yes') {
            $(".fi-mr-container").show();
            $("#templateMrble").clone(true).removeAttr('id').attr('id', 'mrble' + index).appendTo(".fi-mr-container");
            $('img', "#mrble"+index).attr('src', 'useCaseImage/'+value[9]);
            $("#mrble"+index).find('h3.case-study-title').text(value[1]);
            $("#mrble"+index).find('h1.expand-case-header').text(value[1]);
            $("#mrble"+index).find('div.case-study-subtitle').text(value[2]);
            $("#mrble"+index).find('div.full-use-case-para').text(value[2]);
            $("#mrble"+index).find('a.useCaseURL').text(value[3]).attr('href', value[3]);
            $("#mrble"+index).find('p.countryMark').html('<strong>Country:</strong> '+value[4]);
            $("#mrble"+index).find('p.sectorMark').html('<strong>Sector:</strong> '+value[5]);
            $("#mrble"+index).find('p.impactMark').html('<strong>Impact:</strong> '+value[6]);
            $("#mrble"+index).find('p.dataMark').html('<strong>Data Used:</strong> '+value[7]);
            $("#mrble"+index).find('p.longDesc').html(value[8]);
        }
        if (value[5] === 'Governance' && value[11] === 'Yes') {
            $(".gov-mr-container").show();
            $("#templateMrble").clone(true).removeAttr('id').attr('id', 'mrble' + index).appendTo(".gov-mr-container");
            $('img', "#mrble"+index).attr('src', 'useCaseImage/'+value[9]);
            $("#mrble"+index).find('h3.case-study-title').text(value[1]);
            $("#mrble"+index).find('h1.expand-case-header').text(value[1]);
            $("#mrble"+index).find('div.case-study-subtitle').text(value[2]);
            $("#mrble"+index).find('div.full-use-case-para').text(value[2]);
            $("#mrble"+index).find('a.useCaseURL').text(value[3]).attr('href', value[3]);
            $("#mrble"+index).find('p.countryMark').html('<strong>Country:</strong> '+value[4]);
            $("#mrble"+index).find('p.sectorMark').html('<strong>Sector:</strong> '+value[5]);
            $("#mrble"+index).find('p.impactMark').html('<strong>Impact:</strong> '+value[6]);
            $("#mrble"+index).find('p.dataMark').html('<strong>Data Used:</strong> '+value[7]);
            $("#mrble"+index).find('p.longDesc').html(value[8]);
        }
        if (value[5] === 'Healthcare' && value[11] === 'Yes') {
            $(".heal-mr-container").show();
            $("#templateMrble").clone(true).removeAttr('id').attr('id', 'mrble' + index).appendTo(".heal-mr-container");
            $('img', "#mrble"+index).attr('src', 'useCaseImage/'+value[9]);
            $("#mrble"+index).find('h3.case-study-title').text(value[1]);
            $("#mrble"+index).find('h1.expand-case-header').text(value[1]);
            $("#mrble"+index).find('div.case-study-subtitle').text(value[2]);
            $("#mrble"+index).find('div.full-use-case-para').text(value[2]);
            $("#mrble"+index).find('a.useCaseURL').text(value[3]).attr('href', value[3]);
            $("#mrble"+index).find('p.countryMark').html('<strong>Country:</strong> '+value[4]);
            $("#mrble"+index).find('p.sectorMark').html('<strong>Sector:</strong> '+value[5]);
            $("#mrble"+index).find('p.impactMark').html('<strong>Impact:</strong> '+value[6]);
            $("#mrble"+index).find('p.dataMark').html('<strong>Data Used:</strong> '+value[7]);
            $("#mrble"+index).find('p.longDesc').html(value[8]);
        }
        if (value[5] === 'Housing, construction & real estate' && value[11] === 'Yes') {
            $(".hcr-mr-container").show();
            $("#templateMrble").clone(true).removeAttr('id').attr('id', 'mrble' + index).appendTo(".hcr-mr-container");
            $('img', "#mrble"+index).attr('src', 'useCaseImage/'+value[9]);
            $("#mrble"+index).find('h3.case-study-title').text(value[1]);
            $("#mrble"+index).find('h1.expand-case-header').text(value[1]);
            $("#mrble"+index).find('div.case-study-subtitle').text(value[2]);
            $("#mrble"+index).find('div.full-use-case-para').text(value[2]);
            $("#mrble"+index).find('a.useCaseURL').text(value[3]).attr('href', value[3]);
            $("#mrble"+index).find('p.countryMark').html('<strong>Country:</strong> '+value[4]);
            $("#mrble"+index).find('p.sectorMark').html('<strong>Sector:</strong> '+value[5]);
            $("#mrble"+index).find('p.impactMark').html('<strong>Impact:</strong> '+value[6]);
            $("#mrble"+index).find('p.dataMark').html('<strong>Data Used:</strong> '+value[7]);
            $("#mrble"+index).find('p.longDesc').html(value[8]);
        }
        if (value[5] === 'IT and geospatial' && value[11] === 'Yes') {
            $(".ig-mr-container").show();
            $("#templateMrble").clone(true).removeAttr('id').attr('id', 'mrble' + index).appendTo(".ig-mr-container");
            $('img', "#mrble"+index).attr('src', 'useCaseImage/'+value[9]);
            $("#mrble"+index).find('h3.case-study-title').text(value[1]);
            $("#mrble"+index).find('h1.expand-case-header').text(value[1]);
            $("#mrble"+index).find('div.case-study-subtitle').text(value[2]);
            $("#mrble"+index).find('div.full-use-case-para').text(value[2]);
            $("#mrble"+index).find('a.useCaseURL').text(value[3]).attr('href', value[3]);
            $("#mrble"+index).find('p.countryMark').html('<strong>Country:</strong> '+value[4]);
            $("#mrble"+index).find('p.sectorMark').html('<strong>Sector:</strong> '+value[5]);
            $("#mrble"+index).find('p.impactMark').html('<strong>Impact:</strong> '+value[6]);
            $("#mrble"+index).find('p.dataMark').html('<strong>Data Used:</strong> '+value[7]);
            $("#mrble"+index).find('p.longDesc').html(value[8]);
        }
        if (value[5] === 'Media and communications' && value[11] === 'Yes') {
            $(".mc-mr-container").show();
            $("#templateMrble").clone(true).removeAttr('id').attr('id', 'mrble' + index).appendTo(".mc-mr-container");
            $('img', "#mrble"+index).attr('src', 'useCaseImage/'+value[9]);
            $("#mrble"+index).find('h3.case-study-title').text(value[1]);
            $("#mrble"+index).find('h1.expand-case-header').text(value[1]);
            $("#mrble"+index).find('div.case-study-subtitle').text(value[2]);
            $("#mrble"+index).find('div.full-use-case-para').text(value[2]);
            $("#mrble"+index).find('a.useCaseURL').text(value[3]).attr('href', value[3]);
            $("#mrble"+index).find('p.countryMark').html('<strong>Country:</strong> '+value[4]);
            $("#mrble"+index).find('p.sectorMark').html('<strong>Sector:</strong> '+value[5]);
            $("#mrble"+index).find('p.impactMark').html('<strong>Impact:</strong> '+value[6]);
            $("#mrble"+index).find('p.dataMark').html('<strong>Data Used:</strong> '+value[7]);
            $("#mrble"+index).find('p.longDesc').html(value[8]);
        }
        if (value[5] === 'Transportation and logistics' && value[11] === 'Yes') {
            $(".tl-mr-container").show();
            $("#templateMrble").clone(true).removeAttr('id').attr('id', 'mrble' + index).appendTo(".tl-mr-container");
            $('img', "#mrble"+index).attr('src', 'useCaseImage/'+value[9]);
            $("#mrble"+index).find('h3.case-study-title').text(value[1]);
            $("#mrble"+index).find('h1.expand-case-header').text(value[1]);
            $("#mrble"+index).find('div.case-study-subtitle').text(value[2]);
            $("#mrble"+index).find('div.full-use-case-para').text(value[2]);
            $("#mrble"+index).find('a.useCaseURL').text(value[3]).attr('href', value[3]);
            $("#mrble"+index).find('p.countryMark').html('<strong>Country:</strong> '+value[4]);
            $("#mrble"+index).find('p.sectorMark').html('<strong>Sector:</strong> '+value[5]);
            $("#mrble"+index).find('p.impactMark').html('<strong>Impact:</strong> '+value[6]);
            $("#mrble"+index).find('p.dataMark').html('<strong>Data Used:</strong> '+value[7]);
            $("#mrble"+index).find('p.longDesc').html(value[8]);
        }

    })

    // remove template containers
    $('#templateAbc').remove();
    $('#templateRegion').remove();
    $('#templateSector').remove();
    $('#templateMrble').remove();
    
    // interactions for show.hide modal popup
    $('.case-study-intro-1').on('click', function() {
        $(this).parent().find('div.modal-wrapper').show();
        var caseId = $(this).parent().attr("id");
        var stateObj = { foo: "bar" };
        history.pushState(stateObj, "", "/usecases/"+caseId);
    });
    $('.close-case-modal').on('click', function() {
        $('.modal-wrapper').hide();
        var stateObj = { foo: "bar" };
        history.pushState(stateObj, "", "/usecases");
    });

    // show/hide four view containers and color interactions for four new filter buttons
    //first
    $('#byTitle').on('click', function() {
        $(this).css("background-color", "#50b094");
        $('#byRegion').css("background-color", "#376d86");
        $('#bySector').css("background-color", "#376d86");
        $('#byMR').css("background-color", "#376d86");

        $('.abc-case-container').show();
        $('.region-case-container').hide();
        $('.sector-case-container').hide();
        $('.mrble-case-container').hide();
    });
   

    //second
    $('#byRegion').on('click', function() {
        $(this).css("background-color", "#50b094");
        $('#byTitle').css("background-color", "#376d86");
        $('#bySector').css("background-color", "#376d86");
        $('#byMR').css("background-color", "#376d86");

        $('.abc-case-container').hide();
        $('.region-case-container').show();
        $('.sector-case-container').hide();
        $('.mrble-case-container').hide();
    });
    

    //third
    $('#bySector').on('click', function() {
        $(this).css("background-color", "#50b094");
        $('#byRegion').css("background-color", "#376d86");
        $('#byTitle').css("background-color", "#376d86");
        $('#byMR').css("background-color", "#376d86");

        $('.abc-case-container').hide();
        $('.region-case-container').hide();
        $('.sector-case-container').show();
        $('.mrble-case-container').hide();
    });


    //fourth
    $('#byMR').on('click', function() {
        $(this).css("background-color", "#50b094");
        $('#byRegion').css("background-color", "#376d86");
        $('#bySector').css("background-color", "#376d86");
        $('#byTitle').css("background-color", "#376d86");

        $('.abc-case-container').hide();
        $('.region-case-container').hide();
        $('.sector-case-container').hide();
        $('.mrble-case-container').show();
    });

    // show machine readability case view based on URL hash value
    var urlHash = window.location.hash;
    if (urlHash === "#MachineReadabilityProject") {
        $('#byMR').css("background-color", "#50b094");
        $('#byRegion').css("background-color", "#376d86");
        $('#bySector').css("background-color", "#376d86");
        $('#byTitle').css("background-color", "#376d86");

        $('.abc-case-container').hide();
        $('.region-case-container').hide();
        $('.sector-case-container').hide();
        $('.mrble-case-container').show();
    } else if (urlHash && urlHash!=="#MachineReadabilityProject") {
        $('#byMR').css("background-color", "#376d86");
        $('#byRegion').css("background-color", "#376d86");
        $('#bySector').css("background-color", "#376d86");
        $('#byTitle').css("background-color", "#50b094");

        $('.abc-case-container').show();
        $('.region-case-container').hide();
        $('.sector-case-container').hide();
        $('.mrble-case-container').hide();

        $(urlHash).find('div.modal-wrapper').show();  
    } else {
        $('#byMR').css("background-color", "#376d86");
        $('#byRegion').css("background-color", "#376d86");
        $('#bySector').css("background-color", "#376d86");
        $('#byTitle').css("background-color", "#50b094");

        $('.abc-case-container').show();
        $('.region-case-container').hide();
        $('.sector-case-container').hide();
        $('.mrble-case-container').hide();
    }
    

}