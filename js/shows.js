let dateTimes = [];
jQuery(function($) {
  let id = 0;
  /**
     Date time functions
  */
  $("#multiple-checkboxes").multiselect({
    includeSelectAllOption: true
  });
  $.fn.datetimepicker.Constructor.Default = $.extend({}, $.fn.datetimepicker.Constructor.Default, {
    icons: {
      time: "mdi mdi-clock-outline",
      date: "mdi mdi-calendar-range",
      up: "mdi mdi-chevron-up mdi-24px",
      down: "mdi mdi-chevron-down mdi-24px"
    },
    locale: "es" });
  $("#dateShow").datetimepicker({
    inline: true,
    sideBySide: true,
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
    if (
      $(this)
        .val()
        .match(/^\$?\d+(,\d{3})*(\.\d*)?$/)
    ) {
      let num = Number(
        $(this)
          .val()
          .replace(/[\$,]/g, "")
      );
      $(this).val(formatter.format(num));
    } else {
      $(this).val(formatter.format(0));
    }
  });

  $("#add-newShow").hide();

  $("#add-show").click(function() {
    activateRequiredFields()
    $("#group-dates").hide();
    $('.image-name').hide();
    $("#add-newShow").show();
    $("#list-show").hide();
    $("#titleShows").text("Crear nuevo espectáculo");
    $("#update-show").attr("id", "save-new-show");
  });

  $("#cancel-new-show").click(function() {
    $("#add-newShow").hide();
    $("#list-show").show();
    resetForm();
  });
});

/*
Gets shows list to display
*/
jQuery(function($) {
  getShowList();
});
function getShowList() {
  $.ajax({
    type: "GET",
    url: "controller/controller-list-shows.php",
    contentType: "application/json; charset=utf-8",
    dataType: "json",
    success: function(shows) {
      fillTableShows(shows);
    }
  });
}

//Builds the table body
function fillTableShows(shows) {
  let tr = "";

  if (shows.length > 0) {
    shows.forEach(show => {
      const information =
        "<td>" +
        show.artist +
        "</td>" +
        "<td>" +
        moment(show.date).format("DD/MMMM/YYYY") +
        "</td>" +
        "<td>" +
        `${moment(show.time).format("HH:mm")} h` +
        "</td>" +
        '<td class="actions-buttons">' +
        '<button show-id="' +
        show.id_show +
        '" type="button" class="btn btn-primary btn-lg update-show"><i class="mdi mdi-pencil mdi-24px"></i></button>' +
        '<button show-id="' +
        show.id_show +
        '" type="button" class="btn btn-primary btn-lg delete-show" >' +
        '<i class="mdi mdi-delete mdi-24px"></i></button>' +
        " </td>";

      tr += "<tr>" + information + "</tr>";
    });
  } else {
    tr = '<tr><td colspan="4" class="text-center">No hay resultados</td></tr>';
  }

  $("#table-shows tbody").html(tr);
}

//Handle Delete buttons show
jQuery(function($) {
  $("#table-shows tbody").on("click", "button.delete-show", function() {
    const idShow = $(this).attr("show-id");
    conf = confirm("El espectáculo será eliminado. ¿Desea continuar?");
    if (conf) {
      deleteShow(idShow);
    } else {
      return false;
    }
  });
});

/*Handle create new show
  Gets all the values from the form
*/
jQuery(function($) {
  $("#save-new-show").click(function() {
    if (validateRequiredFileds(".form-add-newshow")) {
      let genres = [];
      $("#multiple-checkboxes option:selected").each(function() {
        genres.push($(this).val());
      });
      if (
        validateArray(
          genres,
          ".multiselect-native-select",
          "Selecciona al menos un género"
        ) &&
        validateArray(dateTimes, "#dateShow", "Asigna al menos una fecha")
      ) {
        const showData = {
          artist: $("#nameShow").val(),
          amount: $("#money").val(),
          genres: genres,
          datesTime: dateTimes,
          imgMobile: $("#img-mobile")[0].files[0].name,
          imgDesktop: $("#img-desktop")[0].files[0].name
        };

        $.ajax({
          type: "POST",
          url: "controller/controller-create-shows.php",
          data: JSON.stringify(showData),
          contentType: "application/json; charset=utf-8",
          dataType: "json",
          success: function(data) {
            sendImages("Espectáculo creado.");
            resetForm();
          },
          error: function(errMsg) {
            console.error(errMsg.responseJSON.error);
          }
        });
      }
    }
  });
});

