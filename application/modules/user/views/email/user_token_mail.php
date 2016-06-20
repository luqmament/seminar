<html>
    <head>
        <title></title>
    </head>
    <body>

        <p>Please follow this link to reset your password within 6 hours :</p>
        <p><?php echo site_url('user/reset_user_password?token='.$token.'&id='.$id); ?></p>

    </body>
</html>
