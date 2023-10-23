const table = document.querySelector("table");
const checkBox = document.querySelector("#check");


window.addEventListener('load',()=>{
    for (let i = 1; i < table.rows.length; i++) {
        Published(i);
    }
})

checkBox.addEventListener('click',()=>{
    for (let i = 1; i < table.rows.length; i++) {
        if (!checkBox.checked)Published(i);
        else UnPublished(i);
    }
})


Published = (i) =>{
    table.rows[i].className="";
    if (table.rows[i].cells[5].innerHTML === "No")
    table.rows[i].classList.add("remove");
}
UnPublished = (i) =>{
    table.rows[i].className="";
    if (table.rows[i].cells[5].innerHTML === "Yes") table.rows[i].classList.add("remove");
}
