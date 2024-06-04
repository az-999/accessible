<?php

namespace app\models;

use Yii;

/**
 *
 * @property int $id
 * @property int user_id
 * @property int product_id
 */
class Favorite extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'favorite';
    }

}
