
jQuery(function($) {
    $("#clients").change(function(){
        
        if(!$("#date-time").val()){
           $("#date-time").siblings(".error").show()
           $("#date-time").siblings(".error").text("Seleccione una fecha y hora")
           $("#date-time").addClass("input-text--error")
        }
        else{
            llenarMesas();
        }
    });
});

function llenarMesas(){
    const no_table = $("#clients").val();
    const fecha_Hr = $("#date-time").val();
    let loginData = {
      "no_people": no_table,
      "fecha_Hr": fecha_Hr
    }
   $.ajax({
      type: "POST",
      url: "controller/controller-GetListTable.php",
      data: JSON.stringify(loginData),
      contentType: "application/json; charset=utf-8",
      dataType: "json",
      success: function(data) {
          $("#table").find('option').remove();
          $.each(data, function(id,mesa){
              $("#table").append('<option value="'+mesa.id_table+'">'+mesa.no_table+'</option>');
           });
           $("#table").append('<option value="" disabled="" selected="">Selecciona</option>');
      },
      error: function(errMsg) {
          console.error(errMsg);
          $("#login-form").siblings(".error").text(errMsg)
      }
    });
  }
  