function addComments(comments){
    let ret = `<div class="activity" style="margin-top:20px;margin-left:30px;">Comments:
               <table>`;
    $.each(comments, function(index, val) {
        ret += `<tr>
                    <td>${val["user_name"]}:</td>
                    <td>${val["comment_text"]}</td>
                </tr>`;
    });
    ret += `</table></div>`;
    return ret;
}

function addPosts(val,comments){
    let posts = document.getElementById("posts");
    let inner = `<div class="user-data" style="margin-left:100px;margin-right:100px;margin-bottom:20px">
                     <a style="margin-left:60px">${val["user_name"]}</a>`;
    if(val["type"] == "1"){
        inner += `<button id="follow-"${val["user_id"]}"-btn" style="float:right;">Like page</button>`;
    }
    inner += `<p style="padding-left:60px;padding-top=20px;"><b>${val["text"]}</b></p>
              <img style="height:250px;width:250px;margin-left:60px;" src="data:image/jpeg;base64,${val["picture"]}">
              <div class="activity" style="margin-left:30px;margin-top:20px;">
              <button id="like-${val["post_id"]}-btn">Like</button></div>
              <div class="activity" style="margin-left:30px;margin-top:20px;"> 
              <textarea style="width:90%;height:40px" id="textAr-${val["post_id"]}"></textarea>
              <button style="margin-top:10px;" id="comment-${val["post_id"]}-btn">Comment</button></div>
              <div class="activity" style="margin-top:20px;margin-left:30px">Number of likes${val["likes_num"]}</div>`;
    
    let comment_div = addComments(comments);
    inner += comment_div;
    inner+= `</div>`;
    posts.innerHTML += inner;
}

function addContacts(contacts,contacts_div){
    contacts_div.innerHTML += "<ul>";
    $.each(contacts,function(index,val){
        contacts_div.innerHTML += `<li><button class="contact-btn transparent" id="cht-${val}"-btn">
                                   ${val}</button></li>`;
    });
    contacts_div.innerHTML += "</ul>";
}

window.addEventListener('load',function(){
    let posts = null;
    $.get('./dynamic/php/getUserInfo.php',{},function(resp){
        let obj = jQuery.parseJSON(resp);
        let temp = document.getElementById("temp");
        let img = document.createElement("img");
        let b = document.createElement("b");
        b.innerText = obj.user_name;
        temp.prepend(b);
        img.alt = "User image";
        img.style.marginLeft = "30px";
        img.style.height = "60px";
        img.style.width = "60px";
        img.src = `data:image/jpeg;base64,${obj.profile_pic}`;
        temp.prepend(img);
        user_id = obj.user_id;
    });

    $.ajax({
        type: 'GET',
        url: './dynamic/php/getPosts.php',
        data: {"belongs":0},
        async: false,
        success: function(resp){
            posts = jQuery.parseJSON(resp);
            //alert(resp);
        },
        error: function(){
            alert("Failed to load posts,please come back later");
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
                alert("Failed to load comments, please try again later");
            },
            timeout: 2000
        });
    });
});

$("#form").on('submit',function(){
    let textArea = document.getElementById("msg-text-content").value;
    
    let formData = new FormData();
    let files = $("#upload")[0].files;
    formData.append("file",files[0]);
    formData.append("text",textArea);

    $.ajax({
        url:'./dynamic/php/addPost.php',
        type: 'post',
        dataType: 'text',
        cache: false,
        contentType: false,
        processData: false,
        data: formData,
        success: function(resp){
            alert(resp);
        }
    });

    return false;
});

let openChatBtn = document.getElementById("open-chat-btn");
let chatPanel = document.getElementById("chat-panel");
let contacts = document.getElementById("cnts");
let chatForm = document.getElementById("chat-form");
let contactBtns = document.getElementsByClassName("contact-btn");
let contactTitleBtns = document.getElementsByClassName("contact-title");
let closeChatBtn = document.getElementById("close-chat-btn");
let msgArea = document.getElementById("old-msgs-area");
let msgText = document.getElementById("msgText");
let current_contact = null;

openChatBtn.addEventListener("click", function() {
    openChatBtn.style.display = "none";
    chatPanel.style.display = "inline-block";
    $.post("./dynamic/php/getContacts.php",{},function(resp){
        let obj = jQuery.parseJSON(resp);
        $.each(obj,function(index,val){
            addContacts(obj,contacts);
        });
    });
});

closeChatBtn.addEventListener("click", function() {
    chatPanel.style.display = "none";
    openChatBtn.style.display = "inline-block";
});

for(var i = 0; i < contactTitleBtns.length; ++i) {
  contactTitleBtns[i].addEventListener("click", function() {
      chatForm.style.display = "none";
      chatPanel.style.display = "inline-block";
  });
}

document.addEventListener('click',function(e){
    let element = e.target.nodeName;
    if(element==="BUTTON"){
        let id = e.target.id;
        let arr = id.split("-");
        
        if(arr[0]=="like"){
            $.post("./dynamic/php/likePost.php",{"post_id":arr[1]},function(resp){
                alert(resp);
            });
        }
        else if(arr[0]=="comment"){
            let com = "textAr-" + arr[1];
            let area = document.getElementById(com);
            let text = area.value;
            $.post("./dynamic/php/addComment.php",{"post_id":arr[1],"text":text},function(resp){
               
            });
        }
        else if(arr[0]=="follow"){
            $.post("./dynamic/php/likePage.php",{"page_id":arr[1]},function(resp){
               
            });
        }
        else if(arr[0]=="cht"){
            msgArea.innerHTML = "";
            current_contact = arr[1];
            $.ajax({
                type: 'GET',
                url: './dynamic/php/getMessages.php',
                data: {"contact_name":arr[1]},
                success: function(resp){
                    let obj = jQuery.parseJSON(resp);
                    $.each(obj,function(index,val){
                        msgArea.innerHTML += val["sender"]+":"+val["text"] + "\n";
                    });
                },
                error: function(){
                    console.log("Could not load messages");
                }
            });

            document.getElementById("contact-title").innerHTML = arr[1];
            chatPanel.style.display = "none";
            chatForm.style.display = "inline-block";
            e.preventDefault();
        }
        else if(arr[0]=="send_button"){
            let msgtxt = msgText.value;
            $.post("./dynamic/php/sendMessage.php",{"msg":msgtxt,"contact":current_contact},function(resp){
                alert(resp);
            });
        }
    }
});