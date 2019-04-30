/*
Gets genres list to display
*/
jQuery(function($) {
    getsGenreList();
});

function getsGenreList() {
  $.ajax({
    type: "GET",
    url: "controller/controller-list-genre.php",
    contentType: "application/json; charset=utf-8",
    dataType: "json",
    success: function(genres) {
      fillOptions(genres);
      fillTableGenres(genres);
    }
  });
}

//Builds options for the genres
function fillOptions(genres) {
  let options = "";

  if (genres.length > 0) {
    genres.forEach(genre => {
      options +=
        '<option value="' + genre.id_genre + '">' + genre.genre + "</option>";
    });
  }

  $("#multiple-checkboxes").html(options);
  $("#multiple-checkboxes").multiselect("rebuild");
}

//Builds the table of genres to
function fillTableGenres(genres) {
  let tr = "";

  if (genres.length > 0) {
    genres.forEach(genre => {
      const information =
        "<td>" +
        genre.genre +
        "</td>" +
        '<td class="actions-buttons">' +
        '<button genre-id="' +
        genre.id_genre +
        '" type="button" class="btn btn-primary btn-lg delete-genre" >' +
        '<i class="mdi mdi-delete mdi-24px"></i></button>' +
        " </td>";

      tr += "<tr>" + information + "</tr>";
    });
  } else {
    tr = '<tr><td colspan="2" class="text-center">No hay resultados</td></tr>';
  }

  $("#table-genres tbody").html(tr);
}

//Handle Delete buttons show
jQuery(function($) {
  $("#table-genres tbody").on("click", "button.delete-genre", function() {
    const idGenre = $(this).attr("genre-id");
    conf = confirm("El género será eliminado. ¿Desea continuar?");
    if (conf) {
      deleteGenre(idGenre);
    } else {
      return false;
    }
  });
});

function deleteGenre(idGenre) {
  const genreData = {
    idGenre: idGenre
  };
  $.ajax({
    type: "DELETE",
    url: "controller/controller-deleteGenre.php",
    data: JSON.stringify(genreData),
    contentType: "application/json; charset=utf-8",
    dataType: "json",
    success: function(genreData) {
      notifications("Género eliminado exitosamente.", "success");
      getsGenreList();
    },
    error: function(errMsg) {
      notifications(errMsg.responseJSON.error, "error");
    }
  });
}
/*Handle create new genre
  Gets all the values from the form
*/
jQuery(function($) {
  $("#add-genre").click(function() {
    if (validateRequiredFileds(".form-genre")) {
      const genreData = {
        genre: $("#genre-input").val()
      };
      $.ajax({
        type: "POST",
        url: "controller/controller-create-genre.php",
        data: JSON.stringify(genreData),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function(data) {
          notifications("Género creado exitosamente.", "success");
          getsGenreList();
          $(".form-genre").trigger("reset");
        },
        error: function(errMsg) {
          notifications(errMsg.responseJSON.error, "error");
          console.error(errMsg.responseJSON.error);
        }
      });
    }
  });
});
