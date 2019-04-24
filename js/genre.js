/*
Gets shows list to display
*/ 
jQuery(function($) {
  $.ajax({
    type: "GET",
    url: "controller/controller-list-genre.php",
    contentType: "application/json; charset=utf-8",
    dataType: "json",
    success: function(genres) {
      fillOptions(genres)
    }
  });
});

//Builds options for the genres
function fillOptions(genres){
  let options = ''

  if(genres.length > 0){
    genres.forEach(genre =>{
      options +='<option value="'+genre.id_genre+'">'+genre.genre+'</option>'
    })
  }

  $("#multiple-checkboxes").html(options)
  $('#multiple-checkboxes').multiselect('rebuild');
}