<?php

namespace App\GraphQL\Admin\Mutation;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\UploadType;

use App\Rules\{
    NoHTMLTags,
    MaxImageByCompany
};

class ImageUploadMutation extends Mutation
{
    protected $attributes = [
        'name' => 'ImageUploadMutation',
        'description' => 'A mutation to upload a new image'
    ];

    public function type()
    {
        return GraphQL::type('ImageType');
    }

    public function args()
    {
        $limit = \Config::get('constants.maxUploadImage');
        return [
            'file' => [
                'name' => 'file',
                'type' => new UploadType(),
                'rules' => ['required', 'image', 'max:'.$limit],
            ],
            'guid' => [
                'type' => Type::string(),
                'rules' => ['required', new NoHTMLTags, new MaxImageByCompany]
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $idCompany = \Auth::User()->idCompany;
        $image = new \App\Logic\Image\Image();
        return $image->addImage(
            $idCompany,
            $args['file'],
            $args['guid']
        );
    }
}
