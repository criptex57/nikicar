<?php /**
 * @var array $orders
 * @var int $page
 */?>
<script src="<?=NIKICAR_PLUGIN_URL?>/templates/js/admin.js"></script>
<link rel="stylesheet" href="<?=NIKICAR_PLUGIN_URL?>/templates/css/admin.css">
<span id="wp-nonce" data-wp-nonce="<?=esc_attr( wp_create_nonce( 'wp_rest' ))?>" style="display: none"></span>
<div class="nikicar-order-container">
    <div class="nikicar-order-title">
        <?php if($page == NikicarOrderDb::ORDER_STATUS_NEW):?>
            <h1>Нові замовлення</h1>
	        <?=empty($orders)?'<h2>Нових замовлень немає</h2>':''?>
        <?php elseif($page == NikicarOrderDb::ORDER_STATUS_APPROVE):?>
            <h1>Прийняті замовлення</h1>
	        <?=empty($orders)?'<h2>Прийнятих замовлень немає</h2>':''?>
        <?php elseif($page == NikicarOrderDb::ORDER_STATUS_PAID):?>
            <h1>Оплачені замовлення</h1>
	        <?=empty($orders)?'<h2>Оплачених замовлень немає</h2>':''?>
        <?php elseif($page == NikicarOrderDb::ORDER_STATUS_CLOSE):?>
            <h1>Архівні замовлення</h1>
	        <?=empty($orders)?'<h2>Архівних замовлень немає</h2>':''?>
        <?php endif;?>
    </div>

    <?php foreach ($orders as $order):?>
        <div class="nikicar-order-item-products-cont">
            <div class="nikicar-order-item">

                <div class="nikicar-order-item-data">
                    <div><h3 class="order-num">Замовлення №<?=$order['id']?></h3></div>
                    <div><b>Ім'я:</b><p><?=$order['firstname']?> <?=$order['lastname']?> <?=$order['surname']?></p> </div>
                    <div><b>Телефон:</b> <p><?=$order['phone']?></p></div>
                    <div><b>Область:</b> <p><?=$order['area']?></p></div>
                    <div><b>Район:</b> <p><?=$order['region']?></p></div>
                    <div><b>Населенний пункт:</b> <p><?=$order['settlements']?></p></div>
                    <div><b>Відділеня НП:</b> <p><?=$order['warehouses']?></p></div>
                    <div><b>IP:</b> <p><?=$order['userIp']?></p></div>
                    <div><b>Коментар:</b> <p><?=$order['comment']?></p></div>
                </div>
                    <div class="nikicar-order-item-products">
                        <?php $orderProducts = json_decode($order['userOrder'], true);
                        $totalPrice = 0;
                        foreach ($orderProducts  as $product ):
                            $totalPrice += ($product['souvenirPrice']*$product['count']);
                            ?>

                            <div class="nikicar-order-item-product">
                                <div class="nikicar-order-item-product-desc">
                                    <div><b>Назва: </b><?=$product['souvenirTitle']?></div>
                                    <div><b>Варіант: </b><?=isset($product['variantDesc'])?$product['variantDesc']:''?></div>
                                    <div><b>Кількість: </b><?=$product['count']?> ШТ</div>
                                    <div><b>Вартість: </b><?=$product['souvenirPrice']?> ГРН</div>
                                    <div><b>Ціна: </b><?=$product['souvenirPrice']*$product['count']?> ГРН</div>
                                </div>
                                <div class="nikicar-order-item-product-img">
                                    <a target="_blank" href="/souvenir/<?=$product['slug']?>"><img src="<?=isset($product['variantImageSrc'])&&$product['variantImageSrc']?$product['variantImageSrc']:$product['souvenirImageSrc']?>" alt=""></a>
                                </div>
                            </div>
                        <?php endforeach;?>
                    </div>
            </div>
            <div>
                <h2><b>Загальна вартість замовлення: <?=$totalPrice?> ГРН</b></h2>
                <?php if($order['status'] == NikicarOrderDb::ORDER_STATUS_NEW):?>
                    <a class="nikicar-order-btn approve-order-button" data-id="<?=$order['id']?>" href="#">Прийняти замовлення</a>
                <?php elseif($order['status'] == NikicarOrderDb::ORDER_STATUS_APPROVE):?>
                    <a class="nikicar-order-btn paid-order-button" data-id="<?=$order['id']?>" href="#">Помітити оплаченим</a>
                <?php elseif($order['status'] == NikicarOrderDb::ORDER_STATUS_PAID):?>
                    <a class="nikicar-order-btn close-order-button" data-id="<?=$order['id']?>" href="#">Закрити замовлення</a>
                <?php endif;?>
            </div>
        </div>
    <?php endforeach;?>
</div>