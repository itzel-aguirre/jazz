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
    }
  });
});

function fillSlider(shows){
  let items =''
    shows.forEach(show => {
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
                                show.amount+
                              '</p>'+
                          '</div>'+
                          '<div class="col-6 align-self-center">'+
                            '<div class="row justify-content-center">'+
                              '<button type="button" class="btn btn-primary btn-lg">'+
                                'Reserva'+
                              '</button>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                  '</div>'+
                '</div>'+
              '</div>'+
            '</div>';
    });
  $(".main-slider").html(items);
}