let menu_btn  = document.querySelector('#menu_btn');
let role_btn  = document.querySelector('#role_btn');
let ul        = document.querySelector('#tree');
let tree_name = document.querySelector('#tree_name');

// Вывод таблицы меню
function showMenu()
{
    menu_btn.style.cssText    = 'background-color: gray; color: white;';
    role_btn.style.cssText    = 'background-color: white; color: black;';
    create_menu.style.display = 'block'; create_role.style.display = 'none';
    fetch('/?r=table/show-menu').then(response => {return response.json()}).then(data => {table.innerHTML = data});
}

// Вывод таблицы роли
function showRole()
{
    role_btn.style.cssText    = 'background-color: gray; color: white;';
    menu_btn.style.cssText    = 'background-color: white; color: black;';
    create_role.style.display = 'block'; create_menu.style.display = 'none';
    fetch('/?r=table/show-role').then(response => {return response.json()}).then(data => {table.innerHTML = data});
}

// Формирование дерева под селектором
function tree(elem)
{
    tree_name.innerHTML = elem.value;
    fetch('/?r=table/tree&title=' + elem.value).then(res => {return res.json()}).then(data => {
        ul.innerHTML = data; tree_name.style.display = 'block'; ul.style.display = 'block';
    });
}