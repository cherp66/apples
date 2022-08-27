<?php
namespace frontend\models;

use application\domain\settings\AppleInterface;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "apple".
 *
 * @property string $id
 * @property string $color
 * @property int $appearance_date
 * @property int|null $fall_date
 * @property int $size
 * @property int $status
 */
class Apple extends ActiveRecord implements AppleInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%apple}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'color', 'appearance_date', 'size', 'status'], 'required'],
            [['appearance_date', 'fall_date', 'size', 'status'], 'integer'],
            [['id'], 'string', 'max' => 36],
            [['color'], 'string', 'max' => 10],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findActive()
    {
        return static::find()->where('status != :delete', [':delete' => self::STATUS_DELETE]);
    }
}
