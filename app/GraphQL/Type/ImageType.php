<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL;

class ImageType extends GraphQLType
{
    protected $attributes = [
        'name' => 'ImageType',
        'description' => 'A type'
    ];

    public function fields()
    {
        $min = 'min:' . \Config::get('constants.paginate.min');
        $max = 'max:' . \Config::get('constants.paginate.max');
        $page = \Config::get('constants.paginate.page');
        $limit = \Config::get('constants.paginate.limit');
        $pagination = [
            'page' => [
                'name' => 'page',
                'type' => Type::int(),
                'description' => 'Current page result.',
                'defaultValue' => $page,
                'rules' => ['integer', $min]
            ],
            'limit' => [
                'name' => 'limit',
                'type' => Type::int(),
                'description' => 'Limit result.',
                'defaultValue' => $limit,
                'rules' => ['integer', $min, $max]
            ],
        ];

        return [
            'idImage' => [
                'type' => Type::int(),
                'description' => 'The image id'
            ],
            'name' => [
                'type' => Type::string(),
                'rules' => ['min:3'],
                'description' => 'The name of the device, is the unique'
            ],
            'path' => [
                'type' => Type::string(),
                'description' => 'Directory where are the images'
            ],
            'sourceImageSize' => [
                'type' => Type::int(),
                'description' => 'Source (Uploaded) Image Size'
            ],
            'files' => [
                'type' => GraphQL::paginate('ImageFileType'),
                'description' => 'Files',
                'args' => $pagination
            ],
            'devices' => [
                'type' => GraphQL::paginate('DeviceType'),
                'description' => 'Devices of this image',
                'args' => $pagination
            ],
            'tags' => [
                'type' => Type::listOf(GraphQL::type('TagType')),
                'description' => 'Devices of this image',
            ],
            'original' => [
                'type' => GraphQL::type('ImageFileType'),
                'description' => 'From this image I can resize the others',
            ],
        ];
    }

    protected function resolveDevicesField($root, $args)
    {
        $devices = $root->devices();
        return $devices->paginate($args['limit'], ['*'], 'page', $args['page']);
    }

    protected function resolveFilesField($root, $args)
    {
        $files = $root->files()->orderBy('width', 'desc');
        return $files->paginate($args['limit'], ['*'], 'page', $args['page']);
    }

    protected function resolveTagsField($root, $args)
    {
        return $root->tags()
            ->select('Tag.idTag', 'Tag.idCompany', 'Tag.name')
            ->get();
    }

    protected function resolveOriginalField($root, $args)
    {
        return $root->files()->where('original', 1)->first();
    }
}
