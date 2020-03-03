# Testovací Zadání: Databáze lidí

Databáze lidí vytvořená jako testovací zadání.

Lidi je možné přidávat, mazat, upravovat, filtrovat dle pohlaví a řadit dle data přidání.

## Predispozice

Aplikace vyžaduje PHP 7.4.0 neboť obsahuje typované vlastnosti.

## Instalace

Po stažení apliakce je nutné nainstalovat framework Nette 3.0 pomocí:

```
composer install
```

### Databáze

Dále je nutné vytvořit si databázi:

```
CREATE TABLE `people` (
  `id` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `first_name` VARCHAR(255) NOT NULL,
  `last_name` VARCHAR(255) NOT NULL,
  `gender` ENUM("Muž", "Žena") NOT NULL,
  `birthday` DATE NOT NULL,
  `tel` VARCHAR(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB CHARSET=utf8;
```

### Konfigurace

Připojení k databází je nutné nakonfigurovat v konfiguračním souboru **app/config/common.neon**, nebo **local.neon**:

```
database:
	dsn: "mysql:host=localhost;dbname="
	user: ""
	password: ""
	options:
		lazy: yes
```

Pokud soubor **local.neon** není využit a neexistuje, je nutné ho odstranit ze souboru **app/bootstrap.php**:

```
$configurator
	->addConfig(__DIR__ . '/config/common.neon')
	->addConfig(__DIR__ . '/config/local.neon');
```

Poté je aplikace funkční.

## Vytvořeno pomocí

* [Nette](https://nette.org) - PHP framework
* [jQuery](https://jquery.com) - Javascript framework
* [nette.ajax.js](https://github.com/vojtech-dobes/nette.ajax.js) - Ajaxifikace formulářů a odkazů pro Nette
* [fontawesome](https://https://fontawesome.com) - Open Source sada ikon

## Autor

* **Filip Zrubecký** - [Zrubecky](https://github.com/Zrubecky)