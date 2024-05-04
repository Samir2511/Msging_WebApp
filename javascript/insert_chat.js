const form = document.querySelector(".typing-area");
const inputField = form.querySelector(".input-field");
const sendBtn = form.querySelector("button");


    inputField.focus();
    inputField.onkeyup = ()=>{
    if(inputField.value != ""){
    sendBtn.classList.add("active");
}else{
    sendBtn.classList.remove("active");
}
}


document.getElementById("myForm").addEventListener("submit", function(event) {
    // Prevent the default form submission behavior
    event.preventDefault();

    let formData = new FormData(this);

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/insert_chat.php", true);
    xhr.onload = function() {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {

            inputField.value = "";
            sendBtn.classList.remove("active");

        }
    };
    xhr.send(formData);
});


