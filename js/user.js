jQuery(function($) {
  $("#user-tab").on("click", function(e) {
    getsUsersList();
  });
});

function getsUsersList() {
  $.ajax({
    type: "GET",
    url: "controller/controller-list-user.php",
    contentType: "application/json; charset=utf-8",
    dataType: "json",
    success: function(users) {
      fillTableUsers(users);
    }
  });
}
function fillTableUsers(users) {
  let tr = "";

  if (users.length > 0) {
    users.forEach(user => {
      const information =
        "<td>" +
        user.name +
        "</td>" +
        "<td>" +
        user.type +
        "</td>" +
        "<td>" +
        user.password +
        "</td>" +
        '<td class="actions-buttons">' +
        '<button user-id="' +
        user.id_user +
        '" type="button" class="btn btn-primary btn-lg delete-user" >' +
        '<i class="mdi mdi-delete mdi-24px"></i></button>' +
        " </td>";

      tr += "<tr>" + information + "</tr>";
    });
  } else {
    tr = '<tr><td colspan="4" class="text-center">No hay resultados</td></tr>';
  }

  $("#table-user tbody").html(tr);
}

//Handle Delete buttons user
jQuery(function($) {
  $("#table-user tbody").on("click", "button.delete-user", function() {
    const idUser = $(this).attr("user-id");
    conf = confirm("El uisuario será eliminado. ¿Desea continuar?");
    if (conf) {
      deleteUser(idUser);
    } else {
      return false;
    }
  });
});

function deleteUser(idUser) {
  const userData = {
    idUser: idUser
  };
  $.ajax({
    type: "POST",
    url: "controller/controller-deleteUser.php",
    data: JSON.stringify(userData),
    contentType: "application/json; charset=utf-8",
    dataType: "json",
    success: function(userData) {
      notifications("Usuario eliminado exitosamente.", "success");
      getsUsersList();
    },
    error: function(errMsg) {
      notifications("Error al eliminar un usuario.", "error");
    }
  });
}

/*Handle create new show
  Gets all the values from the form
*/
jQuery(function($) {
  $("#btnAddUsr").click(function() {
    const email = $("#emailUser").val();
    if (validateRequiredFileds(".form-user")&&
    validateEmail(email, "#emailUser")) {
       {
        const userData = {
          name: $("#nameUser").val(),
          password: $("#passUser").val(),
          rol: $("#rolUser").val(),
          email: $("#emailUser").val(),
        };

        $.ajax({
          type: "POST",
          url: "controller/controller-create-users.php",
          data: JSON.stringify(userData),
          contentType: "application/json; charset=utf-8",
          dataType: "json",
          success: function(data) {
            getsUsersList();
            notifications("Usuario creado exitosamente.", "success");
            $(".form-user").trigger("reset");
          },
          error: function(errMsg) {
            console.error(errMsg.responseJSON.error);
            notifications("Error al crear el usuario", "error");
          }
        });
      }
    }
  });
});