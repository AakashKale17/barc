<?php
     require_once 'functions/helpers.php';
     require_once 'functions/pdo_connection.php';
     session_start();
     $message = '';
     if(isset($_POST['category']) && $_POST['category'] !== '' && isset($_POST['date']) && $_POST['date'] !== '' && isset($_POST['description']) && $_POST['description'] !== '' && isset($_POST['submit'])) 
     {    
         $query = "INSERT INTO detail SET category = ?, date = ?, description = ?, pid = ?;";
         $statement = $pdo->prepare($query);
         $statement->execute([$_POST['category'], $_POST['date'], $_POST['description'], $_GET['post_id']]);
         $message = 'Successful!';
         } 
     ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail</title>
    <link rel="stylesheet" href="<?= asset('assets/css/Single.css') ?>" media="all" type="text/css">    
</head>
<body>
    <style> <?php include 'assets/css/Single.css'; ?> </style>
    <?php 
        $query = "SELECT posts.*, users.username FROM posts JOIN users ON posts.uid = users.id WHERE posts.id = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$_GET['post_id']]);
        $post = $statement->fetch();
        if ($post !== false) {
            ?>
        <nav class="navbar">
            <div class="back">
                <a href="<?= url('./') ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" height="25" width="25" viewBox="0 0 256 512">
                        <path fill="#161c1f" d="M9.4 278.6c-12.5-12.5-12.5-32.8 0-45.3l128-128c9.2-9.2 22.9-11.9 34.9-6.9s19.8 16.6 19.8 29.6l0 256c0 12.9-7.8 24.6-19.8 29.6s-25.7 2.2-34.9-6.9l-128-128z"/>
                    </svg>
                </a>
            </div>
            <div class="logo">
                <img src="assets\images\single.PNG" alt="info">
            </div>
        </nav>
        <div class="main-container">
            <div id="info">
                <div id="post-info">
                    <h1>Name: <?= $post->name ?></h1>
                    <h2>Contact no: <?= $post->contact ?></h2>
                    <h2>Date and Time: <?= $post->date ?></h2>
                    <h2>Description: <?= $post->description ?></h2>
                    <h3>Post was made by <?= $post->username ?></h3>
                    <div class="pdf-button">
                        <button id="showpdf" class="log">Show Pdf</button>
                        <button id="hidepdf" class="log" style="display:none;">Hide Pdf</button>
                    </div>
                    <button id="showform" class="log">Add</button>
                    <button id="hideform" class="log" style="display:none;">Hide</button>
                </div>
                <div id="post-form" style="display:none;">
                    <form action="" method="post" enctype="multipart/form-data">
                        <label htmlFor="category">Choose category:</label>
                        <select id="category" name="category">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                        <option value="16">16</option>
                        <option value="17">17</option>
                        <option value="18">18</option>
                        <option value="19">19</option>
                        <option value="20">20</option>
                        </select>
                        <label htmlFor="date">Date and Time:</label>
                        <input
                        type="datetime-local"
                        id="date"
                        name="date"
                        />
                        <label htmlFor="description">Description:</label>
                        <textarea
                        id="description"
                        name="description"
                        value=description
                        ></textarea>
                        <button type="submit" class="log" name='submit' value="submit">Submit</button>
                    </form>
                    <p><?php if ($message !== '') echo $message; ?></p>
                </div>
            </div>
            <div class="detail-info">
                <div id="pdf-display" style="display:none;">
                    <object width='1000' height='780'data='<?= asset($post->file) ?>'></object>
                </div>
                <div class="details-container">
                <?php
                        $query = "SELECT * FROM detail WHERE pid = ? ORDER BY id DESC";
                         $statement = $pdo->prepare($query);
                         $statement->execute([$_GET['post_id']]);
                         $details = $statement->fetchAll();
                         foreach ($details as $detail) { ?>
                    <div class="details">
                        <h3><?= $detail->category ?></h3>
                        <h3><?= $detail->date ?></h3>
                        <h3><?= $detail->description ?></h3>
                        <button class="delete-button">
                        <svg class="delete-svgIcon" viewBox="0 0 448 512">
                            <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"></path>
                        </svg>
                        </button>
                    </div>
                        <?php } ?>
                </div>
            </div>
                    <?php
            } else{ ?>
                        <section>post not found!</section>
                        <?php } ?>
        </div>

<script src="<?= asset('assets/js/jquery.min.js') ?>"></script>
<script src="<?= asset('assets/js/bootstrap.min.js') ?>"></script>
<script>
    $(function(){
   $('button#showpdf').on('click',function(){  
      $('#pdf-display').show();
      $('#showpdf').hide();
      $('#hidepdf').show();
   });
   $('button#hidepdf').on('click',function(){  
      $('#pdf-display').hide();
      $('#showpdf').show();
      $('#hidepdf').hide();
   });
   $('button#showform').on('click',function(){  
      $('#post-form').show();
      $('#showform').hide();
      $('#hideform').show();
   });
   $('button#hideform').on('click',function(){  
      $('#post-form').hide();
      $('#showform').show();
      $('#hideform').hide();
   });
});
</script>
<script type="text/javascript">
    window.onbeforeunload = function() {
        alert("Confirm Details");
    }
</script>
</body>
</html>