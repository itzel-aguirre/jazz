jQuery(function($) {
  getCurrentVideo()
});
function getCurrentVideo(){
  $.ajax({
    type: "GET",
    url: "controller/controller-get-current-video.php",
    contentType: "application/json; charset=utf-8",
    dataType: "json",
    success: function(video) {
      $("video-input").val(video.url)
    }
  });
}

/**
 * Handle updtae video
 */

jQuery(function($) {
  $("#save-video").click(function() {
    if (validateRequiredFileds(".form-video")) {
      const videoData = {
        url: $("#video-input").val()
      };
      $.ajax({
        type: "PUT",
        url: "controller/controller-update-video.php",
        data: JSON.stringify(videoData),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function(data) {
          notifications("Video actualizado exitosamente.", "success");
        },
        error: function(errMsg) {
          notifications(errMsg.responseJSON.error, "error");
          console.error(errMsg.responseJSON.error);
        }
      });
    }
  });
});