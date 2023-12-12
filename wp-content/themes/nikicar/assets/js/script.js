//Анимация бургер меню
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

//Прокрутка наверх
let t;
function up() {
    let top = Math.max(document.body.scrollTop,document.documentElement.scrollTop);
    if(top > 0) {
        window.scrollBy(0,-100);
        t = setTimeout('up()',20);
    } else clearTimeout(t);
    return false;
}

const anchors = document.querySelectorAll('a[href*="#"]')

for (let anchor of anchors) {
    anchor.addEventListener('click', function (e) {
        e.preventDefault()

        const blockID = anchor.getAttribute('href').substr(1)
        var block = document.getElementById(blockID);

        if(!block && blockID == 'contacts'){
            window.location.href = '/#contacts';
        }
        else {
            block.scrollIntoView({behavior: 'smooth', block: 'start'});
        }
    })
}