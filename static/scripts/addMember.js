$('#add').on('submit',function(){
  
    let that = $(this),
    url = that.attr('action');
  
    let email = document.getElementById("memberEmail").value;
  
    $.post(url,{"email":email},function(resp){
        alert(resp);
    });
    
    return false;
});