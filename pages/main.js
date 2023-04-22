const addForm = document.getElementById("add-user-form");
const updateForm = document.getElementById("edit-user-form");
const showAlert = document.getElementById("showAlert");
const addModal = new bootstrap.Modal(document.getElementById("addNewUserModal"));
const editModal = new bootstrap.Modal(document.getElementById("editUserModal"));
const tbody = document.querySelector("tbody");

// Add New User Ajax Request
addForm.addEventListener("submit", async (e) => {
    e.preventDefault();

    const formData = new FormData(addForm);
    formData.append("add", 1);

    if (addForm.checkValidity() === false) {
        e.preventDefault();
        e.stopPropagation();
        addForm.classList.add("was-validated");
        return false;
    } else {
        document.getElementById("add-user-btn").value = "Please Wait...";

        const data = await fetch("action.php", {
            method: "POST",
            body: formData,
        });
        const response = await data.text();
        showAlert.innerHTML = response;
        document.getElementById("add-user-btn").value = "Add User";
        addForm.reset();
        addForm.classList.remove("was-validated");
        addModal.hide();
        fetchAllUsers();
    }
});

// Fetch All Users Ajax Request
const fetchAllUsers = async () => {
    const data = await fetch("action.php?read=1", {
        method: "GET",
    });
    const response = await data.text();
    tbody.innerHTML = response;
};
fetchAllUsers();

// Edit User Ajax Request
tbody.addEventListener("click", (e) => {
    if (e.target && e.target.matches("a.editLink")) {
        e.preventDefault();
        let idetud = e.target.getAttribute("idetud");
        editUser(idetud);
    }
});
const editUser = async (idetud) => {
    const data = await fetch(`action.php?edit=1&idetud=${idetud}`, {
        method: "GET",
    });
    const response = await data.json();
    document.getElementById("idetud").value = response.idetud;
    document.getElementById("apogee").value = response.apogee;
    document.getElementById("nom").value = response.nom;
    document.getElementById("prenom").value = response.prenom;
    document.getElementById("date_naissance").value = response.date_naissance;
    document.getElementById("statut").value = response.statut;
    document.getElementById("filiere").value = response.filiere
};


// Update User Ajax Request
updateForm.addEventListener("submit", async (e) => {
    e.preventDefault();

    const formData = new FormData(updateForm);
    formData.append("update", 1);

    if (updateForm.checkValidity() === false) {
        e.preventDefault();
        e.stopPropagation();
        updateForm.classList.add("was-validated");
        return false;
    } else {
        document.getElementById("edit-user-btn").value = "Please Wait...";

        const data = await fetch("action.php", {
            method: "POST",
            body: formData,
        });
        const response = await data.text();

        showAlert.innerHTML = response;
        document.getElementById("edit-user-btn").value = "Add User";
        updateForm.reset();
        updateForm.classList.remove("was-validated");
        editModal.hide();
        fetchAllUsers();
    }
});

// Delete User Ajax Request
tbody.addEventListener("click", (e) => {
    if (e.target && e.target.matches("a.deleteLink")) {
        e.preventDefault();
        let idetud = e.target.getAttribute("idetud");
        deleteUser(idetud);
    }
});

const deleteUser = async (idetud) => {
    const data = await fetch(`action.php?delete=1&idetud=${idetud}`, {
        method: "GET",
    });
    const response = await data.text();
    showAlert.innerHTML = response;
    fetchAllUsers();
};