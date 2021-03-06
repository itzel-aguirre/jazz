  <footer class="container-fluid footer">
      <div class="p-2 d-flex justify-content-center">
          <a href="https://www.facebook.com/parkerandlenox/" target="_blank">
              <i class="mdi mdi-facebook mdi-24px  icon icon--margin-right icon--color-gold"></i>
          </a>
          <a href="https://twitter.com/parkerandlenox" target="_blank">
              <i class="mdi mdi-twitter mdi-24px icon icon--margin-right icon--color-gold"></i>
          </a>
          <a href="https://www.instagram.com/parkerandlenox/" target="_blank">
              <i class="mdi mdi-instagram mdi-24px icon icon--margin-right icon--color-gold"></i>
          </a>
          <i class="mdi mdi-spotify mdi-24px icon icon--margin-right icon--color-gold"></i>
      </div>
      <div class="row justify-content-center">
          <div class="col-10 col-md-5">
              <p class="address"><span class="logo"><img src="images/footer/logo-lenox.png" alt="Logotipo Lenox"></span>Milán 14, col. Juárez CDMX</p>
          </div>
      </div>
      <div class="row justify-content-center">
          <hr class="horizontal-line">
          <div class="col-6 col-md-4">
              <a href="#">
                  <p class="text-center link">Términos y Condiciones</p>
              </a>
          </div>
          <div class="col-6 col-md-4">
              <a href="#">
                  <p class="text-center link">Política de Privacidad</p>
              </a>
          </div>
      </div>
  </footer>
  <!--js-->
  <script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
  <!-- Carousel -->
  <script type="text/javascript">
      $(document).ready(function() {
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
      });
  </script>
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

  <!-- Your customer chat code -->
  <div class="fb-customerchat" attribution=install_email page_id="388926777938003">
  </div>
  </body>

  </html> 