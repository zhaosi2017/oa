<?php

namespace app\modules\system\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "serial_number".
 *
 * @property integer $id
 * @property integer $number
 * @property string $type
 * @property integer $create_at
 */
class SerialNumber extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'serial_number';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['number', 'create_at'], 'integer'],
            [['type'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'number' => 'Number',
            'type' => 'Type',
            'create_at' => 'Create At',
        ];
    }

    /**
     * @inheritdoc
     * @return SerialNumberQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SerialNumberQuery(get_called_class());
    }

    public function generalSerial($type)
    {
        $before = $this::findOne(['type'=>$type]);
        if(!$before){
            $number =  1;
            $this->isNewRecord = true;
            $this->number = 1;
            $this->type = $type;
            $this->create_at = $_SERVER['REQUEST_TIME'];
            $this->save();
        }else{
            if(date('d',$_SERVER['REQUEST_TIME'])!= date('d',$before->create_at)){
                $before->number = 1;
            }else{
                $before->number += 1;
            }
            $before->type = $type;
            $before->create_at = $_SERVER['REQUEST_TIME'];
            $before->save();
            $number = $before->number;
        }

        //流水号5位
        if($type=='statement'){
            return str_pad($number,5,0,STR_PAD_LEFT);
        }

        return str_pad($number,4,0,STR_PAD_LEFT);
    }
}
