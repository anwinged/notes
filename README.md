# Notes [![Build Status](https://travis-ci.org/anwinged/notes.svg?branch=master)](https://travis-ci.org/anwinged/notes)

Простое приложение для управления заметками. Основано на компоннетах Symfony и
Vue.js.

Сделано в качестве эксперимента по прохождению полного цикла в создании
веб-приложения.

## Разработка

Для разработки можно использовать Docker.

    $ make build
    $ make up
    $ make migrate
    $ make reindex-search-db

## Развертывание

В качестве инструмента развертывания используется
[Deployer](https://deployer.org). Сокращенные версии его команд находятся в
Makefile.

    $ make deploy-prod

## Другие приложения

Источники вдохновения:

* [Bear](http://www.bear-writer.com) - красивое и функциональное приложение. Нет
  веб-версии, нативные клиенты только под MacOs, iOs, Android. Платное.

* [Hackmd](https://hackmd.io) - приложение для совместной работы над заметками.
  Поддерживает огромное количество блоков (программный код, схемы, диаграммы,
  встраивание картинок и видео, ноты).

* [Simplenote](https://simplenote.com) - минималистичное приложение. Есть
  клиенты под популярные платформы, но нет API.

* [Laverna](https://laverna.cc) - open source альтернатива для Evernote.
  Написана на Electron. Есть клиенты под популярные платформы.

* [Inkdrop](https://www.inkdrop.info) - еще одно приложение для заметок.
  Платное.

* [Alternote](http://alternoteapp.com) - альтернативный клиент для Evernote.
  Использует его API, но не все функции. Платное, только под Mac.
