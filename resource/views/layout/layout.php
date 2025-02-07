<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" href="<?php echo asset('img/favicon.ico') ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo asset('lib/bootstrap/css/bootstrap.css') ?>"/>
    <link rel="stylesheet" href="<?php echo asset('css/style.css') ?>"/>

    <title>PHP MVC</title>
</head>
<body>

<?php include_once view('layout/header.php')?>

<main role="main" class="main-content">
    <?= yieldSection('content') ?>
</main>

<?php include_once view('layout/footer.php')?>

</body>
    <script src="<?php echo asset('lib/jquery/jquery-3.4.1.min.js') ?>"></script>
    <script src="<?php echo asset('lib/bootstrap/js/bootstrap.min.js') ?>"></script>
    <script src="<?php echo asset('js/app.js') ?>"></script>

    <?= yieldSection('scripts') ?>
</html>
