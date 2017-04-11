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

Date.prototype.addDays = function(days) {
  var dat = new Date(this.valueOf());
  dat.setDate(dat.getDate() + days);
  return dat;
}

   function formatearFecha(fecha)
   {
      var a = fecha.split('/');
      a.reverse();
      var j = a.join('-');
      return j;         
   }