class Rutas {
    load() {
      this.getXML();
    }
  
    getXML() {
      $.ajax({
        url: "xml/rutas.xml",
        dataType: "xml",
        success: function (data) {
          $(data)
            .find("rutas ruta")
            .each(function () {
              //------------------- nombre_ruta ---------------------
              let nombre_ruta = $(this).find("nombre_ruta").text();
              $("main").append("<section>");
              $("main section:last").append(
                "<h2> Nombre ruta: " + nombre_ruta + "</h2>"
              );
              //------------------- tipo_ruta ----------------------------
              let tipo_ruta = $(this).find("tipo_ruta").text();
              $("main section:last").append(
                "<p> Tipo ruta: " + tipo_ruta + "</p>"
              );
              //------------------- transporte ----------------------------
              let transporte = $(this).find("transporte").text();
              $("main section:last").append(
                "<p> Transporte: " + transporte + "</p>"
              );
              //------------------- fecha_inicio ----------------------------
              let fecha_inicio = $(this).find("fecha_inicio").text();
              $("main section:last").append(
                "<p> Fecha inicio: " + fecha_inicio + "</p>"
              );
              //------------------- hora_inicio ----------------------------
              let hora_inicio = $(this).find("hora_inicio").text();
              $("main section:last").append(
                "<p> Hora inicio: " + hora_inicio + "</p>"
              );
              //------------------- duracion ----------------------------
              let duracion = $(this).find("duracion").text();
              $("main section:last").append("<p> Duracion: " + duracion + "</p>");
              //------------------- agencia ----------------------------
              let agencia = $(this).find("agencia").text();
              $("main section:last").append("<p> Agencia: " + agencia + "</p>");
              //------------------- descripcion ----------------------------
              let descripcion = $(this).find("descripcion").text();
              $("main section:last").append(
                "<p> Agencia: " + descripcion + "</p>"
              );
              //-------------------- personas_adecuadas --------------------------
              let personas_adecuadas = $(this).find("personas_adecuadas").text();
              $("main section:last").append(
                "<p> Personas adecuadas: " + personas_adecuadas + "</p>"
              );
              //------------------- lugar_inicio ---------------------------
              let lugar_inicio = $(this).find("lugar_inicio").text();
              $("main section:last").append(
                "<p> Lugar inicio: " + lugar_inicio + "</p>"
              );
              //------------------- direccion_inicio ---------------------------
              let direccion_inicio = $(this).find("direccion_inicio").text();
              $("main section:last").append(
                "<p> Dirección inicio: " + direccion_inicio + "</p>"
              );
              //-------------------- coordenadas ------------------------------
              $("main section:last").append("<p> COORDENADAS </p>");
              //-------------------- longitud --------------------------
              let longitud = $(this).find("coordenadas").find("longitud");
              $("main section:last").append("<p> Longitud: " + longitud + "</p>");
              //--------------------- latitud -------------------------
              let latitud = $(this).find("coordenadas").find("latitud");
              $("main section:last").append("<p> Latitud: " + latitud + "</p>");
              //---------------------- altitud ------------------------
              let altitud = $(this).find("coordenadas").find("altitud");
              $("main section:last").append("<p> Altitud: " + altitud + "</p>");
              //---------------------- referencias-----------------------
              $("main section:last").append("<p> REFERENCIAS </p>");
              $(this)
                .find("referencias referencia")
                .each(function () {
                  let refernecia = $(this).text();
                  $("main section:last").append(
                    "<p> Referencia: " + refernecia + "</p>"
                  );
                });
              //----------------------- recomendacion ----------------------
              let recomendacion = $(this).find("recomendacion");
              $("main section:last").append(
                "<p> Recomendacion: " + recomendacion + "</p>"
              );
              //----------------------- HITOS ----------------------
              $("main section:last").append("<p> HITOS </p>");
              $(this)
                .find("hitos hito")
                .each(function () {
                  let nombre_hito = $(this).find("nombre_hito").text();
                  $("main section:last").append(
                    "<p> Nombre hito: " + nombre_hito + "</p>"
                  );
                  let descripcion_hito = $(this).find("descripcion_hito").text();
                  $("main section:last").append(
                    "<p> Descripcion hito: " + descripcion_hito + "</p>"
                  );
  
                  let longitud = $(this)
                    .find("coordenadas_hito")
                    .find("longitud");
                  $("main section:last").append(
                    "<p> Longitud hito: " + longitud + "</p>"
                  );
                  //--------------------- latitud -------------------------
                  let latitud = $(this).find("coordenadas_hito").find("latitud");
                  $("main section:last").append(
                    "<p> Latitud hito: " + latitud + "</p>"
                  );
                  //---------------------- altitud ------------------------
                  let altitud = $(this).find("coordenadas_hito").find("altitud");
                  $("main section:last").append(
                    "<p> Altitud hito: " + altitud + "</p>"
                  );
                  //---------------------- distancia hito ----------------------
                  let distancia_hito = $(this)
                    .find("distancia_hito")
                    .attr("distancia");
                  $("main section:last").append(
                    "<p> Distancia hito: " + distancia_hito + " </p>"
                  );
  
                  //---------------------- galeria fotos -------------------
                  $("main section:last").append("<p> Fotos hito </p>");
                  $(this)
                    .find("galeria_fotos foto")
                    .each(function () {
                      $("main section:last").append("<p> Foto: </p>");
                      $("main section:last").append(
                        '<img src="multimedia/images/' +
                          $(this).text() +
                          '"  alt=" imagen de la ruta " />'
                      );
                    });
  
                  //---------------------- galeria videos -------------------
                  $("main section:last").append("<p> Videos hito </p>");
                  $(this)
                    .find("galeria_videos video")
                    .each(function () {
                      $("main section:last").append("<p> Video: </p>");
                      $("main section:last").append(
                        '<img src="multimedia/video/' +
                          $(this).text() +
                          '"  alt=" video de la ruta " />'
                      );
                    });
                });
  
              //----------------------------------------------
              let planimetria = $(this).find("planimetria");
              $("main section:last").append(
                "<p> Planimetria: " + planimetria + "</p>"
              );
              //----------------------------------------------
              let altimetria = $(this).find("altimetria");
              $("main section:last").append(
                "<p> Altimetria: " + altimetria + "</p>"
              );
              //----------------------------------------------
            });
        },
        error: function () {
          $(".timeline").text("Failed to get feed");
        },
      });
    }
  
