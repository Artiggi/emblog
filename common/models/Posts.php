<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "posts".
 *
 * @property integer $id
 * @property string $title
 * @property string $text
 * @property integer $cat_id
 *
 * @property PostTag[] $postTags
 * @property Categories $cat
 */
class Posts extends \yii\db\ActiveRecord
{
    protected $tags = [];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'posts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'text', 'cat_id',], 'required'],
            [['id', 'cat_id'], 'integer'],
            [['text'], 'string'],
            [['title'], 'string', 'max' => 200],
            [['cat_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['cat_id' => 'id']],
            [['tags'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'text' => 'Текст',
            'cat_id' => 'Cat ID',
            'catName' => 'Категория',
            'tags' => 'Теги',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCat()
    {
        return $this->hasOne(Categories::className(), ['id' => 'cat_id']);
    }

    public function getCatName()
    {
        return $this->cat->name;
    }

    public function setTags($tagsId)
    {
        $this->tags = (array) $tagsId;
    }

    /**
     * Возвращает массив идентификаторов тэгов.
     */
    public function getPostTags()
    {
        return $this->hasMany(PostTag::className(), ['post_id' => 'id']);
    }

    public function getTags()
    {
        return ArrayHelper::getColumn(
            $this->getPostTags()->all(), 'tag_id'
        );
    }

    public function afterSave($insert, $changedAttributes)
    {
        PostTag::deleteAll(['post_id' => $this->id]);
        $values = [];
        foreach ($this->tags as $id) {
            $values[] = [$this->id, $id];
        }
        self::getDb()->createCommand()
            ->batchInsert(PostTag::tableName(), ['post_id', 'tag_id'], $values)->execute();

        parent::afterSave($insert, $changedAttributes);
    }

}
