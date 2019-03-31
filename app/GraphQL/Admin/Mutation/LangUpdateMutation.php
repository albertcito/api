<?php

namespace App\GraphQL\Admin\Mutation;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use App\Rules\NoHTMLTags;

use App\Model\Lang;
use App\Exceptions\MessageError;

class LangUpdateMutation extends Mutation
{
    protected $attributes = [
        'name' => 'LangUpdateMutation',
        'description' => 'A mutation to update langw'
    ];

    public function type()
    {
        return GraphQL::type('LangType');
    }

    public function args()
    {
        return [
            'idLang' => [
                'type' => Type::nonNull(Type::int()),
                'rules' => ['required','integer','min:1','exists:Lang,idLang'],
            ],
            'code' => [
                'type' => Type::nonNull(Type::string()),
                'rules' => ['required','min:2', new NoHTMLTags]
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'rules' => ['required','min:3', new NoHTMLTags]
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $lang = Lang::find($args['idLang']);
        $lang->update($args);
        return $lang;
    }
}
