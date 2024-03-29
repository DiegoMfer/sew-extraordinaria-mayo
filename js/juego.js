class Juego {

    calcular(){

        

        var resultado = 0;
        var respuestas = 0;
        var checkedInputs = $('input[type="radio"]:checked');
        checkedInputs.each(function() {
            respuestas += 1;
            if($(this).val() == 'true'){
                resultado += 1;
            } 
        });

        if(respuestas == 10){
            $('section:eq(1)').remove();
            $("main").append("<section>");
            $("section").last().append("<h2> El resultado del juego en nota en base 10 es: " + resultado + "</h2>")
        }
        else{
            $('section:eq(1)').remove();
            $("main").append("<section>");
            $("section").last().append("<h2> Quedan " + (10 - respuestas)  + " preguntas por responder</h2>")
        }
       
        
       
    }
}

var juego = new Juego();