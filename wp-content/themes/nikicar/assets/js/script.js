document.addEventListener('DOMContentLoaded', () => {
    //Анимация бургер меню  @todo///////////////////////////////////////////////////////////////////////////////////////
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

            checkedSouvenirVariant = {
                souvenirId:document.getElementById('souvenir-item').getAttribute('data-post-id'),
                variantId:e.getAttribute('data-var-id'),
                imageSrc:e.childNodes[1].src,
                souvenirDesc:e.childNodes[3].textContent,
            };

            eachSouvenirsVar(function(element){
                element.classList.remove('check');
            });

            setTimeout(() => {
                e.classList.add('check');
            }, 50)
        });
    })

    //ADD TO CART @todo/////////////////////////////////////////////////////////////////////////////////////////////////
    let addToCartElement = document.getElementById('add-to-cart');
    if(addToCartElement){
        addToCartElement.addEventListener('click', (e) => {
            e.preventDefault();
            let souvenirImages = document.getElementsByClassName("lightbox-self-image");

            if(souvenirImages.length > 1 && !checkedSouvenirVariant){
                showModal('Помилка', 'Спочатку виберіть варіант сувеніра');
            }
            else {
                if(!checkedSouvenirVariant && document.getElementById('souvenir-item')){
                    checkedSouvenirVariant = {souvenirId:document.getElementById('souvenir-item').getAttribute('data-post-id')};
                }

                addToCart(checkedSouvenirVariant);
                showModal('', 'Сувенір додано до кошика');
            }
        })
    }

    let checkCart = function (){
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

    let addToCart = function(data){
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

    let clearCart = function(){
        localStorage.setItem('cart', JSON.stringify([]));
        checkCart();
    }

    checkCart();

    document.getElementById('cart').addEventListener('click', () => {
        clearCart();
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
});


