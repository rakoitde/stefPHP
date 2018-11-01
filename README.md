# RaKoITde stefPHP v1.0.0

A Simple Template Engine for PHP

## Simple Template Engine

Why another template engine? Because after a long search I haven't found the simple Enginge that is simple, clear and easy to expand. I use this engine for private, small projects.

# Installation

## Manual

```
cd <your project>
mkdir -p vendor/rakoitde/stefPHP
cd vendor/rakoitde/stefPHP
git clone https://github.com/rakoitde/stefPHP .
composer install
```

## Composer

```
cd <your project>
composer require 'rakoitde/stefPHP:dev-master'
```

# Template Tags

## If / If not
```
[?TAG] [/?TAG]
[!TAG] [/!TAG]
```

## Loops
### Array Loop
```
[%TAG] [/%TAG]
```
### Key Value Loop
```
[%loop] [/%TAG]
```

## Values
```
[@key]
```

## Import (ToDo)
```
[!import template.tpl]
```
