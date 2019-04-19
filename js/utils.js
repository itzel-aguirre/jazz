function validateEmail(email) {
  const emailRegex = /(.+.*@.+.*\..+.*)/;
  if (email.match(emailRegex)) return true;
  return false;
}

function validateRequiredFileds(form) {
  let isValid = false;
  $(form)
    .find("input")
    .each(function() {
      if ($(this).prop("required") && $(this).val().length === 0) {
        $(this)
          .siblings(".error")
          .text("Campo requerido");
        $(this)
          .siblings(".error")
          .show();
        $(this).addClass("input-text--error");
        isValid = false;
      } else {
        $(this)
          .siblings(".error")
          .hide();
        isValid = true;
        $(this).removeClass("input-text--error");
      }
    });
  return isValid;
}

function validateArray(array,element,errorText){
  if(array.length>0){
    $(element).siblings(".error")
    .hide();
    return true
  }
  else{
    $(element)
        .siblings(".error")
        .show();
      $(element)
        .siblings(".error")
        .text(errorText);
        return false;
  }
}

function notifications (text, type){
  let {information,currentClass} = ""

  switch (type) {
    case 'success':
        information= '<strong>¡Éxito!</strong> '
        $('.alert').addClass( "alert-success" )
        currentClass = "alert-success"
        break;
    case 'info':
        information= '<strong>¡Información!</strong> '
        $('.alert').addClass( "alert-info" );
        currentClass = "alert-info"
        break;
    case 'warning':
        information= '<strong>¡Advetrencia!</strong> '
        $('.alert').addClass( "alert-warning" );
        currentClass = "alert-warning"
        break;
    case 'error':
        information= '<strong>¡Érror!</strong> '
        $('.alert').addClass( "alert-danger" );
        currentClass = "alert-danger"
        break;
}
  information+=text;
  
  $('.alert p.information').html(information)
  $('.alert').fadeIn('slow');
  
  $(".alert").delay(3000).fadeOut("slow", function() {
    $(this).removeClass(currentClass);
  });

}