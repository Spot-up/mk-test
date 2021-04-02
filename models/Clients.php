<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clients".
 *
 * @property int $id
 * @property string $last_name
 * @property string $first_name
 * @property string|null $patronymic
 * @property string $email
 * @property string $phone
 * @property int $agreement
 */
class Clients extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    public static function tableName()
    {
        return 'clients';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['last_name', 'first_name', 'email', 'phone', 'agreement'], 'required'],
            [['agreement'], 'integer'],
            [['last_name', 'first_name', 'patronymic'], 'string', 'max' => 64],
            [['email'], 'email'],
            [['phone'], 'string', 'max' => 20],
            [['last_name', 'first_name', 'patronymic'], 'match', 'pattern' => '/^[а-яёА-ЯЁ-]+$/u', 'message' => 'ФИО должно содержать только русские буквы и символ "-"'],
            [['phone'], 'match', 'pattern' => '/^\+7\s\([0-9]{3}\)\s[0-9]{3}\-[0-9]{2}\-[0-9]{2}$/', 'message' => 'Неправильный номер телефона'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'last_name' => 'Фамилия',
            'first_name' => 'Имя',
            'patronymic' => 'Отчество',
            'email' => 'Email',
            'phone' => 'Телефон',
            'agreement' => 'Я согласен',
        ];
    }
    
    public function getPhone_number()
    {
        $number = str_replace('+7','',$this->phone);
        $number = str_replace('(','',$number);
        $number = str_replace(')','',$number);
        $number = str_replace('-','',$number);
        $number = str_replace(' ','',$number);

        return $number;

    }
}
