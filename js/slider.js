/*
Gets shows list to display
*/

jQuery(function($) {
  $.ajax({
    type: "GET",
    url: "controller/controller-list-shows-slider.php",
    contentType: "application/json; charset=utf-8",
    dataType: "json",
    success: function(shows) {
      fillSlider(shows);
        $(".owl-carousel").owlCarousel({
          center: true,
          autoplay: true,
          autoPlayTimeout: 5000,
          autoplayHoverPause: true,
          loop: true,
          margin: 10,
          dots: false,
          responsive: {
              0: {
                  items: 1
              },
              768: {
                  items: 3
              },
              1000: {
                  items: 4
              }
          }
      });
      fillCombobox(shows)
    }
  });
});

function fillSlider(shows){
  let items =''
    shows.forEach(show => {
      const amount = show.amount==='$0.00'?'No cover':show.amount
      items +='<div class="item">'+
                '<div class="card">'+
                  '<picture>'+
                  '<source media="(min-width: 1200px)" srcset="images/slider/'+show.url_img_desktop+'" />'+
                  '<img class="card-img-top" src="images/slider/mobile/'+show.url_img_mobile+'" alt="'+show.artist+'" />'+
                  '</picture>'+
                  '<div class="card-body">'+
                    '<div class="artist-info">'+
                      '<p class="performer">'+
                        '<i class="mdi mdi-account-outline icon--margin-right"></i>'+
                        show.artist+
                        '</p>'+
                        '<p class="genre">'+
                          '<i class="mdi mdi-music icon--margin-right"></i>'+
                          show.genres.join('/')+
                        '</p>'+
                      '</div>'+
                      '<div class="event-info">'+
                        '<div class="row no-gutters">'+
                          '<div class="col-6">'+
                            '<p class="date">'+
                              '<i class="mdi mdi-calendar-text icon--margin-right"></i>'+
                                moment(show.date).format("DD/MMM")+
                            '</p>'+
                            '<p class="time">'+
                              '<i class="mdi mdi-clock-outline icon--margin-right"></i>'+
                                `${moment(show.time).format("HH:mm")} h`+
                            '</p>'+
                            '<p class="cover">'+
                              '<i class="mdi mdi-cash icon--margin-right"></i>'+
                                amount+
                              '</p>'+
                          '</div>'+
                          '<div class="col-6 align-self-center">'+
                            '<div class="row justify-content-center">';
                            show.sold_out === 0 ?
                              items +='<button show-id='+show.id_show+' type="button" class="btn btn-primary btn-lg reserve">'+
                                  'Reserva'+
                                '</button>'
                              :
                              items +='<p class="ticket">'+
                                  'Agotado'+
                                '</p>'
                            items +='</div>'+
                        '</div>'+
                    '</div>'+
                  '</div>'+
                '</div>'+
              '</div>'+
            '</div>';
    });
  $(".main-slider").html(items);
}

function fillCombobox(shows){
  let options ='<option value="" disabled selected>Selecciona</option>'
    shows.forEach(show => {
      options+='<option value="'+show.id_show+'">'+show.artist+'</option>'
    });
    $("#show").html(options);
}

//Handle the show selected and sets the value on the form
jQuery(function($) {
  $(".main-slider ").on('click','button.reserve',function() {
    const id_show = $(this).attr("show-id")
    $("#show").val(id_show);
    getsSchedules(id_show)
    $('html,body').animate({
      scrollTop: $("#reserveForm").offset().top},
      'slow'); 
  });
});

//Handle Date and time by show
jQuery(function($) {
  $('#show').change(function(){
    getsSchedules($('#show').val())
  });
});

function getsSchedules(id_show){
  const showData = {
    id_show:id_show,
  };
  $.ajax({
    type: "POST",
    url: "controller/controller-getschedule-show.php",
    contentType: "application/json; charset=utf-8",
    data: JSON.stringify(showData),
    dataType: "json",
    success: function(schedules) {
      fillSchedules(schedules)
    }
  });
}

function fillSchedules(schedules){
  let options ='<option value="" disabled selected>Selecciona</option>'
  schedules.forEach(schedule => {
      options+='<option value="'+schedule.id_date_hr+'">'+`${moment(schedule.date).format("DD MMM")} / ${moment(schedule.time).format("HH:mm")}`+'</option>'
    });
    $("#date-time").html(options);
}