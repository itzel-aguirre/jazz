jQuery(function($) {
  let dateTimes = [];
  let id = 0;
  /**
     Date time functions
  */
  $("#multiple-checkboxes").multiselect({
    includeSelectAllOption: true
  });

  $("#dateShow").datetimepicker({
    inline: true,
    sideBySide: true,
    icons: {
      time: "mdi mdi-clock-outline",
      date: "mdi mdi-calendar-range",
      up: "mdi mdi-chevron-up mdi-24px",
      down: "mdi mdi-chevron-down mdi-24px"
    },
    locale: "es"
  });
  $("#addDateTime").click(function() {
    const dateTimeInfo = $("#dateShow").datetimepicker("date");
    $("#date-timeShowList").append(
      "<li id='" +
        id +
        "'>" +
        dateTimeInfo.format("LLL") +
        "<i class='mdi mdi-delete mdi-18px'></li>"
    );
    dateTimes.push({
      id: id++,
      date: dateTimeInfo.format("YYYY-MM-DD"),
      time: dateTimeInfo.format("HH:mm")
    });
  });

  $("#date-timeShowList").on("click", "li", function(events) {
    $(this).remove();
    dateTimes.splice(
      dateTimes.findIndex(source => source.id == $(this).attr("id")),
      1
    );
  });

  /*Mask money*/
  const formatter = new Intl.NumberFormat("es-MX", {
    style: "currency",
    currency: "MXN",
    minimumFractionDigits: 2
  });

  $("#money").change(function() {
    var num =
      $(this)
        .val()
        .match(/(?=.)^\$?(([1-9][0-9]{0,2}(,[0-9]{3})*)|0)?(\.[0-9]{1,2})?$/) &&
      $(this).val();
    $(this).val(formatter.format(num));
  });

  $("#add-newShow").hide();

  $("#add-show").click(function() {
    $("#add-newShow").show();
    $("#list-show").hide();
  });

  $("#cancel-new-show").click(function() {
    $("#add-newShow").hide();
    $("#list-show").show();
  });


});


/*
Gets shows list to display
*/ 
jQuery(function($) {
  $.ajax({
    type: "GET",
    url: "controller/controller-list-shows.php",
    contentType: "application/json; charset=utf-8",
    dataType: "json",
    success: function(shows) {
      fillTableShows(shows)
    }
  });
});
//Builds the table body
function fillTableShows(shows){
  let tr = ''

  if(shows.length > 0){
    shows.forEach(show =>{
      const information = '<td>'+show.artist+'</td>'+
      '<td>'+moment(show.date).format("DD/MMMM/YYYY")+'</td>'+
      '<td>'+`${moment(show.time).format("HH:mm")} h`+'</td>'+
      '<td class="actions-buttons">'+
      '<button show-id="'+show.id_show+'" type="button" class="btn btn-primary btn-lg update-show"><i class="mdi mdi-pencil mdi-24px"></i></button>'+
      '<button show-id="'+show.id_show+'" type="button" class="btn btn-primary btn-lg delete-show"><i class="mdi mdi-delete mdi-24px"></i></button>'+
     ' </td>'
  
      tr += '<tr>'+information+'</tr>'
    })
  }
  else{
    tr='<tr><td colspan="4" class="text-center">No hay resultados</td></tr>'
  }

  $("#table-shows tbody").html(tr)
}

//Handle Update buttons show
jQuery(function($) {
  $('#table-shows tbody').on('click', 'button.update-show', function() {
    alert($(this).attr("show-id"))
  });
});

//Handle Delete buttons show
jQuery(function($) {
  $('#table-shows tbody').on('click', 'button.delete-show', function() {
    alert($(this).attr("show-id"))
  });
});


//Handle create new show
jQuery(function($) {
  $("#save-new-show").click(function() {
    $("#add-newShow").hide();
    $("#list-show").show();
  });
});