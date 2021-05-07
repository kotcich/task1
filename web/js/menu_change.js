let menu_buttons             = document.querySelector('#menu_change_buttons');  // Кнопки ролей в форме
let menu_change_form_wrapper = document.querySelector('#menu_change_form_wrapper');  // div для формы менюшки
let cancel_change_menu       = document.querySelector('#cancel_change_menu');  // кнопка отмены формы
let save_change_menu         = document.querySelector('#save_change_menu');  // Кнопка сохранения
let change_menu_btns         = document.querySelectorAll('.change_menu_btn'); // Получаю кнопки таблицы

cancel_change_menu.addEventListener('click', canceledMenu);

// Закрываю форму
function canceledMenu() {
    menu_change_form_wrapper.style.display = 'none';
    menu_buttons.innerHTML          = '';  // Очищаю div для кнопок в форме
    main.style.opacity              = '1';
}

for (var change_menu_btn of change_menu_btns) {
    change_menu_btn.addEventListener('click',  changeMenu.bind(null, change_menu_btn));
}

// Открываю форму по нажатию на кнопку
function changeMenu(change_menu_btn) {
    let menu_id                            = change_menu_btn.dataset.id;
    let menu_title_input                   = document.querySelector('#menu_change_title_input');
    let menu_title_form                    = document.querySelector('#menu_change_title_form');
    menu_title_input.value                 = change_menu_btn.dataset.title;  // Запалняю input формы названием
    menu_title_form.innerHTML              = change_menu_btn.dataset.title;  // Запалняю input формы названием
    menu_change_form_wrapper.style.display = 'block';
    main.style.opacity                     = '.3';

    // Получаю кнопки ролей
    let changeMenu = fetch('/?r=main/all-roles&id=' + menu_id);

    changeMenu
        .then(
            data => { return data.json() }
        )
        .then(
            response => {
                menu_buttons.innerHTML = response;

                // Получаю кнопки после формирования формы
                let menu_change_all = document.querySelector('#menu_change_all');  // Выделить все
                let edits           = document.querySelectorAll('.edit');
                nums                = [];  // Обнуляю глобальный массив

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

                // Выделяю все роли
                menu_change_all.addEventListener('click', function appendAllRole() {
                    nums = [];  // Обнуляю глобальный массив

                    for (let edit of edits) {
                        nums.push(edit.dataset.id);
                        edit.dataset.edit = 1;
                        edit.classList.remove('edit_unset');
                        edit.classList.add('edit_set');
                    }
                });
            }
        )
}

// Обновляю связи и предотвращаю обновление страницы
save_change_menu.addEventListener('click', function preventChangeMenu(e) {
    e.preventDefault();

    let promise4 = fetch('/?r=main/update-menu&titleNew=' + menu_change_title_input.value + '&nums=' + nums +
        '&title=' + menu_change_title_form.innerHTML);

    promise4
        .then(
            data => { return data.json() }
        )
        .then(
            result => {
                menu_table.innerHTML                   = result[0];
                role_table.innerHTML                   = result[1];
                menu_buttons.innerHTML                 = '';
                menu_change_form_wrapper.style.display = 'none';
                main.style.opacity                     = '1';
                let change_menu_btns                   = document.querySelectorAll('.change_menu_btn');
                let change_role_btns                   = document.querySelectorAll('.change_role_btn');

                // Перезапись всех событий после замены html элементов
                for (var change_menu_btn of change_menu_btns) {
                    change_menu_btn.addEventListener('click', changeMenu.bind(null, change_menu_btn));
                }

                for (var change_role_btn of change_role_btns) {
                    change_role_btn.addEventListener('click', changeRole.bind(null, change_role_btn));
                }
            }
        )
});