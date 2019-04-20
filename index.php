<?php
include 'header.php';
/**
 * 	@author Amilkhael Chávez Delgado;
 *	Documento: Index del la landing
 */
?>

<!--Carousel Wrapper-->
<div class="container-fluid">
  <div class="row">
    <div class="col-12 mh-100 p-0 d-flex align-self-end">
      <iframe
        src="https://www.youtube.com/embed/O0rUauUjKVg"
        frameborder="0"
        allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
        allowfullscreen
        class="video-yt"
      ></iframe>
    </div>
  </div>
  <div class="row row--background-red">
    <div class="col-12">
      <p class="title">Cartelera semanal</p>
    </div>
  </div>
  <div class="row">
    <div class="main-slider owl-carousel"></div>
  </div>
  <div class="row row--background-red">
    <div class="col">
      <p class="first-copy">
        Escuchar música no es suficiente; tienes que ser capaz de verla.
      </p>
    </div>
  </div>
  <div class="row">
    <div class="col-6 col-xl-6 mh-100 p-0">
      <div
        class="background-image background-image__button background-image__button--drink"
      >
        <a href="downloads/bebidas.pdf" target="_blank">Coctelería</a>
      </div>
    </div>
    <div class="col-6 col-xl-6 mh-100 p-0">
      <div
        class="background-image background-image__button background-image__button--food"
      >
        <a href="downloads/comida.pdf" target="_blank">Gastronomía</a>
      </div>
    </div>
  </div>
  <div class="row row--background-red">
    <div class="col-12">
      <p class="title">Reservaciones</p>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <form id="reserveForm" action="">
        <div class="form-row justify-content-center">
          <fieldset class="col-12 col-md-6 col-xl-5">
            <div class="form-group">
              <label for="name">Nombre completo</label>
              <input
                id="name"
                type="text"
                class="form-control input-text"
                placeholder="Nombre"
              />
            </div>
            <div class="form-group">
              <label for="email">Correo electrónico</label>
              <input
                type="email"
                id="email"
                class="form-control input-text"
                placeholder="correo@ejemplo.com"
              />
            </div>
            <div class="form-group">
              <label for="mobile">Celular</label>
              <input
                type="number"
                id="mobile"
                class="form-control input-text"
                placeholder="5540123487"
              />
            </div>
          </fieldset>
          <fieldset class="col-12 col-md-6 col-xl-5">
            <div class="form-group">
              <label for="show">Espectáculo</label>
              <select id="show" class="form-control" required> </select>
            </div>
            <div class="form-group">
              <label for="date-time">Fecha y hora</label>
              <select id="date-time" class="form-control " required>
                <option value="" disabled selected>Selecciona</option>
                <option value="volvo">26 mar / 22:30</option>
              </select>
            </div>
            <div class="row ">
              <div class="form-group col-6">
                <label for="clients"># Personas</label>
                <input
                  type="number"
                  id="clients"
                  class="form-control input-text"
                  min="1"
                  max="30"
                  value="1"
                />
              </div>
              <div class="form-group col-6 align-self-end">
                <label for="table">Mesa</label>
                <select id="table" class="form-control" required>
                  <option value="" disabled selected>Selecciona</option>
                  <option value="volvo">1</option>
                  <option value="volvo">50</option>
                  <option value="volvo">23</option>
                </select>
              </div>
            </div>
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
  <div class="row">
    <div class="col-6 d-none d-md-block mh-100 p-0">
      <iframe
        src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d517.8516407387972!2d-99.15644784371455!3d19.43061077713533!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x232dad92e8d474db!2sParker+%26+Lenox!5e0!3m2!1sen!2smx!4v1553575383953"
        class="map d-xs-none"
        frameborder="0"
        style="border:0"
        allowfullscreen
      ></iframe>
    </div>
    <div class="col-6 d-none d-md-block mh-100 p-0">
      <div class="background-image background-image__third-image"></div>
    </div>
    <iframe
      src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d517.8516407387972!2d-99.15644784371455!3d19.43061077713533!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x232dad92e8d474db!2sParker+%26+Lenox!5e0!3m2!1sen!2smx!4v1553575383953"
      class="map d-block d-sm-none"
      frameborder="0"
      style="border:0"
      allowfullscreen
    ></iframe>
  </div>
</div>
<?php include 'footer.php'; ?>
