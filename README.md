# Каталог товаров - API проект на Laravel

## Описание проекта
Этот проект представляет собой API для каталога товаров с гибкой системой фильтрации по свойствам. API позволяет получать список товаров с применением различных фильтров, сортировки и пагинации.

## Технический стек
- **Laravel**: версия 12.0
- **PHP**: версия 8.2
- **MySQL**: версия 8.0
- **Docker**: с использованием Laravel Sail

## Настройка Docker
Проект использует Laravel Sail для Docker-контейнеризации. Конфигурация контейнеров определена в стандартном файле `docker-compose.yml`.

### Порты
- **Laravel**: 80
- **MySQL**: 33060 (проброс на хост-машину)
- **phpMyAdmin**: 8080 (проброс на хост-машину)

## Настройка базы данных
- **Основная БД**: MySQL 8.0
- **База данных**: product_catalog
- **Пользователь**: sail
- **Пароль**: password

Для тестирования используется отдельная база данных `testing`, настроенная в `phpunit.xml`.

## Модели

### Product (`app/Models/Product.php`)
- Представляет товары в каталоге
- Поля: `id`, `name`, `price`, `quantity`, `created_at`, `updated_at`
- Связь many-to-many с `PropertyValue` через промежуточную таблицу

### Property (`app/Models/Property.php`)
- Представляет типы свойств товаров (цвет, размер, материал и т.д.)
- Поля: `id`, `name`, `created_at`, `updated_at`
- Связь one-to-many с `PropertyValue`

### PropertyValue (`app/Models/PropertyValue.php`)
- Представляет конкретные значения свойств (красный, XL, хлопок и т.д.)
- Поля: `id`, `property_id`, `value`, `created_at`, `updated_at`
- Связи: belongs-to с `Property`, many-to-many с `Product`

### ProductPropertyValue (`app/Models/ProductPropertyValue.php`)
- Промежуточная модель для связи many-to-many между `Product` и `PropertyValue`
- Поля: `id`, `product_id`, `property_value_id`
- Связи: belongs-to с `Product` и `PropertyValue`

## Репозитории
Для абстракции работы с данными реализован паттерн Repository:

### RepositoryInterface (`app/Repositories/RepositoryInterface.php`)
- Определяет интерфейс для всех репозиториев
- Методы: `all()`, `find()`, `create()`, `update()`, `delete()`

### ProductRepository (`app/Repositories/ProductRepository.php`)
- Реализует методы для работы с моделью `Product`

### PropertyRepository (`app/Repositories/PropertyRepository.php`)
- Реализует методы для работы с моделью `Property`
- Включает специальный метод `findByName` для поиска свойств по имени

### PropertyValueRepository (`app/Repositories/PropertyValueRepository.php`)
- Реализует методы для работы с моделью `PropertyValue`

## Сервисы

### ProductCatalogService (`app/Services/ProductCatalogService.php`)
- Инкапсулирует бизнес-логику работы с каталогом товаров
- Методы:
  - `getFilteredProducts` - получение товаров с фильтрацией и пагинацией
  - `createFilteredQuery` - создание запроса с фильтрами
  - `addPropertyFilter` - добавление фильтра по свойству
  - `applyPagination` - применение пагинации
  - `formatProducts` - форматирование данных о товарах
  - `createPaginationInfo` - формирование информации о пагинации

## Контроллеры

### ProductController (`app/Http/Controllers/API/ProductController.php`)
- Обрабатывает API-запросы к каталогу товаров
- Метод `index` для получения списка товаров с фильтрацией

## API-маршруты
API-маршруты определены в файле `routes/api.php`:
```php
Route::get('/products', [ProductController::class, 'index']);
