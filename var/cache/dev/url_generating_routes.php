<?php

// This file has been auto-generated by the Symfony Routing Component.

return [
    '_preview_error' => [['code', '_format'], ['_controller' => 'error_controller::preview', '_format' => 'html'], ['code' => '\\d+'], [['variable', '.', '[^/]++', '_format', true], ['variable', '/', '\\d+', 'code', true], ['text', '/_error']], [], []],
    'app_userinterface_pages_home' => [[], ['_controller' => 'App\\UserInterface\\PagesController::home'], [], [['text', '/']], [], []],
    'app_userinterface_usermanagement_oauth2_authtoken_login' => [[], ['_controller' => 'App\\UserInterface\\UserManagement\\OAuth2\\AuthTokenController::login'], [], [['text', '/auth/access-token']], [], []],
    'app_userinterface_usermanagement_userinfo_info' => [[], ['_controller' => 'App\\UserInterface\\UserManagement\\UserInfoController::info'], [], [['text', '/users/me']], [], []],
];
