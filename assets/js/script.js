// JS FILE
let video = document.getElementById('bgVid');
let bar = document.getElementById('loadBar')
let intLoad = setInterval(() => {
    animLoad();
}, 3500);

let intPlay = setInterval(() => {
    video.play();
}, 100)

animLoad();

video.addEventListener('loadeddata', function() {
    bar.style.width = "10%";
    setTimeout(() => {
        bar.style.width = "30%";
        setTimeout(() => {
            bar.style.width = "60%";
            setTimeout(() => {
                bar.style.width = "100%";
                clearInterval(intLoad);
                loading.style.transition = '0.3s ease-in-out';
                loading.style.background = 'transparent';
                loading.style.color = 'transparent';
                loading.style.opacity = '0';
                loading.style.pointerEvents = 'none';
            }, 000);
        }, 500);
    }, 300);
 }, false);

 function animLoad () {
    let loading = document.getElementById('loading');
    let loadingin = document.getElementById('loadingin');
    let spans = loadingin.children;
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