<?php

return [

    // The prefix for routes
    'prefix' => 'graphql',

    // The routes to make GraphQL request. Either a string that will apply
    // to both query and mutation or an array containing the key 'query' and/or
    // 'mutation' with the according Route
    //
    // Example:
    //
    // Same route for both query and mutation
    //
    // 'routes' => 'path/to/query/{graphql_schema?}',
    //
    // or define each route
    //
    // 'routes' => [
    //     'query' => 'query/{graphql_schema?}',
    //     'mutation' => 'mutation/{graphql_schema?}',
    // ]
    //
    'routes' => '{graphql_schema?}',

    // The controller to use in GraphQL request. Either a string that will apply
    // to both query and mutation or an array containing the key 'query' and/or
    // 'mutation' with the according Controller and method
    //
    // Example:
    //
    // 'controllers' => [
    //     'query' => '\Rebing\GraphQL\GraphQLController@query',
    //     'mutation' => '\Rebing\GraphQL\GraphQLController@mutation'
    // ]
    //
    'controllers' => \Rebing\GraphQL\GraphQLController::class . '@query',

    // Any middleware for the graphql route group
    'middleware' => [],

    // The name of the default schema used when no argument is provided
    // to GraphQL::schema() or when the route is used without the graphql_schema
    // parameter.
    'default_schema' => 'public',

    // The schemas for query and/or mutation. It expects an array of schemas to provide
    // both the 'query' fields and the 'mutation' fields.
    //
    // You can also provide a middleware that will only apply to the given schema
    //
    // Example:
    //
    //  'schema' => 'default',
    //
    //  'schemas' => [
    //      'default' => [
    //          'query' => [
    //              'users' => 'App\GraphQL\Query\UsersQuery'
    //          ],
    //          'mutation' => [
    //
    //          ]
    //      ],
    //      'user' => [
    //          'query' => [
    //              'profile' => 'App\GraphQL\Query\ProfileQuery'
    //          ],
    //          'mutation' => [
    //
    //          ],
    //          'middleware' => ['auth'],
    //      ],
    //      'user/me' => [
    //          'query' => [
    //              'profile' => 'App\GraphQL\Query\MyProfileQuery'
    //          ],
    //          'mutation' => [
    //
    //          ],
    //          'middleware' => ['auth'],
    //      ],
    //  ]
    //
    'schemas' => [
        'admin' => [
            'query' => [
                'activities' => App\GraphQL\Admin\Query\ActivitiesQuery::class,
                'activity' => App\GraphQL\Admin\Query\ActivityQuery::class,
                'activityTags' => App\GraphQL\Admin\Query\ActivityTagsQuery::class,
                'langs' => App\GraphQL\Admin\Query\LangsQuery::class,
                'langs' => App\GraphQL\Admin\Query\LangsQuery::class,
                'logout'    => App\GraphQL\Admin\Query\UserLogoutQuery::class,
                'tag' => App\GraphQL\Admin\Query\TagQuery::class,
                'tags' => App\GraphQL\Admin\Query\TagsQuery::class,
                'tagsSearch' => App\GraphQL\Admin\Query\TagsSearch::class,
                'translation' => App\GraphQL\Admin\Query\TranslationQuery::class,
                'translations' => App\GraphQL\Admin\Query\TranslationsQuery::class,
                'user' => App\GraphQL\Admin\Query\UserQuery::class,
                'users' => App\GraphQL\Admin\Query\UsersQuery::class,
            ],
            'mutation' => [
                'activityCreate' => App\GraphQL\Admin\Mutation\ActivityCreateMutation::class,
                'activityDelete' => App\GraphQL\Admin\Mutation\ActivityDeleteMutation::class,
                'activityUpdate' => App\GraphQL\Admin\Mutation\ActivityUpdateMutation::class,
                'activityTagCreate' => App\GraphQL\Admin\Mutation\ActivityTagCreateMutation::class,
                'activityTagDelete' => App\GraphQL\Admin\Mutation\ActivityTagDeleteMutation::class,
                'imageUpload' => App\GraphQL\Admin\Mutation\ImageUploadMutation::class,
                'langUpdate' => App\GraphQL\Admin\Mutation\LangUpdateMutation::class,
                'langCreate' => App\GraphQL\Admin\Mutation\LangCreateMutation::class,
                'tagCreate' => App\GraphQL\Admin\Mutation\TagCreateMutation::class,
                'tagDelete' => App\GraphQL\Admin\Mutation\TagDeleteMutation::class,
                'tagUpdate' => App\GraphQL\Admin\Mutation\TagUpdateMutation::class,
                'translationCreate' => App\GraphQL\Admin\Mutation\TranslationCreateMutation::class,
                'translationUpdate' => App\GraphQL\Admin\Mutation\TranslationUpdateMutation::class,
                'userUpdateEmail' => App\GraphQL\Admin\Mutation\UserUpdateEmail::class,
                'userUpdatePassword' => App\GraphQL\Admin\Mutation\UserUpdatePassword::class,
                'userUpdateProfile' => App\GraphQL\Admin\Mutation\UserUpdateProfile::class,
            ],
            'middleware' => ['auth:api'],
            'method' => ['POST'],
        ],
        'public' => [
            'mutation' => [
                'activate' => App\GraphQL\Publics\Mutation\UserActivateMutation::class,
                'forgotpass' => App\GraphQL\Publics\Mutation\UserForgotPassMutation::class,
                'resetpass' => App\GraphQL\Publics\Mutation\UserResetPassMutation::class,
                'signUpBasic' => App\GraphQL\Publics\Mutation\UserSignUpBasicMutation::class
            ],
            'query' => [
                'login' => App\GraphQL\Publics\Query\UserLoginQuery::class,
            ],
            'middleware' => ['api'],
            'method' => ['POST'],
        ],
    ],

    // The types available in the application. You can then access it from the
    // facade like this: GraphQL::type('user')
    //
    // Example:
    //
    // 'types' => [
    //     'user' => 'App\GraphQL\Type\UserType'
    // ]
    //
    'types' => [
        App\GraphQL\Type\ActivityTagType::class,
        App\GraphQL\Type\ActivityType::class,
        App\GraphQL\Type\DeviceSlotType::class,
        App\GraphQL\Type\DeviceType::class,
        App\GraphQL\Type\LangType::class,
        App\GraphQL\Type\ImageFileSlotType::class,
        App\GraphQL\Type\ImageFileType::class,
        App\GraphQL\Type\ImageType::class,
        App\GraphQL\Type\SimpleMessageType::class,
        App\GraphQL\Type\SessionAndXCSRFTokenType::class,
        App\GraphQL\Type\TagType::class,
        App\GraphQL\Type\TextType::class,
        App\GraphQL\Type\TranslationType::class,
        App\GraphQL\Type\UserStatusReasonType::class,
        App\GraphQL\Type\UserType::class,
    ],

    // This callable will be passed the Error object for each errors GraphQL catch.
    // The method should return an array representing the error.
    // Typically:
    // [
    //     'message' => '',
    //     'locations' => []
    // ]
    //'error_formatter' => ['\Rebing\GraphQL\GraphQL', 'formatError'],
    'error_formatter' => [App\Exceptions\GraphQLExceptions::class, 'formatError'],

    // You can set the key, which will be used to retrieve the dynamic variables
    'params_key'    => 'variables',

    /*
     * Options to limit the query complexity and depth. See the doc
     * @ https://github.com/webonyx/graphql-php#security
     * for details. Disabled by default.
     */
    'security' => [
        'query_max_complexity' => null,
        'query_max_depth' => null,
        'disable_introspection' => false
    ],
    /*
     * Config for GraphiQL (see (https://github.com/graphql/graphiql).
     * To dissable GraphiQL, set this to null
     */
    'graphiql' => [
        'prefix' => '/graphiql/{graphql_schema?}',
        'controller' => \Rebing\GraphQL\GraphQLController::class.'@graphiql',
        'middleware' => ['web'],
        'view' => 'graphql::graphiql',
        'display' => env('ENABLE_GRAPHIQL', true),
    ],
];
