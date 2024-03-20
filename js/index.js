class Index {
    
    constructor(){
        this.carrusel = ['baleares.jpg','Baleares-Mapa.jpg','paisaje.jpg','playa.jpg','puerto.jpg']
        this.carpeta = 'multimedia/image/'
        this.textoImagen = 'Imagen de las Islas Baleares'
        this.index = 0
        this.key = "c4ed265dd950cde9fc4d2b46bf0ee682";
    }

    anterior(){
        this.index -= 1;
        if(this.index == -1){
            this.index = 4;
        }
        $('main section:eq(0) img').attr("src",this.carpeta  + this.carrusel[this.index]);
    }

    siguiente(){
        this.index += 1;
        if(this.index >= 5){
            this.index = 0;
        }
        $('main section:eq(0) img').attr("src",this.carpeta  + this.carrusel[this.index]);
    }


   
    
    ultimaVezActualizado(){
      $("main section:eq(5)").append("<p>"+ document.lastModified+"</p>")
    }


}



class Geolocalizacion {
  constructor (){
      navigator.geolocation.getCurrentPosition(this.getPosicion.bind(this), this.verErrores.bind(this));
  }

  getPosicion(posicion){
      this.longitud         = -5.19014 
      this.latitud          = 43.4676;   
      this.mensaje = "Se ha realizado correctamente la petición de geolocalización";  
      this.key = 'AIzaSyCHrw6i7FALRPCmDi4nPyBhAOgsCdjRunA';
  }

  getLongitud(){
      return this.longitud;
  }

  getLatitud(){
      return this.latitud;
  }
  
  verErrores(error){
      switch(error.code) {
      case error.PERMISSION_DENIED:
          this.mensaje = "El usuario no permite la petición de geolocalización"
          break;
      case error.POSITION_UNAVAILABLE:
          this.mensaje = "Información de geolocalización no disponible"
          break;
      case error.TIMEOUT:
          this.mensaje = "La petición de geolocalización ha caducado"
          break;
      case error.UNKNOWN_ERROR:
          this.mensaje = "Se ha producido un error desconocido"
          break;
      }
  }

  cargarPosicion(){
      if(this.activado != true){
          var datos = ''
          datos+='<section>'; 
          datos+='<p>Error mensaje: '+ this.mensaje +'</p>'
          datos+='<p>Longitud: '+this.longitud +' grados</p>'; 
          datos+='<p>Latitud: '+this.latitud +' grados</p>';
          datos+='</section>'
          $("button").before(datos);
          this.activado = true;
      }
  }

  getMapaEstaticoGoogle(){
      
      var apiKey = "&key=" + this.key;
      var url = "https://maps.googleapis.com/maps/api/staticmap?";
      var centro = "center=" + this.latitud + "," + this.longitud;
      var zoom ="&zoom=15";
      var tamaño= "&size=800x600";
      var marcador = "&markers=color:red%7Clabel:S%7C" + this.latitud + "," + this.longitud;
      var sensor = "&sensor=false"; 
      this.imagenMapa = url + centro + zoom + tamaño + marcador + sensor + apiKey;
      var datos = " <img src='"+this.imagenMapa+"' alt='mapa estático google' /> ";
      $("main section:eq(4)").append(datos)
  }
}
var mapaEstatico = new Geolocalizacion();
var index = new Index();