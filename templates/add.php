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
  <form class="form form--add-lot container form--invalid" enctype="multipart/form-data" action="add.php" method="post"> <!-- form--invalid -->
    <h2>Добавление лота</h2>
    <div class="form__container-two">
      <div class="form__item <?=$errors['lot_name']?"form__item--invalid":""?>"> <!-- form__item--invalid -->
        <label for="lot-name">Наименование</label>
        <input id="lot-name" type="text" name="lot_name" placeholder="Введите наименование лота" required value=<?=isset($lot['lot_name'])?$lot['lot_name']:""?>>
        <span class="form__error"><?=$errors['lot_name']?></span>
      </div>
      <div class="form__item <?=$errors['category']?"form__item--invalid":""?>">
        <label for="category">Категория</label>
        <select id="category" name="category">
          <option <?=isset($lot['category']) == 'Выберите категорию'?"selected":""?>>Выберите категорию</option>
          <option <?=isset($lot['category']) == 'Доски и лыжи'?"selected":""?>>Доски и лыжи</option>
          <option <?=isset($lot['category']) == 'Крепления'?"selected":""?>>Крепления</option>
          <option <?=isset($lot['category']) == 'Ботинки'?"selected":""?>>Ботинки</option> 
          <option <?=isset($lot['category']) == 'Одежда'?"selected":""?>>Одежда</option>
          <option <?=isset($lot['category']) == 'Инструменты'?"selected":""?>>Инструменты</option>
          <option <?=isset($lot['category']) == 'Разное'?"selected":""?>>Разное</option>
        </select>
        <span class="form__error">Выберите категорию</span>
      </div>
    </div>
    <div class="form__item form__item--wide <?=$errors['message']?"form__item--invalid":""?>">
      <label for="message">Описание</label>
      <textarea id="message" name="message" placeholder="Напишите описание лота" required><?=isset($lot['message'])?$lot['message']:""?></textarea>
      <span class="form__error"><?=$errors['message']?></span>
    </div>
    <div class="form__item form__item--file"> <!-- form__item--uploaded -->
      <label>Изображение</label>
      <div class="preview">
        <button class="preview__remove" type="button">x</button>
        <div class="preview__img">
          <img src="img/avatar.jpg" width="113" height="113" alt="Изображение лота">
        </div>
      </div>
      <div class="form__input-file">
        <input class="visually-hidden" type="file" id="photo2" name="file_name">
        <label for="photo2">
          <span>+ Добавить</span>
        </label>
      </div>
    </div>
    <div class="form__container-three">
      <div class="form__item form__item--small <?=$errors['lot_rate']?"form__item--invalid":""?>">
        <label for="lot-rate">Начальная цена</label>
        <input id="lot-rate" type="number" name="lot_rate" value="<?=$lot['lot_rate']?>" placeholder="0" required>
        <span class="form__error"><?=$errors['lot_rate']?></span>
      </div>
      <div class="form__item form__item--small <?=$errors['lot_step']?"form__item--invalid":""?>">
        <label for="lot-step">Шаг ставки</label>
        <input id="lot-step" type="number" name="lot_step" value="<?=$lot['lot_step']?>" placeholder="0" required>
        <span class="form__error"><?=$errors['lot_step']?></span>
      </div>
      <div class="form__item <?=$errors['lot_date']?"form__item--invalid":""?>">
        <label for="lot-date">Дата окончания торгов</label>
        <input class="form__input-date" id="lot-date" type="date" value="<?=$lot['lot_date']?>" name="lot_date" required>
        <span class="form__error"><?=$errors['lot_date']?></span>
      </div>
    </div>
    <span class="form__error <?=$errors?"form__error--bottom":""?>">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Добавить лот</button>
  </form>
</main>