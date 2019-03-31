<?php

namespace App\GraphQL\Admin\Mutation;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\InputObjectType;
use App\Rules\NoHTMLTags;

use Illuminate\Support\Facades\DB;
use App\Model\{
    LangTranslation,
    LangText
};

class TranslationUpdateMutation extends Mutation
{
    protected $attributes = [
        'name' => 'TranslationUpdateMutation',
        'description' => 'A mutation to update a TranslationType'
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
            'transalations' => [
                'name' => 'transalations',
                'type' => Type::listOf(
                    new InputObjectType([
                        'name' => 'transalationUpdateMutation',
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

            $transalation = LangTranslation::find($args['idTranslation']);

            if (!empty($args['transalations'])) {
                foreach ($args['transalations'] as $transWord) {
                    $word = LangText::where([
                        'idTranslation' => $args['idTranslation'],
                        'idLang' => $transWord['idLang']
                    ])->first();

                    if ($word) {
                        $word->update($transWord);
                    } else {
                        $transWord['idTranslation'] = $args['idTranslation'];
                        LangText::create($transWord)->fresh();
                    }
                }
            }

            DB::commit();

            return $transalation;
        } catch (\Exception $error) {
            DB::rollback();
            return $error;
        }
    }
}
