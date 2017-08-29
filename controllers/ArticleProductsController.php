<?php
namespace bl\articles\products\controllers;

use bl\articles\common\entities\Article;
use bl\articles\common\entities\ArticleTranslation;
use bl\articles\products\entities\ArticleRelatedProduct;
use bl\cms\shop\common\entities\Product;
use bl\multilang\entities\Language;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

/**
 * @author Gutsulyak Vadim <guts.vadim@gmail.com>
 */
class ArticleProductsController extends Controller {
    private $tabViewName = '@vendor/black-lamp/yii2-articles-products-extension/views/index';

    public function actionIndex($articleId, $languageId = null) {

        if(empty($languageId)) {
            $languageId = Language::getCurrent()->id;
        }

        if (!empty($articleId)) {
            $article = Article::findOne($articleId);
            $article_translation = ArticleTranslation::find()->where([
                'article_id' => $articleId,
                'language_id' => $languageId
            ])->one();

            if(!empty($article) && !empty($article_translation)) {
                $articleRelatedProduct = new ArticleRelatedProduct();

                if (Yii::$app->request->isPost) {
                    if($articleRelatedProduct->load(Yii::$app->request->post())) {
                        if($articleRelatedProduct->validate() && $articleRelatedProduct->save()) {
                            $articleRelatedProduct = new ArticleRelatedProduct();
                        }
                    }
                }

                $viewParams = [
                    'article' => $article,
                    'article_translation' => $article_translation,
                    'model' => $articleRelatedProduct,
                    'products' => Product::findAll(['status' => Product::STATUS_SUCCESS, 'show' => true]),
                    'articleRelatedProducts' => ArticleRelatedProduct::find()
                        ->where(['article_id' => $article->id])
                        ->orderBy(['position' => SORT_ASC])
                        ->all()
                ];

                /*if (Yii::$app->request->isPjax) {
                    return $this->renderPartial($this->tabViewName, $viewParams);
                }*/

                return $this->render('/article/save', [
                    'article' => $article,
                    'languageId' => $languageId,
                    'viewName' => $this->tabViewName,
                    'params' => $viewParams
                ]);
            }
        }

        throw new BadRequestHttpException();
    }

    public function actionRemove($articleId, $productId) {
        $articleRelatedProduct = ArticleRelatedProduct::findOne(['article_id' => $articleId, 'product_id' => $productId]);

        if(!empty($articleRelatedProduct)) {
            $articleRelatedProduct->delete();
        }

        return $this->redirect(['index', 'articleId' => $articleId]);
    }

}