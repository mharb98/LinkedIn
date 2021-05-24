$('#login').on('submit',function(){
  
  let that = $(this),
  url = that.attr('action'),
  method = that.attr('method');

  let email = document.getElementById("emailID").value;
  let pass = document.getElementById("passID").value;

  $.post(url,{"email":email,"pass":pass},function(resp){
    if(resp === "Wrong password"){
      alert("Nope");
    }
    else if(resp === "No such user!"){
      alert("User problem");
    }
    else{
      window.location.href = "profile_user.html";
    }
    //alert(resp);
  });
  
  return false;
});