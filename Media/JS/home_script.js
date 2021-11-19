function searchByKey(key,page) {
    var xmlhttp = new XMLHttpRequest();
    key = key.replaceAll("'","");
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("list-products").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "../../Apps/Controller/search_home_control.php?key="+key+"&page="+page, true);
    xmlhttp.send();
}

function searchByCategory(id,page){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("list-products").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "../../Apps/Controller/search_home_control.php?categoryId="+id+"&page="+page, true);
    xmlhttp.send();
}