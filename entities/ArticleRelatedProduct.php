<?php
namespace bl\articles\products\entities;

use bl\articles\common\entities\Article;
use bl\cms\shop\common\entities\Product;
use yii\helpers\ArrayHelper;

/**
 * @author Gutsulyak Vadim <guts.vadim@gmail.com>
 *
 * @property integer $article_id
 * @property integer $product_id
 * @property integer $position
 *
 * @property Article article
 * @property Product product
 */
class ArticleRelatedProduct extends \yii\db\ActiveRecord {

    /**
     * @inheritDoc
     */
    public static function tableName()
    {
        return 'article_related_products';
    }


    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            [['article_id', 'product_id'], 'integer'],
            [['product_id'], 'unique', 'targetAttribute' => ['product_id', 'article_id']],
            [['article_id'], 'exist', 'skipOnError' => false, 'targetClass' => Article::className(), 'targetAttribute' => ['article_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => false, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * @inheritDoc
     */
    public function attributeLabels()
    {
        return [
            'article_id' => \Yii::t('backend.article', 'Article'),
            'product_id' => \Yii::t('backend.article', 'Related Product'),
            'position' => \Yii::t('backend', 'Position'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(Article::className(), ['id' => 'article_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public static function findProducts($articleId) {
        $products = [];
        $articleRelatedProducts = self::find()
            ->where(['article_id' => $articleId])
            ->with('product')
            ->all();

        if(!empty($articleRelatedProducts)) {
            foreach ($articleRelatedProducts as $articleRelatedProduct) {
                $products[] = $articleRelatedProduct->product;
            }
        }

        return $products;
    }
}