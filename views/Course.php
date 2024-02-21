<?php
echo "ji";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course page</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $.urlParam = function(name) {
                var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
                if (results == null) {
                    return null;
                }
                return decodeURI(results[1]) || 0;
            }

            let i = $.urlParam('id');
            console.log(i);

            $.post(
                "../controllers/getcontroller.php", {
                    id: i
                },
                function(res, status) {
                    console.log(res);
                },
                'json' 
            ).fail(function(xhr, status, error) {
                console.log("Error:", xhr);
            });
        });
    </script>
</head>

<body>

</body>

</html>