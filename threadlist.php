<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <style>
    #ques {
        min-height: 433px;
    }
    </style>
    <title>iDiscuss - Coding Forum</title>
</head>

<body>
    <?php include 'partials/_dbconnect.php'?>
    <?php include 'partials/_navbar.php'?>
    <!-- slider -->
    <?php
          $id = $_GET['catid'];
          $sql ="SELECT *FROM `categories` WHERE category_id = $id";
          $result = mysqli_query($conn ,$sql);
          while($row = mysqli_fetch_assoc($result))
          {
            $catname = $row['category_name'];
            $catdesc = $row['category_description'];
          }
          ?>

    <?php   
              $method = $_SERVER['REQUEST_METHOD'];
            //   echo $method;
            $showAlert = false;
              if($method=='POST')
              {
                    $showAlert = true;
                    $th_title = $_POST['title'];
                    $th_desc = $_POST['desc'];

                    // $th_title = str_replace("<" , "&lt;" , $comment);
                    // $th_title = str_replace(">" , "&gt;" , $comment);
                    // $th_desc = str_replace("<" , "&lt;" , $comment);
                    // $th_desc = str_replace(">" , "&gt;" , $comment);
    
                    $sno = $_POST['sno'];
                    $sql = "INSERT INTO `threads` ( `thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES ('$th_title','$th_desc', '$id', '$sno', current_timestamp())";
                    $result = mysqli_query($conn , $sql);
                    if($showAlert)
                    {
                        echo'
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strongSuccessHoly guacamole!</strong> Your thread has been added ! Please wait for community to respond.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button> 
                        </div>
                        ';
                    }
              }
          ?>

    <div class="container my-3">
        <div class="jumbotron">
            <h1 class="display-4"><?php  echo $catname; ?></h1>
            <p class="lead"><?php echo $catdesc; ?></p>
            <hr class="my-4">
            <!-- <p>It uses utility classes for typography and spacing to space content out within the larger container.</p> -->
            <!-- <a class="btn btn-success btn-lg" href="#" role="button">Learn more</a> -->
        </div>
    </div>
    <?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)
    {
    echo '<div class="container">
        <h1 class="py-2">Start a Discussion</h1>
        <form action="'. $_SERVER["REQUEST_URI"] . '" method="post">
            <div class="form-group">
                <label for="exampleInputEmail1">Problem Title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
                <small id="emailHelp" class="form-text text-muted">Keep your title as short and crisp as
                    possible.</small>
            </div>
            <input type="hidden" name="sno" value="'.$_SESSION["sno"].'"></input>
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Elaborate Your Concern</label>
                <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>';
    }
    else
    {
    echo '
    <div class="container ">
    <h1 class="py-2">Start a Discussion</h1>
        <p class="lead">"You are not logged in . Please login to start a Discussion"</p>
    </div>';
    }
    ?>
    <div class="container mb-5" id="ques">
        <h1>Browse Questions</h1>
        <?php
          $id = $_GET['catid'];
          $sql ="SELECT *FROM `threads` WHERE thread_cat_id = $id";
          $result = mysqli_query($conn ,$sql);
          $noResult = true;
          while($row = mysqli_fetch_assoc($result))
          {
            $noResult = false;
            $id = $row['thread_id'];
            $title = $row['thread_title'];
            $desc = $row['thread_desc'];
            $thread_time = $row['timestamp'];
            $thread_user_id = $row['thread_user_id']; 
            $sql2 = "SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);
        //     echo '<div class="media my-3">
        //     <img src="partials/user.png" width="54px" class="mr-3" alt="...">
        //     <div class="media-body">'.
        //      '<h5 class="mt-0"> <a class="text-dark" href="thread.php?threadid=' . $id. '">'. $title . ' </a></h5>
        //         '. $desc . ' </div>'.'<div class="font-weight-bold my-0"> Asked by: '. $row2['user_email'].' at '. $thread_time. '</div>'.
        // '</div>';
        echo' <div class="media my-3">
        <img src="https://www.pngitem.com/pimgs/m/150-1503945_transparent-user-png-default-user-image-png-png.png"
            width="54px" class="mr-3" alt="...">
        <div class="media-body">'.
        
            '<h5 class="mt-0"><a class="text-dark" href="thread.php?threadid='.$id.'">'.$title.'</a></h5>
          '.$desc.'</div>'.'<p class="font-weight-bold my-0">Asked by:'.$row2['user_email'].' at '.$thread_time.'</p>'.'
    </div>';
        }
            if($noResult){

    echo' <div class="jumbotron jumbotron-fluid">
    <div class="container">
    <h1 class="display-4">No Results Found</h1>
    <p class="lead">Be the first to ask a questions</p>
    </div>
    </div>';
      }

        ?>

    </div>
    <?php include 'partials/_footer.php'?>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>
</body>

</html>