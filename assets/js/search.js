let search = document.getElementById('floatingInput'),
    prefill = document.getElementById('prefill'),
    links = document.querySelectorAll('#prefill > a'),
    oldValue = '';

search.addEventListener('keyup', (e) => {
    if (e.key == 'Enter' && document.querySelectorAll('.linkTargeted').length > 0) {
        document.querySelectorAll('.linkTargeted')[0].click();
    }
    else if (e.key == 'ArrowDown') {
        goDownSearch();
    }
    else if (e.key == 'ArrowUp') {
        goUpSearch();
    }
    else {
        startSearch();
        if (search.value.length > 0) {
            if (oldValue != search.value) {
                searchData(search.value);
            }
        }
        else {
            prefill.style.opacity = 0;
            prefill.style.pointerEvents = 'none';
        }
    }
});

for (let link of links) {
    link.addEventListener('mouseenter', () => {
        for(let llink of links) {
            llink.classList.remove('linkTargeted');
        }
        link.classList.add('linkTargeted');
    });
}

function startSearch() {
    prefill.style.opacity = 1;
    prefill.style.pointerEvents = 'all';
}

function searchData (value) {
    let elems = document.querySelectorAll('#prefill .list-group-item');
    let first = true;
    let nb = 0;
    for(let elem of elems) {
        elem.classList.remove('linkTargeted');
        if (elem.getAttribute('champion').toLowerCase().includes(value.toLowerCase()) && nb < 4) {
            if (first){
                elem.classList.add('linkTargeted');
                first = false;
            }
            nb++;
            elem.classList.remove("none");
            elem.classList.add("block");
        }
        else {
            elem.classList.remove("block");
            elem.classList.add("none");
        }
    }
    oldValue = value;
}

function goDownSearch() {
    let old = document.getElementsByClassName('linkTargeted')[0],
        elems = document.getElementsByClassName('block'),
        array = [],
        done = false;

    for(let elem of elems) {
        if (done == true) {
            elem.classList.add('linkTargeted');
            done = false;
        }
        if (elem == old) {
            done = true;
            elem.classList.remove('linkTargeted');
        }
    }

    if (document.getElementsByClassName('linkTargeted').length == 0) {
        let nb = 1;
        for(let elem of elems) {
            if (nb == elems.length){
                elem.classList.add('linkTargeted');
            }
            nb++
        }
    }
}

function goUpSearch() {
    console.log('test')
    let old = document.getElementsByClassName('linkTargeted')[0],
        elems = document.getElementsByClassName('block'),
        array = [],
        done = false;
    
    for(let elem of elems) {
        array.push(elem);
    }

    array.reverse();

    for(let elem of array) {
        if (done == true) {
            elem.classList.add('linkTargeted');
            done = false;
        }
        if (elem == old) {
            done = true;
            elem.classList.remove('linkTargeted');
        }
    }
    if (document.getElementsByClassName('linkTargeted').length == 0) {
        document.getElementsByClassName('block')[0].classList.add('linkTargeted');
    }
}