function preview_image(event)
{
    const total_file = document.getElementById("input_images").files.length;
    let listImages = '';
    for(let i = 0; i < total_file; i++)
        listImages += "<img src='" + URL.createObjectURL(event.target.files[i]) + "' class='image-preview'><br>";
    document.getElementById('preview-images').innerHTML = listImages;
}

function clear_image(inp){
    const id = $(inp).attr("title");

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            $(inp).parent().remove();
        }
    };
    xmlhttp.open("GET", "../../Apps/Controller/remove_image.php?Id="+id, true);
    xmlhttp.send();
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
    });
    $(".badge").click(function (){
        clear_image(this);
    });
});