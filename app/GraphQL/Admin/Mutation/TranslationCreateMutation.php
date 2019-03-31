<?php

namespace App\GraphQL\Admin\Mutation;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\InputObjectType;
use App\Rules\NoHTMLTags;

use Illuminate\Support\Facades\DB;
use App\Model\LangTranslation;
use App\Model\LangText;

class TranslationCreateMutation extends Mutation
{
    protected $attributes = [
        'name' => 'TranslationCreateMutation',
        'description' => 'A mutation to create a TranslationType'
    ];

    public function type()
    {
        return GraphQL::type('TranslationType');
    }

    public function args()
    {
        return [
            'code' => [
                'type' => Type::string(),
                'rules' => ['required','min:2'],
            ],
            'transalations' => [
                'name' => 'transalations',
                'type' => Type::listOf(
                    new InputObjectType([
                        'name' => 'transalation',
                        'fields' => [
                            'text' => [
                                'name' => 'text',
                                'type' => Type::string(),
                                'rules' => ['required',new NoHTMLTags]
                            ],
                            'idLang' => [
                                'name' => 'idLang',
                                'type' => Type::int(),
                                'rules' => ['required','integer','min:1'],
                            ]
                        ]
                    ])
                )
            ]
        ];
    }

    public function resolve($root, $args)
    {
        try {
            DB::beginTransaction();
            $transalation = LangTranslation::create([
                'code' => $args['code']
            ])->fresh();
            if (!empty($args['transalations'])) {
                $transalations = [];
                foreach ($args['transalations'] as $key => $value) {
                    $transalations[] = LangText::create([
                        'idLang' => $args['transalations'][$key]['idLang'],
                        'idTranslation' => $transalation->idTranslation,
                        'text' => $args['transalations'][$key]['text'],
                    ])->fresh();
                }
                $transalation->transalations = $transalations;
            }
            DB::commit();
            return $transalation;
        } catch (\Exception $error) {
            DB::rollback();
            return $error;
        }
    }
}
