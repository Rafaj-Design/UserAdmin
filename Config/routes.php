<?php

// Users controller
Router::connect('/users', array('plugin' => 'UserAdmin', 'controller' => 'users', 'action' => 'index'));
Router::connect('/users/:action/*', array('plugin' => 'UserAdmin', 'controller' => 'users'));


// Teams controller
Router::connect('/teams', array('plugin' => 'UserAdmin', 'controller' => 'teams', 'action' => 'index'));
Router::connect('/teams/:action/*', array('plugin' => 'UserAdmin', 'controller' => 'teams'));


