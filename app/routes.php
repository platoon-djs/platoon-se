<?php

$app->get('/', 'IndexController:index')->name('home');
$app->get('/about', 'AboutController:index')->name('about');

$app->get('/booking', 'BookingController:index')->name('booking');
$app->get('/booking/place/:query', 'BookingController:place');
$app->post('/booking/send', 'BookingController:send');
