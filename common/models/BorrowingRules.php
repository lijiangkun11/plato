<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;


/**
 * This is the model class for table "borrowing_rules".
 *
 * @property int $id
 * @property string $title 名称
 * @property int $general_loan_period 一般借期(天)
 * @property int $extended_period_impunity 超期免罚期限(天)
 * @property int $first_term_of_punishment 首罚期限(天)
 * @property string $first_penalty_unit_price 首罚单价(元)
 * @property string $other__unit_price 其它单价(元)
 * @property string $reader_type_ids 适用读者类型
 * @property string $circulation_type_ids 适用流通类型
 * @property int $library_id 图书馆ID
 * @property int $user_id 操作员ID
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $status 状态
 */
class BorrowingRules extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'borrowing_rules';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'general_loan_period', 'extended_period_impunity', 'first_term_of_punishment', 'library_id'], 'required'],
            [['general_loan_period', 'extended_period_impunity', 'first_term_of_punishment', 'library_id', 'user_id', 'created_at', 'updated_at', 'status'], 'integer'],
            [['first_penalty_unit_price', 'other__unit_price'], 'number'],
            [['title'], 'string', 'max' => 128],
            [['reader_type_ids', 'circulation_type_ids', 'readerType', 'circulationType'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '名称',
            'general_loan_period' => '一般借期(天)',
            'extended_period_impunity' => '超期免罚期限(天)',
            'first_term_of_punishment' => '首罚期限(天)',
            'first_penalty_unit_price' => '首罚单价(元)',
            'other__unit_price' => '其它单价(元)',
            'reader_type_ids' => '适用读者类型',
            'circulation_type_ids' => '适用流通类型',
            'library_id' => '图书馆ID',
            'user_id' => '操作员ID',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'status' => '状态',
        ];
    }

    public function getReaderType() {
        return json_decode($this->reader_type_ids);
    }
    public function setReaderType($value) {
        $this->reader_type_ids = json_encode($value);
    }
    public function getReaderTypes() {
        $ids = json_decode($this->reader_type_ids);
        $data = ReaderType::find()
            ->where(['id' => $ids])
            ->select('title')
            ->column();
        return implode(Yii::$app->params['tagSeparater'], $data);
    }
    public function getCirculationType() {
        return json_decode($this->circulation_type_ids);
    }
    public function setCirculationType($value) {
        $this->circulation_type_ids = json_encode($value);
    }
    public function getCirculationTypes() {
        $ids = json_decode($this->circulation_type_ids);
        $data = CirculationType::find()
            ->where(['id' => $ids])
            ->select('title')
            ->column();
        return implode(Yii::$app->params['tagSeparater'], $data);
    }
}
