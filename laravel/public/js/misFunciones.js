function llenarFormulario (formulario, data){
      $("#"+formulario).find(':input').each(function()
         {
            var elemento = this;

            for(var i in data){
               if(elemento.name == i)
               {
                  elemento.value = data[i];
                  delete data[i];
                  break; 
               }
              
            }
         });
   }