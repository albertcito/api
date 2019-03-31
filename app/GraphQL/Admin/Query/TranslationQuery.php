<?php

namespace App\GraphQL\Admin\Query;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

use App\Model\LangTranslation;

class TranslationQuery extends Query
{
    protected $attributes = [
        'name' => 'TranslationQuery',
        'description' => 'A query to get the Translation Type'
    ];

    public function type()
    {
        return GraphQL::type('TranslationType');
    }

    public function args()
    {
        return [
            'idTranslation' => [
                'name' => 'idTranslation',
                'type' => Type::nonNull(Type::int()),
                'rules' => ['required','integer','min:1','exists:LangTranslation,idTranslation'],
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $translation = LangTranslation::find($args['idTranslation']);
        return $translation;
    }
}