function sendImages(message) {
  const form_data = new FormData();
  if($("#img-desktop").length>0)
    form_data.append("img-desktop", $("#img-desktop").prop("files")[0]);
  if($("#img-mobile").length>0)
    form_data.append("img-mobile", $("#img-mobile").prop("files")[0]);
  $.ajax({
    type: "POST",
    url: "controller/controller-create-shows-images.php",
    data: form_data,
    cache: false,
    contentType: false,
    processData: false,
    success: function() {
      notifications(message, "success");
      $("#add-newShow").hide();
      getShowList();
      $("#list-show").show();
    },
    error: function(errMsg) {
      console.error(errMsg.responseJSON.error);
    }
  });
}

function resetForm() {
  $(".form-add-newshow").trigger("reset");
  dateTimes = [];
  $("#date-timeShowList").empty();
  $("#multiple-checkboxes").multiselect("updateButtonText");
}

function deleteShow(idShow) {
  const showData = {
    idShow: idShow
  };
  $.ajax({
    type: "POST",
    url: "controller/controller-deleteShow.php",
    data: JSON.stringify(showData),
    contentType: "application/json; charset=utf-8",
    dataType: "json",
    success: function(showData) {
      notifications("Espectaculo eliminado exitosamente.", "success");
      getShowList();
    },
    error: function(errMsg) {
      notifications("Error al eliminar un espectaculo.", "error");
    }
  });
}

//Handle Update buttons show
jQuery(function($) {
  $("#table-shows tbody").on("click", "button.update-show", function() {
    desactivateRequiredFields()
    $("#add-newShow").show();
    $("#group-dates").show();
    $('.image-name').show();
    $("#list-show").hide();
    $("#titleShows").text("Actualizar espectáculo");
    getInformationShow($(this).attr("show-id"));
    $("#save-new-show").attr("id", "update-show");
  });
});

function getInformationShow(idShow) {

  const showData = {
    idShow: idShow
  };
  $.ajax({
    type: "POST",
    url: "controller/controller-get-info-show.php",
    data: JSON.stringify(showData),
    contentType: "application/json; charset=utf-8",
    dataType: "json",
    success: function(showData) {
      setInformationShow(showData);
    },
    error: function(errMsg) {
      notifications("Error al obtener la información.", "error");
    }
  });
}

function setInformationShow(showData) {
  $("#nameShow").val(showData.artist);
  $("#img-mobile")
    .siblings(".image-name")
    .text(showData.url_img_mobile);
  $("#img-desktop")
    .siblings(".image-name")
    .text(showData.url_img_desktop);
  $("#money").val(showData.amount);
  
  const genres = showData.genres.map(genre => genre.id_genre);
  $("#multiple-checkboxes").multiselect("select", genres);

  createCurrentDates(showData.datesTime, showData.id_show)
  
}

