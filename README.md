﻿Регистрация пользователей с выбором региона

Настройка подключения к БД -> lib/pdoLib

Что реализовано:

- добавлена таблица юзеров с полями id, name, email, territory

- в форме изначально расположены поля ФИО, EMAIL и Список областей в виде выпадающего списка

- список городов и районов подтягивается динамически 

- отображение списков сделано по принципу регион->город->район города, села и мелкие населенные пункты не подтягиваются, городские районы подтягиваются, если они есть.

- валидация полей сделана с помощью JS, на стороне сервера я проверок не делал

- после успешной регистрации отображаются данные пользователя

- если пользователь с таким email-ом существует, отображаются данные пользователя и дополнительное сообщение

- для селектов подкючен плагин Chosen 

- предусмотрена возможность изменения выбора в родительском списке

- дизайн уродский