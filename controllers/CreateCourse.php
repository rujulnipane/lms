<?php

// echo "Hello";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    echo $_POST["title"] .' '. $_POST["des"] .' ' .$_POST["img"];
}   