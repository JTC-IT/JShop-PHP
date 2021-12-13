function searchByKey(key) {
    var xmlhttp = new XMLHttpRequest();
    key = key.replaceAll("'","");
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            let result = this.responseText;
            document.getElementById("list-products").innerHTML = result;
            if(result !== '' && result.split('productItem').length > 9)
                $("#see_more").show();
            else $("#see_more").hide();
        }
    };
    xmlhttp.open("GET", "../../Apps/Controller/search_home_control.php?key="+key, true);
    xmlhttp.send();
}

function searchByCategory(id){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            let result = this.responseText;
            document.getElementById("list-products").innerHTML = result;
            if(result !== '' && result.split('productItem').length > 9)
                $("#see_more").show();
            else $("#see_more").hide();
        }
    };
    xmlhttp.open("GET", "../../Apps/Controller/search_home_control.php?categoryId="+id, true);
    xmlhttp.send();
}

function see_more(){
    const start = $(".productItem").length;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            let result = this.responseText;
            document.getElementById("list-products").innerHTML += result;
            if(result !== '' && result.split('productItem').length > 6)
                $("#see_more").show();
            else $("#see_more").hide();
        }
    };
    xmlhttp.open("GET", "../../Apps/Controller/see_more_control.php?start="+start, true);
    xmlhttp.send();
}

$(document).ready(function() {
    $("#see_more").click(function (){
        see_more();
    })
});
