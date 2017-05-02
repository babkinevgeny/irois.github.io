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
</head>
<script>
$(document).ready(function(){
  $(".nav-item a").on("click", function(){
    $("input[name=country]").val($(this).attr("country"));
    $(".nav-item a").removeClass("active");
    $(this).addClass("active");
  })
})
</script>
<body>
<div class="container">
      <div class="header clearfix">
      <img src="logo.png" style="width:100%"/><br>
      <form action="search.php" method="POST">
      <div class="input-group">
          <input name="ois" type="text" class="form-control" placeholder="Введите ОИС, например: toyota">
          <input type="hidden" name="country" value="ru"/>
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
              <a country="ru" class="nav-link active" href="#">Россия</a>
            </li>
            <li class="nav-item">
              <a country="bl"  class="nav-link" href="#">Беларусь</a>
            </li>
            <li class="nav-item">
              <a country="kz" class="nav-link" href="#">Казахстан</a>
            </li>
            <li class="nav-item">
              <a country="kg" class="nav-link" href="#">Киргизия</a>
            </li>
            <li class="nav-item">
              <a country="am" class="nav-link" href="#">Армения</a>
            </li>
          </ul>
        </nav>
      </div>


      <div class="row marketing">
        <div class="col-lg-6">
          <h4>Более 971 записей</h4>
          <p>Donec id elit non mi porta gravida at eget metus. Maecenas faucibus mollis interdum.</p>

          <h4>Удобный API</h4>
          <p>Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Cras mattis consectetur purus sit amet fermentum.</p>

          <h4>Приятный интерфейс</h4>
          <p>Maecenas sed diam eget risus varius blandit sit amet non magna.</p>
        </div>

        <div class="col-lg-6">
          <h4>Постоянные обновления</h4>
          <p>Donec id elit non mi porta gravida at eget metus. Maecenas faucibus mollis interdum.</p>

          <h4>Синхронизация с БД Налоговой службы РФ</h4>
          <p>Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Cras mattis consectetur purus sit amet fermentum.</p>

          <h4>И многое другое</h4>
          <p>Maecenas sed diam eget risus varius blandit sit amet non magna.</p>
        </div>
      </div>

      <footer class="footer">
        <p>© Evgeniy Babkin</p>
      </footer>

    </div>
</body>
</html>