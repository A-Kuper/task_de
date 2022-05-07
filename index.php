<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Task</title>
</head>
<body>
    <form method="GET" action="/lib/news.php">
        <label>
            <input type="text" name="search" placeholder="Введите имя новсоти">
        </label>
        <select name="type">
            <option value="Выбрать">Выбрать...</option>
            <option value="Новость">Новость</option>
            <option value="Статья">Статья</option>
            <option value="Пресс-релиз">Пресс-релиз</option>
            <option value="Объявление">Объявление</option>
        </select>
        <button type="submit">Поиск</button>
    </form>
</body>
</html>