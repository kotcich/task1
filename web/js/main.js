function toTime(timestamp)
{
    let date = new Date(timestamp);
    let time = date.getDate()+"/"+date.getMonth()+"/"+date.getFullYear() + " ";
    time += date.getHours()+":"+date.getMinutes()+":"+date.getSeconds();
    return(time);
}

fetch("/role/getall").then(
    function (response){
        response.json().then(function(data) {
        var table = document.getElementById('action_table');
        data.forEach((element) => {
            let e = document.createElement("tr");
            e.innerHTML += "<td>"+ element.id +"</td>";
            e.innerHTML += "<td>"+ element.title +"</td>";
            e.innerHTML += "<td>"+ element.status +"</td>";
            e.innerHTML += "<td><button>UPDATE</button><button>DELETE</button></td>";
            table.appendChild(e);
        });
    });
});

function showHideModal()
{
    console.log("WTF");
    let modal = document.getElementById("modal-dialog");
    modal.classList.toggle("modal-show");
}

function addRole()
{
   
    showHideModal();
}