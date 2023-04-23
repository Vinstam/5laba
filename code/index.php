<?php
$host = 'db'; //хост базы данных
$user = 'root'; //пользователь
$pass = 'Aa123456'; //пароль
$dsn = "mysql:host=$host"; //задаем параметры базы данных
$opt = [  //задаем свойства базы данных
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
$pdo = new PDO($dsn, $user, $pass, $opt); //объект подключения к базе данных
$stmt = $pdo->query('USE `web`;'); //используем базу данных 'web'
$stmt = $pdo->query('SELECT * FROM `web.ad`;'); //считываем все объявления из таблицы
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
	<div>
		<div>
			<form method="POST">
				<div>Электронная почта: <input type="text" name="email">
				</div>
				<div>Категория: <input type="text" name="category">
				</div>
				<div>Заголовок: <input type="text" name="title">
				</div>
				<div>Текст объявления: <input type="text" name="textAd">
				</div>
				<input name="btn" type="submit" value="Add">
			</form>
		</div>
		<div>
			<table style="width: 100%;">
				<tr style="display: flex; flex-direction: row; justify-content: space-around;">
					<th>ID</th>
					<th>Категория</th>
					<th>Заголовок</th>
					<th>Текст</th>
					<th>Электронная почта</th>
					<th>Время добавления</th>
				</tr>

			<?php
			while ($arrayOfRows = $stmt->fetch()) { //сохраняем результат в массив и обходим строчки результата
				$tmpStr = '<tr style="display: flex; flex-direction: row; justify-content: space-around;">'; //временная строка, в которой постепенно будем создавать строку таблицы
				foreach ($arrayOfRows as $numOfRow => $row) { //обход строчки результата по полям
					$tmpStr .= "<td>" . $row . "</td>"; //вносим в временную строку информацию из результата
				}
				$tmpStr .= '</td>'; //закончили формирование временной строки
				echo $tmpStr; //вывели ее в таблицу html страницы
			}
			if (isset($_POST['btn'])) { //проверка существования отправленных данных по кнопке
			switch ($_POST['btn']) {
				case 'Add': //по кнопке Add

					if($_POST['email'] && $_POST['category'] && $_POST['title'] && $_POST['textAd']) {
						$stmt = $pdo->prepare('INSERT `web.ad` (category, title, description, email) VALUES (:category, :title, :description, :email)'); //готовим SQL запрос
						$stmt->execute(array('category' => $_POST['category'], 'title' => $_POST['title'], 'description' => $_POST['textAd'], 'email' => $_POST['email'])); //обращаемся к базе данных обработанным запросом, добавив в заглушки данные

					}
				}
			}
			?>
			</table>
		</div>

	</div>
</body>
</html>
