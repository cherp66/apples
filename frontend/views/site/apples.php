<?php

use yii\grid\GridView;;
use yii\helpers\Html;
use frontend\models\Apple;

$this->title = 'Яблоки';
$colors = [
    'green' => 'Зеленое',
    'red' => 'Красное',
    'yellow' => 'Желтое',
];
$conditions = [
    Apple::STATUS_IN_TREE => 'На дереве',
    Apple::STATUS_FALL => 'На земле',
    Apple::STATUS_ROTTEN => 'Гнилое',
];
?>
<script>
    var page = 'apples';
    var apiURI = '<?=$apiURI?>';
    var token  = '<?=$token?>';
</script>
<div class="site-index">
    <div class="container-fluid py-5 text-center">
        <p>
            <a class="btn btn-lg btn-success create" href="#">Добавить</a>
        </p>
    </div>
    <div class="container-fluid py-5 text-center" >
<?php
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'color' => [
                'label' => 'Цвет',
                'value' => function($model) use($colors) {
                                return $colors[$model->color];
                            }],
            'status' => [
                'label' => 'Состояние',
                'value' => function($model) use($conditions) {
                                return $conditions[$model->status];
                            }],
            'size' => [
                'label' => 'Осталось',
                'value' => function($model) {
                                return $model->size .' %';
                            }],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{fall} {eat} {del}',
                'buttons' => [
                    'fall' => function ($url, $model) {
                        return Html::a('Уронить', '#', [
                                'class' => 'btn btn-success btn-xs fall',
                                'id' => $model->id,
                        ]);
                    },
                    'eat' => function ($url, $model) {
                        return Html::a('Откусить', '#', [
                            'class' => 'btn btn-success btn-xs eat',
                            'id' => $model->id,
                        ])
                            . Html::input(
                                'text', 'кол-во',
                                '10',
                                [
                                    'id' => 'inp-'. $model->id,
                                    'class' => 'perc',
                                    'type' => 'number',
                                    'min' => 1,
                                    'max' => 100,
                                    'data-pjax'=>false,
                                    'style' => 'width:60px; border-radius:4px;margin-left:10px;',
                                ]) .' %';
                    },
                    'del' => function ($url, $model) {
                        return Html::a('Удалить', '#', [
                            'class' => 'btn btn-danger btn-xs del',
                            'id' => $model->id,
                        ]);
                    },
                ],
                'visibleButtons' => [
                    'fall' => function($model) { return visible($model->status, Apple::STATUS_IN_TREE); },
                    'eat'  => function($model) { return visible($model->status, Apple::STATUS_FALL); },
                    'del'  => function($model) { return visible($model->status, Apple::STATUS_ROTTEN); },
                ],
            ],
        ],
   ]);

    function visible($status, $type)
    {
        return ($status === $type);
    }
?>
    </div>
</div>
