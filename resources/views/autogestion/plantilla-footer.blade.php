  <footer class="sticky-footer pt-4 pt-md-5 border-top">
    <div class="row">
      <div class="col-md-3 ml-3">
        <img src="{{asset('images/logo_uba_footer.gif')}}" alt="Universidad de Buenos Aires" />    
      </div>
      <div class="col-md-2 offset-md-1">
        <h5>Mapa del sitio</h5>
        <ul class="list-unstyled text-small">
          <li><a class="text-muted" href="https://getbootstrap.com/docs/4.2/examples/pricing/#">Oferta Académica</a></li>
          <li><a class="text-muted" href="https://getbootstrap.com/docs/4.2/examples/pricing/#">Contactos</a></li>
        </ul>
      </div>
      <div class="col-md-3">
        <h5>Información general</h5>
        <ul class="list-unstyled text-small">
          <li><a class="text-muted" target="_blank" href="https://www.fmed.uba.ar/cursos-de-posgrado-y-prog-de-actualizacion/informacion-general">Cursos de Posgrado y Prog. de Actualización</a></li>
          <li><a class="text-muted" target="_blank" href="https://www.fmed.uba.ar/carreras-de-especialistas/informacion-general">Carrera de especialistas</a></li>
          <li><a class="text-muted" target="_blank" href="https://www.fmed.uba.ar/maestrias/informacion-general">Maestrías</a></li>
          <li><a class="text-muted" target="_blank" href="https://www.fmed.uba.ar/doctorados/informacion-general-0">Doctorados</a></li>
        </ul>
      </div>
      <div class="col-md-2">
        <h5>Ubicación</h5>
        <ul class="list-unstyled text-small">
          <li><a class="text-muted" target="_blank" href="https://goo.gl/maps/hyeSyTSVBBs">Paraguay 2155, Ciudad Autónoma de Buenos Aires</a></li>
        </ul>
      </div>
    </div>
  </footer>
  <div class="bg-dark py-md-3">
    <div class="col-md-12">
      <div class="copyright text-center my-auto">
        <small class="d-block text-muted">©{{ date("Y") }} {{ env('APP_NAME') }} - {{ env('ORG_NAME') }}</small>
      </div>
    </div>
  </div>
</body>
</html>