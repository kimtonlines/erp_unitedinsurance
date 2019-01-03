if (window.FileReader) {

    let reader = new FileReader(), rFilter = /^(image\/jpeg|image\/png)$/i;

    reader.onload = function (oFREvent) {
        preview = document.getElementById("uploadPreview");
        preview.src = oFREvent.target.result;
        // preview.style.display = "block";
    };

    function previewImageUser() {

        if (document.getElementById("user_imageFile").files.length === 0) {
            return;
        }
        let file = document.getElementById("user_imageFile").files[0];
        if (!rFilter.test(file.type)) {
            alert("Veuillez choisir une image au format jpeg!");
            return null;
        }
        reader.readAsDataURL(file);
    }

    function previewImage() {

        if (document.getElementById("commercial_imageFile").files.length === 0) {
            return;
        }
        let file = document.getElementById("commercial_imageFile").files[0];
        if (!rFilter.test(file.type)) {
            alert("Veuillez choisir une image au format jpeg!");
            return null;
        }
        reader.readAsDataURL(file);
    }

    function previewImageProspect() {

        if (document.getElementById("prospect_imageFile").files.length === 0) {
            return;
        }
        let file = document.getElementById("prospect_imageFile").files[0];
        if (!rFilter.test(file.type)) {
            alert("Veuillez choisir une image au format jpeg!");
            return null;
        }
        reader.readAsDataURL(file);
    }

} else {
    alert("FileReader object not found :( \nTry using Chrome, Firefox or WebKit");
}