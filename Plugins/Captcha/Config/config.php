<?php

return [
    'name'      => 'Captcha',
    'slug'      => 'captcha',
    'identifier'=> 'captcha',
    'namespace' => 'Plugins\Captcha\\',

    'characters' => '2346789abcdefghjmnpqrtuxyzABCDEFGHJMNPQRTUXYZ',

    'default'   => [
        'length'    => 4,
        'width'     => 120,
        'height'    => 36,
        'quality'   => 90
    ],

    'flat'   => [
        'length'    => 4,
        'width'     => 160,
        'height'    => 46,
        'quality'   => 90,
        'lines'     => 6,
        'bgImage'   => false,
        'bgColor'   => '#ecf2f4',
        'fontColors'=> ['#2c3e50', '#c0392b', '#16a085', '#c0392b', '#8e44ad', '#303f9f', '#f57c00', '#795548'],
        'contrast'  => -5
    ],

    'mini'   => [
        'length'    => 4,
        'width'     => 60,
        'height'    => 32
    ],

    'inverse'   => [
        'length'    => 4,
        'width'     => 120,
        'height'    => 36,
        'quality'   => 90,
        'sensitive' => true,
        'angle'     => 12,
        'sharpen'   => 10,
        'blur'      => 2,
        'invert'    => true,
        'contrast'  => -5
    ],

    'support_form' => [
        'login_form' => [
            'name'                  => 'Login Form',
            'function_callback'     => 'captcha_template_form_input_default',
            'add_action'            => 'simple_cms_acl_add_to_form_login_hook_action',
            'add_filter_rules'      => 'simple_cms_acl_add_to_validation_roles_form_login_add_filter',
            'add_filter_messages'   => 'simple_cms_acl_add_to_validation_messages_form_login_add_filter',
            'enable'                => true
        ],
        'register_form' => [
            'name'                  => 'Register Form',
            'function_callback'     => 'captcha_template_form_input_default',
            'add_action'            => 'simple_cms_acl_add_to_form_register_hook_action',
            'add_filter_rules'      => 'simple_cms_acl_add_to_validation_roles_form_register_add_filter',
            'add_filter_messages'   => 'simple_cms_acl_add_to_validation_messages_form_register_add_filter',
            'enable'                => true
        ],
        'reset_password_form' => [
            'name'                  => 'Reset Password Form',
            'function_callback'     => 'captcha_template_form_input_default',
            'add_action'            => 'simple_cms_acl_add_to_form_reset_password_hook_action',
            'add_filter_rules'      => 'simple_cms_acl_add_to_validation_roles_form_reset_password_add_filter',
            'add_filter_messages'   => 'simple_cms_acl_add_to_validation_messages_form_reset_password_add_filter',
            'enable'                => true
        ],
        'confirm_password_form' => [
            'name'                  => 'Confirm Password Form',
            'function_callback'     => 'captcha_template_form_input_default',
            'add_action'            => 'simple_cms_acl_add_to_form_confirm_password_hook_action',
            'add_filter_rules'      => 'simple_cms_acl_add_to_validation_roles_form_confirm_password_add_filter',
            'add_filter_messages'   => 'simple_cms_acl_add_to_validation_messages_form_confirm_password_add_filter',
            'enable'                => true
        ],
        'contact_form' => [
            'name'                  => 'Contact Form',
            'function_callback'     => 'captcha_template_form_input_frontend',
            'add_action'            => 'simple_cms_theme_contact_form_add_action',
            'add_filter_rules'      => 'simple_cms_contact_form_validation_rules',
            'add_filter_messages'   => 'simple_cms_contact_form_validation_message',
            'enable'                => true
        ]
    ],
];
