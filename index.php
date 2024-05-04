<?php
session_start();
if(isset($_SESSION['unique_id'])){
    header("location: users.php");
}
?>

<?php include_once "header.php"; ?>
<body>
<div class="wrapper">
    <section class="form signup">
        <header>Realtime Chat App</header>
        <form action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
            <div class="error-text"></div>
            <div class="name-details">
                <div class="field input">
                    <label>First Name</label>
                    <input type="text" name="fname" placeholder="First name" required>
                </div>
                <div class="field input">
                    <label>Last Name</label>
                    <input type="text" name="lname" placeholder="Last name" required>
                </div>
            </div>
            <div class="field input">
                <label>Email Address</label>
                <input type="text" name="email" placeholder="Enter your email" required>
            </div>
            <div class="field input">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter new password" required>
                <i class="fas fa-eye"></i>
            </div>
            <div class="field image">
                <label>Select Image</label>
                <input type="file" name="image" accept="image/x-png,image/gif,image/jpeg,image/jpg" required>
            </div>
            <div class="field button">
                <input type="submit" name="submit" value="Continue to Chat">
            </div>
        </form>
        <div class="link">Already signed up? <a href="login.php">Login now</a></div>
    </section>
</div>



<script src="javascript/pass-show-hide.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.querySelector(".form.signup form");
        const continueBtn = form.querySelector(".field.button input[type='submit']");
        const errorText = form.querySelector(".error-text");

        form.onsubmit = async (e) => {
            e.preventDefault(); 

            
            const formData = new FormData(form);

            try {
                
                const response = await fetch("php/signup.php", {
                    method: "POST",
                    body: formData
                });

                
                const data = await response.json();

                
                if (data.status === "success") {
                    
                    console.log("Registration successful!");
                    window.location.href = "users.php";
                } else {
                    errorText.textContent = data.message;
                    errorText.style.display = "block";
                }
            } catch (error) {
                console.error("Error:", error);
                errorText.textContent = "An error occurred. Please try again later.";
                errorText.style.display = "block";
            }
        };
    });

</script>

</body>
</html>