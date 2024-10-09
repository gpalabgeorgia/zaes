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
        let status = $(this).text();
        let section_id = $(this).attr("section_id");
        $.ajax({
            type: 'post',
            url: '/admin/update-section-status',
            data: {status:status,section_id:section_id},
            success: function(resp) {
                if(resp['status']==0) {
                    $("#section-"+section_id).html("<a class='updateSectionsStatus' href='javascript:void(0)'>Inactive</a>");
                }else if(resp['status']==1) {
                    $("#section-"+section_id).html("<a class='updateSectionsStatus' href='javascript:void(0)'>Active</a>");
                }
            },error:function() {
                alert("წარმოიშვა შეცდომა");
            }
        });
    });

    // Update Categories Status
    $(".updateCategoryStatus").click(function() {
        let status = $(this).text();
        let category_id = $(this).attr("category_id");
        $.ajax({
            type: 'post',
            url: '/admin/update-category-status',
            data: {status:status,category_id:category_id},
            success: function(resp) {
                if(resp['status']==0) {
                    $("#category-"+category_id).html("<a class='updateCategoryStatus' href='javascript:void(0)'>Inactive</a>");
                }else if(resp['status']==1) {
                    $("#category-"+category_id).html("<a class='updateCategoryStatus' href='javascript:void(0)'>Active</a>");
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
        let status = $(this).text();
        let product_id = $(this).attr("product_id");
        $.ajax({
            type: 'post',
            url: '/admin/update-product-status',
            data: {status:status,product_id:product_id},
            success: function(resp) {
                if(resp['status']==0) {
                    $("#product-"+product_id).html("<a class='updateProductStatus' href='javascript:void(0)'>Inactive</a>");
                }else if(resp['status']==1) {
                    $("#product-"+product_id).html("<a class='updateProductStatus' href='javascript:void(0)'>Active</a>");
                }
            },error:function() {
                alert("წარმოიშვა შეცდომა");
            }
        });
    });
});