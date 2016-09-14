<?php session_start();
// If user hasn't logged in, have them do that now. 
if (!isset($_SESSION["uname"])) {
    header("Location: login.php"); // comment this line to disable login (for debug) 
}
?>
<html>
    <head> 
    <?php include './head_common.php'; ?>

    </head>
<body>

<?php include './banner.php'; ?>


<div class="container">

    <br>
    <br>
    

    </div>

    <div class="col-md-3">  </div>

    <div class="col-md-5">
        <h1>Welcome!</h1>

        <h2>Template Header</h2>

        <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc quam mauris, vulputate ut nisi pharetra, gravida aliquet erat. Pellentesque iaculis lobortis tortor, eu eleifend eros fringilla sed. Donec consequat purus eu sem pellentesque, vel porttitor mi aliquam. Vivamus ornare dolor eleifend consequat vestibulum. Etiam eleifend neque eu mauris aliquam consectetur. Ut feugiat nulla quis nisi tempor ornare vitae ac enim. Nam consectetur id nulla in congue. Sed et odio quis ante fermentum finibus ut sed massa. Suspendisse maximus gravida lorem vitae sagittis. Integer consectetur augue magna, molestie placerat ligula rhoncus ac. Proin dictum, lacus sit amet semper euismod, orci lacus condimentum dui, nec blandit lorem metus semper dui. 
            <?php 

            // if running locally, we get a username, else it's a null string. 
            if (getenv("USER")){
                $user = getenv("USER");
            } else {
                $user = "ubuntu" ;
            }

            // Connect to our sql server
            $conn = mysqli_connect("localhost", $user, "");

            // Give error if the connection failed. 
            if ($conn->connect_error){
                die("Connection failed:" . $conn->connect_error);
            }

            // Run a really dumb query 
            $tbl = $conn->query("select 'SQL Query Result' as test;");

            // get the result into a table 
            echo $tbl->fetch_assoc()["test"];

            // Another debug: print the username that the user had at the beginning. 
            echo "Uname = " . $_SESSION['uname'];
            ?>
        </p>

            <p class="text-right">
                <a href="https://www.google.com">Sample Link</a>
            </p>

    </div>


</body>
</html>
