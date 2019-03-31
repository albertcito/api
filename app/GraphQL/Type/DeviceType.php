<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL;

use App\Device;

class DeviceType extends GraphQLType
{
    protected $attributes = [
        'name' => 'DeviceType',
        'description' => 'A Device type',
        'model' => Device::class,
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
            'idDevice' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The id of the device'
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The name of the device, is the unique'
            ],
            'description' => [
                'type' => Type::string(),
                'description' => 'The device description'
            ],
            'type' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The type of the device: ios or android'
            ],
            'isComplete' => [
                'type' => Type::boolean(),
                'description' => 'If the image have all devices whit images'
            ],
            'slots' => [
                'type' => Type::listOf(GraphQL::type('DeviceSlotType')),
                'description' => 'Slots of this device',
                'args' => $pagination
            ]
        ];
    }

    protected function resolveSlotsField($root, $args)
    {
        return $root->slots()->get();
    }
}
