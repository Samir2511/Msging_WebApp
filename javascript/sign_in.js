document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector(".form.login form");
    const continueBtn = form.querySelector(".field.button input[type='submit']");
    const errorText = form.querySelector(".error-text");

    form.onsubmit = async (e) => {
        e.preventDefault();
        console.log(e);
        const formData = new FormData(form);

        try {
            const response = await fetch("php/login.php", {
                method: "POST",
                body: formData
            });

            const data = await response.json();

            if (data.status === "success") {
                window.location.href = "users.php";
            } else {
                errorText.textContent = data.status;
                errorText.style.display = "block";
            }
        } catch (error) {
            console.error("Error:", error);
            errorText.textContent = "An error occurred. Please try again later.";
            errorText.style.display = "block";
        }
    };
});