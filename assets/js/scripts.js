function showSuccessAlert(text, title="Success") {
    Swal.fire({
        title: title,
        text: text,
        icon: "success"
    });
}
function showErrorAlert(text, title="Oops!") {
    Swal.fire({
        title: title,
        text: text,
        icon: "error"
    });
}
