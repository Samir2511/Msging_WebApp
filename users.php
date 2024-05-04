<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once "config.php";
include "php/userData.php";

if(!isset($_SESSION['unique_id'])){
    header("location: login.php");
}
?>
<?php $userData = userData::with_SessionUniqueId(); ?>
<?php include_once "header.php"; ?>
<body>
<div class="wrapper">
    <section class="users">
        <header>
            <div class="content">
                <img src="php/uploads/<?php echo $userData['img']; ?>" alt="">
                <div class="details">
                    <span><?php echo $userData['fname'].' '.$userData['lname']; ?></span>
                    <p><?php echo $userData['status']; ?></p>
                </div>
            </div>
            <a href="php/logout.php?logout_id=<?php echo $userData['unique_id'] ?>" class="logout">Logout</a>
        </header>
        <div class="search">
            <span class="text">Select a user to start chat</span>
            <input type="text" placeholder="Enter name to search...">
            <button><i class="fas fa-search"></i></button>
        </div>
        <div class="users-list">

        </div>
    </section>
</div>

<script src="javascript/users.js"></script>

</body>
</html>



