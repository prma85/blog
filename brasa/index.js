if (window.XMLHttpRequest) {
    var ajax = new XMLHttpRequest();
} else {
    var ajax = new ActiveXObject("Microsoft.XMLHTTP");
}

function saveUser() {
    var form = document.getElementById('contact');
    var data = 'email=' + encodeURIComponent(form.email.value) + '&name=' + encodeURIComponent(form.name.value)+ '&student=' + encodeURIComponent(form.student.value);

    ajax.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            if (this.responseText == '1') {
                //clean the form
                form.reset();
                alert('Thank you!');
            } else {
                console.log(this.responseText);
                alert(this.responseText);
            }
        }
    }
    ajax.open("post", 'process.php', true);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.send(data);
}

