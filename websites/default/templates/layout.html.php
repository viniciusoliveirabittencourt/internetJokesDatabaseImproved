<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?=$title . ' - Internet Joke Database'?></title>
</head>
<body>
    <header>
        <h1>Internet Joke Database</h1>
    </header>
    <nav>
        <ul>
            <li><a href="/">Home</a></li>
            <li><a href="/jokes.php">Jokes List</a></li>
            <li><a href="/editjoke.php">Add a new joke</a></li>
        </ul>
    </nav>
    <main>
        <?=$output?>
    </main>
    <?php include __DIR__ . '/footer.html.php'?>
</body>
</html>