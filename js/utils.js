function validateEmail(email, idInput) {
  const emailRegex = /(.+.*@.+.*\..+.*)/;
  if (email.match(emailRegex)) {
    $(idInput).removeClass("input-text--error");
    return true;
  } else {
    $(idInput)
      .siblings(".error")
      .show();
    $(idInput)
      .siblings(".error")
      .text("Ingresa un correo electrónico válido");
    $(idInput).addClass("input-text--error");
    return false;
  }
}

function validateRequiredFileds(form) {
  const requiredFields = Array.from(
    document.querySelectorAll(`${form} *:required`)
  ).filter(field => {
    const simblings = Array.from(field.parentNode.children);
    if (!field.value) {
      simblings.find(simbling => {
        if (simbling.className === "error") {
          simbling.innerText = "Campo Requerido";
        }
        if (
          simbling.localName !== "label" &&
          !simbling.className.includes("--error") &&
          simbling.localName !== "p"
        ) {
          const modifier = simbling.classList[1] + "--error";
          simbling.className += ` ${modifier}`;
        }
      });
    } else {
      simblings.find(simbling => {
        if (simbling.className === "error") simbling.innerText = "";
        if (simbling.localName !== "label") {
          simbling.classList = Array.from(simbling.classList)
            .filter(classN => !classN.includes("--error"))
            .join(" ");
        }
      });
    }
    return field.value === "";
  });
  return requiredFields.length > 0 ? false : true;
}

function validateArray(array, element, errorText) {
  if (array.length > 0) {
    $(element)
      .siblings(".error")
      .hide();
    return true;
  } else {
    $(element)
      .siblings(".error")
      .show();
    $(element)
      .siblings(".error")
      .text(errorText);
    return false;
  }
}

function notifications(text, type, isTemporal=true) {
  let { information, currentClass } = "";

  switch (type) {
    case "success":
      information = "<strong>¡Éxito!</strong> ";
      $(".alert").addClass("alert-success");
      currentClass = "alert-success";
      break;
    case "info":
      information = "<strong>¡Información!</strong> ";
      $(".alert").addClass("alert-info");
      currentClass = "alert-info";
      break;
    case "warning":
      information = "<strong>¡Advetrencia!</strong> ";
      $(".alert").addClass("alert-warning");
      currentClass = "alert-warning";
      break;
    case "error":
      information = "<strong>¡Érror!</strong> ";
      $(".alert").addClass("alert-danger");
      currentClass = "alert-danger";
      break;
  }
  information += text;

  $(".alert p.information").html(information);
  $(".alert").fadeIn("slow");
  if(isTemporal){
    $(".alert")
    .delay(3000)
    .fadeOut("slow", function() {
      $(this).removeClass(currentClass);
    });
  }

}