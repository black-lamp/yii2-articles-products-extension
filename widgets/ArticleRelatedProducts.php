<?php
namespace bl\articles\products\widgets;
use bl\articles\products\entities\ArticleRelatedProduct;
use bl\cms\shop\common\entities\Product;
use yii\base\Widget;

/**
 * @author Gutsulyak Vadim <guts.vadim@gmail.com>
 */
class ArticleRelatedProducts extends Widget {

    public $articleId;
    private $products;

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();
    }

    /**
     * @inheritDoc
     */
    public function run()
    {
        return $this->render('related_products', [
            'products' => ArticleRelatedProduct::findProducts($this->articleId)
        ]);
    }

}