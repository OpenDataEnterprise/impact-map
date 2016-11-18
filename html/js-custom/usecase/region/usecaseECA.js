//get the data
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
    $.each(dataArray, function(index, value) {

    // clone and append template container, also add data to it
        if (value[10] === 'Europe & Central Asia') {
            $("#template").clone(true).removeAttr('id').attr('id', 'agriculture' + index).appendTo(".text-container");
            $('img', "#agriculture"+index).attr('src', 'useCaseImage/'+value[9]);
            $("#agriculture"+index).find('h3.case-study-title').text(value[1]);
            $("#agriculture"+index).find('div.case-study-subtitle').text(value[2]);
            $("#agriculture"+index).find('a#useCaseURL').text(value[3]).attr('href', value[3]);
            $("#agriculture"+index).find('p#countryPara').html('<strong>Country:</strong> '+value[4]);
            $("#agriculture"+index).find('p#impactPara').html('<strong>Impact:</strong> '+value[6]);
            $("#agriculture"+index).find('p#dataUsePara').html('<strong>Data Used:</strong> '+value[7]);
            $("#agriculture"+index).find('p#mainPara').html(value[8]);
        }
    })

    // remove the template container
    $('#template').remove();

    // interactions for show and hide buttons
    $('.read-more-button-1').on('click', function() {
        $(this).hide();
    });
    $('.read-more-button-1').on('click', function() {
        $(this).parent().find('img.case-study-thumbnail-image-1').hide();
    });
    $('.read-more-button-1').on('click', function() {
        $(this).parent().find('div.case-study-body-1').show();
    });
    $('.read-more-button-1').on('click', function() {
        $(this).parent().find('a.show-less-button-1').show();
    });
    


    $('.show-less-button-1').on('click', function() {
        $(this).parent().find('div.case-study-body-1').hide();
    });
    $('.show-less-button-1').on('click', function() {
        $(this).hide();
    });
    $('.show-less-button-1').on('click', function() {
        $(this).parent().find('a.read-more-button-1').show();
    });
    $('.show-less-button-1').on('click', function() {
        $(this).parent().find('img.case-study-thumbnail-image-1').show();
    });


}