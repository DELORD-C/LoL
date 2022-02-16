// JS FILE
let video = document.getElementById('bgVid');
video.addEventListener('loadeddata', function() {
    animLoad();
    let intLoad = setInterval(() => {
        animLoad();
    }, 3500);
    setTimeout(() => {
        clearInterval(intLoad);
        loading.style.transition = '0.3s ease-in-out';
        loading.style.background = 'transparent';
        loading.style.color = 'transparent';
        setTimeout(() => {
            loading.style.transition = '0.3s ease-in-out';
            loading.style.opacity = '0';
            loading.style.pointerEvents = 'none';
            setTimeout(() => {
                loading.remove();
            }, 1000);
        }, 300);
    }, 5000);
 }, false);

 function animLoad () {
    let loading = document.getElementById('loading');
    let spans = loading.children;
    let timer = 150;
    for (span of spans) {
        let temp = span;
        setTimeout(() => {
            temp.style.display = 'block';
        }, timer)
        timer = timer + 150;
    }
    setTimeout(() => {
        loading.style.fontSize = "12vw";
        setTimeout(() => {
            loading.style.fontSize = "22vw";
            setTimeout(() => {
                for (span of spans) {
                    span.style.display = 'none';
                }
            }, 1200);
        }, 300);
    }, 1500);
 }