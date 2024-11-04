$('#signupBtn').click(function(e){
    e.preventDefault();
    
    $.ajax({
        url: 'index_includes/functions/user_login_register.php',
        type: 'POST',
        data: $('#register-form').serialize(),

        success: function(response){
            var jsonResponse = JSON.parse(response);
            if(jsonResponse.success === "Registration successful"){
                alert('Registration successful');
            }
        },

        error: function(xhr, status, error){
            console.log(xhr);
        }
    })
});