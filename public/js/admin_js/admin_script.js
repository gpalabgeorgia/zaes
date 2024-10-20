$(document).ready(function() {
    // Check Admin password is correct
    $("#current_pwd ").keyup(function() {
        var current_pwd = $("#current_pwd").val();
        // alert(current_pwd);
       $.ajax({
        type: 'post',
        url: '/admin/check-current-pwd',
        data: {current_pwd:current_pwd},
        success: function(resp) {
            // alert(resp);
            if(resp=="false") {
                $("#chkCurentPwd").html("<font color=red>მიმდინარე პაროლი არასწორია</font>");
            }else if(resp="true") {
                $("#chkCurentPwd").html("<font color=green>მიმდინარე პაროლი სწორია</font>");
            }
        },error: function() {
            alert("წარმოიშვა შეცდომა"); 
        }
       });
    });

     // Update Sections Status
     $(".updateSectionsStatus").click(function() {
        let status = $(this).children("i").attr("status");
        let section_id = $(this).attr("section_id");
        $.ajax({
            type: 'post',
            url: '/admin/update-section-status',
            data: {status:status,section_id:section_id},
            success: function(resp) {
                if(resp['status']==0) {
                    $("#section-"+section_id).html("<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>");
                }else if(resp['status']==1) {
                    $("#section-"+section_id).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");
                }
            },error:function() {
                alert("წარმოიშვა შეცდომა");
            }
        });
    });

    // Update Brands Status
    $(".updateBrandStatus").click(function() {
        let status = $(this).children("i").attr("status");
        let brand_id = $(this).attr("brand_id");
        $.ajax({
            type: 'post',
            url: '/admin/update-brand-status',
            data: {status:status,brand_id:brand_id},
            success: function(resp) {
                if(resp['status']==0) {
                    $("#brand-"+brand_id).html("<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>");
                }else if(resp['status']==1) {
                    $("#brand-"+brand_id).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");
                }
            },error:function() {
                alert("წარმოიშვა შეცდომა");
            }
        });
    });

    // Update Categories Status
    $(".updateCategoryStatus").click(function() {
        let status = $(this).children("i").attr("status");
        let category_id = $(this).attr("category_id");
        $.ajax({
            type: 'post',
            url: '/admin/update-category-status',
            data: {status:status,category_id:category_id},
            success: function(resp) {
                if(resp['status']==0) {
                    $("#category-"+category_id).html("<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>");
                }else if(resp['status']==1) {
                    $("#category-"+category_id).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");
                }
            },error:function() {
                alert("წარმოიშვა შეცდომა");
            }
        });
    });

    // Append Categories Level
    $('#section_id').change(function() {
        var section_id = $(this).val();
        // alert(section_id);
        $.ajax({
            type: 'post',
            url: '/admin/append-categories-level',
            data: {section_id:section_id},
            success: function(resp) {
                $("#appendCategoriesLevel").html(resp);
            },error: function() {
                alert("Error");
            }
        });
    });

    // Confirm Deletetion of Record
    $(".confirmDelete").click(function() {
        var record = $(this).attr("record");
        var recordid = $(this).attr("recordid");
        Swal.fire({
            title: "გსურთ წაშლა?",
            text: "თქვენ ვეღარ გააუქმებთ მოქმედებას!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "დიახ, წაშალე!"
          }).then((result) => {
            if (result.isConfirmed) {
              Swal.fire({
                title: "წაიშალა!",
                text: "ჩანაწერი წარმატებით წაიშალა.",
                icon: "success"
              });
              window.location.href="/admin/delete-"+record+"/"+recordid;

            }
          });
          return false;
    });

     // Update Products Status
     $(".updateProductStatus").click(function() {
        let status = $(this).children("i").attr("status");
        let product_id = $(this).attr("product_id");
        $.ajax({
            type: 'post',
            url: '/admin/update-product-status',
            data: {status:status,product_id:product_id},
            success: function(resp) {
                if(resp['status']==0) {
                    $("#product-"+product_id).html("<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>");
                }else if(resp['status']==1) {
                    $("#product-"+product_id).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");
                }
            },error:function() {
                alert("წარმოიშვა შეცდომა");
            }
        });
    });

     // Update Products Attribute Status
     $(".updateAttributeStatus").click(function() {
        let status = $(this).children("i").attr("status");
        let attribute_id = $(this).attr("attribute_id");
        $.ajax({
            type: 'post',
            url: '/admin/update-attribute-status',
            data: {status:status,attribute_id:attribute_id},
            success: function(resp) {
                if(resp['status']==0) {
                    $("#attribute-"+attribute_id).html("<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>");
                }else if(resp['status']==1) {
                    $("#attribute-"+attribute_id).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");
                }
            },error:function() {
                alert("წარმოიშვა შეცდომა");
            }
        });
    });

    // Update Products Images Status
    $(".updateImageStatus").click(function() {
        let status = $(this).children("i").attr("status");
        let image_id = $(this).attr("image_id");
        $.ajax({
            type: 'post',
            url: '/admin/update-image-status',
            data: {status:status,image_id:image_id},
            success: function(resp) {
                if(resp['status']==0) {
                    $("#image-"+image_id).html("<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>");
                }else if(resp['status']==1) {
                    $("#image-"+image_id).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");
                }
            },error:function() {
                alert("წარმოიშვა შეცდომა");
            }
        });
    });

    // Products Attributes Add/Remove Script
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '<div><div style="height: 10px;"></div><input type="text" name="size[]" style="width: 80px;" placeholder="ზომა" required=""/>&nbsp;<input type="text" name="sku[]" style="width: 80px;" placeholder="კოდი" required=""/>&nbsp;<input type="number" name="price[]" style="width: 80px;" placeholder="ფასი" required=""/>&nbsp;<input type="number" name="stock[]" style="width: 80px;" placeholder="მარაგი" required=""/><a href="javascript:void(0);" class="remove_button">&nbsp;წაშლა</a></div>'; //New input field html 
    var x = 1; //Initial field counter is 1
    
    // Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increase field counter
            $(wrapper).append(fieldHTML); //Add field html
        }else{
            alert('A maximum of '+maxField+' fields are allowed to be added. ');
        }
    });
    
    // Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrease field counter
    });
});