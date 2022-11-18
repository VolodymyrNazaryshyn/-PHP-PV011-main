<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css" />
    <title>PV011</title>
    <style>
    html,
    body {
        height: 100%;
    }
    .wrapper {
        min-height: 100%;
        display: flex;
        flex-direction: column;
    }
    main {
        flex: 1 1 auto;
    }
    footer {
        border-top: 1px solid gray;
        padding: 10px 0 10px;
    }
    </style>
</head>
<body>
    <nav>
        <img src="/img/php.png" alt="logo" class="logo" />
        <a href="/basics">Введение в РНР</a>
        <a href="/fundamentals">Основы РНР</a>
        <a href="/layout">Шаблонизация</a>
        <a href="/formdata">Данные форм</a>
    </nav>

    <h1>PHP</h1>

    <!-- Render body -->
    <?php
    if( $path_parts[1] === '' ) $path_parts[1] = 'index' ;
    switch( $path_parts[1] ) { // [1] - первая непустая часть (суть контроллер)
        case 'index'        : 
        case 'basics'       : 
        case 'fundamentals' : 
        case 'layout'       : 
        case 'formdata'     : include "{$path_parts[1]}.php" ; break ;
        default             : include "404.php";
    }
    ?>

    <?php 
    $currentYear = date("Y");
    include "footer.php" 
    ?>
</body>
</html>