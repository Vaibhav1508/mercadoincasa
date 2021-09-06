<?php

$code = $_GET["code"];
$error = false;

// If you took $code from user input it's a good idea to trim it:


// Make sure the code is valid before sending it to Envato:
if (!isset($code)) {
    $error = true;
} else {
    $code = trim($code);
    if (!preg_match("/^(\w{8})-((\w{4})-){3}(\w{12})$/", $code)) {
        $code = false;
        $error = "Not valid purchase code";
    } else {

// Query using CURL:
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => "https://api.envato.com/v3/market/author/sale?code={$code}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 20,

            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer aVH71sVL6UA91XchRumA8AHY5tahMXBp",
                "User-Agent: Verify Purchase Code"
            )
        ));
        $result = curl_exec($ch);
        if (isset($result) && json_decode($result)->error == 404) {
            $code = false;
            $error = json_decode($result)->description;
        }
        if(isset($result) && json_decode($result)->item->id != "24878940"){
            $code = false;
            $error ="Not valid purchase code";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta name="description" content="Description">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <?php if (!$error && $code) : ?>
        <link rel="stylesheet" href="//unpkg.com/docsify/lib/themes/vue.css">
    <?php endif; ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <style>
        .content > article.markdown-section{
            max-width: 60%;
        }
        img {
            width: 100%;
            border-radius: 10px;
            border: 1px solid #e9e9e9;
            box-shadow: 0 10px 8px #e9e9e9;
        }

        .login-container {
            margin-top: 5%;
            margin-bottom: 5%;
        }

        .login-form-1 {
            margin: auto;
            padding: 9%;
            background: #282726;
            box-shadow: 0 5px 8px 0 rgba(0, 0, 0, 0.2), 0 9px 26px 0 rgba(0, 0, 0, 0.19);
        }

        .login-form-1 h3, .login-form-1 p{
            text-align: center;
            margin-bottom: 12%;
            color: #fff;
        }

        .login-form-1 .form-group {
            text-align: center;
        }

        .btnSubmit {
            font-weight: 600;
            width: 50%;
            color: #282726;
            background-color: #fff;
            border: none;
            border-radius: 1.5rem;
            padding: 2%;
        }

        .btnForgetPwd {
            color: #fff;
            font-weight: 600;
            text-decoration: none;
        }

        .btnForgetPwd:hover {
            text-decoration: none;
            color: #fff;
        }
    </style>
</head>
<body>
<?php
if (!$code && $error) :?>
    <div class="container login-container">
        <div class="row">
            <div class="col-md-6 login-form-1">
                <?php if ($error && gettype($error) != "boolean") : ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                <form action="" method="get">
                    <h3>Verify purchase code</h3>
                    <p>You must purchase this script to get full organized documentation with videos tutorial to use it</p>
                    <div class="form-group">
                        <input name="code" type="text" class="form-control" placeholder="Your Purchase Code *" value=""/>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btnSubmit" value="Submit"/>
                    </div>
                    <h3></h3>
                    <div class="form-group">
                        <a href="https://codecanyon.net/downloads" class="btnForgetPwd">How find Purchase Code?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php else: ?>
    <div id="app"></div>
    <script>
        window.$docsify = {
            name: '',
            repo: ''
        }
    </script>
    <script src="//unpkg.com/docsify/lib/docsify.min.js"></script>
<?php endif; ?>
</body>
</html>
