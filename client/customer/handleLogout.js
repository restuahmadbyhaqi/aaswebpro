$('#logout').on('click', function() {
    var KonfirmasiUser = confirm('Apakah anda yakin ingin logout?');
    if(KonfirmasiUser){
        localStorage.removeItem('token');
        window.location.href="/client/customer/auth/login.html";
    }
    
  });