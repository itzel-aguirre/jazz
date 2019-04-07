<!DOCTYPE html>
<html lang="es">

<head>
  <!--metas-->
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="author" content="Somefriends">
  <meta name="description" content="Parker&Lenox Restaurante, bar y foro de música en la Ciudad de México (CDMX). La mejor experiencia en un espacio lleno de magia y las mejores presentaciones en vivo.">
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
  <!-- Metadatos Facebook-->
  <meta property="og:url" content="http://parker-lenox.com/" />
  <meta property="og:type" content="website" />
  <meta property="og:title" content="Parker & Lenox" />
  <meta property="og:description" content="Restaurante, bar y foro de música en la Ciudad de México (CDMX). La mejor experiencia en un espacio lleno de magia y las mejores presentaciones en vivo." />
  <meta property="og:image" content="http://parker-lenox.com/images/content/mainBG-desk.jpg" />

  <!-- Metadatos Twitter-->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:site" content="@parkerandlenox">
  <meta name="twitter:creator" content="@parkerandlenox">
  <meta name="twitter:title" content="Parker & Lenox">
  <meta name="twitter:description" content="Restaurante, bar y foro de música en la Ciudad de México (CDMX). La mejor experiencia en un espacio lleno de magia y las mejores presentaciones en vivo.">
  <meta name="twitter:image" content="http://parker-lenox.com/images/content/mainBG-desk.jpg">

  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Admin | Parker & Lenox</title>
  <!--css-->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="css/admin-main.css">
  <link rel="stylesheet" href="//cdn.materialdesignicons.com/3.5.95/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css">

  <!--fonts-->
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700" rel="stylesheet">
  <!--js-->

  <!-- favicon -->
  <link rel="apple-touch-icon" sizes="57x57" href="images/favicon/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="images/favicon/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="images/favicon/apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="images/favicon/apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="images/favicon/apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="images/favicon/apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="images/favicon/apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="images/favicon/apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="images/favicon/apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192" href="images/favicon/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="images/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="images/favicon/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="images/favicon/favicon-16x16.png">
  <link rel="manifest" href="images/favicon/manifest.json">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="images/favicon/ms-icon-144x144.png">
  <meta name="theme-color" content="#ffffff">
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-137244781-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-137244781-1');
  </script>
</head>

