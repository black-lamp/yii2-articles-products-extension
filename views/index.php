<?php
/**
 * @author Gutsulyak Vadim <guts.vadim@gmail.com>
 *
 * @var View $this
 * @var Article $article
 * @var ArticleTranslation $article_translation
 * @var Product[] $products
 * @var ArticleRelatedProduct[] $articleRelatedProducts
 * @var ArticleRelatedProduct $model
 */

use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\helpers\ArrayHelper;
use bl\articles\common\entities\Article;
use bl\articles\common\entities\ArticleTranslation;
use bl\articles\products\entities\ArticleRelatedProduct;
use bl\cms\shop\common\entities\Product;

?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="glyphicon glyphicon-list"></i>
                <?= Yii::t('articles', 'Related products') ?>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="main col-md-8 col-md-offset-2">

                        <?php $form = \yii\widgets\ActiveForm::begin(['action' => ['articleId' => $article->id, 'languageId' => $article_translation->language_id]]); ?>

                        <div class="row">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <td>
                                        <?= $form->field($model, 'product_id')
                                            ->widget(\yii2mod\chosen\ChosenSelect::className(), [
                                                'items' => ArrayHelper::map($products, 'id', 'translation.title'),
                                            ]);
                                        ?>
                                        <?= $form->field($model, 'article_id')->hiddenInput(['value' => $article->id])->label(false) ?>
                                    </td>
                                    <td>
                                        <br>
                                        <?= Html::submitButton(\Yii::t('article', 'Add'), ['class' => 'btn btn-primary']); ?>
                                    </td>
                                </tr>
                                <?php if (!empty($articleRelatedProducts)): ?>
                                    <?php foreach ($articleRelatedProducts as $articleRelatedProduct): ?>
                                        <tr>
                                            <td>
                                                <?= $articleRelatedProduct->product->translation->title; ?>
                                            </td>
                                            <td class="text-center">
                                                <?= Html::a(
                                                    '<span class="glyphicon glyphicon-remove"></span>',
                                                    Url::to(['remove', 'articleId' => $articleRelatedProduct->article_id, 'productId' => $articleRelatedProduct->product_id]),
                                                    ['class' => 'btn btn-danger btn-xs']);
                                                ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <?php $form::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>