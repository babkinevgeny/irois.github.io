<?php
header("Content-type: text/html;charset=utf-8");
function getPage($page, $query){
	$result = file_get_contents("http://www.tks.ru/db/ois?mode=search&second=x&page=" . $page . "&regnom=&description=" . urlencode(iconv("UTF-8", "windows-1251", $query)) . "&name=&namet=");
	$result = iconv("windows-1251", "UTF-8", $result);
	$pos = strpos($result, '</thead>');
	if (!$pos) return false;
	$result = substr($result, $pos + 8);
	$pos = strpos($result, '</table>');
	$result2 = substr($result, 0, $pos);

	$pos = strpos($result, 'Страницы:');
	$pages = substr($result, $pos);
	$pos = strpos($pages, '</p>');
	$pages = substr($pages, 0, $pos + 4);
	$pages = preg_replace('/\s+/', '', $pages);
	$result = $result2;
	if (substr_count($pages, '</b></p>') == 0 && $page < 5) $result .= getPage($page + 1, $query);

	$result = str_replace("a href", 'span vhref', $result);
 	return $result;
}



$mysqli = new mysqli("localhost", "reestry", "reestry", "excel");


if ($mysqli->connect_errno) {
    printf("Не удалось подключиться: %s\n", $mysqli->connect_error);
    exit();
}
$mysqli->set_charset("utf8");

$query = "%" . $mysqli->real_escape_string($_POST['ois']) . "%";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="https://v4-alpha.getbootstrap.com/examples/narrow-jumbotron/narrow-jumbotron.css">
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
<script>
$(document).ready(function(){
  $(".nav-item a").on("click", function(){
    $("input[name=country]").val($(this).attr("country"));
    $(".nav-item a").removeClass("active");
    $(this).addClass("active");
  })
})
</script>
</head>
<body style="padding:30px;">

      <div class="header clearfix">
      <form action="search.php" method="POST">
      <div class="input-group">
          <input name="ois" type="text" class="form-control" placeholder="Введите ОИС" value="<?php echo $_POST['ois'];?>">
                    <input type="hidden" name="country" value="<?php echo $_POST['country'];?>"/>
        <span class="input-group-btn">
               <button class="btn btn-primary">Поиск</button>
        </span>
      </div>
      </form>

                    <br>
        <nav>
          <ul class="nav nav-pills float-right">
            <li class="nav-item"><a class="nav-link">Страна поиска:</a></li>
            <li class="nav-item">
              <a country="ru" class="nav-link<?php if ($_POST['country'] == 'ru') echo ' active';?>" href="#">Россия</a>
            </li>
            <li class="nav-item">
              <a country="bl"  class="nav-link<?php if ($_POST['country'] == 'bl') echo ' active';?>" href="#">Беларусь</a>
            </li>
            <li class="nav-item">
              <a country="kz" class="nav-link<?php if ($_POST['country'] == 'kz') echo ' active';?>" href="#">Казахстан</a>
            </li>
            <li class="nav-item">
              <a country="kg" class="nav-link<?php if ($_POST['country'] == 'kg') echo ' active';?>" href="#">Киргизия</a>
            </li>
            <li class="nav-item">
              <a country="am" class="nav-link<?php if ($_POST['country'] == 'am') echo ' active';?>" href="#">Армения</a>
            </li>
          </ul>
        </nav>

              <br>             
              <br>
              <table class="table table-striped">
<?php
switch($_POST['country']){
	case "ru":
		if($result = getPage(1, $query)){
			echo ('<tr><th>Рег.номер</th><th>Описание ОИС</th><th>Наименование правообладателя</th><th style="padding: 5px 5px;">Наименование товаров</th></tr>');
			echo $result;
		} else {
			die ('Данного ОИС в реестре России не найдено.');
		}
	break;
	case "bl":

		if ($result = $mysqli->query("SELECT * FROM `reestr_belarus` WHERE OIS LIKE '{$query}'") and $result->num_rows > 0) {
			echo ('<tr><th>Регистрационный номер объекта интеллектуальной собственности по реестру</th><th>Наименование (описание, изображение) объекта интеллектуальной собственности</th><th>Наименование, номер и дата документа, подтверждающего наличие и принадлежность права на объект интеллектуальной собственности</th><th>Наименование товаров, содержащих объект интеллектуальной собственности</th><th>Класс товаров по МКТУ / коды товаров по ТН ВЭД ЕАЭС</th><th>Сведения о правообладателе</th><th>Сведения о доверенных лицах правообладателя</th><th>Дата окончания срока действия решения о принятии таможенными органами мер по защите прав на объект интеллектуальной собственности</th><th>Примечание</th></tr>');
		    while ($row = $result->fetch_object()){
		      echo sprintf('<tr>' . str_repeat('<td>%s</td>', 9) . '</tr>', $row->reg_num, $row->OIS, $row->document, $row->products, $row->product_class, $row->copyright, $row->authorized_guys, $row->expiry, $row->notes);
		    }
		} else {
				die ('Данного ОИС в реестре Беларуси не найдено.');
		}
	break;
	case "kz":
		
		if ($result = $mysqli->query("SELECT * FROM `reestr_kazahstan` WHERE OIS LIKE '{$query}'") and $result->num_rows > 0) {
			echo ('<tr><th>Регистрационный номер по таможенному реестру ОИС</th><th>Наименование (вид, описание, изображение) объекта интеллектуальной собственности</th><th>Наименование товаров, класс товаров по МКТУ/ код товаров по ТН ВЭД </th><th>Сведения о правообладателе</th><th>Название, номер и дата охранного документа</th><th>Срок защиты на 
объект интеллектуальной собственности</th><th>Сведения о доверенных лицах правообладателя</th><th>Номер и дата письма  в таможенные органы о включении объекта интеллектуальной собственности в таможенный реестр ОИС</th></tr>');

		     while ($row = $result->fetch_object()){
		      echo sprintf('<tr>' . str_repeat('<td>%s</td>', 8) . '</tr>', $row->reg_num, $row->OIS, $row->products, $row->copyright, $row->document, $row->expiry, $row->authorized_guys, $row->letter);
		    }
		} else {
				die ('Данного ОИС в реестре Казахстана не найдено.');
		}
	break;
	case "kg":
		
		if ($result = $mysqli->query("SELECT * FROM `reestr_kirgizia` WHERE OIS LIKE '{$query}'") and $result->num_rows > 0) {
			echo ('<tr><th>Регистрационный номер</th><th>Наименование (вид, описание, изображение) ОИС</th><th>Наименование, №, дата документа об охраноспособности ОИС</th><th>Наименование товаров, в отношении которых принимаются меры. Класс товаров по МКТУ/ Код товаров по ТН ВЭД еаэс</th><th>Правообладатель</th><th>Доверенные лица правообладателя</th><th>Срок внесения ОИС в Реестр</th><th>Номер и дата письма ГТС</th></tr>');

		     while ($row = $result->fetch_object()){
		      echo sprintf('<tr>' . str_repeat('<td>%s</td>', 8) . '</tr>', $row->reg_num, $row->ois, $row->document, $row->products, $row->copyright, $row->authorized_guys, $row->expiry, $row->GTS);
		    }
		} else {
				die ('Данного ОИС в реестре Киргизии не найдено.');
		}
	break;
	case "am":
		die ('Данного ОИС в реестре Армении не найдено.');
	break;
}


?>
</table>

</div>
</body>
</html>