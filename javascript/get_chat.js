document.addEventListener("DOMContentLoaded", function() {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "php/get_chat.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            var response = xhr.responseText;
            var chatBox = document.querySelector(".chat-box");
            chatBox.innerHTML = response; 

        }
    };
    xhr.send("other_user_id=" + otherUserId);
});

// ---------------------------------------------------------------------------------------
var chatBox = document.querySelector(".chat-box");
const formz = document.querySelector(".typing-area");
const sendBtnz = formz.querySelector("button");


chatBox.onmouseenter = ()=>{
    chatBox.classList.add("active");
}

function scrollToBottom() {
    chatBox.scrollTop = chatBox.scrollHeight;
}

setInterval(() =>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/get_chat.php", true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                chatBox.innerHTML = data;
                if(!chatBox.classList.contains("active")){
                    scrollToBottom();
                }
            }
        }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("other_user_id=" + otherUserId);
}, 500);

