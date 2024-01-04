let registeredNIKs = []; // Array untuk menyimpan NIK yang sudah terdaftar

function checkNIK() {
    const inputNIK = document.getElementById("nik");
    const nikValue = inputNIK.value.trim();

    // Periksa apakah NIK sudah terdaftar
    if (registeredNIKs.includes(nikValue)) {
        alert("NIK sudah terdaftar. Silakan masukkan NIK lain.");
    } else {
        registeredNIKs.push(nikValue);
        updateNIKList();
        inputNIK.value = ""; // Kosongkan input setelah NIK ditambahkan
    }
}

function updateNIKList() {
    const nikListContainer = document.getElementById("nikList");
    nikListContainer.innerHTML = "<p>NIK yang terdaftar:</p><ul>";

    registeredNIKs.forEach(nik => {
        nikListContainer.innerHTML += `<li>${nik}</li>`;
    });

    nikListContainer.innerHTML += "</ul>";
}
