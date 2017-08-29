<?php
use bl\cms\shop\common\entities\Product;

/**
 * @author Gutsulyak Vadim <guts.vadim@gmail.com>
 *
 * @var Product[] products
 */

?>

<?php if(!empty($products)): ?>
    <?php foreach ($products as $product): ?>
        <h3><?= $product->translation->title ?></h3>
    <?php endforeach; ?>
<?php endif; ?>