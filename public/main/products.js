const search = document.querySelector("#rechercher");
const table = document.querySelector("table");
const tab = table.children[1].rows;
search.addEventListener("keyup", () => {
  init();
  var regex = /[0-9]/;
  let index;
  regex.test(search.value) ? (index = 0) : (index = 1);
  for (let i = 0; i < tab.length; i++) {
    if (tab[i].cells[index].innerHTML.toUpperCase().indexOf(search.value.toUpperCase()) === -1)
      tab[i].style.display = "none";
  }
});
init = () => {
  for (let i = 0; i < tab.length; i++) tab[i].style.display = "table-row";
};