    generateKML() {
      // Cargar el XML
      $.ajax({
        url: "xml/rutas.xml",
        dataType: "xml",
        success: function (xml) {
          // Recorrer las rutas
          $(xml)
            .find("ruta")
            .each(function () {
  
              var nombreRuta = $(this).find("nombre_ruta").text();
  
              // Contenido del archivo de texto
              var content = '<?xml version="1.0" encoding="UTF-8"?> <kml>'
              
              content += "<Document>"
              content += "<Placemark>"
              content += "<name>"+nombreRuta+"</name> <LineString><extrude>1</extrude><tessellate>1</tessellate><coordinates>"
              var hitos = $(this).find("hito");
              
              
              hitos.each(function () {
                var longitud = $(this).find("longitud").text();
                var latitud = $(this).find("latitud").text();
                var altitud = $(this).find("altitud").text();
                var coordinateText =
                  longitud + "," + latitud + "," + altitud + "\n";
                content += coordinateText;
               
              });
              
              content += "</coordinates>"
              content += "</LineString>"
              content += "</Placemark>"
              content += "</Document>"
              content += "</kml>"
  
  
              // Crear un elemento de enlace
              var link = document.createElement("a");
              link.setAttribute("href", "data:text/plain;charset=utf-8," + encodeURIComponent(content));
              link.setAttribute("download", nombreRuta + ".kml");
              link.style.display = "none";
  
              // Agregar el enlace al documento
              document.body.appendChild(link);
  
              // Simular un clic en el enlace para descargar el archivo
              link.click();
  
              // Eliminar el enlace del documento
              document.body.removeChild(link);
            });
        },
      });
    }
  
    generateSVG() {
      // Cargar el XML
      $.ajax({
        url: "xml/rutas.xml",
        dataType: "xml",
        success: function (xml) {
          // Recorrer las rutas
          $(xml)
            .find("ruta")
            .each(function () {
  
              var nombreRuta = $(this).find("nombre_ruta").text();
  
              // Contenido del archivo de texto
              var content = '<?xml version="1.0" encoding="UTF-8" ?> <svg xmlns="http://www.w3.org/2000/svg" version="2.0">'
              
              content += "<polyline points="
  
              var hitos = $(this).find("hito");
              content += '"'
              var counter = 0
  
              content += counter + ',' + 160 +'\n'
              hitos.each(function () {
                var altitud = $(this).find("altitud").text();
                counter += 40
                content += counter + ',' + altitud +'\n'
                
               
              });
              content += counter + 40 + ',' + 160 +'\n'
              content += 0 + ',' + 160 +'\n'
              content += '" style="fill:white;stroke:red;stroke-width:4" />'
              content += 'Su agente de usuario no soporta SVG \n';
  
              counter = 0
              hitos.each(function () {
                var nombreHito = $(this).find("nombre_hito").text();
                counter += 40
               
                content += '<text x="' + counter +'" y="'+ 180 + '" style="writing-mode: tb; glyph-orientation-vertical: 0;">'
                content += nombreHito
                content += "</text>"
                
               
              });
  
              content += '</svg>';
  
  
              // Crear un elemento de enlace
              var link = document.createElement("a");
              link.setAttribute("href", "data:text/plain;charset=utf-8," + encodeURIComponent(content));
              link.setAttribute("download", nombreRuta + ".svg");
              link.style.display = "none";
  
              // Agregar el enlace al documento
              document.body.appendChild(link);
  
              // Simular un clic en el enlace para descargar el archivo
              link.click();
  
              // Eliminar el enlace del documento
              document.body.removeChild(link);
            });
        },
      });
    }
  }
  
  var rutas = new Rutas();