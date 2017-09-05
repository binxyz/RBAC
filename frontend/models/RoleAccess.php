<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "role_access".
 *
 * @property integer $id
 * @property integer $role_id
 * @property integer $access_id
 * @property string $create_time
 */
class RoleAccess extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'role_access';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role_id', 'access_id'], 'integer'],
            [['create_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role_id' => 'Role ID',
            'access_id' => 'Access ID',
            'create_time' => 'Create Time',
        ];
    }
}
