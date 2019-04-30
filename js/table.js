jQuery(function($) {
  $("#general-tab").on("click", function(e) {
    getsTablesList();
  });
});

jQuery(function($) {
  const tablesParcialView = [2, 3, 20, 56];
  $("#clients").change(function() {
    if (!$("#date-time").val()) {
      $("#date-time")
        .siblings(".error")
        .show();
      $("#date-time")
        .siblings(".error")
        .text("Seleccione una fecha y hora");
      $("#date-time").addClass("input-text--error");
    } else {
      llenarMesas($("#clients").val(), $("#date-time").val());
    }
  });
  $("#date-time").change(function() {
    if ($("#date-time").val()) {
      $("#date-time")
        .siblings(".error")
        .hide();
      $("#date-time").removeClass("input-text--error");
      if ($("#clients").val()) {
        llenarMesas($("#clients").val(), $("#date-time").val());
      }
    }
  });

  $("#table").change(function() {
    const numberTable = $("#table option:selected").text();
    if (tablesParcialView.includes(Number(numberTable))) {
      notifications(`Mesa ${numberTable} con vista parcial`, "warning", false);
    } else {
      $(".alert").fadeOut("slow", function() {
        $(this).removeClass("alert-warning");
      });
    }
  });
});

function llenarMesas(no_table, fecha_Hr) {
  let loginData = {
    no_people: no_table,
    fecha_Hr: fecha_Hr
  };
  $.ajax({
    type: "POST",
    url: "controller/controller-GetListTable.php",
    data: JSON.stringify(loginData),
    contentType: "application/json; charset=utf-8",
    dataType: "json",
    success: function(data) {
      $("#table")
        .find("option")
        .remove();
      $.each(data, function(id, mesa) {
        $("#table").append(
          '<option value="' + mesa.id_table + '">' + mesa.no_table + "</option>"
        );
      });
      $("#table").append(
        '<option value="" disabled="" selected="">Selecciona</option>'
      );
    },
    error: function(errMsg) {
      console.error(errMsg);
      $("#table")
        .find("option")
        .remove();
      $("#table").append(
        '<option value="" disabled="" selected="">Sin mesas disponibles</option>'
      );
      $("#login-form")
        .siblings(".error")
        .text(errMsg);
    }
  });
}

/*
Gets tables list to display
*/

function getsTablesList() {
  $.ajax({
    type: "GET",
    url: "controller/controller-list-all-tables.php",
    contentType: "application/json; charset=utf-8",
    dataType: "json",
    success: function(tables) {
      fillTableTables(tables);
    }
  });
}

function fillTableTables(tables) {
  let tr = "";

  if (tables.length > 0) {
    tables.forEach(table => {
      const information =
        "<td>" +
        table.no_table +
        "</td>" +
        "<td>" +
        table.min_person +
        "</td>" +
        "<td>" +
        table.max_person +
        "</td>" +
        '<td class="actions-buttons">' +
        '<button table-id="' +
        table.id_table +
        '" type="button" class="btn btn-primary btn-lg delete-table" >' +
        '<i class="mdi mdi-delete mdi-24px"></i></button>' +
        " </td>";

      tr += "<tr>" + information + "</tr>";
    });
  } else {
    tr = '<tr><td colspan="4" class="text-center">No hay resultados</td></tr>';
  }

  $("#table-tables tbody").html(tr);
}

/**
 * Handle create new table
 */
jQuery(function($) {
  $("#add-table").click(function() {
    if (validateRequiredFileds(".form-tables")) {
      if ($("#min-person-input").val() <= $("#max-person-input").val()) {
        const tableData = {
          noTable: $("#table-input").val(),
          minPerson: $("#min-person-input").val(),
          maxPerson: $("#max-person-input").val()
        };
        $.ajax({
          type: "POST",
          url: "controller/controller-create-table.php",
          data: JSON.stringify(tableData),
          contentType: "application/json; charset=utf-8",
          dataType: "json",
          success: function(data) {
            notifications("Mesa creada exitosamente.", "success");
            getsTablesList();
            $(".form-tables").trigger("reset");
          },
          error: function(errMsg) {
            notifications(errMsg.responseJSON.error, "error");
            console.error(errMsg.responseJSON.error);
          }
        });
      } else {
        $("#min-person-input")
          .siblings(".error")
          .show();
        $("#min-person-input")
          .siblings(".error")
          .text("Ingresa un número menor al mayor de personas");
      }
    }
  });
});

//Handle Delete buttons show
jQuery(function($) {
  $("#table-tables tbody").on("click", "button.delete-table", function() {
    const idTable = $(this).attr("table-id");
    conf = confirm("La mesa será eliminada. ¿Desea continuar?");
    if (conf) {
      deleteTable(idTable);
    } else {
      return false;
    }
  });
});

function deleteTable(idTable) {
  const tableData = {
    idTable: idTable
  };
  $.ajax({
    type: "DELETE",
    url: "controller/controller-deleteTable.php",
    data: JSON.stringify(tableData),
    contentType: "application/json; charset=utf-8",
    dataType: "json",
    success: function(tableData) {
      notifications("Mesa eliminada exitosamente.", "success");
      getsTablesList();
    },
    error: function(errMsg) {
      notifications(errMsg.responseJSON.error, "error");
    }
  });
}
