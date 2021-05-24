let update_name_btn = document.getElementById("save-uname-btn");
let update_email_btn = document.getElementById("save-email-btn");
let update_pass_btn = document.getElementById("save-pass-btn");
let update_birthday_btn = document.getElementById("save-birthday-btn");
let update_bio_btn = document.getElementById("save-bio-btn");
let add_skill_btn = document.getElementById("save-skill-btn");
let update_image_btn = document.getElementById("save-img-btn");

update_name_btn.addEventListener('click',function(){
    let name = document.getElementById("uname-field").value;
    if(name === ""){
        alert("Please enter your new user name");
    }
    else{
        $.post("./dynamic/php/updateUserName.php",{"name":name},function(resp){
            alert(resp);
        });
    }
});

update_email_btn.addEventListener('click',function(){
    let email = document.getElementById("email-field").value;
    if(email === ""){
        alert("Please enter your new email");
    }
    else{
        $.post("./dynamic/php/updateEmail.php",{"email":email},function(resp){
            alert(resp);
        });
    }
});

update_pass_btn.addEventListener('click',function(){
    let password = document.getElementById("password-field").value;
    let confirm_password = document.getElementById("cpass").value;
    if(password === ""){
        alert("Please enter a new password");
    }
    if(confirm_password === ""){
        alert("Please confirm your password");
    }
    if(password !== confirm_password){
        alert("Confirm password must match password");
    }
    if(password.length<8 || confirm_password.length<8){
        alert("Password must be atleast 8 characters");
    }
    else{
        $.post("./dynamic/php/updatePassword.php",{"password":password,"confirm_password":confirm_password},function(resp){
            alert(resp);
        });
    }
});

update_birthday_btn.addEventListener('click',function(){
    let birthday = document.getElementById("birthday").value;
    if(!birthday){
        alert("Please enter a valid birth date");
    }
    else{
        $.post("./dynamic/php/updateBirthday.php",{"birthday":birthday},function(resp){
            alert(resp);
        });
    }
});

update_bio_btn.addEventListener('click',function(){
    let bio = document.getElementById("bio").value;
    if(bio === ""){
        alert("Plase enter bio");
    }
    else{
        $.post("./dynamic/php/updateBio.php",{"bio":bio},function(resp){
            alert(resp);
        });
    }
});

add_skill_btn.addEventListener('click',function(){
    let skill = document.getElementById("skill-field").value;
    if(skill === ""){
        alert("Please enter a skill");
    }
    else{
        $.post("./dynamic/php/addSkill.php",{"skill":skill},function(resp){
            alert(resp);
        });
    }
});

update_image_btn.addEventListener('click',function(){
    let formData = new FormData();
    let files = $("#profile-pic")[0].files;
    formData.append("file",files[0]);

    $.ajax({
        url:'./dynamic/php/updatePicture.php',
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
});