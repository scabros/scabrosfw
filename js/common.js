function showNotif(type, msg){
	notif({
	  type: type,
	  msg: msg,
	  position: "center",
	  opacity: 0.8,
	  multiline: true,
	  width: 200,
	  fade: true
	});
}

function ucwords (str) {
    return (str + '').replace(/^([a-z])|\s+([a-z])/g, function ($1) {
        return $1.toUpperCase();
    });
}

function ajxWrapper(file, params, callback){
  dimOn();
  $.ajax({
    type: "POST",
    url: file,
    data: params,
    success: function(response){
      dimOff();
      var r = jQuery.parseJSON(response);
      if(r.hasOwnProperty('success') && r.success == false){
        showNotif('error', r.msg);
      } else {
        callback(r);
      }
    }
  });
}

function dimOff(){
  document.getElementById("darkLayer").style.display = "none";
}

function dimOn(){
  document.getElementById("darkLayer").style.display = "";
}

var listarLocalidades = function(){
  var provincia = $("#provincia option:selected").val();
  ajxWrapper("ajx_listar_localidades.php", {provincia: provincia}, function(res){
      var localidades;
        $.each(res.data, function( index, value ) {
        localidades += '<option value="'+value.id+'">'+value.nombre+'</option>';
      });
      $("#localidad").empty().append(localidades);
    }
  );
}

function isNumber(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}

function parseCombat(){
  $.each(CScript.events, function( index, value ) {
    $('#combat-layer').append( "<p>Asalto "+ index +" ##############</p>");
    $.each(value, function( i, v ) {
      //console.log(v);
      if(v.action == 'attack'){
        $('#combat-layer').append( "<p>"+ FIGHTERS[v.who]['name'] +" ataca a "+ FIGHTERS[v.whom]['name'] +" con "+ v.what +"</p>");
      }
      if(v.action == 'evades'){
        $('#combat-layer').append( "<p>"+ FIGHTERS[v.whom]['name'] +" evade el ataque de "+ FIGHTERS[v.who]['name'] +"!</p>");
      }
      if(v.action == 'damages'){
        $('#combat-layer').append( "<p>"+ FIGHTERS[v.whom]['name'] +" recibe "+ v.what +" puntos de daño!</p>");
      }
      if(v.action == 'unavailable_tech'){
        $('#combat-layer').append( "<p>"+ FIGHTERS[v.whom]['name'] +" no puede realizar ninguna tecnica!</p>");
      }
    });
  });
  $.each(CScript.msg, function( index, value ) {
    //console.log(value);
    $('#combat-layer').append( "<p>"+ value +"</p>");
  });
}
