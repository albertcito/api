<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL;

use App\DeviceSlot;

class DeviceSlotType extends GraphQLType
{
    protected $attributes = [
        'name' => 'DeviceSlotType',
        'description' => 'A type of the Slots of the Devices',
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
            'idSlot' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Primary key of the table'
            ],
            'idDevice' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Foreign key of the table Device'
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Name of slot, e.g: 1x, 2x, 3x, drawable-xhdpi, drawable-xxhdpi...'
            ],
            'percent'  => [
                'type' => Type::nonNull(Type::float()),
                'description' => 'Primery key of the table'
            ],
            'imageFileSlot' => [
                'type' => GraphQL::paginate('ImageFileSlotType'),
                'description' => 'All the images realted to this slot',
                'args' => $pagination
            ],
            'idFile' => [
                'type' => Type::int(),
                'description' => 'File of this device in a detemined image of teh table image_device_slot'
            ],
            'idImageFileSlot' => [
                'type' => Type::int(),
                'description' => 'File of this device in a detemined image of the table image_device_slot'
            ],
        ];
    }

    protected function resolveImageFileSlotField($root, $args)
    {
        $imageFileSlot = $root->imageFileSlot();
        return $imageFileSlot->paginate($args['limit'], ['*'], 'page', $args['page']);
    }
}
