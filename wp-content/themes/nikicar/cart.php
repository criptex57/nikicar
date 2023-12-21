<?php //Template Name: Кошик ?>
<?=get_header()?>
<div class="cart-container">
    <div class="cart-title">ОФОРМЛЕННЯ ЗАМОВЛЕННЯ</div>
    <div class="cart-body">
        <div class="cart-left-body">
            <div class="cart-block-title"><span>1.</span> Контактна інформація</div>
            <form>
                <label for="phone">Номер телефону в форматі 380ХХ ХХ ХХ ХХХ*</label>
                <input type="text" id="phone">
                <label for="lastname">Прізвище*</label>
                <input type="text" id="lastname">
                <label for="firstname">Ім'я*</label>
                <input type="text" id="firstname">
                <label for="surname">По батькові</label>
                <input type="text" id="surname">
            </form>
            <div class="cart-block-title"><span>2.</span> Спосіб доставки</div>
            <form>
                <label for="area">Область*</label>
                <div class="select">
                    <select id="area" class="cart-select"></select>
                </div>
                <label style="display: none" id="label-region" for="region">Район*</label>
                <div style="display: none" id="div-region" class="select">
                    <select id="region" class="cart-select"></select>
                </div>
                <label style="display: none" id="label-settlements" for="settlements">Населений пункт*</label>
                <div style="display: none" id="div-settlements" class="select">
                    <select id="settlements" class="cart-select"></select>
                </div>
                <label style="display: none" id="label-warehouses" for="warehouses">Номер відділення*</label>
                <div style="display: none" id="div-warehouses" class="select">
                    <select id="warehouses" class="cart-select"></select>
                </div>
            </form>
        </div>
        <div class="cart-right-body">
            <form>
                <label for="comment">Коментар до замовлення</label>
                <textarea id="comment" cols="30" rows="10"></textarea>
            </form>
            <div class="cart-order" id="cart-order"></div>
            <a href="#" class="btn cart-approve-order" id="approve-order">Підтвердити замовлення</a>
        </div>
    </div>
</div>
<?=get_footer()?>
