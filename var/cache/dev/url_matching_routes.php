<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/' => [[['_route' => 'app_userinterface_pages_home', '_controller' => 'App\\UserInterface\\PagesController::home'], null, null, null, false, false, null]],
        '/questions' => [
            [['_route' => 'app_userinterface_questions_createquestion_handle', '_controller' => 'App\\UserInterface\\Questions\\CreateQuestionController::handle'], null, ['POST' => 0], null, false, false, null],
            [['_route' => 'app_userinterface_questions_questionslist_handle', '_controller' => 'App\\UserInterface\\Questions\\QuestionsListController::handle'], null, ['GET' => 0], null, false, false, null],
        ],
        '/auth/access-token' => [[['_route' => 'app_userinterface_usermanagement_oauth2_authtoken_login', '_controller' => 'App\\UserInterface\\UserManagement\\OAuth2\\AuthTokenController::login'], null, null, null, false, false, null]],
        '/users/me' => [[['_route' => 'app_userinterface_usermanagement_userinfo_info', '_controller' => 'App\\UserInterface\\UserManagement\\UserInfoController::info'], null, null, null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/_error/(\\d+)(?:\\.([^/]++))?(*:35)'
                .'|/questions/([^/]++)(?'
                    .'|/answers(*:72)'
                    .'|(*:79)'
                .')'
                .'|/answers/([^/]++)(?'
                    .'|(*:107)'
                    .'|/(?'
                        .'|set\\-as\\-accepted(*:136)'
                        .'|vote\\-(?'
                            .'|positive(*:161)'
                            .'|negative(*:177)'
                        .')'
                    .')'
                    .'|(*:187)'
                .')'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        35 => [[['_route' => '_preview_error', '_controller' => 'error_controller::preview', '_format' => 'html'], ['code', '_format'], null, null, false, true, null]],
        72 => [[['_route' => 'app_userinterface_answers_createanswer_handle', '_controller' => 'App\\UserInterface\\Answers\\CreateAnswerController::handle'], ['questionId'], ['POST' => 0], null, false, false, null]],
        79 => [
            [['_route' => 'app_userinterface_questions_deletequestion_handle', '_controller' => 'App\\UserInterface\\Questions\\DeleteQuestionController::handle'], ['questionId'], ['DELETE' => 0], null, false, true, null],
            [['_route' => 'app_userinterface_questions_getspecificquestion_handle', '_controller' => 'App\\UserInterface\\Questions\\GetSpecificQuestionController::handle'], ['questionId'], ['GET' => 0], null, false, true, null],
            [['_route' => 'app_userinterface_questions_updatequestion_handle', '_controller' => 'App\\UserInterface\\Questions\\UpdateQuestionController::handle'], ['questionId'], ['PATCH' => 0], null, false, true, null],
        ],
        107 => [
            [['_route' => 'app_userinterface_answers_deleteanswer_handle', '_controller' => 'App\\UserInterface\\Answers\\DeleteAnswerController::handle'], ['answerId'], ['DELETE' => 0], null, false, true, null],
            [['_route' => 'app_userinterface_answers_getspecificanswer_handle', '_controller' => 'App\\UserInterface\\Answers\\GetSpecificAnswerController::handle'], ['answerId'], ['GET' => 0], null, false, true, null],
        ],
        136 => [[['_route' => 'app_userinterface_answers_setacceptanswer_handle', '_controller' => 'App\\UserInterface\\Answers\\SetAcceptAnswerController::handle'], ['answerId'], ['PATCH' => 0, 'POST' => 1], null, false, false, null]],
        161 => [[['_route' => 'app_userinterface_answers_voteanswer_votepositive', '_controller' => 'App\\UserInterface\\Answers\\VoteAnswerController::votePositive'], ['answerId'], ['PUT' => 0], null, false, false, null]],
        177 => [[['_route' => 'app_userinterface_answers_voteanswer_votenegative', '_controller' => 'App\\UserInterface\\Answers\\VoteAnswerController::voteNegative'], ['answerId'], ['PUT' => 0], null, false, false, null]],
        187 => [
            [['_route' => 'app_userinterface_answers_updateanswer_handle', '_controller' => 'App\\UserInterface\\Answers\\UpdateAnswerController::handle'], ['answerId'], ['PATCH' => 0], null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
