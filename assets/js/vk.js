VK.init(function() {
    VK.api("users.get", {fields:"photo_400_orig,city,verified,first_name,last_name"}, function(data) {
        //$('.name').html(data.response[0].first_name);
        var flag = $('.wrap').attr('flag');
        var id = data.response[0].id;
        var name = data.response[0].first_name;
        var last_name = data.response[0].last_name;
        var photo = data.response[0].photo_400_orig;
        if(flag == 0){
            $.ajax({
                type: 'POST',
                url: "/vk2/auth/auth/",
                data: 'id=' + id + '&name=' + name + '&last_name=' + last_name + '&photo=' + photo,
                success: function(data){
                    $('.auth').html(data);
                    $('.wrap').attr('flag', '1');
                }
            });
        }
    });

}, function() {
    // API initialization failed
    // Can reload page here
}, '5.44');