INSERT INTO categories
SET title = 'Доски и лыжи';
INSERT INTO categories
SET title = 'Крепления';
INSERT INTO categories
SET title = 'Ботинки';
INSERT INTO categories
SET title = 'Одежда';
INSERT INTO categories
SET title = 'Инструменты';
INSERT INTO categories
SET title = 'Разное';

INSERT INTO users
SET email = 'ignat.v@gmail.com', name = 'Игнат', password = '$2y$10$OqvsKHQwr0Wk6FMZDoHo1uHoXd4UdxJG/5UDtUiie00XaxMHrW8ka';
INSERT INTO users
SET email = 'kitty_93@li.ru', name = 'Леночка', password = '$2y$10$bWtSjUhwgggtxrnJ7rxmIe63ABubHQs0AS0hgnOo41IEdMHkYoSVa';
INSERT INTO users
SET email = 'retrocow@mail.ru', name = 'Никита', password = '$2y$10$hU8xs.RncXr4OJgweBhnIu8tNzFyARUMnigdU6ALs7BBWw7EEgvZ2', avatar = 'img/avatar.jpg';

INSERT INTO lots
SET title = '2014 Rossignol District Snowboard',
    description = 'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег мощным щелчком и четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот снаряд отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом кэмбер позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется, просто посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла равнодушным.',
    start_price = '10999',
    price_step = '100',
    current_price = '11009',
    img = 'img/lot-1.jpg',
    category_id = 1,
    create_date = '2020-09-20 17:31:18';

INSERT INTO lots
SET title = 'DC Ply Mens 2016/2017 Snownboard',
    description = 'Описание лота.',
    start_price = '15999',
    price_step = '300',
    current_price = '16299',
    img = 'img/lot-2.jpg',
    category_id = 1,
    create_date = '2020-08-25 14:19:42';

INSERT INTO lots
SET title = 'Крепления Union Contact Pro 2015 года размер L/XL',
    description = 'Описание лота.',
    start_price = '8000',
    price_step = '150',
    current_price = '8150',
    img = 'img/lot-3.jpg',
    category_id = 2,
    create_date = '2020-09-03 22:51:37';

INSERT INTO lots
SET title = 'Ботинки для сноуборда DC Mutiny Charcoal',
    description = 'Описание лота.',
    start_price = '10999',
    price_step = '250',
    current_price = '11249',
    img = 'img/lot-4.jpg',
    category_id = 3,
    create_date = '2020-09-15 19:58:53';

INSERT INTO lots
SET title = 'Куртка для сноуборда DC Mutiny Charcoal',
    description = 'Описание лота.',
    start_price = '7500',
    price_step = '50',
    current_price = '7550',
    img = 'img/lot-5.jpg',
    category_id = 4,
    create_date = '2020-09-21 10:18:22';

INSERT INTO lots
SET title = 'Маска Oakley Canopy',
    description = 'Описание лота.',
    start_price = '5400',
    price_step = '75',
    current_price = '5475',
    img = 'img/lot-6.jpg',
    category_id = 6,
    create_date = '2020-08-29 12:28:51';

INSERT INTO bids
SET amount = '10999', user_id = '1', lot_id = '1', date = '2020-09-19 12:02:07';
INSERT INTO bids
SET amount = '11099', user_id = '2', lot_id = '1', date = '2020-09-19 19:18:46';
INSERT INTO bids
SET amount = '11199', user_id = '3', lot_id = '1', date = '2020-09-20 15:31:52';

SELECT title FROM categories;

SELECT lots.title, start_price, img, current_price, c.title AS category FROM lots JOIN categories c ON category_id = c.id JOIN bids b ON b.lot_id = lots.id ORDER BY create_date DESC;

SELECT lots.title, c.title AS category FROM lots JOIN categories c ON category_id = c.id WHERE lots.id = 1;

UPDATE lots SET title = 'Новое значение' WHERE id = 2;

SELECT title, name, amount, date FROM bids JOIN lots ON lot_id = lots.id JOIN users ON user_id = users.id WHERE lots.id = 1 ORDER BY date DESC;