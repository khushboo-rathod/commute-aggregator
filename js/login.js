function handleFormSubmit(event) {
    event.preventDefault();
    const form = event.target;
    const formData = new FormData(form);
    // console.log(form)
    // console.log(formData)
    fetch(form.action, {
        method: form.method,
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            window.location.href = data.redirect;
        } else {
            alert(data.message);
        }
    })
    .catch(error => console.error('Error:', error));
}