function createCurrentDates(datesTime, idShow){
  let dateInput =""

  datesTime.forEach(date=>{
     dateInput+=
    '<div class="input-group date current-dates" id="'+date.id_date_hr+'" id-show="'+idShow+'" data-target-input="nearest">'+
      '<input type="text" class="form-control datetimepicker-input" data-target="#'+date.id_date_hr+'" />'+
      '<div class="input-group-append" data-target="#'+date.id_date_hr+'" data-toggle="datetimepicker">'+
        '<div class="input-group-text"><i class="mdi mdi-calendar"></i></div>'+
      '</div>'+
      '<button show-id="' +
        idShow +
        '" date-id="'+date.id_date_hr+'" type="button" class="btn btn-primary btn-lg delete-date-show" >' +
        '<i class="mdi mdi-delete mdi-24px"></i></button>' +
    '</div>'
  })
  $(".container-current-dates").html(dateInput);
  datesTime.forEach(date=>{
    $('#'+date.id_date_hr).datetimepicker({
      date: date.date+' '+moment(date.time).format("HH:mm"),
    });
  })
}

//Handle Update show
jQuery(function($) {
  $("#update-show").click(function() {
    if (validateRequiredFileds(".form-add-newshow")) {
      let genres = [];
      $("#multiple-checkboxes option:selected").each(function() {
        genres.push($(this).val());
      });
      if (
        validateArray(
          genres,
          ".multiselect-native-select",
          "Selecciona al menos un género"
        )
      ) {
        let imgMobilename=''
        let imgDesktopname=''
        if(!$("#img-mobile").val()){
          imgMobilename = $("#img-mobile")[0].files[0].name
        }
        if(!$("#img-desktop").val()){
          imgDesktopname = $("#img-desktop")[0].files[0].name
        }
        
        let currentDates = []
        $(".current-dates").each(function(){
          let idDate = $(this).attr('id')
          const dateTimeInfo = $(`#${idDate}`).datetimepicker("date")
          currentDates [currentDates.length]={
            idDate: $(this).attr('id'),
            date: dateTimeInfo.format("YYYY-MM-DD"),
            time: dateTimeInfo.format("HH:mm")
          }
        });

        const showData = {
          artist: $("#nameShow").val(),
          amount: $("#money").val(),
          genres: genres,
          datesTime: dateTimes,
          imgMobile: imgMobilename,
          imgDesktop: imgDesktopname,
          idShow: $(".current-dates").attr("id-show"),
          currentDates: currentDates
        };

        $.ajax({
          type: "POST",
          url: "controller/controller-update-info-show.php",
          data: JSON.stringify(showData),
          contentType: "application/json; charset=utf-8",
          dataType: "json",
          success: function(data) {
            if(!$("#img-mobile").val() || !$("#img-desktop").val()){
              sendImages("Espectáculo actualizado.");
            }
            else{
              notifications("Espectáculo actualizado.", "success");
              $("#add-newShow").hide();
              getShowList();
              $("#list-show").show();
            }
            resetForm();
          },
          error: function(errMsg) {
            console.error(errMsg.responseJSON.error);
          }
        });
      }
    }
  });
});

function desactivateRequiredFields(){

    $('#img-mobile').prop('required',false);
    $('#img-desktop').prop('required',false);
}

function activateRequiredFields(){
  $('#img-mobile').prop('required',true);
  $('#img-desktop').prop('required',true);
}
//Handle Delete date show
jQuery(function($) {
  $(".container-current-dates").on("click", "button.delete-date-show", function() {
    const idShow = $(this).attr("show-id")
    const idDate = $(this).attr("date-id")
    const conf = confirm("La fecha con sus reservaciones será eliminado. ¿Desea continuar?");
    if (conf) {
      deleteScheduleDate(idShow, idDate);
    } else {
      return false;
    }
  });
});

function deleteScheduleDate(idShow, idDate){
  const showData = {
    idShow: idShow,
    idDate: idDate
  };
  $.ajax({
    type: "POST",
    url: "controller/controller-delete-datesTime.php",
    data: JSON.stringify(showData),
    contentType: "application/json; charset=utf-8",
    dataType: "json",
    success: function(showData) {
      notifications("Fecha eliminada exitosamente.", "success");
      $(`#${idDate}`).remove();
    },
    error: function(errMsg) {
      notifications("Error al eliminar la fecha.", "error");
    }
  });
}