  <footer class="container-fluid footer">
      <div class="p-2 d-flex justify-content-center">
          <a href="https://www.facebook.com/parkerandlenox/" target="_blank">
              <i class="mdi mdi-facebook mdi-24px  icon icon--margin-right"></i>
          </a>
          <a href="https://twitter.com/parkerandlenox" target="_blank">
              <i class="mdi mdi-twitter mdi-24px icon icon--margin-right"></i>
          </a>
          <a href="https://www.instagram.com/parkerandlenox/" target="_blank">
              <i class="mdi mdi-instagram mdi-24px icon icon--margin-right"></i>
          </a>
          <i class="mdi mdi-spotify mdi-24px icon icon--margin-right"></i>
      </div>
      <div class="row justify-content-center">
          <div class="col-10 col-md-5">
              <p class="address"><span class="logo"><img src="images/footer/logo-lenox.svg" alt="Logotipo Lenox" class="img-logo"></span>Milán 14, col. Juárez CDMX</p>
          </div>
      </div>
      <div class="row justify-content-center">
          <hr class="horizontal-line">
          <div class="col-6 col-md-4">
              <a href="terminos-condiciones.php">
                  <p class="text-center link">Términos y Condiciones</p>
              </a>
          </div>
          <div class="col-6 col-md-4">
              <a href="privacidad.php">
                  <p class="text-center link">Política de Privacidad</p>
              </a>
          </div>
      </div>
  </footer>
  <!--js-->
  <script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
  <script src="js/utils.js"></script>
  <script src="js/slider.js"></script>
  <script src="js/table.js"></script>
  <script src="js/reservation.js"></script>
  <script src="js/video.js"></script>
  <!-- End Carousel -->
  <!-- Load Facebook SDK for JavaScript -->
  <div id="fb-root"></div>
  <script>
      window.fbAsyncInit = function() {
          FB.init({
              xfbml: true,
              version: 'v3.2'
          });
      };

      (function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s);
          js.id = id;
          js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
          fjs.parentNode.insertBefore(js, fjs);
     }(document, 'script', 'facebook-jssdk'));

  </script>

  <script>
    const getUrl = window.location;
    const baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
    $('#main-logo').attr("href",baseUrl)
  </script>

  <!-- Your customer chat code -->
  <div class="fb-customerchat" attribution=install_email page_id="388926777938003">
  </div>
  </body>

  </html>