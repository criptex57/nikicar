document.addEventListener('DOMContentLoaded', () => {
    let request = function (method, url, param, callback){
        const xhr = new XMLHttpRequest();
        let body;
        xhr.open(method, url);

        if(method == 'POST'){
            xhr.setRequestHeader("Content-Type", "application/json; charset=UTF-8");
            body = JSON.stringify(param);
        }

        xhr.onreadystatechange = () => {
            if (xhr.readyState === 4 && xhr.status === 200) {
                let response = JSON.parse(xhr.response);

                if(response.success){
                    callback(response.data)
                }
            }
        };

        xhr.send(body);
    }

    //АНИМАЦИЯ БУРГЕР МЕНЮ  @todo///////////////////////////////////////////////////////////////////////////////////////
    const burger = document.getElementById("burger");
    const headerNav = document.getElementById("header-nav");
    let close = true;

    burger.addEventListener("click", (event) => {
        if (close) {
            burger.classList.remove('close');
            headerNav.classList.add('burger-open');
            close = false;
        } else {
            burger.classList.add('close');
            headerNav.classList.remove('burger-open');
            close = true;
        }
    });

    //ПЕРЕХОД ПО ЯКОРЯМ @todo////////////////////////////////////////////////////////////////////////////////////////////
    const anchors = document.querySelectorAll('a[href*="#"]')

    for (let anchor of anchors) {
        anchor.addEventListener('click', function (e) {
            e.preventDefault()

            const blockID = anchor.getAttribute('href').substr(1)
            var block = document.getElementById(blockID);

            if(blockID){
                if(!block && blockID == 'contacts'){
                    window.location.href = '/#contacts';
                }
                else {
                    block.scrollIntoView({behavior: 'smooth', block: 'start'});
                }
            }
        })
    }

    //LIGHTBOX @todo///////////////////////////////////////////////////////////////////////////////////////////////////
    let lightbox = document.getElementById('lightbox');
    let isOpen = false;

    document.addEventListener('click', (event) => {
        if (isOpen && !document.getElementById('lightbox-image').contains(event.target)){
            document.getElementById('lightbox').classList.remove('open');
            isOpen = false;
        }
    });

    let souvenirImages = document.getElementsByClassName("lightbox-self-image");

    if(souvenirImages.length > 0){
        for (let i in souvenirImages){
            if(typeof souvenirImages[i].tagName != 'undefined'){
                souvenirImages[i].addEventListener('click', (event) => {
                    event.preventDefault();
                    setTimeout(() => {
                        let lightboxImage = document.getElementById('lightbox-image');
                        lightboxImage.setAttribute('src', souvenirImages[i].src);
                        isOpen = true;
                        lightbox.classList.add('open');
                    }, 50)
                });
            }
        }
    }

    //ADD SOUVENIR @todo////////////////////////////////////////////////////////////////////////////////////////////////
    let checkedSouvenirVariant = false;

    let eachSouvenirsVar = function(callback){
        let variant = document.getElementsByClassName("souvenir-self-head-vari-item");

        if(variant.length > 0){
            for (let i in variant){
                if(typeof variant[i].tagName != 'undefined'){
                    callback(variant[i]);
                }
            }
        }
    }

    eachSouvenirsVar(function(e){
        e.addEventListener('click', (event) => {
            event.preventDefault();

            let souvenirItem = document.getElementById('souvenir-item');

            checkedSouvenirVariant = {
                souvenirId:souvenirItem.getAttribute('data-post-id'),
                variantId:e.getAttribute('data-var-id'),
                slug:souvenirItem.getAttribute('data-post-slug'),
                souvenirTitle:souvenirItem.getAttribute('data-post-title'),
                souvenirImageSrc:souvenirItem.getAttribute('data-post-image'),
                souvenirPrice:souvenirItem.getAttribute('data-post-price'),
                variantImageSrc:e.childNodes[1].src,
                variantDesc:e.childNodes[3].textContent,
            };

            eachSouvenirsVar(function(element){
                element.classList.remove('check');
            });

            setTimeout(() => {
                e.classList.add('check');
            }, 50)
        });
    })

    //MODAL @todo///////////////////////////////////////////////////////////////////////////////////////////////////////
    let openModal = false;

    document.addEventListener('click', (event) => {
        if (!document.getElementById('modal').contains(event.target)){
            closeModal();
        }
    });

    document.getElementById('modal-close').addEventListener('click', () => {
        closeModal();
    })

    let closeModal = function(){
        if(openModal){
            document.getElementById('modal').classList.remove('show-modal-op');
            document.getElementById('modal').classList.remove('show-modal');
            document.getElementById('modal-body').textContent = '';
            document.getElementById('modal-header').textContent = '';
            isOpen = false;
        }
    }

    let showModal = function(title, body){
        setTimeout(() => {
            document.getElementById('modal-body').textContent =body;
            document.getElementById('modal-header').textContent = title;
            document.getElementById('modal').classList.add('show-modal');
            setTimeout(() => {
                document.getElementById('modal').classList.add('show-modal-op');
            }, 200)

            openModal = true;
        }, 5)
    }

    //ADD TO CART @todo/////////////////////////////////////////////////////////////////////////////////////////////////
    let addToCartElement = document.getElementById('add-to-cart');
    if(addToCartElement){
        addToCartElement.addEventListener('click', (e) => {
            e.preventDefault();
            let souvenirImages = document.getElementsByClassName("souvenir-self-head-vari-item");

            if(souvenirImages.length > 1 && !checkedSouvenirVariant){
                showModal('Помилка', 'Спочатку виберіть варіант сувеніра');
            }
            else {
                let souvenirItem = document.getElementById('souvenir-item');
                if(!checkedSouvenirVariant && souvenirItem){
                    checkedSouvenirVariant = {
                        souvenirId:souvenirItem.getAttribute('data-post-id'),
                        slug:souvenirItem.getAttribute('data-post-slug'),
                        souvenirTitle:souvenirItem.getAttribute('data-post-title'),
                        souvenirImageSrc:souvenirItem.getAttribute('data-post-image'),
                        souvenirPrice:souvenirItem.getAttribute('data-post-price'),
                    };
                }

                addToCart(checkedSouvenirVariant);
                showModal('', 'Сувенір додано до кошика');
            }
        })
    }

    let checkCart = function (){ //Изменение визуального отображения значка корзины
        let carData = localStorage.getItem('cart');
        let cartDiv = document.getElementById('cart');

        if(carData){
            carData = JSON.parse(carData);

            if(carData.length){
                cartDiv.classList.add('show');
                cartDiv.setAttribute('data-content', carData.length)
            }
            else {
                cartDiv.classList.remove('show');
                cartDiv.setAttribute('data-content', 0)
            }
        }
        else {
            cartDiv.classList.remove('show');
            cartDiv.setAttribute('data-content', 0)
        }
    }

    let addToCart = function(data){ //Добавление данных в корзину
        let carData = localStorage.getItem('cart');

        if(carData){
            carData = JSON.parse(carData);
        }
        else {
            carData = [];
        }

        carData.push(data);

        localStorage.setItem('cart', JSON.stringify(carData));
        checkCart();
    }

    let clearCart = function(){ //Очистка корзины
        localStorage.setItem('cart', JSON.stringify([]));
        checkCart();
    }


    setInterval(() => {
        checkCart();
    }, 300);

    document.getElementById('cart').addEventListener('click', () => { //Переход в корзину при клике
        window.location.href = '/cart';
    })

    //CART @todo/////////////////////////////////////////////////////////////////////////////////////////////////
    if(window.location.pathname == '/cart/'){
        let order = {};
        let area = [];
        let regions = [];
        let settlements = [];
        let warehouses = [];
        let regionCenter = {ref:'', name:''};

        let clearSelects = function(ids){
            for(let i in ids){
                let select = document.getElementById(ids[i]);
                let label = document.getElementById('label-'+ids[i]);
                let div = document.getElementById('div-'+ids[i]);
                select.setAttribute('data-text-value', '');

                if(i == 0){
                    div.style.display = 'block';
                    label.style.display = 'block';
                }
                else {
                    div.style.display = 'none';
                    label.style.display = 'none';
                }

                while (select.options.length > 0) {
                    select.remove(0);
                }
            }
        }

        let getOption = function (selectId, clear, value){
            let select = document.getElementById(selectId);

            if(!value && selectId !== 'area'){
                clearSelects(clear);
            }
            else if(selectId == 'settlements' && value == regionCenter.ref){
                clearSelects(clear);
                eval(selectId)[regionCenter.ref] = {name:regionCenter.name, center:null};

                select.prepend(new Option('', ''));
                select.append(new Option(regionCenter.name, regionCenter.ref));
                select.value = '';
            }
            else {
                request("GET", "/np/?"+selectId+"="+value, null, (data) => {
                    clearSelects(clear);

                    if(data.length > 0){
                        for(let i in data){
                            eval(selectId)[data[i].Ref] = {name:data[i].Description, center:typeof data[i].AreasCenter != 'undefined'?data[i].AreasCenter:null};
                            select.append(new Option(data[i].Description, data[i].Ref));
                        }

                        if(selectId == 'region'){
                            regionCenter = {ref:'', name:''};

                            request("GET", "/np/?settlementsCity="+area[value]['center'], null, (data) => {
                                if(typeof data[0] != 'undefined' && data[0].Description){
                                    select.prepend(new Option(data[0].Description, area[value]['center']));
                                    select.prepend(new Option('', ''));

                                    regionCenter = {ref:area[value]['center'], name:data[0].Description};
                                    eval(selectId)[area[value]['center']] = {name:data[0].Description, center:null};
                                }

                                select.value = '';
                            })
                        }
                        else {
                            select.prepend(new Option('', ''));
                        }
                    }
                    else {
                        showModal('Ой', 'У вашому населеному пункті немає відділень Нової пошти.');
                    }

                    select.value = '';
                });
            }
        }

        let areaSelect = document.querySelector("#area")
        areaSelect.addEventListener('change', function (e) {
            areaSelect.setAttribute('data-text-value', e.target.value?area[e.target.value].name:'');
            getOption('region', ['region', 'settlements', 'warehouses'], e.target.value);
        })

        let regionSelect = document.querySelector("#region");
        regionSelect.addEventListener('change', function (e) {
            regionSelect.setAttribute('data-text-value', e.target.value?region[e.target.value].name:'');
            getOption('settlements', ['settlements', 'warehouses'], e.target.value);
        })

        let settlementsSelect = document.querySelector("#settlements");
        settlementsSelect.addEventListener('change', function (e) {
            settlementsSelect.setAttribute('data-text-value', e.target.value?settlements[e.target.value].name:'');
            getOption('warehouses', ['warehouses'], e.target.value);
        })

        let warehousesSelect = document.querySelector("#warehouses");
        warehousesSelect.addEventListener('change', function (e) {
            warehousesSelect.setAttribute('data-text-value', e.target.value?warehouses[e.target.value].name:'');
        })

        getOption('area', [], null);

        let groupOrder = function(carData, singleProduct){
            let groupById = {};

            if(carData){
                for(let i in carData){
                    let key = carData[i].souvenirId;

                    if(typeof carData[i].variantId != 'undefined' && carData[i].variantId){
                        key += '-'+carData[i].variantId;
                    }

                    if(singleProduct){
                        if(typeof groupById[key] === 'undefined'){
                            groupById[key] = carData[i];
                            groupById[key]['count'] = 1;
                        }
                        else {
                            groupById[key]['count']++;
                        }
                    }
                    else {
                        if(typeof groupById[key] === 'undefined'){
                            groupById[key] = [];
                        }

                        groupById[key].push(carData[i]);
                    }

                }
            }

            return groupById;
        }

        let createOrderBlocks = function(oldCartState){
            let carData = localStorage.getItem('cart');

            if(oldCartState === false || oldCartState !== carData){
                oldCartState = carData;

                carData = JSON.parse(carData);
                let order = groupOrder(carData);
                let mainBlock = document.getElementById('cart-order');
                let totalPrice = 0;
                mainBlock.innerHTML = '';

                for(let id in order){
                    let count = order[id].length;
                    let img = typeof order[id][0]['variantImageSrc'] != 'undefined'?order[id][0]['variantImageSrc']:order[id][0]['souvenirImageSrc'];
                    let variantTitle = typeof order[id][0]['variantDesc'] != 'undefined'?order[id][0]['variantDesc']:'';
                    let price = order[id][0]['souvenirPrice']*count;
                    let title = order[id][0]['souvenirTitle'];
                    let sId = order[id][0]['souvenirId'];
                    let variantId = typeof order[id][0]['variantId'] != 'undefined' && order[id][0]['variantId']?order[id][0]['variantId']:'';
                    totalPrice += price;

                    mainBlock.insertAdjacentHTML("beforeend",
                        '<div class="cart-order-body">' +
                        '<div class="cart-order-text">' +
                        '<div class="cart-order-title"><a target="_blank" href="/souvenir/'+order[id][0]['slug']+'">'+title+'</a></div>' +
                        '<div class="cart-order-desc">'+variantTitle+'</div>' +
                        '<div class="cart-order-count"><i class="cart-order-count-min" data-id="'+sId+'" data-var-id="'+variantId+'">-</i>'+count+'<i class="cart-order-count-plus" data-id="'+sId+'" data-var-id="'+variantId+'">+</i></div>' +
                        '<div class="cart-order-price">'+price+' ГРН</div>\n' +
                        '</div>' +
                        '<div class="cart-order-img">' +
                        '<div class="cart-order-remove" data-id="'+sId+'" data-var-id="'+variantId+'"></div>\n' +
                        '<img src="'+img+'" alt="">' +
                        '</div>' +
                        '</div>'
                    );
                }

                mainBlock.insertAdjacentHTML("beforeend",  '<div class="cart-total-price">Загальна сумма: '+totalPrice+' ГРН</div>');
                mainBlock.insertAdjacentHTML("afterbegin",  '<div class="cart-order-block-title">ВАШЕ ЗАМОВЛЕННЯ:</div>');
                mainBlock.style.display = 'block';

                addListeners();
            }

            return oldCartState;
        }

        let addListeners = function(){
            document.querySelectorAll('.cart-order-count-min').forEach((button) => {
                button.addEventListener('click', () => {
                    removeProductFromCart(button);
                });
            });

            document.querySelectorAll('.cart-order-count-plus').forEach((button) => {
                button.addEventListener('click', () => {
                    addProductFromCart(button);
                });
            });

            document.querySelectorAll('.cart-order-remove').forEach((button) => {
                button.addEventListener('click', () => {
                    removeAllProductFromCart(button);
                });
            });
        }

        let addProductFromCart = function (button){
            let productId = button.getAttribute('data-id');
            let productVarId = button.getAttribute('data-var-id');
            let carData = localStorage.getItem('cart');

            if(carData){
                carData = JSON.parse(carData);

                for(let i in carData){
                    if(carData[i].souvenirId === productId && (typeof carData[i].variantId === 'undefined' || carData[i].variantId === productVarId)){
                        carData.push(carData[i]);
                        break;
                    }
                }

                localStorage.setItem('cart', JSON.stringify(carData));
            }
        }

        let removeAllProductFromCart = function(button){
            let productId = button.getAttribute('data-id');
            let productVarId = button.getAttribute('data-var-id');
            let carData = localStorage.getItem('cart');

            if(carData){
                carData = JSON.parse(carData);
                let newData = [];

                for(let i in carData){
                    if((carData[i].souvenirId !== productId && !productVarId) || (productVarId && carData[i].variantId !== productVarId) || (carData[i].variantId === productVarId && carData[i].souvenirId !== productId)){
                        newData.push(carData[i]);
                    }
                }

                localStorage.setItem('cart', JSON.stringify(newData));
            }
        }

        let removeProductFromCart = function(button){
            let productId = button.getAttribute('data-id');
            let productVarId = button.getAttribute('data-var-id');
            let carData = localStorage.getItem('cart');

            if(carData){
                carData = JSON.parse(carData);

                for(let i in carData){
                    if(carData[i].souvenirId === productId && (typeof carData[i].variantId === 'undefined' || carData[i].variantId === productVarId)){
                        carData.splice(i, 1);
                        break;
                    }
                }

                localStorage.setItem('cart', JSON.stringify(carData));
            }
        }

        let validateField = function(data){
            let error = '';

            if(typeof data.order === 'undefined' || Object.keys(data.order).length === 0){
                error = 'Спочатку потрібно додати товар у кошик';
            }
            else if(!data.phone){
                error = 'Номер телефону це обов\'язкове поле';
            }
            else if(!data.phone.match(/^\d+$/)) {
                error = 'Номер телефону містить не допустимі символи';
            }
            else if(!data.phone.match(/^380\d+$/)) {
                error = 'Не правильний формат номеру';
            }
            else if(data.phone.length < 12){
                error = 'Номер телефону занадто короткий';
            }
            else if(data.phone.length > 12){
                error = 'Номер телефону занадто довгий';
            }
            else if(!data.lastname){
                error = 'Прізвище це обов\'язкове поле';
            }
            else if(!data.firstname){
                error = 'Ім\'я це обов\'язкове поле';
            }
            else if(!data.area){
                error = 'Виберіть область';
            }
            else if(!data.region){
                error = 'Виберіть район';
            }
            else if(!data.settlements){
                error = 'Виберіть населений пункт';
            }
            else if(!data.warehouses){
                error = 'Виберіть відділеня "Нової пошти"';
            }

            return error;
        }

        document.getElementById('approve-order').addEventListener('click', function(){
            let data = {};

            let order = localStorage.getItem('cart');
            order = JSON.parse(order);
            order = groupOrder(order, true)

            data.order = order;
            data.phone = document.getElementById('phone').value;
            data.comment = document.getElementById('comment').value;
            data.lastname = document.getElementById('lastname').value;
            data.firstname = document.getElementById('firstname').value;
            data.firstname = document.getElementById('firstname').value;
            data.surname = document.getElementById('surname').value;
            data.area = document.getElementById('area').getAttribute('data-text-value');
            data.region = document.getElementById('region').getAttribute('data-text-value');
            data.settlements = document.getElementById('settlements').getAttribute('data-text-value');
            data.warehouses = document.getElementById('warehouses').getAttribute('data-text-value');
            data.price = document.getElementById('warehouses').getAttribute('data-post-price');

            let error = validateField(data);

            if(error){
                showModal('Помилка', error);
            }
            else {
                request("POST", "/wp-json/nikicar-order/v1/addOrder", data, (data) => {
                    showModal('Дякуємо', 'Замовлення прийнято. У найближчий час з вами зв\'яжеться консультант.');
                    clearCart();
                });
            }

        })

        let oldCartState = false;
        setInterval(() => {
            oldCartState = createOrderBlocks(oldCartState);
        }, 300);
    }
});