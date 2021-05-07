let menu_table = document.querySelector('#menu_table');
let role_table = document.querySelector('#role_table');
let menu_btn   = document.querySelector('#menu_btn');  // Кнопка над таблицей
let role_btn   = document.querySelector('#role_btn');  // Кнопка над таблицей
var nums       = [];

// Выбираю таблицу
menu_btn.addEventListener('click', function () {
    menu_btn.style.cssText = 'background: gray; color: white';
    role_btn.style.cssText = 'background: white; color: black';
    role_table.style.display = 'none';
    menu_table.style.display = 'block';
});

role_btn.addEventListener('click', function () {
    role_btn.style.cssText = 'background: gray; color: white';
    menu_btn.style.cssText = 'background: white; color: black';
    menu_table.style.display = 'none';
    role_table.style.display = 'block';
});
// _______________________