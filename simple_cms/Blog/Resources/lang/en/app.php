<?php
/**
 * Created by PhpStorm.
 * User: whendy
 * Date: 28/08/18
 * Time: 22:51
 */

return [
    'posts' => [
        'btn_add_new' => 'Add New Post',
        'btn_edit' => 'Edit Post',
        'error' => [
            'empty_category' => 'Category must be filled.'
        ],
        'request' => [
            'title' => [
                'required'  => 'Title must be filled.',
                'max'       => 'Title too long'
            ],
            'slug' => [
                'required'  => 'Slug must be filled.',
                'max'       => 'Slug too long'
            ],
            'description' => [
                'required'  => 'Description must be filled.',
                'max'       => 'Description too long'
            ],
            'content' => [
                'required'  => 'Content must be filled.'
            ],
            'type' => [
                'required'  => 'Type must be filled.',
                'in'        => 'Type not valid.'
            ],
            'status' => [
                'required'  => 'Status must be filled.',
                'in'        => 'Status not valid.'
            ],
            'post_date' => [
                'required'  => 'Post Date must be filled.',
                'date_format' => 'Format date Post not valid (d-m-Y H:i).',
            ],
            'categories' => [
                'required'  => 'Categories must be filled.'
            ],
            'change_status' => [
                'invalid'  => 'Parameter change status not valid.',
                'in'       => 'Change status not in Publish, Member or Draft.'
            ]
        ]
    ],
    'pages' => [
        'btn_add_new' => 'Add New Pages',
        'btn_edit' => 'Edit Pages',
        'request' => [
            'title' => [
                'required'  => 'Title must be filled.',
                'max'       => 'Title too long'
            ],
            'slug' => [
                'required'  => 'Slug must be filled.',
                'max'       => 'Slug too long'
            ],
            'content' => [
                'required'  => 'Content must be filled.'
            ],
            'type' => [
                'required'  => 'Type must be filled.',
                'in'        => 'Type not valid.'
            ],
            'status' => [
                'required'  => 'Status must be filled.',
                'in'        => 'Status not valid.'
            ],
            'post_date' => [
                'required'  => 'Post Date must be filled.',
                'date_format' => 'Format date Page not valid (d-m-Y H:i).',
            ],
            'change_status' => [
                'invalid'  => 'Parameter change status not valid.',
                'in'       => 'Change status not in Publish, Member or Draft.'
            ],
        ]
    ],
    'category' => [
        'title' => [
            'index' => 'Categories',
            'add' => 'Add New Category',
            'edit' => 'Edit Category'
        ],
        'btn_add_new' => 'Add New Category',
        'btn_edit' => 'Edit Category',
        'form' => [
            'name' => 'Category Name',
            'description' => 'Description'
        ],
        'request' => [
            'name' => [
                'required'  => 'Category name must be filled.',
                'unique'    => 'Category already exists.',
                'max'       => 'Category too long'
            ],
            'slug' => [
                'required'  => 'Slug must be filled.',
                'max'       => 'Slug too long'
            ],
        ]
    ],
    'contact' => [
        'request' => [
            'name' => [
                'required'  => 'Name must be filled.',
                'min'       => 'Name too short.',
                'max'       => 'Name too long.',
            ],
            'email' => [
                'required'  => 'Email must be filled.',
                'email'     => 'Email wrong format.',
                'min'       => 'Email too short.',
                'max'       => 'Email too long.',
            ],
            'phone' => [
                'required'  => 'Phone must be filled.',
                'min'       => 'Phone too short.',
                'max'       => 'Phone too long.',
            ],
            'website' => [
                'required'  => 'Website url must be filled.',
                'url'       => 'Website url wrong format.',
                'min'       => 'Website url too short.',
                'max'       => 'Website url too long.',
            ],
            'subject' => [
                'required'  => 'Subject must be filled.',
                'min'       => 'Subject too short.',
                'max'       => 'Subject too long.',
            ],
            'message' => [
                'required'  => 'Message must be filled.',
                'min'       => 'Message too short.',
                'max'       => 'Message too long.',
            ],
            'captcha' => [
                'required'  => 'Please verify captcha that you are not a robot.',
                'captcha'   => 'Incorrect captcha input.'
            ]
        ],
        'message' => [
            'success' => [
                'submit_form' => [
                    'title'     => 'Thank you for contacting us.',
                    'message'   => 'Your message has been successfully sent. We will contact you very soon!'
                ]
            ]
        ]
    ]
];
