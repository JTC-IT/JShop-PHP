function preview_image(event)
{
    const total_file = document.getElementById("input_images").files.length;
    let listImages = '';
    for(let i = 0; i < total_file; i++)
        listImages += "<img src='" + URL.createObjectURL(event.target.files[i]) + "' class='image-preview'><br>";
    document.getElementById('preview-images').innerHTML = listImages;
}

function clear_images(){
    let images = document.getElementsByClassName('image-preview');
    let i = images.length - 1;
    while (i >= 0){
        images[i].remove();
        i -= 1;
    }
}

$(document).ready(function() {
    $('a[data-toggle=modal], button[data-toggle=modal]').click(function () {
        if (typeof $(this).data('id') !== 'undefined') {
            $("#btnDeleteProduct").attr("href","../Apps/Controller/delete_product_control.php?id="+$(this).data('id'));
        }
    })
});

function searchByKey(key,page) {
    var xmlhttp = new XMLHttpRequest();
    key = key.trim();
    key = key.replaceAll("'","");
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            let result = this.responseText;
            if(result == "")
                result = "<tr><td colspan='7'>Không tìm thấy sản phẩm nào!</td></tr>";
            document.getElementById("list-products").innerHTML = result;
            const count = document.getElementsByClassName('product-item').length;
            document.getElementById('result-showing').innerHTML = "Showing <b>"+count+"</b> out of <b>"+count+"</b> products";
        }
    };
    xmlhttp.open("GET", "../../Apps/Controller/search_manage_product.php?key="+key+"&page="+page, true);
    xmlhttp.send();
}

function searchByCategory(id,page){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            let result = this.responseText;
            if(result == "")
                result = "<tr><td colspan='7'>Không tìm thấy sản phẩm nào!</td></tr>";
            document.getElementById("list-products").innerHTML = result;
            const count = document.getElementsByClassName('product-item').length;
            document.getElementById('result-showing').innerHTML = "Showing <b>"+count+"</b> out of <b>"+count+"</b> products";
        }
    };
    xmlhttp.open("GET", "../../Apps/Controller/search_manage_product.php?categoryId="+id+"&page="+page, true);
    xmlhttp.send();
}