var imgArray = [
        'images/banner1.jpg',
        'images/banner2.jpg',
        'images/banner3.jpg',
        'images/banner4.jpg',
    ],
    curIndex = 0;
imgDuration = 5000;

function slideShow() {
    document.getElementById('slider').className += "fadeOut";
    setTimeout(function () {
        document.getElementById('slider').src = imgArray[curIndex];
        document.getElementById('slider').className = "";
    }, 1000);
    curIndex++;
    if (curIndex == imgArray.length) {
        curIndex = 0;
    }
    setTimeout(slideShow, imgDuration);
}
slideShow();

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})