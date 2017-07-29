
jQuery(document).ready(function() {


var ok = "#btnOK";
var clean = "#btnClean";
var radio = ":radio";
var msgbox ="#msg-box span";
var color;

$(ok).on("click" , function(){
  //Check se há alguma opção selecionada
  if($(radio).is(":checked")){

    $.each($("input[type='radio']"), function(id , val){
      if($(val).is(":checked")){
        color = $(val).val();
        return false;
      };
    });
    //var color = $(radio).is("checked").prop("id");
    console.log(color);
    $(msgbox)
    .html("Foi selecionado a opção <strong>" + color + "</strong>.")
    .removeClass()
    .addClass("alert alert-success")
    .show();

    setTimeout(function(){
      $(msgbox).hide();
    } , 5000);                      
  } else {

    $(msgbox)
    .html("Não foi selecionado nenhuma opção")
    .removeClass()
    .addClass("alert alert-danger")
    .show();

    setTimeout(function(){
      $(msgbox + " span").hide();
    } , 5000);

  }
});

$(clean).on('click' , function(){
  $(radio).prop("checked" , false);
})
    
    
    
});
