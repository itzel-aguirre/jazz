jQuery(function($) {
  $("#admin").show();
  $("#login").hide();
  //$("#admin").hide();

  $("#login-form").keydown(function(e) {
    if (e.keyCode == 13) {
      login();
    }
  });
  $("#btnEnviar").click(function() {
    login();
  });
  $("#logout").click(function() {
    $("#admin").hide();
    $("#login").show();
  });
});

function login() {
  if (validateRequiredFileds("#login-form")) {
    if (validateEmail($("#email").val())) {
      $("#email").removeClass("input-text--error");
      const email = $("#email").val();
      const password = $("#password").val();
      const loginData = {
        email: email,
        password: password
      };
      $.ajax({
        type: "POST",
        url: "controller/controller-login.php",
        data: JSON.stringify(loginData),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function(data) {
          $(".welcome-text").text("Bienvenido " + data.name);
          $("#admin").show();
          $("#login").hide();
        },
        error: function(errMsg) {
          console.error(errMsg.responseJSON.error);
          $("#login-form")
            .siblings(".error")
            .text(errMsg.responseJSON.error);
        }
      });
    } else {
      $("#email")
        .siblings(".error")
        .show();
      $("#email")
        .siblings(".error")
        .text("Ingresa un correo electrónico válido");
      $("#email").addClass("input-text--error");
    }
  }
}
