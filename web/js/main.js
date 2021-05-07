// change timestamp to str
function toTime(timestamp)
{
    let date = new Date(timestamp);
    let time = date.getDate()+"/"+date.getMonth()+"/"+date.getFullYear() + " ";
    time += date.getHours()+":"+date.getMinutes()+":"+date.getSeconds();
    return(time);
}

//fill main table for roles
function getAllRoles()
{
    fetch("/role/getall").then(
        function (response){
            response.json().then(function(data) {
            var table = document.getElementById('action_table');
            table.innerHTML="<tr><th>ID</th><th>TITLE</th><th>STATUS</th><th>ACTION</th></tr>";
            data.forEach((element) => {
                let e = document.createElement("tr");
                e.innerHTML += "<td>"+ element.id +"</td>";
                e.innerHTML += "<td>"+ element.title +"</td>";
                e.innerHTML += "<td>"+ element.status +"</td>";
                e.innerHTML += "<td><button onclick=\"showMenuModal(1)\">UPDATE</button><button>DELETE</button></td>";
                table.appendChild(e);
            });
        });
    });
}

//add or update current menu
function AddToMenu(menu_id)
{
    let title = document.getElementById("modal-input").value;
    let parent = document.getElementById("modal-menu").value;
    console.log(title, parent);
    // TODO: ADD FETCH FOR CREATE OR UPDATE
}

// add or update current role
function AddToRole(role_id)
{
    let title = document.getElementById("modal-input").value;
    // TODO: ADD FETCH FOR CREATE OR UPDATE
}

// Show and Hide modal menu
function showHideModal()
{
    document.getElementById("modal-dialog").classList.toggle("modal-show");
}

//Fill modal menu by role
function showRoleModal(role_id)
{
    showHideModal();
    document.getElementById("saveChanges").setAttribute("onclick", "AddToRole("+role_id+")");
    document.getElementById("modal-menu").classList.remove("modal-show");
    if (role_id === null)
    {
        document.getElementById("modal-title").innerHTML="Добавление новой роли";
    }
    else
    {

    }

}

//Fill modal menu by menu
function showMenuModal(menu_id)
{
    document.getElementById("modal-menu").classList.add("modal-show");
    document.getElementById("saveChanges").setAttribute("onclick", "AddToMenu("+menu_id+")");
    showHideModal();
    fillDropdown();

}

//Fill Role changer
function fillRoles()
{
    let list = document.getElementById("selectRole");
    fetch("/role/getall").then(
        function (response){
            response.json().then(function(data) {
            list.innerHTML="<option value=\"0\"> Выберите роль</option>";
            data.forEach((element) => {
                let e = document.createElement("option");
                e.value= element.id;
                e.innerHTML += element.title;
                list.appendChild(e);
            });
        });
    });
}

// Fill pages by role
function changeMenu(element)
{
    document.getElementById("pages").innerHTML=element.value;
    // TODO Update menu by role
}

// Fill pages for choose parent menu
function fillDropdown()
{
    let e = document.createElement("option");
    e.value= null;
    e.innerHTML = "Нет родителя";
    let modal = document.getElementById("modal-menu");
    modal.innerHTML = "";
    modal.appendChild(e);
}

// INIT
getAllRoles();
fillRoles();