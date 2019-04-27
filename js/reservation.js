jQuery(function($) {
  $("#btnEnviar").click(function() {
    validarReservation();
  });
});

function validarReservation() {
  if (validateRequiredFileds("#reserveForm")) {
    const email = $("#email").val();
    if (validateEmail(email, "#email")) {
      $("#name").removeClass("input-text--error");
      $("#mobile").removeClass("input-text--error");
      const email = $("#email").val();
      const name = $("#name").val();
      const mobile = $("#mobile").val();
      const show = $("#show").val();
      const dateTime = $("#date-time").val();
      const clients = $("#clients").val();
      const table = $("#table").val();
      let loginData = {
        email: email,
        name: name,
        mobile: mobile,
        show: show,
        dateTime: dateTime,
        clients: clients,
        table: table
      };
      $.ajax({
        type: "POST",
        url: "controller/controller-CreateReservation.php",
        data: JSON.stringify(loginData),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function(data) {
          notifications("Reservación realizada exitosamente.", "success");
          $("#reserveForm").trigger("reset");
          $("#table")
            .find("option")
            .remove();
          $("#table").append(
            '<option value="" disabled="" selected="">Selecciona</option>'
          );
        },
        error: function(errMsg) {
          console.error(errMsg);
          $("#login-form")
            .siblings(".error")
            .text(errMsg);
        }
      });
    }
  }
}

/*
Gets shows list to display
*/
jQuery(function($) {
  $("#reservations-tab").on("click", function(e) {
    getReservationList();
  });
});

function  getReservationList(){
  $.ajax({
    type: "GET",
    url: "controller/controller-reservation-list.php",
    contentType: "application/json; charset=utf-8",
    dataType: "json",
    success: function(reservations) {
      fillTableReservation(reservations);
    }
  });
}

//Builds the table body
function fillTableReservation(reservations) {
  let tr = "";
  let InfoCheck ="";
  if (reservations.length > 0) {
   
    reservations.forEach(reservation => {
      const information =
        "<td>" +
        reservation.full_name +
        "</td>" +
        "<td>" +
        reservation.artist +
        "</td>" +
        "<td>" +
        moment(reservation.date).format("DD/MMMM/YYYY") +
        "</td>" +
        "<td>" +
        `${moment(reservation.hour).format("HH:mm")} h` +
        "</td>" +
        '<td class="actions-buttons">' +
        '<button reservation-id="' +
        reservation.id_reservation +
        '" type="button" class="btn btn-primary btn-lg delete-reservation"><i class="mdi mdi-delete mdi-24px"></i></button>' +
        " </td>"

       if (reservation.no_people >= 7) {
        if ((reservation.deposit_made == 1)) {
          InfoCheck =
          "<td>" +
          '<input type="checkbox"  name="checkDeposito" id="Deposito" value="' +
          reservation.id_reservation +
          '" checked="checked"> Depósito Realizado</input>' +
          "</td>";
        } else {
          InfoCheck =
            "<td>" +
            '<input type="checkbox"  name="checkDeposito" id="Deposito" value="' +
            reservation.id_reservation +
            '"> Depósito Pendiente</input>' +
            "</td>";
        }
      } else {
        InfoCheck = "<td>" + "</td>";
      } 

      tr += "<tr>" + information + InfoCheck + "</tr>";
    });
  } else {
    tr = '<tr><td colspan="6" class="text-center">No hay resultados</td></tr>';
  }

  $("#table-reservation tbody").html(tr);
}

jQuery(function($) {
  $("#table-reservation tbody").delegate("#Deposito", "change", function() {
    const idReservation = $(this).val();
    if ($(this).is(":checked")) {
      update_Deposit(idReservation, 1); //Deposito recibido
    } else {
      update_Deposit(idReservation, 0);
    }
    getReservationList();
  });
});

//Handle Delete buttons show
jQuery(function($) {
  $("#table-reservation tbody").on("click", "button.delete-reservation", function() {
    const idReservation = $(this).attr("reservation-id");
    conf = confirm("La reservación será eliminada. ¿Desea continuar?");
    if (conf) {
      deleteReservations(idReservation);
    } else {
      return false;
    }
  });
});

function deleteReservations(idReservation) {
  const reservationsData = {
    idReservation: idReservation
  };
  $.ajax({
    type: "POST",
    url: "controller/controller-deleteReservations.php",
    data: JSON.stringify(reservationsData),
    contentType: "application/json; charset=utf-8",
    dataType: "json",
    success: function(reservationsData) {

      getReservationList();
      notifications("Reservación eliminada exitosamente.", "success");
      
    },
    error: function(errMsg) {
      notifications("Error al eliminar una reservación.", "error");
    }
  });
}

function update_Deposit(idReservation, deposito) {
  const reservationsData = {
    idReservation: idReservation,
    deposito: deposito
  };
  $.ajax({
    type: "POST",
    url: "controller/controller-updateDeposit.php",
    data: JSON.stringify(reservationsData),
    contentType: "application/json; charset=utf-8",
    dataType: "json",
    success: function(reservationsData) {
      notifications("Depósito registrado exitosamente.", "success");
      getReservationList();
    },
    error: function(errMsg) {
      notifications("Error al registrar el depósito.", "error");
    }
  });
}
