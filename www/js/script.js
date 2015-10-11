$(document).ready(init);

var URL_jobs        = "http://rebp.nl/API/jobs/",
    URL_benefits    = "http://rebp.nl/API/benefits/",
    ULR_info        = "http://rebp.nl/API/excellent_info/1";

function init() {
    jobList();
    jobFilter();
    benefits();
    info();
    $("#myForm").ajaxForm(options);
}

var options = { 
    beforeSend: function() 
    {

    },
    uploadProgress: function(event, position, total, percentComplete) 
    {
 
    },
    success: function() 
    {
 
    },
    complete: function(response) 
    {
        //$("#msg").html("<font color='green'>"+response.responseText+"</font>");
        $.mobile.changePage("#sendApplication", {transition: "slideUp", role: "page"});

    },
    error: function()
    {
    console.log("Error!");
    }
}

// Job list

function jobList() {
    $.getJSON(
        URL_jobs,
        showJobs
    );
}

function showJobs(data) {
    //console.log(data);

    var output = '<ul data-role="listview" class="ui-listview">';

    $.each(data, function(i, val) {
      output += '<li><a href="#job-requirements" class="ui-btn ui-btn-icon-right ui-icon-carat-r" onclick ="jobName(' + val.id + ')">' + val.job_name + '</a></li>';
    });

    output += '</ul>';

    $('#job-list article').html(output);

}

function jobName(data) {
  //console.log(data);

    $.ajax({
      type: "POST",
      url: "http://rebp.nl/ajax_request.php",
      data: {id: data},
      success: function(data) {

        $('#job-name').text(data);

      }
    });

}


//Job filter

function jobFilter() {
    $.getJSON(
        URL_jobs,
        showJobFilter
    );
}

function showJobFilter(data) {
    //console.log(data);
    var output = '<option></option>';
        output += '<option value="all" selected="selected">All</option>';

        $.each(data, function(i, val) {
          output += '<option value="' + val.id + '">' + val.job_name + '</option>';
        });

    $('#job-filter').html(output);
}

// Benefits

function benefits() {
    $.getJSON(
        URL_benefits,
        showBenefits
    );
}

function showBenefits(data) {
    //console.log(data);

    var output = '<ul>';

    $.each(data, function(i, val) {
      output += '<li>' + val.benefit + '</li>';
    });

    output += '</ul>';

    $('#benefits article').html(output);
}

// excellent info

function info() {
    $.getJSON(
        ULR_info,
        showInfo
    );
}

function showInfo(data) {
    // console.log();
    $("a#address").text(data.address);
    $("a#email").attr('href', 'mailto:' + data.email);
    $("a#tel").attr('href', 'tel:' + data.tel);
    $("p#kvk").text("Kvk: " + data.kvk);
}