<?php

Router::connect('/users', array('plugin' => 'UserAdmin', 'controller' => 'users', 'action' => 'index'));
Router::connect('/users/login', array('plugin' => 'UserAdmin', 'controller' => 'users', 'action' => 'login'));
Router::connect('/users/logout', array('plugin' => 'UserAdmin', 'controller' => 'users', 'action' => 'logout'));
Router::connect('/users/account', array('plugin' => 'UserAdmin', 'controller' => 'users', 'action' => 'account'));
Router::connect('/users', array('plugin' => 'UserAdmin', 'controller' => 'users', 'action' => 'index'));
Router::connect('/users', array('plugin' => 'UserAdmin', 'controller' => 'users', 'action' => 'index'));


