<?php include_once "header.php"; ?>
<body>
<div class="wrapper">
    <section class="form signup">
        <header>Realtime Chat App</header>
        <form action="php/file-upload-manager.php" method="POST" enctype="multipart/form-data" autocomplete="off">
            <div class="field image">
                <label>Select Image</label>
                <input type="file" name="image" >
            </div>
            <div class="field button">
                <input type="submit" name="submit" value="Upload Image">
            </div>
        </form>
    </section>
</div>

</body>
</html>




