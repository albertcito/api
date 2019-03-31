<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL;

class ImageFileType extends GraphQLType
{
    protected $attributes = [
        'name' => 'ImageFileType',
        'description' => 'A type'
    ];

    public function fields()
    {
        return [
            'idFile' => [
                'type' => Type::int(),
                'description' => 'The id of the file'
            ],
            'idImage' => [
                'type' => Type::int(),
                'description' => 'The id of the file'
            ],
            'slug' => [
                'type' => Type::string(),
                'description' => 'The id of the file'
            ],
            'ext' => [
                'type' => Type::string(),
                'description' => 'The id of the file'
            ],
            'size' => [
                'type' => Type::int(),
                'description' => 'The id of the file'
            ],
            'width' => [
                'type' => Type::int(),
                'description' => 'The id of the file'
            ],
            'height' => [
                'type' => Type::int(),
                'description' => 'The id of the file'
            ],
            'original' => [
                'type' => Type::int(),
                'description' => 'From this image I can resize the others'
            ],
        ];
    }
}
