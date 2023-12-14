$('#logout').on('click', function() {
    var userConfirmed = confirm('Apakah anda yakin ingin logout?');
    if(userConfirmed){
        localStorage.removeItem('token');
        window.location.href="auth/login.html";
    }
    
  });