$('#register').on('submit',function(){
    var that = $(this),
    url = that.attr('action'),
    method = that.attr('method');

    let name = document.getElementById("nameID").value; 
    let email = document.getElementById("emailID").value;
    let pass = document.getElementById("passID").value;
    let cpass = document.getElementById("cpassID").value;
    let birth = document.getElementById("birthday").value;
    let type = document.getElementById("type").value; 
    
    if(pass.length<8){
        alert("Please enter a password of atleast 8 characters");
    }

    if(pass !== cpass){
        alert("Confirm password doesn't match password");
    }

    $.post(url, {"uname":name,"email":email,"pass":pass,"cpass":cpass,"birthday":birth,"type":type}, function(resp){
        console.log("First step done");
    });

    let formData = new FormData();
    let files = $("#img")[0].files;
    formData.append("file2",files[0]);

    $.ajax({
        url:'./dynamic/php/register.php',
        dataType:'text',
        cache: false,
        contentType: false,
        processData: false,
        data: formData,
        type: 'post',
        success: function(resp){
            alert(resp);
        }
    });

    return false;
});