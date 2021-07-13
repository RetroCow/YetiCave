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
  <form class="form container <?=isset($errors)?"form--invalid":""?>" enctype="multipart/form-data" action="registration.php" method="post"> <!-- form--invalid -->
    <h2>Регистрация нового аккаунта</h2>
    <div class="form__item <?=isset($errors['email'])?"form__item--invalid":""?>"> <!-- form__item--invalid -->
      <label for="email">E-mail*</label>
      <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?=isset($form['email'])?$form['email']:""?>" required>
      <span class="form__error"><?=isset($errors['email'])?$errors['email']:""?></span>
    </div>
    <div class="form__item <?=isset($errors['password'])?"form__item--invalid":""?>">
      <label for="password">Пароль*</label>
      <input id="password" type="password" name="password" placeholder="Введите пароль" value="<?=isset($form['password'])?$form['password']:""?>" required>
      <span class="form__error"><?=isset($errors['password'])?$errors['password']:""?></span>
    </div>
    <div class="form__item <?=isset($errors['name'])?"form__item--invalid":""?>">
      <label for="name">Имя*</label>
      <input id="name" type="text" name="name" placeholder="Введите имя" value="<?=isset($form['name'])?$form['name']:""?>" required>
      <span class="form__error"><?=isset($errors['name'])?$errors['name']:""?></span>
    </div>
    <div class="form__item <?=isset($errors['message'])?"form__item--invalid":""?>">
      <label for="message">Контактные данные*</label>
      <textarea id="message" name="message" placeholder="Напишите как с вами связаться" required><?=isset($form['message'])?$form['message']:""?></textarea>
      <span class="form__error"><?=isset($errors['message'])?$errors['message']:""?></span>
    </div>
    <div class="form__item form__item--file form__item--last  <?=isset($errors['file_name'])?"form__item--invalid":""?>">
      <label>Аватар</label>
      <div class="preview">
        <button class="preview__remove" type="button">x</button>
        <div class="preview__img">
          <img src="img/avatar.jpg" width="113" height="113" alt="Ваш аватар">
        </div>
      </div>
      <div class="form__input-file">
        <input class="visually-hidden" type="file" id="photo2" name="file_name">
        <label for="photo2">
          <span>+ Добавить</span>
        </label>
      </div>
    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Зарегистрироваться</button>
    <a class="text-link" href="#">Уже есть аккаунт</a>
  </form>
</main>