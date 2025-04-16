<?php

return [
    'default' => 'default',
    'documentations' => [
        'default' => [
            'api' => [
                'title' => 'MailMaster API Documentation', // Changed title
                'description' => 'RESTful API for managing newsletters, subscribers, and campaigns.', // Added description
                'version' => '1.0.0', // Added version
            ],
            'routes' => [
                /*
                 * Route for accessing api documentation interface
                 */
                'api' => 'api/documentation',
            ],
            'paths' => [
                /*
                 * Edit to include full URL in ui for assets
                 */
                'use_absolute_path' => env('L5_SWAGGER_USE_ABSOLUTE_PATH', true),

                /*
                * Edit to set path where swagger ui assets should be stored
                */
                'swagger_ui_assets_path' => env('L5_SWAGGER_UI_ASSETS_PATH', 'vendor/swagger-api/swagger-ui/dist/'),

                /*
                 * File name of the generated json documentation file
                 */
                'docs_json' => 'api-docs.json',

                /*
                 * File name of the generated YAML documentation file
                 */
                'docs_yaml' => 'api-docs.yaml',

                /*
                 * Set this to `json` or `yaml` to determine which documentation file to use in UI
                 */
                'format_to_use_for_docs' => env('L5_FORMAT_TO_USE_FOR_DOCS', 'json'),

                /*
                 * Absolute paths to directory containing the swagger annotations are stored.
                 */
                'annotations' => [
                    base_path('app'),
                ],
            ],
            'components' => [ // Added components section
                'securitySchemes' => [
                    'bearerAuth' => [
                        'type' => 'http',
                        'scheme' => 'bearer',
                        'bearerFormat' => 'JWT',
                        'description' => 'Enter your bearer token to access secured API endpoints.',
                    ],
                ],
                'schemas' => [
                    'Newsletter' => [
                        'type' => 'object',
                        'properties' => [
                            'id' => ['type' => 'integer', 'format' => 'int64', 'description' => 'Newsletter ID'],
                            'title' => ['type' => 'string', 'description' => 'Newsletter Title'],
                            'content' => ['type' => 'string', 'description' => 'Newsletter Content'],
                            'created_at' => ['type' => 'string', 'format' => 'date-time', 'description' => 'Creation timestamp'],
                            'updated_at' => ['type' => 'string', 'format' => 'date-time', 'description' => 'Update timestamp'],
                        ],
                    ],
                    'Subscriber' => [
                        'type' => 'object',
                        'properties' => [
                            'id' => ['type' => 'integer', 'format' => 'int64', 'description' => 'Subscriber ID'],
                            'email' => ['type' => 'string', 'format' => 'email', 'description' => 'Subscriber Email'],
                            'name' => ['type' => 'string', 'nullable' => true, 'description' => 'Subscriber Name (optional)'],
                            'created_at' => ['type' => 'string', 'format' => 'date-time', 'description' => 'Creation timestamp'],
                            'updated_at' => ['type' => 'string', 'format' => 'date-time', 'description' => 'Update timestamp'],
                        ],
                    ],
                    'Campaign' => [
                        'type' => 'object',
                        'properties' => [
                            'id' => ['type' => 'integer', 'format' => 'int64', 'description' => 'Campaign ID'],
                            'newsletter_id' => ['type' => 'integer', 'format' => 'int64', 'description' => 'Associated Newsletter ID'],
                            'title' => ['type' => 'string', 'description' => 'Campaign Title'],
                            'subject' => ['type' => 'string', 'description' => 'Email Subject'],
                            'sent_at' => ['type' => 'string', 'format' => 'date-time', 'nullable' => true, 'description' => 'Sent timestamp (nullable)'],
                            'status' => ['type' => 'string', 'enum' => ['draft', 'pending', 'sent', 'failed'], 'description' => 'Campaign Status'],
                            'created_at' => ['type' => 'string', 'format' => 'date-time', 'description' => 'Creation timestamp'],
                            'updated_at' => ['type' => 'string', 'format' => 'date-time', 'description' => 'Update timestamp'],
                        ],
                    ],
                    'PaginationLinks' => [  // Reusable schema for pagination links
                        'type' => 'object',
                        'properties' => [
                            'first' => ['type' => 'string', 'nullable' => true, 'description' => 'First page URL'],
                            'last' => ['type' => 'string', 'nullable' => true, 'description' => 'Last page URL'],
                            'prev' => ['type' => 'string', 'nullable' => true, 'description' => 'Previous page URL'],
                            'next' => ['type' => 'string', 'nullable' => true, 'description' => 'Next page URL'],
                        ],
                    ],
                    'PaginationMeta' => [   // Reusable schema for pagination metadata
                        'type' => 'object',
                        'properties' => [
                            'current_page' => ['type' => 'integer', 'description' => 'Current page number'],
                            'from' => ['type' => 'integer', 'nullable' => true, 'description' => 'Starting item number for the current page'],
                            'last_page' => ['type' => 'integer', 'description' => 'Last page number'],
                            'links' => ['type' => 'array', 'items' => ['type' => 'object']], // Could be further defined if needed
                            'path' => ['type' => 'string', 'description' => 'Base path for pagination URLs'],
                            'per_page' => ['type' => 'integer', 'description' => 'Number of items per page'],
                            'to' => ['type' => 'integer', 'nullable' => true, 'description' => 'Ending item number for the current page'],
                            'total' => ['type' => 'integer', 'description' => 'Total number of items'],
                        ],
                    ],
                    'Error' => [    // Reusable schema for error responses
                        'type' => 'object',
                        'properties' => [
                            'message' => ['type' => 'string', 'description' => 'Error message'],
                        ],
                    ],
                    'ValidationError' => [   // Reusable schema for validation error responses
                        'type' => 'object',
                        'properties' => [
                            'message' => ['type' => 'string', 'description' => 'Validation error message', 'example' => 'The given data was invalid.'],
                            'errors' => [
                                'type' => 'object',
                                'additionalProperties' => [
                                    'type' => 'array',
                                    'items' => ['type' => 'string'],
                                    'example' => ['The email field is required.', 'The email must be a valid email address.'],
                                ],
                            ],
                        ],
                    ],
                    'UnauthorizedError' => [  // Reusable schema for 401 Unauthorized responses
                        'type' => 'object',
                        'properties' => [
                            'message' => ['type' => 'string', 'description' => 'Unauthorized error message', 'example' => 'Unauthorized'],
                        ],
                    ],
                    'ForbiddenError' => [     // Reusable schema for 403 Forbidden responses
                        'type' => 'object',
                        'properties' => [
                            'message' => ['type' => 'string', 'description' => 'Forbidden error message', 'example' => 'Forbidden'],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'defaults' => [
        'routes' => [
            /*
             * Route for accessing parsed swagger annotations.
             */
            'docs' => 'docs',

            /*
             * Route for Oauth2 authentication callback.
             */
            'oauth2_callback' => 'api/oauth2-callback',

            /*
             * Middleware allows to prevent unexpected access to API documentation
             */
            'middleware' => [
                'api' => [],
                'asset' => [],
                'docs' => [],
                'oauth2_callback' => [],
            ],

            /*
             * Route Group options
             */
            'group_options' => [],
        ],
        'paths' => [
            /*
             * Absolute path to location where parsed annotations will be stored
             */
            'docs' => storage_path('api-docs'),

            /*
             * Absolute path to directory where to export views
             */
            'views' => base_path('resources/views/vendor/l5-swagger'),

            /*
             * Edit to set the api's base path
             */
            'base' => env('L5_SWAGGER_BASE_PATH', null),

            /*
             * Absolute path to directories that should be excluded from scanning
             * @deprecated Please use `scanOptions.exclude`
             * `scanOptions.exclude` overwrites this
             */
            'excludes' => [],
        ],
        'scanOptions' => [
            /**
             * Configuration for default processors. Allows to pass processors configuration to swagger-php.
             *
             * @link https://zircote.github.io/swagger-php/reference/processors.html
             */
            'default_processors_configuration' => [
                /** Example */
                /**
                 * 'operationId.hash' => true,
                 * 'pathFilter' => [
                 * 'tags' => [
                 * '/pets/',
                 * '/store/',
                 * ],
                 * ],.
                 */
            ],
            /**
             * analyser: defaults to \OpenApi\StaticAnalyser .
             *
             * @see \OpenApi\scan
             */
            'analyser' => null,
            /**
             * analysis: defaults to a new \OpenApi\Analysis .
             *
             * @see \OpenApi\scan
             */
            'analysis' => null,
            /**
             * Custom query path processors classes.
             *
             * @link https://github.com/zircote/swagger-php/tree/master/Examples/processors/schema-query-parameter
             * @see \OpenApi\scan
             */
            'processors' => [
                // new \App\SwaggerProcessors\SchemaQueryParameter(),
            ],
            /**
             * pattern: string       $pattern File pattern(s) to scan (default: *.php) .
             *
             * @see \OpenApi\scan
             */
            'pattern' => null,
            /*
             * Absolute path to directories that should be excluded from scanning
             * @note This option overwrites `paths.excludes`
             * @see \OpenApi\scan
             */
            'exclude' => [],
            /*
             * Allows to generate specs either for OpenAPI 3.0.0 or OpenAPI 3.1.0.
             * By default the spec will be in version 3.0.0
             */
            'open_api_spec_version' => env('L5_SWAGGER_OPEN_API_SPEC_VERSION', \L5Swagger\Generator::OPEN_API_DEFAULT_SPEC_VERSION),
        ],
        /*
         * API security definitions. Will be generated into documentation file.
         */
        'securityDefinitions' => [
            'securitySchemes' => [
                /*
                 * Examples of Security schemes
                 */
                /*
                'api_key_security_example' => [ // Unique name of security
                    'type' => 'apiKey', // The type of the security scheme. Valid values are "basic", "apiKey" or "oauth2".
                    'description' => 'A short description for security scheme',
                    'name' => 'api_key', // The name of the header or query parameter to be used.
                    'in' => 'header', // The location of the API key. Valid values are "query" or "header".
                ],
                'oauth2_security_example' => [ // Unique name of security
                    'type' => 'oauth2', // The type of the security scheme. Valid values are "basic", "apiKey" or "oauth2".
                    'description' => 'A short description for oauth2 security scheme.',
                    'flow' => 'implicit', // The flow used by the OAuth2 security scheme. Valid values are "implicit", "password", "application" or "accessCode".
                    'authorizationUrl' => 'http://example.com/auth', // The authorization URL to be used for (implicit/accessCode)
                    //'tokenUrl' => 'http://example.com/auth' // The authorization URL to be used for (password/application/accessCode)
                    'scopes' => [
                        'read:projects' => 'read your projects',
                        'write:projects' => 'modify projects in your account',
                    ]
                ],
                */
                /* Open API 3.0 support */
                /*
                'passport' => [ // Unique name of security
                    'type' => 'oauth2', // The type of the security scheme. Valid values are "basic", "apiKey" or "oauth2".
                    'description' => 'Laravel passport oauth2 security.',
                    'in' => 'header',
                    'scheme' => 'https',
                    'flows' => [
                        "password" => [
                            "authorizationUrl" => config('app.url') . '/oauth/authorize',
                            "tokenUrl" => config('app.url') . '/oauth/token',
                            "refreshUrl" => config('app.url') . '/token/refresh',
                            "scopes" => []
                        ],
                    ],
                ],
                'sanctum' => [ // Unique name of security
                    'type' => 'apiKey', // Valid values are "basic", "apiKey" or "oauth2".
                    'description' => 'Enter token in format (Bearer <token>)',
                    'name' => 'Authorization', // The name of the header or query parameter to be used.
                    'in' => 'header', // The location of the API key. Valid values are "query" or "header".
                ],
                */
            ],
            'security' => [
                /*
                 * Examples of Securities
                 */
                [
                    /*
                    'oauth2_security_example' => [
                        'read',
                        'write'
                    ],
                    'passport' => []
                    */
                ],
            ],
        ],
        /*
         * Set this to `true` in development mode so that docs would be regenerated on each request
         * Set this to `false` to disable swagger generation on production
         */
        'generate_always' => env('L5_SWAGGER_GENERATE_ALWAYS', false),
        /*
         * Set this to `true` to generate a copy of documentation in yaml format
         */
        'generate_yaml_copy' => env('L5_SWAGGER_GENERATE_YAML_COPY', false),
        /*
         * Edit to trust the proxy's ip address - needed for AWS Load Balancer
         * string[]
         */
        'proxy' => false,
        /*
         * Configs plugin allows to fetch external configs instead of passing them to SwaggerUIBundle.
         * See more at: https://github.com/swagger-api/swagger-ui#configs-plugin
         */
        'additional_config_url' => null,
        /*
         * Apply a sort to the operation list of each API. It can be 'alpha' (sort by paths alphanumerically),
         * 'method' (sort by HTTP method).
         * Default is the order returned by the server unchanged.
         */
        'operations_sort' => env('L5_SWAGGER_OPERATIONS_SORT', null),
        /*
         * Pass the validatorUrl parameter to SwaggerUi init on the JS side.
         * A null value here disables validation.
         */
        'validator_url' => null,
        /*
         * Swagger UI configuration parameters
         */
        'ui' => [
            'display' => [
                'dark_mode' => env('L5_SWAGGER_UI_DARK_MODE', false),
                /*
                 * Controls the default expansion setting for the operations and tags. It can be :
                 * 'list' (expands only the tags),
                 * 'full' (expands the tags and operations),
                 * 'none' (expands nothing).
                 */
                'doc_expansion' => env('L5_SWAGGER_UI_DOC_EXPANSION', 'list'), // Changed default to 'list'
                /**
                 * If set, enables filtering. The top bar will show an edit box that
                 * you can use to filter the tagged operations that are shown. Can be
                 * Boolean to enable or disable, or a string, in which case filtering
                 * will be enabled using that string as the filter expression. Filtering
                 * is case-sensitive matching the filter expression anywhere inside
                 * the tag.
                 */
                'filter' => env('L5_SWAGGER_UI_FILTERS', true), // true | false
            ],
            'authorization' => [
                /*
                 * If set to true, it persists authorization data, and it would not be lost on browser close/refresh
                 */
                'persist_authorization' => env('L5_SWAGGER_UI_PERSIST_AUTHORIZATION', false),
                'oauth2' => [
                    /*
                     * If set to true, adds PKCE to AuthorizationCodeGrant flow
                     */
                    'use_pkce_with_authorization_code_grant' => false,
                ],
            ],
        ],
        /*
         * Constants which can be used in annotations
         */
        'constants' => [
            'L5_SWAGGER_CONST_HOST' => env('L5_SWAGGER_CONST_HOST', 'http://my-default-host.com'),
        ],
    ],
];