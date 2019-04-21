jQuery(function($) {
  $("#admin").hide();
  if (typeof Storage !== "undefined") {
    if (sessionStorage.loginData) {
      loginData = JSON.parse(sessionStorage.getItem("loginData"));
      login(loginData.email, loginData.password);
    }
  } else {
    document.getElementById("result").innerHTML =
      "Sorry, your browser does not support Web Storage...";
  }

  $("#login-form").keydown(function(e) {
    if (e.keyCode == 13) {
      const email = $("#email").val();
      const password = $("#password").val();
      if (
        validateRequiredFileds("#login-form") &&
        validateEmail(email, "#email")
      ) {
        login(email, password);
      }
    }
  });
  $("#btnEnviar").click(function() {
    const email = $("#email").val();
    const password = $("#password").val();

    if (
      validateRequiredFileds("#login-form") &&
      validateEmail(email, "#email")
    ) {
      login(email, password);
    }
  });
  $("#logout").click(function() {
    $("#admin").hide();
    $("#login").show();
    sessionStorage.clear();
  });
});

function login(email, password) {
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
      if (typeof Storage !== "undefined") {
        sessionStorage.setItem("loginData", JSON.stringify(loginData));
      } else {
        document.getElementById("result").innerHTML =
          "Sorry, your browser does not support Web Storage...";
      }
    },
    error: function(errMsg) {
      console.error(errMsg.responseJSON.error);
      $("#login-form")
        .siblings(".error")
        .text(errMsg.responseJSON.error);
    }
  });
}
