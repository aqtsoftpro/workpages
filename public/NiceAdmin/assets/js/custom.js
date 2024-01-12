/**
* Template Name: NiceAdmin - v2.5.0
* Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
* Author: BootstrapMade.com
* License: https://bootstrapmade.com/license/
*/





$(document).ready(function(){

  

    // $('.delete-rec-btn').on('click',function(event){
    //     event.preventDefault();
    //     console.log('working');
    //     var name = $(this).attr('data-name');
    //     var msg = $(this).attr('data-msg');
    //     var url = $(this).attr('data-url');
        
    //     console.log(name);
    //     $('.modal-title').html(name);
    //     $('.modal-body').html(msg);
    //     $('#delete-form').attr('action', url);
        

    //     let modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('deleteModel')) // Returns a Bootstrap modal instance
    //     // Show or hide:
    //     modal.show();
    
    // });

    $('#subrub_id').change(function () {
        // Get the selected value
        var suburb_id = $(this).val();
        if(suburb_id != '')
            {
                window.location.href = window.location.pathname + '?suburb_id=' + suburb_id;
            }
            else
            {
                window.location.href = window.location.pathname;
            }
        

    });


});    
