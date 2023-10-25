const table = document.querySelector("table");
const select = document.querySelector("#check");

select.addEventListener("click", () => {
  if (select.selectedIndex === 0) init();
  for (let i = 1; i < table.rows.length; i++) {
    if (select.selectedIndex === 1) Published(i,5);
    else if (select.selectedIndex === 2) UnPublished(i,5);
  }
});

init = () => {
  for (let i = 1; i < table.rows.length; i++) {
    table.rows[i].className = "";
  }
};

Published = (i,x) => {
  table.rows[i].className = "";
  if (table.rows[i].cells[x].innerHTML === "No")
    table.rows[i].classList.add("remove");
};
UnPublished = (i,x) => {
  table.rows[i].className = "";
  if (table.rows[i].cells[x].innerHTML === "Yes")
    table.rows[i].classList.add("remove");
};

