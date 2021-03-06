window.onload = function () {
  'use strict';

  var i,
    element;

  //Criar cabeçalhos para a visualização móvel
  (function () {
    var headers = document.querySelectorAll("th"),
      index = 1,
      columns = document.querySelectorAll("td"),
      headerName,
      responsiveHeader;

    if (columns.length > 0) {
      for (i = 0; i < columns.length; i += 1) {
        if (index > headers.length) {
          index = 1;
        }
        //Cabeçalhos móveis são realmente td
        element = columns[i];
        headerName = document.querySelector('th:nth-of-type(' + index + ')').textContent;
        responsiveHeader = document.createElement("td");

        responsiveHeader.className = "responsive-header";
        responsiveHeader.innerHTML = headerName;
        element.parentNode.insertBefore(responsiveHeader, element);

        index+=1;
      }
    }
  }());

  var tableMinWidth,
    hasBeenSet = false;
 
  //Adiciona a classe mobile para a tabela quando a tabela é maior do que a tela
  function sytleTable () {
    var tableWidth = document.querySelector('.responsive-table').offsetWidth,
      windowWidth = window.innerWidth,
      responsiveTables = document.getElementsByClassName('responsive-table');

    if (tableWidth >= windowWidth) {
      if (!hasBeenSet) {
        tableMinWidth = tableWidth;
        hasBeenSet = true;
      }

      for (i = 0; i < responsiveTables.length; i += 1) {
        element = responsiveTables[i];
        element.classList.add("mobile");
      }

    } else if (tableWidth >= tableMinWidth) {

      for (i = 0; i < responsiveTables.length ; i += 1) {
        element = responsiveTables[i];
        element.classList.remove("mobile");
      }

    }
  }

  window.onresize = function () {
    sytleTable();
  };

  sytleTable();
}; //window.onload