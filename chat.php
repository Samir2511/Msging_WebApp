<?php
session_start();
include_once "config.php";
include "php/data.php";
if(!isset($_SESSION['unique_id'])){
    header("location: login.php");
}
?>
<?php $otherUser = userData::with_GET_UniqueId($_GET['user_id']); ?>
<?php $currentUser = userData::with_SessionUniqueId(); ?>

<?php include_once "header.php"; ?>
    <body>
    <div class="wrapper">
        <section class="chat-area">
            <header>

                <a href="users.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
                <img src="php/uploads/<?php echo $otherUser['img']?>" alt="">
                <div class="details">
                    <span><?php echo $otherUser['fname'] . $otherUser['lname']; ?></span>
                    <p> <?php echo $otherUser['status'] ?></p>
                </div>
            </header>
            <div class="chat-box">

            </div>

            <form action="#"  class="typing-area" id="myForm">
                <input type="text" class="incoming_id" name="other_user" value="<?php echo $otherUser['unique_id'];?>" hidden>
                <input type="text" name="message" class="input-field" id="in" placeholder="Type a message here..." autocomplete="off">
                <button type="submit"><i class="fab fa-telegram-plane"></i></button>

            </form>
        </section>
    </div>


    <script>var otherUserId = <?php echo $otherUser['unique_id']; ?></script>
    <script src="javascript/insert_chat.js"></script>
    <script  src="javascript/get_chat.js"></script>


    </body>
    </html>
