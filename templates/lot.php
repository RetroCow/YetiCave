<main>
  <nav class="nav">
    <ul class="nav__list container">
      <li class="nav__item">
        <a href="all-lots.html">Доски и лыжи</a>
      </li>
      <li class="nav__item">
        <a href="all-lots.html">Крепления</a>
      </li>
      <li class="nav__item">
        <a href="all-lots.html">Ботинки</a>
      </li>
      <li class="nav__item">
        <a href="all-lots.html">Одежда</a>
      </li>
      <li class="nav__item">
        <a href="all-lots.html">Инструменты</a>
      </li>
      <li class="nav__item">
        <a href="all-lots.html">Разное</a>
      </li>
    </ul>
  </nav>
  <?php if ($lot != null):?>
    <section class="lot-item container">
        <h2><?=htmlspecialchars($lot['lot_name'])?></h2>
        <div class="lot-item__content">
        <div class="lot-item__left">
            <div class="lot-item__image">
            <img src="<?=$lot['pic']??"upload/".$_FILES['file_name']['name']?>" width="730" height="548" alt="Сноуборд">
            </div>
            <p class="lot-item__category">Категория: <span><?=$lot['category']?></span></p>
            <p class="lot-item__description"><?=$lot['message']??"Описание товара"?></p>
        </div>
        <div class="lot-item__right">
          <?php if(isset($_SESSION['user'])):?>
            <div class="lot-item__state">
            <div class="lot-item__timer timer">
                10:54:12
            </div>
            <div class="lot-item__cost-state">
                <div class="lot-item__rate">
                <span class="lot-item__amount">Текущая цена</span>
                <span class="lot-item__cost"><?=$lot['current_price']??$lot['start_price']?></span>
                </div>
                <div class="lot-item__min-cost">
                Мин. ставка <span><?=$lot['lot_step']??""?></span>
                </div>
            </div>
            <form class="lot-item__form" action="lot.php<?='?id='.$lot['id']?>" method="post">
                <p class="lot-item__form-item">
                <label for="cost">Ваша ставка</label>
                <input id="cost" type="number" name="cost" placeholder=<?=$lot['lot_step']??""?>>
                </p>
                <button type="submit" class="button">Сделать ставку</button>
            </form>
            </div>
            <div class="history">
            <h3>История ставок (<span><?=count($bids)?></span>)</h3>
            <table class="history__list">
              <?php foreach ($bids as $bid):?>
                <tr class="history__item">
                <td class="history__name"><?=$bid['name']?></td>
                <td class="history__price"><?=$bid['amount']?> р</td>
                <td class="history__time"><?=$bid['date']?></td>
                </tr>
              <?php endforeach?>
            </table>
            </div>
        </div>
        </div>
      <?php endif; ?>
    </section>
  <?php endif ?>
</main>
</body>
</html>
