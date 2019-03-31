<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL;

class TextType extends GraphQLType
{
    protected $attributes = [
        'name' => 'TextType',
        'description' => 'A Text'
    ];

    public function fields()
    {
        return [
            'idLangText' => [
                'type' => Type::int(),
                'description' => 'The Word ID'
            ],
            'idLang' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The Lang ID'
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The Lang ID'
            ],
            'code' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The Lang ID'
            ],
            'idTranslation' => [
                'type' => Type::int(),
                'description' => 'The Group ID'
            ],
            'text' => [
                'type' => Type::string(),
                'description' => 'translation name'
            ],
        ];
    }
}
