function renderLink(){
    let x= document.getElementById("top");

    let inner = `<a href="addMember.html">Add new member</a>`;
    x.innerHTML += inner;
}

function addUserInfo(obj,left){
    let inner = `<img src= "data:image/jpeg;base64,${obj.profile_pic}" alt = "User image"
                 style="height:200px;width:200px;"><h1>${obj.user_name}</h1>
                 <div class="User_info"><h2>Email address:${obj.user_email}</h2> 
                                        <h2>Birthday:${obj.birthday}</h2>
                                        <h2>Bio:${obj.bio}</h2>`;
    left.innerHTML += inner;
}

function addFields(obj,left,param){
    let inner = `<p>${param}s:</p>
                 <table style="margin-left:30px">`;

    $.each(obj,function(index,val){
        inner += `<tr>
                    <td>${val}</td>
                    <td><button id="${param}-${val}-btn">Delete</button></td>`;
        
        if(param==="Liker" || param==="Staff"){
            inner += `<td><button id="user-${val}-btn">View</button></td>`;
        }

        inner += '</tr>';
    });

    inner += "</table>";
    left.innerHTML += inner;
}

function addComments(comments){
    let ret = `<div class="activity" style="margin-top:20px;margin-left:30px;">Comments:
               <table>`;
    $.each(comments, function(index, val) {
        ret += `<tr>
                    <td>${val["user_name"]}:</td>
                    <td>${val["comment_text"]}</td>
                    <td><button id="comment-${val["comment_id"]}-btn">Delete</button></td>
                </tr>`;
    });
    ret += `</table></div>`;
    return ret;
}

function addPosts(val,comments){
    let posts = document.getElementById("posts");
    let inner = `<div class="user-data" style="margin-left:100px;margin-right:100px;margin-bottom:20px">
                 <p style="padding-left:60px;padding-top=20px;"><b>${val["text"]}</b></p>
                 <img style="height:250px;width:250px;margin-left:60px;" src="data:image/jpeg;base64,${val["picture"]}">
                 <div class="activity" style="margin-top:20px;margin-left:30px">Number of likes${val["likes_num"]}</div>`;
    
    let comment_div = addComments(comments);
    inner += comment_div;
    inner+= `</div>`;
    posts.innerHTML += inner;
}

window.addEventListener('load',function(){
    let left = document.getElementById("left");
    let right = document.getElementById("right");
    let posts = null;
    let temp = null;
    $.ajax({
        type: 'POST',
        url: './dynamic/php/checkType.php',
        data: {},
        dataType: 'text',
        async: false,

        error: function(){
            console.log("Please come back later, the server is down at the moment");
        },

        success: function(resp){
            temp = resp;
        },

        timeout:3000
    });

    $.ajax({
        type: 'GET',
        url:"./dynamic/php/getUserInfo.php",
        data:{},
        async: false,
        success: function(resp){
            if(resp==="no result"){
                alert("Server error, please try again later");
            }
            else{
                let obj = jQuery.parseJSON(resp);
                addUserInfo(obj,left);
            }
        },
        error: function(){
            console.log("Please come back later, the server is down at the moment");
        },
        timeout:2000
    });

    if(temp == 0){
        $.get("./dynamic/php/getSkills.php",{},function(resp){
            let obj = jQuery.parseJSON(resp);
            addFields(obj,left,"Skill");
        });
    }
    else{
        renderLink();
        $.ajax({
            url: "./dynamic/php/getStaff.php",
            data: {},
            async: false,
            timeout: 2000,
            success: function(resp){
                let obj = jQuery.parseJSON(resp);
                addFields(obj,left,"Staff");
            },
            error: function(){
                console.log("Failed to load staff, please try again later");
            }
        });

        $.ajax({
            url: "./dynamic/php/getLikers.php",
            data: {},
            async: false,
            timeout: 2000,
            success: function(resp){
                let obj = jQuery.parseJSON(resp);
                addFields(obj,left,"Liker");
            },
            error: function(){
                console.log("Failed to load company likers, please try again later");
            }
        });
    }

    $.ajax({
        type: 'GET',
        url: './dynamic/php/getPosts.php',
        data: {"belongs":1},
        async: false,
        success: function(resp){
            posts = jQuery.parseJSON(resp);
        },
        error: function(){
            console.log("Failed to get posts, please come back later");
        },
        timeout: 2000
    });

    $.each(posts, function(index, val){
        let post_id = val["post_id"];
        $.ajax({
            type: 'GET',
            url: './dynamic/php/getComments.php',
            data: {"post_id":post_id},
            async: false,
            success: function(resp){
                let obj = jQuery.parseJSON(resp);
                addPosts(val,obj);
            },
            error: function(){
                console.log("Failed to retrieve comments, please try again later");
            },
            timeout: 2000
        });
    });
});

document.addEventListener('click',function(e){
    let element = e.target.nodeName;
    if(element==="BUTTON"){
        let id = e.target.id;
        let arr = id.split("-");
        if(arr.lenght==0){
            console.log("Ok");
        }
        else if(arr[0]=="Skill"){
            $.post("./dynamic/php/deleteSkill.php",{"skill":arr[1]},function(resp){
            
            });
            $(e.target).parent().parent().remove();
        }
        else if(arr[0]=="Staff"){
            $.post("./dynamic/php/deleteMember.php",{"staff":arr[1]},function(resp){

            });
            $(e.target).parent().parent().remove();
        }
        else if(arr[0]=="comment"){
            $.post("./dynamic/php/deleteComment.php",{"comment_id":arr[1]},function(resp){
                alert(resp);
            });
            $(e.target).parent().parent().remove();
        }
        else if(arr[0]=="delete"){
            $.post("./dynamic/php/deletePost.php",{"post_id":arr[1]},function(resp){
                alert(resp);
            });
            $(e.target).parent().parent().remove();
        }
        else if(arr[0]=="user"){
            alert("Hey");
            alert(arr[1]);
        }
        else if(arr[0]=="logout"){
            $.post("./dynamic/php/logout.php",{},function(resp){
                
            });

            window.location.href = "Login.html";
        }
        else if(arr[0]=="deleteAccount"){
            $.ajax({
                type: 'POST',
                url: "./dynamic/php/deleteAccount.php",
                data: {},
                success: function(resp){
                    alert(resp);
                }
            });
            window.location.href = "Login.html";
        }
    }
});