/////////анимация кружочек
window.addEventListener("scroll", changePartAnim)
window.addEventListener("touchmove", changePartAnim);
window.addEventListener("resize", changePartAnim)

function changePartAnim() {
    let anim = document.getElementById('anim-cont');
    let inquireWidth = (anim.clientWidth - (anim.clientHeight));
    let part = document.getElementById("anim-part");
    let link = document.getElementById("anim-link");
    let minPartSize = 75;
    let scrollInPro = 0;
    let pageOffset = (window.pageYOffset || document.documentElement.scrollTop);

    if (pageOffset >= anim.offsetHeight && pageOffset <= (anim.offsetHeight + anim.clientHeight)) {
        scrollInPro = Math.round((pageOffset - anim.offsetHeight) / (anim.clientHeight / 100));
    } else if (pageOffset < anim.offsetHeight) {
        scrollInPro = 0;
    } else if (pageOffset > (anim.offsetHeight + anim.clientHeight)) {
        scrollInPro = 100;
    }

    part.style.transform = 'translateX(' + Math.round((inquireWidth) * (scrollInPro / 100)) + 'px)';
    let partSize = Math.round(((anim.clientHeight) / 100) * scrollInPro);

    if (partSize > minPartSize) {
        part.style.height = partSize + 'px';
        part.style.width = partSize + 'px';
    }

    if (scrollInPro > 80) {
        link.style.opacity = 1;
    } else {
        link.style.opacity = 0;
    }
}