let role_change_form_wrapper = document.querySelector('#role_change_form_wrapper');  // div для формы ролей
let cancel_change_role       = document.querySelector('#cancel_change_role');  // кнопка отмены формы
let save_change_role         = document.querySelector('#save_change_role');  // Кнопка сохранения
let change_role_btns         = document.querySelectorAll('.change_role_btn'); // Получаю кнопки таблицы
let role_buttons             = document.querySelector('#role_change_buttons');  // Кнопки менюшек в форме

cancel_change_role.addEventListener('click', canceledRole);

// Закрываю форму
function canceledRole() {
    role_change_form_wrapper.style.display = 'none';
    role_buttons.innerHTML          = '';  // Очищаю div для кнопок в форме
    main.style.opacity              = '1';
}

for (var change_role_btn of change_role_btns) {
    change_role_btn.addEventListener('click',  changeRole.bind(null, change_role_btn));
}

// Открываю форму по нажатию на кнопку
function changeRole(change_role_btn) {
    let role_id                            = change_role_btn.dataset.id;
    let role_title_input                   = document.querySelector('#role_change_title_input');
    let role_title_form                    = document.querySelector('#role_change_title_form');
    role_title_input.value                 = change_role_btn.dataset.title;  // Запалняю input формы названием
    role_title_form.innerHTML              = change_role_btn.dataset.title;  // Запалняю input формы названием
    role_change_form_wrapper.style.display = 'block';
    main.style.opacity                     = '.3';

    // Получаю кнопки ролей
    let promise3 = fetch('/?r=main/all-menus&id=' + role_id);

    promise3
        .then(
            data => { return data.json() }
        )
        .then(
            response => {
                role_buttons.innerHTML = response;

                // Получаю кнопки после формирования формы
                let role_change_all = document.querySelector('#role_change_all');  // Выделить все
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
                role_change_all.addEventListener('click', function appendAllMenu() {
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
save_change_role.addEventListener('click', function preventChangeRole(e) {
    e.preventDefault();

    let promise4 = fetch('/?r=main/update-role&titleNew=' + role_change_title_input.value + '&nums=' + nums +
        '&title=' + role_change_title_form.innerHTML);

    promise4
        .then(
            data => { return data.json() }
        )
        .then(
            result => {
                role_table.innerHTML                   = result[0];
                menu_table.innerHTML                   = result[1];
                role_buttons.innerHTML                 = '';
                role_change_form_wrapper.style.display = 'none';
                main.style.opacity                     = '1';
                let change_role_btns                   = document.querySelectorAll('.change_role_btn');
                let change_menu_btns                   = document.querySelectorAll('.change_menu_btn');

                // Перезапись всех событий после замены html элементов
                for (var change_role_btn of change_role_btns) {
                    change_role_btn.addEventListener('click', changeRole.bind(null, change_role_btn));
                }

                for (var change_menu_btn of change_menu_btns) {
                    change_menu_btn.addEventListener('click', changeMenu.bind(null, change_menu_btn));
                }
            }
        )
});