let table        = document.querySelector('#table');
let form         = document.querySelector('#form');
let form_buttons = document.querySelector('#form_buttons');
let form_name    = document.querySelector('#form_name');
let form_title   = document.querySelector('#form_title');
let cancel       = document.querySelector('#cancel');
let all          = document.querySelector('#all');
let create_menu  = document.querySelector('#create_menu');
let create_role  = document.querySelector('#create_role');
let parents      = document.querySelector('#parents');
var nums         = [];

// Открываю форму для меню
function openFormMenu(elem)
{
    form.style.display  = 'block'; main.style.opacity = '.3'; nums = []; // Обнуляю выбронные значения
    form_name.innerHTML = elem.dataset.title; form_title.value = elem.dataset.title;
    save.setAttribute('onclick', 'updateMenu()');
    fetch('/?r=table/parents&child=' + form_name.innerHTML).then(res => {return res.json()}).then(data => {parents.innerHTML = data});
    fetch('/?r=main/all-roles&id=' + elem.dataset.id).then(response => {return response.json()}).then(data => {
        form_buttons.innerHTML = data;
        let edits = document.querySelectorAll('.edit');
        edits.forEach(el => {if (el.dataset.edit == 1) nums.push(el.dataset.id);});
    });
}

// Открываю форму для роли
function openFormRole(elem)
{
    form.style.display  = 'block'; main.style.opacity = '.3'; nums = []; // Обнуляю выбронные значения
    form_name.innerHTML = elem.dataset.title; form_title.value = elem.dataset.title;
    save.setAttribute('onclick', 'updateRole()');
    fetch('/?r=main/all-menus&id=' + elem.dataset.id).then(response => {return response.json()}).then(data => {
        form_buttons.innerHTML = data;
        let edits = document.querySelectorAll('.edit');
        edits.forEach(el => {if (el.dataset.edit == 1) nums.push(el.dataset.id);});
    });
}

// Открываю форму для меню
function openCreateMenu()
{
    form.style.display  = 'block'; main.style.opacity = '.3'; nums = []; // Обнуляю выбронные значения
    form_name.innerHTML = 'Новый пункт меню'; form_title.value    = '';
    save.setAttribute('onclick', 'createMenu()');
    fetch('/?r=table/parents&child=' + 'нет').then(res => {return res.json()}).then(data => {parents.innerHTML = data});
    fetch('/?r=main/all-roles').then(response => {return response.json()}).then(data => {
        form_buttons.innerHTML = data;
    });
}

// Открываю форму для меню
function openCreateRole()
{
    form.style.display  = 'block'; main.style.opacity = '.3'; nums = []; // Обнуляю выбронные значения
    form_name.innerHTML = 'Новая роль'; form_title.value    = '';
    save.setAttribute('onclick', 'createRole()');
    fetch('/?r=main/all-menus').then(response => {return response.json()}).then(data => {
        form_buttons.innerHTML = data;
    });
}

function cancelForm()
{
    form.style.display = 'none'; form_buttons.innerHTML = ''; main.style.opacity = '1';
}

// Меняю связи
function set(elem)
{
    if (elem.dataset.edit == 0) {
        elem.dataset.edit = 1; elem.classList.remove('edit_unset'); elem.classList.add('edit_set');
        nums.push(elem.dataset.id);  // Добавление id роли для работы с бд
    } else {
        elem.dataset.edit = 0; elem.classList.remove('edit_set'); elem.classList.add('edit_unset');
        let index = nums.indexOf(elem.dataset.id);  // Ищу id роли для удаления
        nums.splice(index, 1); // удаление из массива
    }
}

// Выбрать все
function setAll()
{
    let edits = document.querySelectorAll('.edit'); nums = [];
    edits.forEach(el => {nums.push(el.dataset.id); el.dataset.edit = 1; el.classList.remove('edit_unset');
    el.classList.add('edit_set');});
}

function updateMenu()
{
    fetch('/?r=main/update-menu&titleNew=' + form_title.value + '&nums=' + nums + '&title=' + form_name.innerHTML +
        '&parent=' + parents.value).then(response => {return response.json()}).then(data => {
            table.innerHTML = data; form.style.display = 'none'; main.style.opacity = '1';
    });
}

function updateRole()
{
    fetch('/?r=main/update-role&titleNew=' + form_title.value + '&nums=' + nums + '&title=' + form_name.innerHTML).
    then(response => {return response.json()}).then(data => {
        table.innerHTML = data; form.style.display = 'none'; main.style.opacity = '1';
    });
}

function createMenu()
{
    fetch('/?r=main/create-menu&title=' + form_title.value  + '&nums=' + nums + '&parent=' + parents.value).
    then(res => {return res.json()}).then(data=> { table.innerHTML = data; form.style.display = 'none'; main.style.opacity = '1'; });
}

function createRole()
{
    fetch('/?r=main/create-role&title=' + form_title.value  + '&nums=' + nums).then(res => {return res.json()}).
    then(data=> { table.innerHTML = data; form.style.display = 'none'; main.style.opacity = '1'; });
}