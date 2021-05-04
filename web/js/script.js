let menu_btn = document.querySelector('#menu_btn');
let role_btn = document.querySelector('#role_btn');
let table    = document.querySelector('#table');

menu_btn.addEventListener('click', function () {
    menu_btn.style.backgroundColor = 'gray';
    menu_btn.style.color           = 'white';
    role_btn.style.backgroundColor = 'white';
    role_btn.style.color           = 'black';

    let promise1 = fetch('/?r=main/show-menu');

    promise1
        .then(
            data => { return data.json() }
        )
        .then(
            result  => { table.innerHTML = result }
        )
});

role_btn.addEventListener('click', function () {
    role_btn.style.backgroundColor = 'gray';
    role_btn.style.color           = 'white';
    menu_btn.style.backgroundColor = 'white';
    menu_btn.style.color           = 'black';

    let promise2 = fetch('/?r=main/show-role');

    promise2
        .then(
            data => { return data.json() }
        )
        .then(
            result  => { table.innerHTML = result }
        )
});