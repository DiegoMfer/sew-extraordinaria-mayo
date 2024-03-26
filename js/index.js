class Index {
    
    constructor(){
        this.carrusel = ['baleares.jpg','Baleares-Mapa.jpg','paisaje.jpg','playa.jpg','puerto.jpg']
        this.carpeta = 'multimedia/image/'
        this.textoImagen = 'Imagen de las Islas Baleares'
        this.index = 0
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

    //sexip11104@rockdian.com 9!RSg66*Ro*^
    //jixel20241@shaflyn.com 4b599a13e3434e658a83954f78d06ae4 https://newsapi.org/docs/get-started#search
    //jixel20241@shaflyn.com https://newsdata.io/documentation/#first-api-request
    cargarNoticias(){
      
        var settings = {
            "url": "https://newsdata.io/api/1/news?apikey=pub_40700bc2ea6eab212dcda37877ccfb028a0d8&q=islas baleares",
            "method": "GET",
            "timeout": 0,
          };

          

          $.ajax(settings).done(function(response) {
            var datos = "";
            $.each(response.results, function(index, article) {
                datos += "<p> Título: " + article.title + "</p>";
                datos += "<p> Descripción: " + article.description + "</p>";
                datos += "<p> Enlace: <a href='" + article.link + "'>" + article.link + "</a></p>";
                datos += "<p> ------------------------------------------------ </p>";
            });
            $("main section:eq(2)").append(datos);
            $("main section:eq(2) button").attr("disabled", "disabled");
        });
    }


    cargarDatosMeteorológicos() {

        var settings = {
            dataType:"json",
            url:
              "https://api.openweathermap.org/data/2.5/weather?q=Palma de Mallorca,ES&units=metric&lang=es&APPID=ef31978d6c1730f185266d2fcfef78b8",
            method: "GET",
            timeout: 0,
          };
      
    
    
        $.ajax(settings).done(function (datos) {
            var meteo = ("<p>Datos de las Islas Baleares</p>")
             meteo +=("<p>País: " +  datos.sys.country + "</p>");
             meteo +=("<p>Latitud: " +  datos.coord.lat + " grados</p>");
             meteo +=("<p>Longitud: " +  datos.coord.lon + " grados</p>");
             meteo +=("<p>Temperatura: " +  datos.main.temp + " grados Celsius</p>");
             meteo +=("<p>Temperatura máxima: " +  datos.main.temp_max + " grados Celsius</p>");
             meteo +=("<p>Temperatura mínima: " +  datos.main.temp_min + " grados Celsius</p>");
             meteo +=("<p>Presión: " +  datos.main.pressure + " milímetros</p>");
             meteo +=("<p>Humedad: " +  datos.main.humidity + "%</p>"); 
             meteo +=("<p>Amanece a las: " + new Date( datos.sys.sunrise *1000).toLocaleTimeString() + "</p>"); 
             meteo +=("<p>Oscurece a las: " + new Date( datos.sys.sunset *1000).toLocaleTimeString() + "</p>"); 
             meteo +=("<p>Dirección del viento: " +  datos.wind.deg + "  grados</p>");
             meteo +=("<p>Velocidad del viento: " +  datos.wind.speed + " metros/segundo</p>");
             meteo +=("<p>Hora de la medida: " + new Date( datos.dt *1000).toLocaleTimeString() + "</p>");
             meteo +=("<p>Fecha de la medida: " + new Date( datos.dt *1000).toLocaleDateString() + "</p>");
             meteo +=("<p>Descripción: " +  datos.weather[0].description + "</p>");
             meteo +=("<p>Visibilidad: " +  datos.visibility + " metros</p>");
             meteo +=("<p>Nubosidad: " +  datos.clouds.all + " %</p>");
    
             $("main section:eq(1)").append(meteo)
             $("main section:eq(1) button").attr("disabled","disabled");
            
        });   
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
      this.longitud         = 3.0294800 
      this.latitud          = 39.6099200;   
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
      var zoom ="&zoom=8";
      var tamaño= "&size=800x600";
      var marcador = "&markers=color:red%7Clabel:S%7C" + this.latitud + "," + this.longitud;
      var sensor = "&sensor=false"; 
      this.imagenMapa = url + centro + zoom + tamaño + marcador + sensor + apiKey;
      var datos = " <img src='"+this.imagenMapa+"' alt='mapa estático google' /> ";
      $("main section:eq(3)").append(datos)
      $("main section:eq(3) button").remove();

  }
}
var mapaEstatico = new Geolocalizacion();
var index = new Index();