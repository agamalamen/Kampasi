$('document').ready(function () {
  $("#search-inventory-input").keyup(function(event){
    var str = $("#search-inventory-input").val();
    if (str.length == -1) {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("inventories").innerHTML = this.responseText;
            } else {
              document.getElementById("inventories").innerHTML = "<div class='text-center'><img style='' class='text-center' src="+ itemsLoading +"></div>";
            }
        };
        xmlhttp.open("GET", searchInventoryRoute + '?q=' + $("#search-inventory-input").val(), true);
        xmlhttp.send();
    }
  });
});
