let menu_table        = document.querySelector('#menu_table');
let role_table        = document.querySelector('#role_table');
let menu_btn          = document.querySelector('#menu_btn');  // Кнопка над таблицей
let role_btn          = document.querySelector('#role_btn');  // Кнопка над таблицей
let menu_buttons      = document.querySelector('#menu_buttons');  // Кнопки ролей в форме
let menu_form_wrapper = document.querySelector('#menu_form_wrapper');  // div для формы менюшки
let cancel            = document.querySelector('#cancel');  // кнопка отмены формы
let save              = document.querySelector('#save');  // Кнопка сохранения
var change_menu_btns  = document.querySelectorAll('.change_menu_btn'); // Получаю кнопки таблицы
var nums              = [];

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

cancel.addEventListener('click', canceled);

// Закрываю форму
function canceled() {
    menu_form_wrapper.style.display = 'none';
    menu_buttons.innerHTML          = '';  // Очищаю div для кнопок в форме
    main.style.opacity              = '1';
}

for (var change_menu_btn of change_menu_btns) {
    change_menu_btn.addEventListener('click',  changeMenu.bind(null, change_menu_btn));
}

// Открываю форму по нажатию на кнопку
function changeMenu(change_menu_btn) {
    let menu_id                     = change_menu_btn.dataset.id;
    let menu_title_input            = document.querySelector('#menu_title_input');
    let menu_title_form             = document.querySelector('#menu_title_form');
    menu_title_input.value          = change_menu_btn.dataset.title;  // Запалняю input формы названием
    menu_title_form.innerHTML       = change_menu_btn.dataset.title;  // Запалняю input формы названием
    menu_form_wrapper.style.display = 'block';
    main.style.opacity              = '.3';

    // Получаю кнопки ролей
    let promise3 = fetch('/?r=main/all-roles&id=' + menu_id);

    promise3
        .then(
            data => {
                return data.json()
            }
        )
        .then(
            response => {
                menu_buttons.innerHTML = response;

                // Получаю кнопки после формирования формы
                let edits = menu_buttons.querySelectorAll('.edit');
                nums = [];  // Обнуляю глобальный массив

                for (let edit of edits) {
                    if (edit.className == 'edit edit_set') {
                        nums.push(edit.dataset.id);
                    }

                    // выбрать или убрать связь
                    edit.addEventListener('click', function () {
                        if (edit.dataset.edit == 0) {
                            edit.dataset.edit = 1;
                            edit.classList.remove('edit_unset');
                            edit.classList.add('edit_set');
                            nums.push(edit.dataset.id);  // Добавление id роли для работы с бд
                        } else {
                            edit.dataset.edit = 0;
                            edit.classList.remove('edit_set');
                            edit.classList.add('edit_unset');
                            let index = nums.indexOf(edit.dataset.id);  // Ищу id роли для удаления
                            nums.splice(index, 1); // удаление из массива
                        }
                    });
                }
            }
        )
}

// Обновляю связи и предотвращаю обновление страницы
save.addEventListener('click', function prevent(e) {
    e.preventDefault();

    let promise4 = fetch('/?r=main/update-menu&titleNew=' + menu_title_input.value + '&nums=' + nums + '&title='
        + menu_title_form.innerHTML);

    promise4
        .then(
            data => {
                return data.json();
            }
        )
        .then(
            result => {
                menu_table.innerHTML            = result;
                menu_buttons.innerHTML          = '';
                menu_form_wrapper.style.display = 'none';
                main.style.opacity              = '1';
                let change_menu_btns            = document.querySelectorAll('.change_menu_btn');

                // Перезапись всех событий после замены html элементов
                for (var change_menu_btn of change_menu_btns) {
                    change_menu_btn.addEventListener('click', changeMenu.bind(null, change_menu_btn));
                }
            }
        )
});