<body>
  <section id="login" class="container-fluid">
    <div class="row align-items-center justify-content-center contenido-login">
      <div class="login-wrapper">
        <h1 class="text-center">Iniciar sesión</h1>
        <form id="login-form">
          <div class="form-group">
            <label for="email">Correo</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="correo@ejemplo.com" value="" required />
            <p class="error"></p>
          </div>
          <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Ingresa tu contraseña" value="" required />
            <p class="error"></p>
          </div>
          <button type="button" id="btnEnviar" class="btn btn-primary btn-lg float-right">Enviar</button>
        </form>
        <p class="error"></p>
      </div>
    </div>
  </section>

  <section id="admin" class="container-fluid">
    <div class="row ">
      <div class="col-12 p-0">
        <header>
          <p class="welcome-text">Bienvenido usuario</p>
          <button id="logout" class="btn btn-primary btn-lg">Cerrar Sesión</button>
        </header>
      </div>
    </div>

    <div class="admin-container">
      <ul class="nav nav-tabs" id="adminTabs" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="show-tab" data-toggle="tab" href="#show" role="tab" aria-controls="show" aria-selected="true">Espectáculos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="reservations-tab" data-toggle="tab" href="#reservations" role="tab" aria-controls="reservations" aria-selected="false">Reservaciones</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="false">General</a>
        </li>
      </ul>
      <div class="tab-content" id="adminTabsContent">
        <div class="tab-pane fade show active" id="show" role="tabpanel" aria-labelledby="show-tab">
          <div class="row">
            <div class="col-12">
              <div class="row row--margin-top-bottom justify-content-end">
                <button class="btn btn-primary btn-lg"><i class="mdi mdi-plus icon--margin-right"></i>Agregar Espectáculo</button>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="table-responsive">
              <table class="table table--with-70 table-hover">
                <thead>
                  <th>Artista</th>
                  <th>Fecha</th>
                  <th>Hora</th>
                  <th></th>
                </thead>
                <tbody>
                  <tr>
                    <td>Abel Mirales Cuarteto</td>
                    <td>26 mar</td>
                    <td>22:30 h</td>
                    <td class="actions-buttons">
                      <button class="btn btn-primary btn-lg"><i class="mdi mdi-pencil mdi-24px"></i></button>
                      <button class="btn btn-primary btn-lg"><i class="mdi mdi-delete mdi-24px"></i></button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <form action="">
                <div class="form-row justify-content-center">
                  <fieldset class="col-12 col-md-6 col-xl-12">
                    <div class="form-group">
                      <label for="nameShow">Nombre espectáculo</label>
                      <input id="nameShow" type="text" class="form-control input-text" placeholder="Espectáculo" maxlength="100" />
                    </div>
                    <div class="form-group">
                      <select id="multiple-checkboxes" multiple="multiple">
                        <option value="php">PHP</option>
                        <option value="javascript">JavaScript</option>
                        <option value="java">Java</option>
                        <option value="sql">SQL</option>
                        <option value="jquery">Jquery</option>
                        <option value=".net">.Net</option>
                      </select>
                    </div>
                  </fieldset>
                  <fieldset class="col-12 col-md-6 col-xl-12">
                    <div class="col-12">
                      <div class="row justify-content-end">
                        <button class="btn btn-primary btn-lg">Enviar</button>
                      </div>
                    </div>
                  </fieldset>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="reservations" role="tabpanel" aria-labelledby="reservations-tab">...

        </div>
        <div class="tab-pane fade" id="general" role="tabpanel" aria-labelledby="general-tab">...

        </div>
      </div>
    </div>

  </section>

  <!--js-->
  <script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.min.js"></script>

  <!--Checkboxes script-->
  <script>
    $(document).ready(function() {
      $('#multiple-checkboxes').multiselect({
        includeSelectAllOption: true,
      });
    });
  </script>
  <script>
    $(document).ready(function() {
      $("#admin").hide();
      $('#login-form').keydown(function(e) {
        if (e.keyCode == 13) {
          login();
        }
      })
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
          $("#email").removeClass("input-text--error")
          const email = $("#email").val();
          const password = $("#password").val();
          let loginData = {
            "email": email,
            "password": password
          }
          $.ajax({
            type: "POST",
            url: "controller/controller-login.php",
            data: JSON.stringify(loginData),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data) {
              $(".welcome-text").text("Bienvenido " + data.name)
              $("#admin").show();
              $("#login").hide();
            },
            error: function(errMsg) {
              console.error(errMsg.responseJSON.error);
              $("#login-form").siblings(".error").text(errMsg.responseJSON.error)
            }
          });
        } else {
          $("#email").siblings(".error").show()
          $("#email").siblings(".error").text("Ingresa un correo electrónico válido")
          $("#email").addClass("input-text--error")
        }
      }
    }

    function validateEmail(email) {
      const emailRegex = /(.+.*@.+.*\..+.*)/;
      if (email.match(emailRegex))
        return true;
      return false;
    }

    function validateRequiredFileds(form) {
      let isValid = false
      $(form).find('input').each(function() {
        if ($(this).prop('required') && $(this).val().length === 0) {
          $(this).siblings(".error").text("Campo requerido");
          $(this).siblings(".error").show()
          $(this).addClass("input-text--error")
          isValid = false
        } else {
          $(this).siblings(".error").hide()
          isValid = true
          $(this).removeClass("input-text--error")
        }
      });
      return isValid;
    }
  </script>
</body>

</html>