let dateTimes = [];
jQuery(function($) {
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
    $("#add-newShow").show();
    $("#list-show").hide();
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

//Handle Update buttons show
jQuery(function($) {
  $("#table-shows tbody").on("click", "button.update-show", function() {
    alert($(this).attr("show-id"));
  });
});

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
            sendImages();
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

function sendImages() {
  const form_data = new FormData();
  form_data.append("img-desktop", $("#img-desktop").prop("files")[0]);
  form_data.append("img-mobile", $("#img-mobile").prop("files")[0]);
  $.ajax({
    type: "POST",
    url: "controller/controller-create-shows-images.php",
    data: form_data,
    cache: false,
    contentType: false,
    processData: false,
    success: function() {
      notifications("Espectáculo creado.", "success");
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
