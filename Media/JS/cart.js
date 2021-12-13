$(document).ready(function(){
    var modal1 = document.getElementById('confirmClean');
    var modal2 = document.getElementById('modalConfirmOrder');

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal1) {
            modal1.style.display = "none";
        }
        if (event.target == modal2) {
            modal2.style.display = "none";
        }
    }
});

function changeAmount(val,id) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            const data = this.responseText.split(";");
            document.getElementById("price_"+id).innerHTML = data[0];
            document.getElementById("sumPay").innerHTML = data[1];
        }
    };
    xmlhttp.open("GET", "../../Apps/Controller/change_order.php?id="+id+"&quantity="+val);
    xmlhttp.send();
}